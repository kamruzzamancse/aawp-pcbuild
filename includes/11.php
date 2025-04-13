$request_payload = [
    'Keywords'     => $category,
    'SearchIndex'  => 'Electronics',
    'Resources'    => [
        'Images.Primary.Large',                                 // ✅ Product image
        'ItemInfo.Title',                                       // ✅ Product title
        'ItemInfo.Features',                                    // ✅ About this item
        'ItemInfo.ByLineInfo.Brand',                            // ✅ Brand
        'ItemInfo.Classifications.ProductGroup',                // ✅ Style
        'Offers.Listings.Price',                                // ✅ Price
        'Offers.Listings.DeliveryInfo.IsFreeShippingEligible',  // ✅ Shipping info
        'Offers.Listings.Promotions',                           // ✅ Promo
        'Offers.Listings.Availability.Message',                 // ✅ Availability
        'ItemInfo.CustomerReviews.StarRating',                  // ✅ Rating
    ],
    'PartnerTag'   => $associate_tag,
    'PartnerType'  => 'Associates',
    'Marketplace'  => 'www.amazon.com'
];


$output .= '<button class="add-to-builder"
    data-asin="' . esc_attr($asin) . '"
    data-title="' . esc_attr($raw_title) . '"
    data-image="' . esc_url($raw_image) . '"
    data-base="' . esc_attr($base_price) . '"
    data-promo="' . esc_attr($promo) . '"
    data-shipping="' . ($is_free_shipping ? 'FREE' : 'Paid') . '"
    data-availability="' . esc_attr($availability_message) . '"
    data-price="' . esc_attr($raw_price) . '"
    data-category="' . esc_attr($category) . '"
    data-brand="' . esc_attr($brand) . '"
    data-rating="' . esc_attr($rating) . '"
    data-style="' . esc_attr($product_style) . '"
    data-about="' . esc_attr(implode("\n", $about_features)) . '"
    style="display:inline-block; margin-top:10px; padding:8px 12px; background-color:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer;">
    ' . __('Add to Builder', 'aawp-pcbuild') . '
</button>';
