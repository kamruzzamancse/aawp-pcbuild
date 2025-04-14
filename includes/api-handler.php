<?php

if (!defined('ABSPATH')) {
    exit;
}

function aawp_pcbuild_get_products($category) {
    $category = sanitize_text_field($category);
    $cache_key = 'aawp_pcbuild_cache_' . md5($category);
    $cache_time = HOUR_IN_SECONDS;

    // Check WordPress transient cache
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    // Fetch plugin settings
    $access_key = get_option('aawp_pcbuild_amazon_access_key');
    $secret_key = get_option('aawp_pcbuild_amazon_secret_key');
    $associate_tag = get_option('aawp_pcbuild_amazon_associate_tag');

    if (!$access_key || !$secret_key || !$associate_tag) {
        return 'Error: Amazon API credentials are missing. Please check settings.';
    }

    // Request Setup
    $region = 'us-east-1'; // Required for signing
    $endpoint = 'https://webservices.amazon.com/paapi5/searchitems';
    $host = 'webservices.amazon.com';
    $uri_path = '/paapi5/searchitems';

    $search_data = aawp_pcbuild_get_search_index($category);

    $request_payload = [
        'Keywords'     => $category,       // ✅ কিওয়ার্ড ঠিকমতো যাচ্ছে
        'SearchIndex'  => $search_data['search_index'],     // ✅ স্ট্রিং হিসেবে সঠিক ভ্যালু যাচ্ছে
        'Resources'    => [
            'Images.Primary.Large',                               // ✅ Product image
            'ItemInfo.Title',                                     // ✅ Product title
            'Offers.Listings.Price',                              // ✅ Price
            'Offers.Listings.DeliveryInfo.IsFreeShippingEligible',// ✅ Shipping info
            'Offers.Listings.Promotions',                         // ✅ Promo info
            'Offers.Listings.Availability.Message',               // ✅ Availability
            'CustomerReviews.StarRating',                         // ✅ Rating
            'ItemInfo.Features',                                  // ✅ About
        ],
        'PartnerTag'   => $associate_tag,
        'PartnerType'  => 'Associates',
        'Marketplace'  => 'www.amazon.com'
    ];

    $json_payload = json_encode($request_payload);
    $timestamp = gmdate('Ymd\THis\Z');

    // Build signed headers
    $headers = generateSignedHeaders_v2($access_key, $secret_key, $region, $host, $uri_path, $json_payload, $timestamp);

    // Use cURL to make request
    $ch = curl_init($endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error_msg = curl_error($ch);
    curl_close($ch);

    // Debug log
    //error_log("Amazon API Response (code $http_code): " . $response);

    if ($http_code !== 200 || !$response) {
        return "Error: Amazon API request failed with status code $http_code.";
    }

    $data = json_decode($response, true);
    if (isset($data['Errors'])) {
        error_log('Amazon API Errors: ' . print_r($data['Errors'], true));
        return 'Error: Amazon API returned an error.';
    }

    set_transient($cache_key, $data, $cache_time);
    return $data;
}

function aawp_pcbuild_get_search_index($category) {
    $category = strtolower($category);

    $mapping = [
        'cpu'              => 'Computers',
        'cpu cooler'       => 'Computers',
        'motherboard'      => 'Computers',
        'memory'           => 'Computers',
        'storage'          => 'Computers',
        'video card'       => 'Computers',
        'case'             => 'Computers',
        'power supply'     => 'Computers',
        'operating system' => 'Software',
        'monitor'          => 'Electronics',
    ];

    // Default keyword logic
    $keywords = match ($category) {
        'case' => 'desktop computer case',
        'storage' => 'SSD or HDD',
        default => $category,
    };

    // Smart keyword builder for Operating System
    if (str_contains($category, 'operating system') || str_contains($category, 'windows')) {
        preg_match_all('/windows\s*(10|11)?\s*(home|pro)?\s*(oem|retail)?\s*(dvd|usb|download)?\s*(32\/64-bit|64-bit|32-bit)?\s*(french)?/i', $category, $matches);

        $version = $matches[1][0] ?? '11';
        $edition = ucfirst($matches[2][0] ?? 'Home');
        $license = strtoupper($matches[3][0] ?? 'OEM');
        $format  = strtoupper($matches[4][0] ?? 'DVD');
        $bit     = $matches[5][0] ?? '64-bit';
        $lang    = ucfirst($matches[6][0] ?? '');

        $base = "Microsoft Windows $version $edition";
        if (!empty($lang)) {
            $base .= " $lang";
        }
        $keywords = "$base $license - $format $bit";

        // Exclude hardware-related results
        $keywords .= " -server -NAS -bundle -device";
    }

    return [
        'search_index' => $mapping[$category] ?? 'Electronics',
        'keywords'     => $keywords,
    ];
}


function getSignatureKey($key, $dateStamp, $regionName, $serviceName) {
    $kSecret  = 'AWS4' . $key;
    $kDate    = hash_hmac('sha256', $dateStamp, $kSecret, true);
    $kRegion  = hash_hmac('sha256', $regionName, $kDate, true);
    $kService = hash_hmac('sha256', $serviceName, $kRegion, true);
    $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
    return $kSigning;
}

function generateSignedHeaders_v2($access_key, $secret_key, $region, $host, $uri_path, $payload, $timestamp) {
    $service = 'ProductAdvertisingAPI';
    $algorithm = 'AWS4-HMAC-SHA256';
    $date = gmdate('Ymd');
    $credential_scope = "$date/$region/$service/aws4_request";

    // Canonical Request
    $canonical_headers = "content-encoding:amz-1.0\ncontent-type:application/json; charset=utf-8\nhost:$host\nx-amz-date:$timestamp\nx-amz-target:com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems\n";
    $signed_headers = "content-encoding;content-type;host;x-amz-date;x-amz-target";
    $payload_hash = hash('sha256', $payload);

    $canonical_request = "POST\n$uri_path\n\n$canonical_headers\n$signed_headers\n$payload_hash";

    // String to Sign
    $string_to_sign = "$algorithm\n$timestamp\n$credential_scope\n" . hash('sha256', $canonical_request);

    // Signature
    $signing_key = getSignatureKey($secret_key, $date, $region, $service);
    $signature = hash_hmac('sha256', $string_to_sign, $signing_key);

    // Authorization Header
    $authorization_header = "$algorithm Credential=$access_key/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";

    return [
        "Content-Encoding: amz-1.0",
        "Content-Type: application/json; charset=utf-8",
        "Host: $host",
        "X-Amz-Date: $timestamp",
        "X-Amz-Target: com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems",
        "Authorization: $authorization_header"
    ];
}

