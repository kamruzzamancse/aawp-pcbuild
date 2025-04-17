<?php
function aawp_pcbuild_display_parts($atts) {
    $atts = shortcode_atts(array('category' => 'CPU'), $atts);
    $input_category = sanitize_title($atts['category']);

    $category_map = [
        'cpu' => 'CPU',
        'gpu' => 'Video Card',
        'video-card' => 'Video Card',
        'motherboard' => 'Motherboard',
        'cpu-cooler' => 'CPU Cooler',
        'power-supply' => 'Power Supply',
        'ram' => 'Memory',
        'memory' => 'Memory',
        'storage' => 'Storage',
        'case' => 'Case',
        'pc-case' => 'Case',
        'monitor' => 'Monitor',
        'keyboard' => 'Keyboard',
        'mouse' => 'Mouse',
        'operating-system' => 'Operating System',
    ];

    $category = $category_map[$input_category] ?? 'CPU';
    //error_log("AAWP PCBuild: Loading products for category => " . $category);

    $products = aawp_pcbuild_get_products($category);

    if (!is_array($products) || empty($products['SearchResult']['Items'])) {
        return '<p class="aawp-error">No products found or error fetching data. Please try again later.</p>';
    }

    ob_start();
    ?>
    <div style="background-color:#41466c; padding:20px; color:#fff; font-size:24px; font-weight:bold; text-align:center; margin-bottom:40px">
            Choose A <?php echo esc_html($category); ?>
        </div>
    <div style="width:90%; margin:0 auto; font-family:sans-serif;">
        <div style="display:flex; gap:20px; margin-top:20px;">
            <!-- Sidebar -->
            <div style="width:250px; background:#f9f9f9; padding:20px; border-radius:8px;">
                <div style="margin-bottom:20px;">
                    <strong>Part</strong> | <strong>List</strong>
                </div>
                <div style="margin-bottom:20px;">
                    <label><input type="checkbox" checked disabled /> Compatibility Filter</label>
                </div>
                <div style="margin-bottom:20px;">
                    <div>PARTS: <strong>1</strong></div>
                    <div>TOTAL: <strong>$476.99</strong></div>
                </div>
                <div style="margin-bottom:20px;">
                    ESTIMATED WATTAGE: <strong style="color:#007bff;">120W</strong>
                </div>
                <div>
                    <strong>Filters</strong>
                    <div style="margin-top:10px;">
                        <label><input type="checkbox" checked /> Include mail-in rebates</label>
                    </div>
                </div>
            </div>

            <!-- Main Table Section -->
            <div style="flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <div style="font-weight:bold;">
                        <?php echo count($products['SearchResult']['Items']); ?> Compatible Products
                    </div>
                    <div>
                        <input type="text" id="pcbuild-search" placeholder="Search..." style="padding:6px 10px; border-radius:6px; border:1px solid #ccc;" />
                    </div>
                </div>

                <table id="pcbuild-table" style="width:100%; border-collapse:collapse;">
                    <thead style="background:#f0f0f0;">
                        <tr>
                            <th class="sortable-header" data-key="name">&#9654; Name</th>
                            <th class="sortable-header" data-key="core_count">&#9654; Core Count</th>
                            <th class="sortable-header" data-key="base_clock">&#9654; Base Clock</th>
                            <th class="sortable-header" data-key="boost_clock">&#9654; Boost Clock</th>
                            <th class="sortable-header" data-key="microarch">&#9654; Microarchitecture</th>
                            <th class="sortable-header" data-key="rating">&#9654; Rating</th>
                            <th class="sortable-header" data-key="price">&#9654; Price</th>
                            <th style="padding:10px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products['SearchResult']['Items'] as $index => $item):

                            // All your setup code here...
                            $row_bg = ($index % 2 === 0) ? '#d4d4d4' : '#ebebeb';

                            $asin = $item['ASIN'] ?? '';
                            $full_title = $item['ItemInfo']['Title']['DisplayValue'] ?? 'Unknown Product';
                            $title = esc_html(implode(' ', array_slice(explode(' ', $full_title), 0, 4)));
                            $raw_title = esc_attr($full_title);

                            $image = $item['Images']['Primary']['Large']['URL'] ??
                                    $item['Images']['Primary']['Medium']['URL'] ??
                                    $item['Images']['Primary']['Small']['URL'] ?? '';
                            $raw_image = esc_url($image);

                            $price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? 'N/A';
                            $base_price = $price;
                            $availability = $item['Offers']['Listings'][0]['Availability']['Message'] ?? 'In Stock';
                            $product_url = $item['DetailPageURL'] ?? '#';
                            $features = $item['ItemInfo']['Features']['DisplayValues'] ?? [];
                            $features_string = implode(' ', $features);

                            // Specs parsing
                            preg_match('/(\d+)[ -]?[Cc]ore/', $features_string, $core_match);
                            preg_match('/(\d+(\.\d+)?)[ ]?GHz/i', $features_string, $base_match);
                            preg_match('/(?:Boost Clock|Max Boost|Turbo Clock|Turbo Frequency|up to)[^\d]*([\d\.]+)\s?GHz/i', $features_string, $boost_match);
                            preg_match('/Zen\s?[\d\.]+|Zen\s?[a-zA-Z]+/', $features_string, $arch_match);

                            $core_count = $core_match[1] ?? '-';
                            $base_clock = $base_match[1] ?? '-';
                            $boost_clock = $boost_match[1] ?? '-';
                            $microarch = $arch_match[0] ?? '-';

                            $rating = $item['CustomerReviews']['StarRating']['DisplayValue'] ?? null;
                            $rating_count = $item['CustomerReviews']['Count'] ?? null;

                            $rating_display = ($rating !== null && $rating_count !== null)
                                ? number_format($rating, 1) . ' / 5 (' . number_format($rating_count) . ' reviews)'
                                : '-';

                        ?>
                        <tr style="background-color: <?php echo $row_bg; ?>; border-bottom:1px solid #DDD; font-size: 16px">
                            <td style="font-weight:800; padding:10px; display:flex; align-items:center; gap:10px;" title="<?php echo $raw_title; ?>">
                                <img src="<?php echo $raw_image; ?>" alt="<?php echo $title; ?>" style="width:125px; height:125px; object-fit:cover; border-radius:4px;" />
                                <?php echo $title; ?>
                            </td>
                            <td style="padding:10px;"><?php echo $core_count; ?></td>
                            <td style="padding:10px;"><?php echo $base_clock !== '-' ? $base_clock . ' GHz' : '-'; ?></td>
                            <td style="padding:10px;"><?php echo $boost_clock !== '-' ? $boost_clock . ' GHz' : '-'; ?></td>
                            <td style="padding:10px;"><?php echo $microarch; ?></td>
                            <td style="padding:10px;"><?php echo esc_html($rating_display); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($price); ?></td>
                            <td style="padding:10px;">
                                <button class="add-to-builder"
                                    data-asin="<?php echo esc_attr($asin); ?>"
                                    data-title="<?php echo esc_attr($full_title); ?>"
                                    data-image="<?php echo esc_url($image); ?>"
                                    data-base="<?php echo esc_attr($base_price); ?>"
                                    data-promo=""
                                    data-shipping="FREE"
                                    data-tax=""
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
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById("pcbuild-table");
        const headers = table.querySelectorAll(".sortable-header");

        let currentSort = { key: null, direction: 'asc' };

        headers.forEach(header => {
            header.addEventListener('click', function () {
                const key = this.dataset.key;

                // Toggle direction
                currentSort.direction = (currentSort.key === key && currentSort.direction === 'asc') ? 'desc' : 'asc';
                currentSort.key = key;

                // Reset arrow indicators
                headers.forEach(h => {
                    h.innerHTML = `&#9654; ${h.textContent.trim().replace(/^▲|▼|\▶/, '')}`;
                });

                // Set current arrow
                this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${this.textContent.trim().replace(/^▲|▼|\▶/, '')}`;

                sortTableByKey(key, currentSort.direction);
            });
        });

        function sortTableByKey(key, direction) {
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));

            rows.sort((a, b) => {
                const getText = row => row.querySelector(`td:nth-child(${getColumnIndex(key)})`)?.innerText.trim().toLowerCase() || '';
                const valA = getText(a);
                const valB = getText(b);

                if (!isNaN(parseFloat(valA)) && !isNaN(parseFloat(valB))) {
                    return direction === 'asc' ? parseFloat(valA) - parseFloat(valB) : parseFloat(valB) - parseFloat(valA);
                }

                return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
            });

            // Reattach sorted rows and reset row colors
            rows.forEach((row, i) => {
                row.style.backgroundColor = (i % 2 === 0) ?  '#d4d4d4' : '#ebebeb'; // light ash variations
                tbody.appendChild(row);
            });
        }

        function getColumnIndex(key) {
            const mapping = {
                name: 1,
                core_count: 2,
                base_clock: 3,
                boost_clock: 4,
                microarch: 5,
                rating: 6,
                price: 7
            };
            return mapping[key];
        }
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("pcbuild-search");
        const table = document.getElementById("pcbuild-table");

        if (!searchInput || !table) return;

        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const rows = table.querySelectorAll("tbody tr");

            rows.forEach(row => {
                const nameCell = row.querySelector("td:first-child");
                const nameText = nameCell?.textContent.toLowerCase() || "";
                row.style.display = nameText.includes(searchTerm) ? "" : "none";
            });
        });

        document.querySelectorAll(".add-to-builder").forEach(button => {
            button.addEventListener("click", function () {
                const category = button.dataset.category.toLowerCase();
                const productData = {
                    title: button.dataset.title,
                    image: button.dataset.image,
                    base: button.dataset.base,
                    promo: button.dataset.promo,
                    shipping: button.dataset.shipping,
                    tax: button.dataset.tax,
                    availability: button.dataset.availability,
                    price: button.dataset.price,
                    affiliateUrl: button.dataset.affiliateUrl,
                    asin: button.dataset.asin,
                    features: button.dataset.features,
                    rating: button.dataset.rating || ''
                };

                localStorage.setItem(`pcbuild_${category}`, JSON.stringify(productData));

                if (window.location.pathname.includes("/pcbuildparts/pc-build-parts")) {
                    if (typeof updateRow === "function") {
                        updateRow(category, productData);
                    }
                } else {
                    window.location.href = "/pcbuildparts/pc-build-parts/";
                }
            });
        });
    });
    </script>
    <style>
        .sortable-header {
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .sortable-header:hover {
            text-decoration: underline;
        }
        .entry-content thead th, .entry-content tr th {
            padding: 10px !important;
        }
    </style>
    <?php
    return ob_get_clean();
}
add_shortcode('pcbuild_parts', 'aawp_pcbuild_display_parts');
