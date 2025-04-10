<?php

if (!defined('ABSPATH')) {
    exit;
}

// [pcbuild_parts category="GPU"]
function aawp_pcbuild_display_parts($atts) {
    // Accept category from shortcode, default to CPU
    $atts = shortcode_atts(array('category' => 'CPU'), $atts);
    $category = sanitize_text_field($atts['category']);

    // Fetch product data via API
    $products = aawp_pcbuild_get_products($category);

    // Check if response is error string
    if (!is_array($products)) {
        error_log("AAWP-PCBuild Error: " . print_r($products, true));
        return '<p class="aawp-error">' . esc_html($products) . '</p>';
    }

    // Check if valid product list returned
    if (!empty($products['SearchResult']['Items'])) {
        $output = '<div class="pcbuild-products" style="display:grid; grid-template-columns:repeat(auto-fill,minmax(250px,1fr)); gap:20px;">';

        foreach ($products['SearchResult']['Items'] as $item) {
            $asin = $item['ASIN'] ?? '';
            $raw_title = $item['ItemInfo']['Title']['DisplayValue'] ?? __('Unknown Product', 'aawp-pcbuild');
            $raw_image = $item['Images']['Primary']['Large']['URL'] ?? '';
            $raw_price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? __('Price not available', 'aawp-pcbuild');
            $product_url = $item['DetailPageURL'] ?? '#';

            // Escaped values
            $title = esc_html($raw_title);
            $image = esc_url($raw_image);
            $price = esc_html($raw_price);
            $category_escaped = esc_attr($category);

            $availability_message = $item['Offers']['Listings'][0]['Availability']['Message'] ?? 'In stock';
            $is_prime = $item['Offers']['Listings'][0]['IsEligibleForPrime'] ?? false;
            $is_free_shipping = $item['Offers']['Listings'][0]['DeliveryInfo']['IsFreeShippingEligible'] ?? false;
            $promo = $item['Offers']['Listings'][0]['Promotions'][0]['Summary']['DisplayValue'] ?? '—';
            $base_price = $item['Offers']['Listings'][0]['Price']['Amount'] ?? '12000';

            $output .= '<div class="pcbuild-product" style="border:1px solid #ccc; padding:15px; border-radius:10px; text-align:center;">';

            if (!empty($image)) {
                $output .= '<img src="' . $image . '" alt="' . $title . '" style="max-width:100%; height:auto;" />';
            } else {
                $output .= '<p>' . __('No image available', 'aawp-pcbuild') . '</p>';
            }

            $output .= '<h3 style="font-size:16px; margin:10px 0;">' . $title . '</h3>';
            $output .= '<p style="font-weight:bold;">' . __('Price:', 'aawp-pcbuild') . ' ' . $price . '</p>';

            $output .= '<button class="add-to-builder"
                data-asin="' . esc_attr($asin) . '"
                data-title="' . esc_attr($raw_title) . '"
                data-image="' . esc_url($raw_image) . '"
                data-base="' . esc_attr($base_price) . '"
                data-promo="' . esc_attr($promo) . '"
                data-shipping="' . ($is_free_shipping ? 'FREE' : '100') . '"
                data-tax=""
                data-availability="' . esc_attr($availability_message) . '"
                data-price="' . esc_attr($raw_price) . '"
                data-category="' . esc_attr($category) . '"
                data-affiliate-url="' . esc_url($product_url) . '"
                style="display:inline-block; margin-top:10px; padding:8px 12px; background-color:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer;">
                ' . __('Add to Builder', 'aawp-pcbuild') . '
            </button>';

            $output .= '</div>';
        }

        $output .= '</div>';
    } else {
        error_log("AAWP-PCBuild Warning: No products found for category: $category");
        $output = '<p class="aawp-warning">' . esc_html__('No products found for category:', 'aawp-pcbuild') . ' ' . esc_html($category) . '</p>';
    }

    return $output;
}

add_shortcode('pcbuild_parts', 'aawp_pcbuild_display_parts');

// AJAX handlers to dynamically load shortcode content
add_action('wp_ajax_load_pcbuild_parts', 'ajax_load_pcbuild_parts');
add_action('wp_ajax_nopriv_load_pcbuild_parts', 'ajax_load_pcbuild_parts');

function ajax_load_pcbuild_parts() {
    // Sanitize the category input
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : 'CPU';

    // Return the rendered HTML from the shortcode
    echo do_shortcode('[pcbuild_parts category="' . $category . '"]');
    wp_die(); // Properly end AJAX call
}
