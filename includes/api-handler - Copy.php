<?php

if (!defined('ABSPATH')) {
    exit;
}

function aawp_pcbuild_get_products($category) {
    $category = sanitize_text_field($category);
    $cache_key = 'aawp_pcbuild_cache_' . md5($category);
    $cache_time = HOUR_IN_SECONDS; // 1-hour cache using WordPress transient

    // Return cached response if available
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    // Get API credentials
    $access_key = get_option('aawp_pcbuild_amazon_access_key');
    $secret_key = get_option('aawp_pcbuild_amazon_secret_key');
    $associate_tag = get_option('aawp_pcbuild_amazon_associate_tag');

    if (!$access_key || !$secret_key || !$associate_tag) {
        return "Error: Amazon API credentials are missing. Please configure them in the plugin settings.";
    }

    $region = 'us'; // You can make this dynamic later via settings
    $endpoint = getAmazonEndpoint($region);
    $timestamp = gmdate('Ymd\THis\Z');

    $request = [
        'Keywords' => $category,
        'SearchIndex' => 'Electronics',
        'Resources' => [
            'Images.Primary.Large',
            'ItemInfo.Title',
            'Offers.Listings.Price'
        ],
        'PartnerTag' => $associate_tag,
        'PartnerType' => 'Associates',
        'Marketplace' => 'www.amazon.com'
    ];

    $headers = generateSignedHeaders($access_key, $secret_key, $region, $endpoint, $request, $timestamp);

    // cURL request
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($http_code !== 200) {
        error_log("Amazon API Error: HTTP $http_code. Response: " . print_r($response, true));
        if (!empty($curl_error)) {
            error_log("cURL Error: " . $curl_error);
        }
        return "Error: Amazon API request failed with status code $http_code.";
    }

    $data = json_decode($response, true);

    if (isset($data['Errors'])) {
        error_log("Amazon API Error Response: " . json_encode($data['Errors']));
        return "Error: Amazon API returned an error. Please check credentials and category.";
    }

    // Cache and return
    set_transient($cache_key, $data, $cache_time);
    return $data;
}

// Endpoint selector based on region
function getAmazonEndpoint($region) {
    $endpoints = [
        'us' => 'https://webservices.amazon.com/paapi5/searchitems',
        'uk' => 'https://webservices.amazon.co.uk/paapi5/searchitems',
        'in' => 'https://webservices.amazon.in/paapi5/searchitems',
        'de' => 'https://webservices.amazon.de/paapi5/searchitems',
        'fr' => 'https://webservices.amazon.fr/paapi5/searchitems',
        'jp' => 'https://webservices.amazon.co.jp/paapi5/searchitems',
        'ca' => 'https://webservices.amazon.ca/paapi5/searchitems',
    ];

    return $endpoints[$region] ?? $endpoints['us'];
}

// Generate signed headers
function generateSignedHeaders($access_key, $secret_key, $region, $endpoint, $request, $timestamp) {
    $host = parse_url($endpoint, PHP_URL_HOST);
    $service = 'ProductAdvertisingAPI';
    $canonical_uri = '/paapi5/searchitems';
    $payload = json_encode($request);

    // Step 1: Canonical Request
    $canonical_headers = "content-type:application/json\nhost:$host\nx-amz-date:$timestamp\n";
    $signed_headers = "content-type;host;x-amz-date";
    $payload_hash = hash('sha256', $payload);
    $canonical_request = "POST\n$canonical_uri\n\n$canonical_headers\n$signed_headers\n$payload_hash";

    // Step 2: String to Sign
    $algorithm = 'AWS4-HMAC-SHA256';
    $date = gmdate('Ymd');
    $credential_scope = "$date/$region/execute-api/aws4_request";
    $string_to_sign = "$algorithm\n$timestamp\n$credential_scope\n" . hash('sha256', $canonical_request);

    // Step 3: Calculate Signature
    $signing_key = getSignatureKey($secret_key, $date, $region, 'execute-api');
    $signature = hash_hmac('sha256', $string_to_sign, $signing_key);

    // Step 4: Auth Header
    $authorization_header = "$algorithm Credential=$access_key/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";

    return [
        "Content-Type: application/json",
        "X-Amz-Date: $timestamp",
        "Authorization: $authorization_header"
    ];
}

// Helper: Signature Key Generator
function getSignatureKey($key, $dateStamp, $regionName, $serviceName) {
    $kDate = hash_hmac('sha256', $dateStamp, "AWS4{$key}", true);
    $kRegion = hash_hmac('sha256', $regionName, $kDate, true);
    $kService = hash_hmac('sha256', $serviceName, $kRegion, true);
    return hash_hmac('sha256', 'aws4_request', $kService, true);
}
