<?php
function aawp_pcbuild_display_parts_memory($atts) {
    $atts = shortcode_atts(array('category' => 'memory'), $atts);
    $input_category = sanitize_title($atts['category']);

    $category_map = [
        'ram' => 'Memory',
        'memory' => 'Memory',
    ];

    $category = $category_map[$input_category] ?? 'Memory';
    
    //for caching
    /* $transient_key = 'aawp_pcbuild_' . md5($category);

    if (is_user_logged_in() && current_user_can('manage_options') && isset($_GET['clear_cache'])) {
        delete_transient($transient_key);
    }
    
    $products = get_transient($transient_key);

    if ($products === false) {
        $products = aawp_pcbuild_get_products($category);
        set_transient($transient_key, $products, HOUR_IN_SECONDS);
    } */

    $products = aawp_pcbuild_get_products($category);

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
                            <th class="sortable-header" data-key="speed">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Speed
                                </span>
                            </th>
                            <th class="sortable-header" data-key="modules">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Modules
                                </span>
                            </th>
                            <th class="sortable-header" data-key="price_per_gb">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Price / GB
                                </span>
                            </th>
                            <th class="sortable-header" data-key="color">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Color
                                </span>
                            </th>
                            <!-- <th class="sortable-header" data-key="first_word_latency">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> First Word Latency
                                </span>
                            </th> -->
                            <th class="sortable-header" data-key="cas_latency">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> CAS Latency
                                </span>
                            </th>
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
                            $raw_image = esc_url($image);
                            $price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? 'N/A';
                            $base_price = $price;
                            $availability = $item['Offers']['Listings'][0]['Availability']['Message'] ?? 'In Stock';
                            $product_url = $item['DetailPageURL'] ?? '#';
                            $features = $item['ItemInfo']['Features']['DisplayValues'] ?? [];
                            $features_string = implode(' ', $features);

                            // Extract from features string or title
                            preg_match('/(DDR\d)/i', $features_string . ' ' . $full_title, $ram_type_match);
                            preg_match('/(\d{3,4})\s?MHz/i', $features_string . ' ' . $full_title, $mhz_match);

                            // Combine if both parts are found
                            $speed = (isset($ram_type_match[1]) && isset($mhz_match[1]))
                                ? strtoupper($ram_type_match[1]) . '-' . $mhz_match[1]
                                : '-';

                            // Try to match "2x16GB", "2 x 16GB", etc.
                            preg_match('/(\d)\s?[xX×]\s?(\d+)\s?GB/i', $features_string . ' ' . $full_title, $modules_match);

                            $modules = isset($modules_match[1], $modules_match[2])
                                ? $modules_match[1] . ' x ' . $modules_match[2] . 'GB'
                                : '-';


                            preg_match('/(\d+)\s?[xX]\s?(\d+)\s?GB/i', $features_string, $modules_combo_match);
                            preg_match('/(Black|White|Red|Blue|Silver|Gray|RGB)/i', $features_string, $color_match);
                            preg_match('/(CL\d+)/i', $features_string, $cas_latency_match);
                            //preg_match('/(\d+(?:\.\d+)?\s*ns)/i', $features_string, $first_word_latency_match);

                            // Assign values
                            $total_gb = (isset($modules_combo_match[1], $modules_combo_match[2]))
                                ? (int)$modules_combo_match[1] * (int)$modules_combo_match[2]
                                : null;

                            $color = $color_match[1] ?? '-';
                            $cas_latency = $cas_latency_match[1] ?? '-';
                            $first_word_latency = $first_word_latency_match[1] ?? '-';

                            // Calculate price per GB
                            $price_per_gb = '-';
                            if ($total_gb) {
                                $price_value = floatval(preg_replace('/[^\d.]/', '', $base_price));
                                if ($price_value > 0) {
                                    $price_per_gb = '$' . number_format($price_value / $total_gb, 3);
                                }
                            }

                            // Rating
                            $rating = $item['CustomerReviews']['StarRating']['DisplayValue'] ?? null;
                            $rating_count = $item['CustomerReviews']['Count'] ?? null;
                            $rating_display = ($rating !== null && $rating_count !== null)
                                ? number_format($rating, 1) . ' / 5 (' . number_format($rating_count) . ' reviews)'
                                : '-';
                        ?>
                        <tr style="background-color: <?php echo $row_bg; ?>; border-bottom:1px solid #DDD; font-size: 14px">
                            <td style="font-weight:800; padding:10px; display:flex; align-items:center; gap:10px;" title="<?php echo $raw_title; ?>">
                                <img src="<?php echo $raw_image; ?>" alt="<?php echo $title; ?>" style="width:100px; height:100px; object-fit:cover; border-radius:4px;" />
                                <?php echo $title; ?>
                            </td>
                            <td style="padding:10px;"><?php echo esc_html($speed); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($modules); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($price_per_gb); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($color); ?></td>
                            <!-- <td style="padding:10px;"><?php //echo esc_html($first_word_latency); ?></td> -->
                            <td style="padding:10px;"><?php echo esc_html($cas_latency); ?></td>
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
                                    data-ram_type="<?php echo esc_attr($ram_type_match[1] ?? ''); ?>"
                                    data-ram_speed="<?php echo esc_attr($mhz_match[1] ?? ''); ?>"
                                    style="padding:10px 18px; background-color:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer;">
                                    <?php _e('Add to Builder', 'aawp-pcbuild'); ?>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

                <!-- Pagination UI -->
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
        // SORTING LOGIC for STORAGE TABLE
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById("pcbuild-table");
            const headers = table.querySelectorAll(".sortable-header");

            let currentSort = { key: null, direction: 'asc' };

            headers.forEach(header => {
                header.addEventListener('click', function () {
                    const key = this.dataset.key;
                    currentSort.direction = (currentSort.key === key && currentSort.direction === 'asc') ? 'desc' : 'asc';
                    currentSort.key = key;

                    // Reset all header arrows
                    headers.forEach(h => {
                        const text = h.textContent.trim().replace(/^▲|▼|\▶/, '');
                        h.innerHTML = `&#9654; ${text}`;
                    });

                    // Update arrow on active column
                    const text = this.textContent.trim().replace(/^▲|▼|\▶/, '');
                    this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${text}`;

                    // Sort the table
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

                    const numA = parseFloat(valA.replace(/[^\d.]/g, ''));
                    const numB = parseFloat(valB.replace(/[^\d.]/g, ''));

                    // Numeric sort if both values are valid numbers
                    if (!isNaN(numA) && !isNaN(numB)) {
                        return direction === 'asc' ? numA - numB : numB - numA;
                    }

                    // Otherwise sort as strings
                    return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                });

                // Re-apply zebra striping and re-attach rows
                rows.forEach((row, i) => {
                    row.style.backgroundColor = (i % 2 === 0) ? '#d4d4d4' : '#ebebeb';
                    tbody.appendChild(row);
                });
            }

            function getColumnIndex(key) {
                const headers = Array.from(document.querySelectorAll("#pcbuild-table thead th"));
                return headers.findIndex(th => th.dataset.key === key) + 1;
            }
        });
    </script>

    <!-- PRICE RANGE SLIDER FILTER -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const sliderContainer = document.getElementById("price-slider");
            const minLabel = document.getElementById("price-min-label");
            const maxLabel = document.getElementById("price-max-label");

            if (!table || !sliderContainer) return;

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const prices = rows.map(row => {
                // Assuming price is in the 8th column (index 8)
                const priceText = row.querySelector("td:nth-child(8)")?.textContent.replace(/[^0-9.]/g, '') || "0";
                return parseFloat(priceText) || 0;
            });

            const minPrice = Math.floor(Math.min(...prices));
            const maxPrice = Math.ceil(Math.max(...prices));
            let currentMin = minPrice;
            let currentMax = maxPrice;

            // Set default labels
            minLabel.textContent = `$${minPrice}`;
            maxLabel.textContent = `$${maxPrice}`;

            // Create 2 sliders
            sliderContainer.innerHTML = `
                <input type="range" id="min-price" min="${minPrice}" max="${maxPrice}" value="${minPrice}" step="1" style="width: 100%;">
                <input type="range" id="max-price" min="${minPrice}" max="${maxPrice}" value="${maxPrice}" step="1" style="width: 100%; margin-top: 10px;">
            `;

            const minSlider = document.getElementById("min-price");
            const maxSlider = document.getElementById("max-price");

            function filterByPrice() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);
                currentMin = minVal;
                currentMax = maxVal;

                minLabel.textContent = `$${minVal}`;
                maxLabel.textContent = `$${maxVal}`;

                rows.forEach(row => {
                    // Update selector to target the correct column (8th column for price)
                    const priceText = row.querySelector("td:nth-child(8)")?.textContent.replace(/[^0-9.]/g, '') || "0";
                    const price = parseFloat(priceText) || 0;

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

            // Initial filter apply
            filterByPrice();
        });

        // SORTING LOGIC for MEMORY TABLE
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById("pcbuild-table");
            const headers = table.querySelectorAll(".sortable-header");

            let currentSort = { key: null, direction: 'asc' };

            headers.forEach(header => {
                header.addEventListener('click', function () {
                    const key = this.dataset.key;
                    currentSort.direction = (currentSort.key === key && currentSort.direction === 'asc') ? 'desc' : 'asc';
                    currentSort.key = key;

                    // Reset all header arrows
                    headers.forEach(h => {
                        const text = h.textContent.trim().replace(/^▲|▼|\▶/, '');
                        h.innerHTML = `&#9654; ${text}`;
                    });

                    // Update arrow on active column
                    const text = this.textContent.trim().replace(/^▲|▼|\▶/, '');
                    this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${text}`;

                    // Sort the table
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

                    const numA = parseFloat(valA.replace(/[^\d.]/g, ''));
                    const numB = parseFloat(valB.replace(/[^\d.]/g, ''));

                    // Numeric sort if both values are valid numbers
                    if (!isNaN(numA) && !isNaN(numB)) {
                        return direction === 'asc' ? numA - numB : numB - numA;
                    }

                    // Otherwise sort as strings
                    return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                });

                // Re-apply zebra striping and re-attach rows
                rows.forEach((row, i) => {
                    row.style.backgroundColor = (i % 2 === 0) ? '#d4d4d4' : '#ebebeb';
                    tbody.appendChild(row);
                });
            }

            function getColumnIndex(key) {
                const headers = Array.from(document.querySelectorAll("#pcbuild-table thead th"));
                return headers.findIndex(th => th.dataset.key === key) + 1;
            }
        });
    </script>


    <?php
    return ob_get_clean();
}

add_shortcode('pcbuild_parts_memory', 'aawp_pcbuild_display_parts_memory');
?>
