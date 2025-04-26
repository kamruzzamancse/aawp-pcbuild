<?php
function aawp_pcbuild_display_parts_monitor($atts) {
    $atts = shortcode_atts(array('category' => 'monitor'), $atts);
    $input_category = sanitize_title($atts['category']);
    
    $category_map = [
        'monitor' => 'Monitor',
    ];
    
    $category = $category_map[$input_category] ?? 'Monitor';
    
    // Create transient key (consistent naming)
    $transient_key = 'aawp_pcbuild_cache_' . md5($category);
    
    // Clear cache if admin and ?clear_cache=1 in URL
    if (is_user_logged_in() && current_user_can('manage_options') && isset($_GET['clear_cache'])) {
        delete_transient($transient_key);
    }
    
    // Try to get products from cache
    $products = get_transient($transient_key);
    
    // If no cached products, fetch and cache them
    if ($products === false) {
        $products = aawp_pcbuild_get_products($category);
        set_transient($transient_key, $products, HOUR_IN_SECONDS);
    }
    
    // If still no products, show error
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
        <div style="display:flex; gap:20px; margin-top:20px;">
            <div style="width:250px; background:#f9f9f9; padding:20px; border-radius:8px;">
                <div style="margin-bottom:20px;"><strong>Part</strong> | <strong>List</strong></div>
                <div style="margin-bottom:20px;"><label><input type="checkbox" checked disabled /> Compatibility Filter</label></div>
                <div style="margin-bottom:20px;">
                    <div>PARTS: <strong id="parts_count"></strong></div>
                    <div>TOTAL: <strong id="parts_total_price"></strong></div>
                </div>
                <div style="margin-bottom:20px;">
                    <strong>PRICE</strong>
                    <div id="price-slider" style="margin-top: 15px;"></div>
                    <div style="display: flex; justify-content: space-between; font-size: 14px; margin-top: 6px;">
                        <span id="price-min-label">$0</span>
                        <span id="price-max-label">$0</span>
                    </div>
                </div>
                <div style="margin-bottom: 20px;">
                    <strong>RATING</strong>
                    <div style="margin-top: 10px;" id="rating-filter">
                        <label><input type="checkbox" name="rating" value="all" checked /> All</label><br/>
                        <label><input type="checkbox" name="rating" value="5" /> <span style="color: orange;">★★★★★</span></label><br/>
                        <label><input type="checkbox" name="rating" value="4" /> <span style="color: orange;">★★★★☆</span></label><br/>
                        <label><input type="checkbox" name="rating" value="3" /> <span style="color: orange;">★★★☆☆</span></label><br/>
                        <label><input type="checkbox" name="rating" value="unrated" /> Unrated</label>
                    </div>
                </div>
            </div>

            <div style="flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <div style="font-weight:bold;"><?php echo $total_items; ?> Products</div>
                    <div><input type="text" id="pcbuild-search" placeholder="Search..." style="padding:6px 10px; border-radius:6px; border:1px solid #ccc;" /></div>
                </div>

                <table id="pcbuild-table" style="width:100%; border-collapse:collapse;">
                    <thead style="background:#f0f0f0;">
                        <tr>
                            <th class="sortable-header" data-key="name"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Name</span></th>
                            <th class="sortable-header" data-key="screen-size"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Screen Size</span></th>
                            <th class="sortable-header" data-key="resolution"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Resolution</span></th>
                            <th class="sortable-header" data-key="refresh-rate"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Refresh Rate</span></th>
                            <!-- <th class="sortable-header" data-key="response-time"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Response Time (G2G)</span></th> -->
                            <th class="sortable-header" data-key="panel-type"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Panel Type</span></th>
                            <th class="sortable-header" data-key="aspect-ratio"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Aspect Ratio</span></th>
                            <th class="sortable-header" data-key="rating"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Rating</span></th>
                            <th class="sortable-header" data-key="price"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Price</span></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($display_items as $index => $item):
                        $row_bg = ($index % 2 === 0) ? '#d4d4d4' : '#ebebeb';
                        $asin = $item['ASIN'] ?? '';
                        $full_title = $item['ItemInfo']['Title']['DisplayValue'] ?? 'Unknown Product';
                        $title = esc_html(implode(' ', array_slice(explode(' ', $full_title), 0, 4)));
                        $raw_title = esc_attr($full_title);
                        $image = $item['Images']['Primary']['Large']['URL'] ?? '';
                        $price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? 'N/A';
                        $base_price = $price;
                        $availability = $item['Offers']['Listings'][0]['Availability']['Message'] ?? 'In Stock';
                        $product_url = $item['DetailPageURL'] ?? '#';
                        $features = $item['ItemInfo']['Features']['DisplayValues'] ?? [];
                        $features_string = implode(' ', $features);
                        $combined_string = $features_string . ' ' . $full_title;

                        // Extract monitor attributes
                        preg_match('/(\d+(\.\d+)?)\s*(inches?|")/i', $combined_string, $screen_size_match);
                        preg_match('/(\d{4}x\d{4}|\d{3}0p)/i', $combined_string, $resolution_match);
                        preg_match('/(\d+(\.\d+)?\s*Hz)/i', $combined_string, $refresh_rate_match);
                        //preg_match('/(\d+\s*ms)/i', $combined_string, $response_time_match);
                        preg_match('/(IPS|TN|VA|OLED)/i', $combined_string, $panel_type_match);
                        preg_match('/(16:9|21:9|4:3|32:9)/i', $combined_string, $aspect_ratio_match);
                        //preg_match('/\b(16:9|21:9|32:9|16:10|4:3|5:4|3:2|1:1)\b/i', $combined_string, $aspect_ratio_match);

                        // Check for direct aspect ratio match in features or title
preg_match('/\b(16:9|21:9|32:9|16:10|4:3|5:4|3:2|1:1)\b/i', $combined_string, $aspect_ratio_match);
$aspect_ratio = $aspect_ratio_match[1] ?? null;

// Fallback: Check product details like ItemInfo['ProductInfo']['AspectRatio']
if (!$aspect_ratio && isset($item['ItemInfo']['ProductInfo']['AspectRatio']['DisplayValue'])) {
    $aspect_ratio = trim($item['ItemInfo']['ProductInfo']['AspectRatio']['DisplayValue']);
}

// Fallback: Infer from resolution
if (!$aspect_ratio && preg_match('/(\d{3,4})\s*[xX×]\s*(\d{3,4})/', $combined_string, $res_match)) {
    $width = (int)$res_match[1];
    $height = (int)$res_match[2];
    if ($height > 0) {
        $gcd = function($a, $b) use (&$gcd) {
            return ($b == 0) ? $a : $gcd($b, $a % $b);
        };
        $factor = $gcd($width, $height);
        $ar_w = $width / $factor;
        $ar_h = $height / $factor;
        $aspect_ratio = "{$ar_w}:{$ar_h}";
    }
}

                        $screen_size = isset($screen_size_match[1]) ? number_format($screen_size_match[1], 1) . '"' : '-';
                        $resolution = $resolution_match[1] ?? '-';
                        $refresh_rate = $refresh_rate_match[1] ?? '-';
                        //$response_time = $response_time_match[1] ?? '-';
                        $panel_type = $panel_type_match[1] ?? '-';
                        //$aspect_ratio = isset($aspect_ratio_match[1]) ? trim($aspect_ratio_match[1]) : '-';

                        $rating = $item['CustomerReviews']['StarRating']['DisplayValue'] ?? null;
                        $rating_count = $item['CustomerReviews']['Count'] ?? null;
                        $rating_display = ($rating !== null && $rating_count !== null) ? number_format($rating, 1) . ' / 5 (' . number_format($rating_count) . ')' : '-';
                    ?>
                    <tr style="background-color: <?php echo $row_bg; ?>; border-bottom:1px solid #DDD; font-size: 14px">
                        <td style="font-weight:800; padding:10px; display:flex; align-items:center; gap:10px;" title="<?php echo $raw_title; ?>">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo $title; ?>" style="width:100px; height:100px; object-fit:cover; border-radius:4px;" />
                            <?php echo $title; ?>
                        </td>
                        <td style="padding:10px;"><?php echo esc_html($screen_size); ?></td>
                        <td style="padding:10px;"><?php echo esc_html($resolution); ?></td>
                        <td style="padding:10px;"><?php echo esc_html($refresh_rate); ?></td>
                        <!-- <td style="padding:10px;"><?php //echo esc_html($response_time); ?></td> -->
                        <td style="padding:10px;"><?php echo esc_html($panel_type); ?></td>
                        <td style="padding:10px;"><?php echo esc_html($aspect_ratio); ?></td>
                        <td style="padding:10px;"><?php echo esc_html($rating_display); ?></td>
                        <td style="padding:10px;"><?php echo esc_html($price); ?></td>
                        <td style="padding:10px;">
                            <button class="add-to-builder"
                                data-asin="<?php echo esc_attr($asin); ?>"
                                data-title="<?php echo esc_attr($full_title); ?>"
                                data-image="<?php echo esc_url($image); ?>"
                                data-base="<?php echo esc_attr($base_price); ?>"
                                data-shipping="FREE"
                                data-availability="<?php echo esc_attr($availability); ?>"
                                data-price="<?php echo esc_attr($base_price); ?>"
                                data-category="Monitor"
                                data-affiliate-url="<?php echo esc_url($product_url); ?>"
                                data-features="<?php echo esc_attr(implode(', ', $features)); ?>"
                                style="padding:10px 18px; background-color:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer;">
                                <?php _e('Add to Builder', 'aawp-pcbuild'); ?>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const sliderContainer = document.getElementById("price-slider");
            const minLabel = document.getElementById("price-min-label");
            const maxLabel = document.getElementById("price-max-label");

            if (!table || !sliderContainer || !minLabel || !maxLabel) {
                console.warn("Table, slider container, or labels not found.");
                return;
            }

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            if (!rows.length) {
                console.warn("No rows found in table.");
                return;
            }

            // 🟡 Column 8 is the Price column
            const prices = rows.map(row => {
                const priceText = row.querySelector("td:nth-child(8)")?.textContent || "";
                const price = parseFloat(priceText.replace(/[^0-9.]/g, ""));
                row.dataset.price = isNaN(price) ? 0 : price; // optional but useful for later
                return isNaN(price) ? 0 : price;
            });

            const minPrice = Math.floor(Math.min(...prices));
            const maxPrice = Math.ceil(Math.max(...prices));

            minLabel.textContent = `$${minPrice}`;
            maxLabel.textContent = `$${maxPrice}`;

            sliderContainer.innerHTML = `
                <input type="range" id="min-price" min="${minPrice}" max="${maxPrice}" value="${minPrice}" step="1" style="width: 100%;">
                <input type="range" id="max-price" min="${minPrice}" max="${maxPrice}" value="${maxPrice}" step="1" style="width: 100%; margin-top: 10px;">
            `;

            const minSlider = document.getElementById("min-price");
            const maxSlider = document.getElementById("max-price");

            function filterByPrice() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);

                minLabel.textContent = `$${minVal}`;
                maxLabel.textContent = `$${maxVal}`;

                rows.forEach(row => {
                    const price = parseFloat(row.dataset.price || 0);
                    const show = price >= minVal && price <= maxVal;
                    row.style.display = show ? "" : "none";
                });
            }

            minSlider.addEventListener("input", () => {
                if (parseFloat(minSlider.value) > parseFloat(maxSlider.value)) {
                    minSlider.value = maxSlider.value;
                }
                filterByPrice();
            });

            maxSlider.addEventListener("input", () => {
                if (parseFloat(maxSlider.value) < parseFloat(minSlider.value)) {
                    maxSlider.value = minSlider.value;
                }
                filterByPrice();
            });

            filterByPrice(); // Initial run
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById("pcbuild-table");
            const headers = table.querySelectorAll(".sortable-header");

            let currentSort = { key: null, direction: 'asc' };

            headers.forEach(header => {
                header.addEventListener('click', function () {
                    const key = this.dataset.key;
                    currentSort.direction = (currentSort.key === key && currentSort.direction === 'asc') ? 'desc' : 'asc';
                    currentSort.key = key;

                    // Reset all headers
                    headers.forEach(h => {
                        const label = h.textContent.trim().replace(/^▲|▼|▶/, '');
                        h.innerHTML = `&#9654; ${label}`;
                    });

                    // Update clicked header
                    const label = this.textContent.trim().replace(/^▲|▼|▶/, '');
                    this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${label}`;

                    sortTableByKey(key, currentSort.direction);
                });
            });

            function sortTableByKey(key, direction) {
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));
                const columnIndex = getColumnIndex(key);
                if (!columnIndex) return;

                rows.sort((a, b) => {
                    const getValue = row => row.querySelector(`td:nth-child(${columnIndex})`)?.innerText.trim().toLowerCase() || '';

                    const valA = parseValue(getValue(a), key);
                    const valB = parseValue(getValue(b), key);

                    if (typeof valA === 'number' && typeof valB === 'number') {
                        return direction === 'asc' ? valA - valB : valB - valA;
                    }

                    return direction === 'asc' ? String(valA).localeCompare(valB) : String(valB).localeCompare(valA);
                });

                rows.forEach((row, index) => {
                    row.style.backgroundColor = index % 2 === 0 ? '#d4d4d4' : '#ebebeb';
                    tbody.appendChild(row);
                });
            }

            function parseValue(value, key) {
                switch (key) {
                    case 'screen-size':        // e.g., 27"
                    case 'refresh-rate':       // e.g., 144 Hz
                    case 'response-time':      // e.g., 1ms
                    case 'price':              // e.g., $199.99
                        return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;

                    case 'resolution':         // e.g., 1920x1080
                        const res = value.match(/(\d+)\s*[x×]\s*(\d+)/);
                        return res ? parseInt(res[1]) * parseInt(res[2]) : 0;

                    case 'aspect-ratio':       // e.g., 16:9
                        const ar = value.match(/(\d+):(\d+)/);
                        return ar ? parseFloat(ar[1]) / parseFloat(ar[2]) : 0;

                    case 'rating':             // e.g., 4.5 out of 5
                        const match = value.match(/([\d.]+)/);
                        return match ? parseFloat(match[1]) : 0;

                    default:
                        return value;
                }
            }

            function getColumnIndex(key) {
                const ths = Array.from(table.querySelectorAll("thead th"));
                return ths.findIndex(th => th.dataset.key === key) + 1;
            }
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('pcbuild_parts_monitor', 'aawp_pcbuild_display_parts_monitor');
