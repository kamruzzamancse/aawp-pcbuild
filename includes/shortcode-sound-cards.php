<?php
function aawp_pcbuild_display_parts_sound_cards($atts) {
    $atts = shortcode_atts(array('category' => 'sound-cards'), $atts);
    $input_category = sanitize_title($atts['category']);
    
    $category_map = [
        'sound-cards' => 'Sound Cards',
    ];
    
    $category = $category_map[$input_category] ?? 'Sound Cards';
    
    $transient_key = 'aawp_pcbuild_cache_' . md5($category);

    if (is_user_logged_in() && current_user_can('manage_options') && isset($_GET['clear_cache'])) {
        delete_transient($transient_key);
    }

    $products = get_transient($transient_key);

    if ($products === false) {
        $products = aawp_pcbuild_get_products($category);
        set_transient($transient_key, $products, 12 * HOUR_IN_SECONDS);
    }

    if (!is_array($products) || empty($products['SearchResult']['Items'])) {
        return '<p class="aawp-error">No products found or error fetching data. Please try again later.</p>';
    }

    $all_items = $products['SearchResult']['Items'];
    $total_items = count($all_items);
    $items_per_page = 25;
    $current_page = isset($_GET['pcbuild_page']) ? max(1, intval($_GET['pcbuild_page'])) : 1;
    $total_pages = ceil($total_items / $items_per_page);
    $start = ($current_page - 1) * $items_per_page;
    $display_items = array_slice($all_items, $start, $items_per_page);

    ob_start();
    ?>

    <div style="background-color:#41466c; padding:20px; color:#fff; font-size:24px; font-weight:bold; text-align:center; margin-bottom:40px">
        Choose A <?php echo esc_html($category); ?>
    </div>
    <div style="width:90%; margin:0 auto; font-family:sans-serif;">
        <div class="pcbuilder-container" style="display:flex; gap:20px; margin-top:20px;">

            <!-- Sidebar and filters here if needed -->

            <div class="pcbuilder-main" style="flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <div id="total_products" style="font-weight:bold;"><?php echo $total_items; ?> Products</div>
                    <div>
                        <input type="text" id="pcbuild-search" placeholder="Search..." style="padding:6px 10px; border-radius:6px; border:1px solid #ccc; margin-bottom: 15px" /><br>
                    </div>
                </div>

                <table id="pcbuild-table" style="width:100%; border-collapse: collapse; white-space: nowrap;">
                    <thead>
                        <tr>
                            <th style="padding: 10px;">Image</th>
                            <th style="padding: 10px;">Name</th>
                            <th style="padding: 10px;">Channels</th>
                            <th style="padding: 10px;">Digital Audio</th>
                            <th style="padding: 10px;">SNR</th>
                            <th style="padding: 10px;">Sample Rate</th>
                            <th style="padding: 10px;">Chipset</th>
                            <th style="padding: 10px;">Interface</th>
                            <th style="padding: 10px;">Rating</th>
                            <th style="padding: 10px;">Price</th>
                            <th style="padding: 10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($display_items as $index => $item):
                        $row_bg = ($index % 2 === 0) ? '#d4d4d4' : '#ebebeb';

                        $full_title = $item['ItemInfo']['Title']['DisplayValue'] ?? 'Unknown Product';
                        $title = esc_html($full_title);

                        $image = $item['Images']['Primary']['Large']['URL'] 
                            ?? $item['Images']['Primary']['Medium']['URL'] 
                            ?? $item['Images']['Primary']['Small']['URL'] 
                            ?? '';

                        $price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? 'N/A';

                        $sellerCount = $item['Offers']['Listings'][0]['MerchantInfo']['FeedbackCount'] ?? 0;
                        $sellerRating = $item['Offers']['Listings'][0]['MerchantInfo']['FeedbackRating'] ?? 0;
                        $rating_display = str_repeat('★', round(floatval($sellerRating))) . ' (' . $sellerCount . ')';

                        $channels = $digital_audio = $snr = $sample_rate = $chipset = $interface = '-';
                        $technical_info = $item['ItemInfo']['TechnicalInfo']['DisplayValues'] ?? [];
                        $features = $item['ItemInfo']['Features']['DisplayValues'] ?? [];
                        $all_specs = array_merge($technical_info, $features);

                        foreach ($all_specs as $spec) {
                            $spec_lower = strtolower($spec);
                            if (strpos($spec_lower, 'channel') !== false) {
                                $channels = esc_html($spec);
                            } elseif (strpos($spec_lower, 'digital audio') !== false) {
                                $digital_audio = esc_html($spec);
                            } elseif (strpos($spec_lower, 'snr') !== false) {
                                $snr = esc_html($spec);
                            } elseif (strpos($spec_lower, 'sample rate') !== false) {
                                $sample_rate = esc_html($spec);
                            } elseif (strpos($spec_lower, 'chipset') !== false) {
                                $chipset = esc_html($spec);
                            } elseif (strpos($spec_lower, 'interface') !== false) {
                                $interface = esc_html($spec);
                            }
                        }
                    ?>
                        <tr style="background-color: <?php echo $row_bg; ?>;">
                            <td style="padding: 10px; text-align: center;">
                                <?php if ($image): ?>
                                    <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" style="width:125px; height:auto; border-radius:4px;">
                                <?php else: ?>
                                    <span>No Image</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 10px; font-weight: 600;"><?php echo $title; ?></td>
                            <td style="padding: 10px;"><?php echo $channels; ?></td>
                            <td style="padding: 10px;"><?php echo $digital_audio; ?></td>
                            <td style="padding: 10px;"><?php echo $snr; ?></td>
                            <td style="padding: 10px;"><?php echo $sample_rate; ?></td>
                            <td style="padding: 10px;"><?php echo $chipset; ?></td>
                            <td style="padding: 10px;"><?php echo $interface; ?></td>
                            <td style="padding: 10px;"><?php echo $rating_display; ?></td>
                            <td style="padding: 10px; font-weight: 600;"><?php echo esc_html($price); ?></td>
                            <td style="padding: 10px;">
                                <button class="add-to-pcbuild" data-title="<?php echo esc_attr($title); ?>" data-price="<?php echo esc_attr($price); ?>"
                                    style="padding: 6px 12px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
                                    Add
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($total_pages > 1): ?>
                    <div style="margin-top: 20px; text-align: center;">
                        <?php for ($i = 1; $i <= $total_pages; $i++):
                            $url = add_query_arg('pcbuild_page', $i);
                            $is_active = ($i === $current_page);
                        ?>
                            <a href="<?php echo esc_url($url); ?>"
                                style="margin: 0 5px; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; text-decoration: none;
                                <?php echo $is_active ? 'background-color: #007bff; color: white;' : 'color: #007bff;'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('pcbuild_parts_sound_cards', 'aawp_pcbuild_display_parts_sound_cards');
