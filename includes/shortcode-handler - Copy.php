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
            $title = $item['ItemInfo']['Title']['DisplayValue'] ?? __('Unknown Product', 'aawp-pcbuild');
            $image = $item['Images']['Primary']['Large']['URL'] ?? '';
            $price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? __('Price not available', 'aawp-pcbuild');
            $product_url = $item['DetailPageURL'] ?? '#';

            $output .= '<div class="pcbuild-product" style="border:1px solid #ccc; padding:15px; border-radius:10px; text-align:center;">';
            $output .= !empty($image)
                ? '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '" style="max-width:100%; height:auto;" />'
                : '<p>' . esc_html__('No image available', 'aawp-pcbuild') . '</p>';

            $output .= '<h3 style="font-size:16px; margin:10px 0;">' . esc_html($title) . '</h3>';
            $output .= '<p style="font-weight:bold;">' . esc_html__('Price:', 'aawp-pcbuild') . ' ' . esc_html($price) . '</p>';
            $output .= '<a href="' . esc_url($product_url) . '" target="_blank" rel="nofollow noopener" style="display:inline-block; margin-top:10px; padding:8px 12px; background-color:#0073aa; color:#fff; border-radius:5px; text-decoration:none;">' . esc_html__('View on Amazon', 'aawp-pcbuild') . '</a>';
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
