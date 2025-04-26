<?php
function aawp_pcbuild_display_parts_gpu($atts) {
    $atts = shortcode_atts(array('category' => 'video-card'), $atts);
    $input_category = sanitize_title($atts['category']);
    
    $category_map = [
        'gpu' => 'Video Card',
        'video-card' => 'Video Card',
    ];
    
    $category = $category_map[$input_category] ?? 'Video Card';
    
    // Create transient key
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

            <!-- Main Table Section -->
            <div style="flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <div style="font-weight:bold;"><?php echo $total_items; ?> Products</div>
                    <div><input type="text" id="pcbuild-search" placeholder="Search..." style="padding:6px 10px; border-radius:6px; border:1px solid #ccc;" /></div>
                </div>

                <table id="pcbuild-table" style="width:100%; border-collapse:collapse;">
                    <thead style="background:#f0f0f0;">
                        <tr>
                            <th class="sortable-header" data-key="name">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Name
                                </span>
                            </th>                           
                            <th class="sortable-header" data-key="chipset">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Chipset
                                </span>
                            </th>
                            <th class="sortable-header" data-key="memory">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Memory
                                </span>
                            </th>
                            <th class="sortable-header" data-key="core_clock">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Core Clock
                                </span>
                            </th>
                            <th class="sortable-header" data-key="boost_clock">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Boost Clock
                                </span>
                            </th>
                            <th class="sortable-header" data-key="color">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Color
                                </span>
                            </th>
                            <!-- <th class="sortable-header" data-key="length">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Length
                                </span>
                            </th> -->
                            <th class="sortable-header" data-key="rating">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Rating
                                </span>
                            </th>
                            <th class="sortable-header" data-key="price">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Price
                                </span>
                            </th>
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

                            // Append title to features string for better matching
                            $combined_string = $features_string . ' ' . $full_title . ' ' . ($item['ItemInfo']['ProductInfo']['Size']['DisplayValue'] ?? '');

                            // Extract GPU attributes
                            preg_match('/(?:NVIDIA\s+)?(GeForce\s+RTX\s?\d{3,4}|GeForce\s+GTX\s?\d{3,4})|(?:AMD\s+)?(Radeon\s+RX\s?\d{3,4}|Radeon\s+HD\s?\d{3,4})/i', $combined_string, $chipset_match);
                            preg_match('/(\d+)\s*GB/i', $features_string . ' ' . $full_title, $memory_match);
                            preg_match('/(?:Core Clock|GPU Clock Speed|Base Clock|Heart stroke|OC Mode|Gaming Mode)[^0-9]{0,10}(\d{3,5})\s*MHz/i', $combined_string, $core_match);
                            $core = isset($core_match[1]) ? $core_match[1] . ' MHz' : '-';
                            preg_match('/Boost Clock[:\s]*([\d,]+)\s*MHz/i', $combined_string, $boost_match);
                            preg_match('/(Black|White|Red|Blue|Silver|Gray|RGB)/i', $combined_string, $color_match);
                            //preg_match('/L\s*=\s*(\d{2,3})\s*mm/i', $combined_string, $length_match);

                            $chipset = $chipset_match[0] ?? '-';
                            $memory = isset($memory_match[1]) ? $memory_match[1] . 'GB' : '-';
                            $core = isset($core_match[1]) ? $core_match[1] . ' MHz' : '-';
                            $boost = isset($boost_match[1]) ? $boost_match[1] . ' MHz' : '-';
                            $color = $color_match[1] ?? '-';
                            //$length = $length_match[1] ?? '-';

                            $rating = $item['CustomerReviews']['StarRating']['DisplayValue'] ?? null;
                            $rating_count = $item['CustomerReviews']['Count'] ?? null;
                            $rating_display = ($rating !== null && $rating_count !== null) ? number_format($rating, 1) . ' / 5 (' . number_format($rating_count) . ' reviews)' : '-';
                        ?>

                        <tr style="background-color: <?php echo $row_bg; ?>; border-bottom:1px solid #DDD; font-size: 14px">
                            <td style="font-weight:800; padding:10px; display:flex; align-items:center; gap:10px;" title="<?php echo $raw_title; ?>">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo $title; ?>" style="width:100px; height:100px; object-fit:cover; border-radius:4px;" />
                                <?php echo $title; ?>
                            </td>
                            <td style="padding:10px;"><?php echo esc_html($chipset); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($memory); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($core); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($boost); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($color); ?></td>
                            <!-- <td style="padding:10px;"><?php //echo esc_html($length); ?> mm</td> -->
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
                                    data-category="<?php echo esc_attr($category); ?>"
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

            // Extract prices from the 8th column (Price)
            const prices = rows.map(row => {
                const cell = row.querySelector("td:nth-child(8)");
                if (!cell) return 0;

                const priceText = cell.textContent || "";
                const cleaned = priceText.replace(/[^0-9.]/g, "");
                const price = parseFloat(cleaned) || 0;
                return price;
            });

            const minPrice = Math.floor(Math.min(...prices));
            const maxPrice = Math.ceil(Math.max(...prices));

            // Set initial labels
            minLabel.textContent = `$${minPrice}`;
            maxLabel.textContent = `$${maxPrice}`;

            // Create sliders
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
                    const priceCell = row.querySelector("td:nth-child(8)");
                    const price = priceCell ? parseFloat(priceCell.textContent.replace(/[^0-9.]/g, "")) || 0 : 0;
                    row.style.display = (price >= minVal && price <= maxVal) ? "" : "none";
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

            filterByPrice(); // Apply initial filtering
        });
        </script>

        <script>
            // SORTING LOGIC for GPU TABLE
            document.addEventListener('DOMContentLoaded', () => {
                const table = document.getElementById("pcbuild-table");
                const headers = table.querySelectorAll(".sortable-header");

                let currentSort = { key: null, direction: 'asc' };

                headers.forEach(header => {
                    header.addEventListener('click', function () {
                        const key = this.dataset.key;
                        currentSort.direction = (currentSort.key === key && currentSort.direction === 'asc') ? 'desc' : 'asc';
                        currentSort.key = key;

                        // Reset header icons
                        headers.forEach(h => {
                            const text = h.textContent.trim().replace(/^▲|▼|▶/, '');
                            h.innerHTML = `&#9654; ${text}`;
                        });

                        // Set arrow icon on active header
                        const text = this.textContent.trim().replace(/^▲|▼|▶/, '');
                        this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${text}`;

                        sortTableByKey(key, currentSort.direction);
                    });
                });

                function sortTableByKey(key, direction) {
                    const tbody = table.querySelector("tbody");
                    const rows = Array.from(tbody.querySelectorAll("tr"));
                    const columnIndex = getColumnIndex(key);
                    if (!columnIndex) return;

                    rows.sort((a, b) => {
                        const getText = row => row.querySelector(`td:nth-child(${columnIndex})`)?.innerText.trim().toLowerCase() || '';

                        const valA = getText(a);
                        const valB = getText(b);

                        const parsedA = parseValue(valA, key);
                        const parsedB = parseValue(valB, key);

                        if (typeof parsedA === 'number' && typeof parsedB === 'number') {
                            return direction === 'asc' ? parsedA - parsedB : parsedB - parsedA;
                        }

                        return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                    });

                    rows.forEach((row, i) => {
                        row.style.backgroundColor = (i % 2 === 0) ? '#d4d4d4' : '#ebebeb';
                        tbody.appendChild(row);
                    });
                }

                function parseValue(value, key) {
                    switch (key) {
                        case 'price':
                            return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;

                        case 'rating':
                            return parseFloat(value) || 0;

                        case 'memory': // e.g., "8GB"
                            return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;

                        case 'core_clock':
                        case 'boost_clock': // e.g., "1605 MHz"
                            return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;

                        default:
                            return value;
                    }
                }

                function getColumnIndex(key) {
                    const headers = Array.from(table.querySelectorAll("thead th"));
                    return headers.findIndex(th => th.dataset.key === key) + 1;
                }
            });
        </script>

    <?php
    return ob_get_clean();
}
add_shortcode('pcbuild_parts_gpu', 'aawp_pcbuild_display_parts_gpu');

