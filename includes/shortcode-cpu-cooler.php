<?php
function aawp_pcbuild_display_parts_cpu_cooler($atts) {
    $atts = shortcode_atts(array('category' => 'cpu-cooler'), $atts);
    $input_category = sanitize_title($atts['category']);

    $category_map = [
        'cpu-cooler' => 'CPU Cooler',
    ];

    $category = $category_map[$input_category] ?? 'CPU Cooler';

    // Create transient key (MATCH naming)
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

    // Pagination
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
            <!-- Sidebar -->
            <div class="pcbuild-sidebar" style="width:250px; background:#f9f9f9; padding:20px; border-radius:8px;">
                <div style="margin-bottom:20px;"><strong>Part</strong> | <strong>List</strong></div>
                <!-- <div style="margin-bottom:20px;"><label><input type="checkbox" checked disabled /> Compatibility Filter</label></div> -->
                <div style="margin-bottom:20px;">
                    <div>PARTS: <strong id="parts_count"></strong></div>
                    <div>TOTAL: <strong id="parts_total_price"></strong></div>
                </div>
                <div class="filter-group">
                    <div class="filter-header">
                        <strong>PRICE</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="price-filter" style="display: block;">
                        <div id="price-slider" style="margin-top: 15px;"></div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-top: 6px;">
                            <span id="price-min-label">$0</span>
                            <span id="price-max-label">$0</span>
                        </div>
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>MANUFACTURER</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="manufacturer-filter">
                        <label><input type="checkbox" id="manufacturer-all" checked> All</label><br/>
                        <!-- Checkboxes will be inserted here by JS -->
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>RATING</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="rating-filter">
                        <label><input type="checkbox" name="rating" value="all" checked /> All</label><br/>
                        <label><input type="checkbox" name="rating" value="5" /> <span style="color: orange;">★★★★★</span></label><br/>
                        <label><input type="checkbox" name="rating" value="4" /> <span style="color: orange;">★★★★☆</span></label><br/>
                        <label><input type="checkbox" name="rating" value="3" /> <span style="color: orange;">★★★☆☆</span></label><br/>
                        <label><input type="checkbox" name="rating" value="unrated" /> Unrated</label>
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>COLOR</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="color-filter">
                        <label><input type="checkbox" id="color-all" checked> All</label><br/>
                        <!-- Checkboxes for colors will be inserted here by JS -->
                    </div>
                </div>
                <div class="filter-group">
                    <div class="filter-header">
                        <strong>HEIGHT</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="height-filter" style="display: block;">
                        <div id="height-slider" style="margin-top: 15px;"></div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-top: 6px;">
                            <span id="height-min-label">0 mm</span>
                            <span id="height-max-label">0 mm</span>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Main Section -->
            <div style="flex:1;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <div id="total_products" style="font-weight:bold;"><?php echo $total_items; ?> Products</div>
                    <div><input type="text" id="pcbuild-search" placeholder="Search..." style="padding:6px 10px; border-radius:6px; border:1px solid #ccc;" /></div>
                </div>

                <table id="pcbuild-table" style="width:100%; border-collapse:collapse;">
                    <thead style="background:#f0f0f0;">
                        <tr>
                            <th class="sortable-header" data-key="name"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Name</span></th>
                            <th class="sortable-header" data-key="fan_rpm"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Fan RPM</span></th>
                            <th class="sortable-header" data-key="noise"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Noise Level</span></th>
                            <th class="sortable-header" data-key="radiator"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Radiator Size</span></th>
                            <th class="sortable-header" data-key="rating"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Rating</span></th>
                            <th class="sortable-header" data-key="price"><span class="sort-header-label"><span class="sort-arrow">&#9654;</span> Price</span></th>
                            <th style="padding:10px;">Action</th>
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
                            $manufacturer = $item['ItemInfo']['ByLineInfo']['Manufacturer']['DisplayValue'] ?? 'Unknown';
                            $color = $item['ItemInfo']['ProductInfo']['Color']['DisplayValue'] ?? '';
                            
                            // Get customer review
                            $rating = $item['CustomerReviews']['StarRating']['DisplayValue'] ?? null;
                            $rating_count = $item['CustomerReviews']['Count'] ?? null;

                            // Format the rating display
                            $rating_display = ($rating !== null && $rating_count !== null) 
                                ? number_format($rating, 1) . ' / 5 (' . number_format($rating_count) . ' reviews)' 
                                : '-';
                             
                            // Get height and convert to mm (assuming it's in inches by default)
                            $height_in = $item['ItemInfo']['ProductInfo']['ItemDimensions']['Height']['DisplayValue'] ?? '';
                            $height_unit = $item['ItemInfo']['ProductInfo']['ItemDimensions']['Height']['Unit'] ?? '';
                            $height_mm = '';

                            if ($height_in !== '' && strtolower($height_unit) === 'inches') {
                                $height_mm = round(floatval($height_in) * 25.4, 1); // Convert inches to mm
                            } elseif ($height_in !== '' && strtolower($height_unit) === 'millimeters') {
                                $height_mm = floatval($height_in);
                            }

                            // Extract values
                            preg_match('/(\d{3,4})\s?RPM/i', $features_string, $rpm_match);
                            preg_match('/(\d+(\.\d+)?\s?dB)/i', $features_string, $noise_match);
                            preg_match('/(120|240|280|360)\s?mm/i', $features_string, $rad_match);
                            //preg_match_all('/(AM4|AM5|LGA ?1200|LGA ?1700|LGA ?1151|LGA ?2066|TR4|sTRX4|FM2\+?)/i', $features_string . ' ' . $full_title, $socket_matches);
                            preg_match_all('/(AM4|AM5|FM2\+?|TR4|sTRX4|LGA ?(1150|1151|1155|1200|1700|1851|2066))/i', $features_string . ' ' . $full_title, $socket_matches);

                            $fan_rpm = $rpm_match[1] ?? '-';
                            $noise_level = $noise_match[1] ?? '-';
                            $radiator = $rad_match[1] ?? '-';
                            $compatible_sockets = array_map('trim', array_unique($socket_matches[1]));
                            if (empty($compatible_sockets)) $compatible_sockets[] = 'all';
                            $socket = implode(',', $compatible_sockets);

                        ?>
                        <tr style="background-color: <?php echo $row_bg; ?>; border-bottom:1px solid #DDD; font-size: 16px"
                            data-compatible-sockets="<?php echo esc_attr(implode(',', $compatible_sockets)); ?>">
                            <td style="font-weight:800; padding:10px; display:flex; align-items:center; gap:10px;" title="<?php echo $raw_title; ?>">
                                <img src="<?php echo $raw_image; ?>" alt="<?php echo $title; ?>" style="width:125px; height:125px; object-fit:cover; border-radius:4px;" />
                                <?php echo $title; ?>
                            </td>
                            <td style="padding:10px;"><?php echo esc_html($fan_rpm); ?></td>
                            <td style="padding:10px;"><?php echo esc_html($noise_level); ?></td>
                            <td style="padding:10px;"><?php echo ($radiator !== '-') ? esc_html($radiator) . ' mm' : '-'; ?></td>
                            
                            <!-- <td style="padding:10px;"><?php //echo esc_html($rating_display); ?></td> -->
                            <td style="padding:10px;">
                                <?php if (!empty($product_url) && $rating_display !== '-'): ?>
                                    <a href="<?php echo esc_url($product_url); ?>" target="_blank" style="color: #0073aa; text-decoration: underline;">
                                        <?php echo esc_html($rating_display); ?>
                                    </a>
                                <?php else: ?>
                                    <?php echo esc_html($rating_display); ?>
                                <?php endif; ?>
                            </td>

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
                                    data-rating="<?php echo isset($rating_display) ? esc_attr($rating_display) : ''; ?>"
                                    data-socket="<?php echo isset($socket) ? esc_attr($socket) : ''; ?>"
                                    data-manufacturer="<?php echo esc_attr($manufacturer); ?>"
                                    data-color="<?php echo esc_attr($color); ?>"
                                    data-height="<?php echo esc_attr($height_mm); ?>"
                                    style="padding:10px 18px; background-color:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer;">
                                    <?php _e('Add to Builder', 'aawp-pcbuild'); ?>
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

    <script>
        // Compatibility Checking
        document.addEventListener('DOMContentLoaded', function () {

            const selectedCpuSocket = localStorage.getItem('selected_cpu_socket');
            console.log(selectedCpuSocket);

            const compatibilityToggle = document.createElement('div');
            compatibilityToggle.innerHTML = `
                <div style="margin-bottom:20px;">
                    <label>
                        <input type="checkbox" id="compatibility-toggle" checked /> 
                        Compatibility Filter
                    </label>
                </div>
            `;
            document.querySelector('.pcbuild-sidebar > div:first-child').after(compatibilityToggle);

            const noticeElement = document.createElement('div');
            noticeElement.id = 'compatibility-notice';
            noticeElement.style.display = 'none';
            noticeElement.style.marginBottom = '20px';
            noticeElement.style.padding = '10px';
            noticeElement.style.background = '#fff8e1';
            noticeElement.style.borderLeft = '4px solid #ffc107';
            noticeElement.innerHTML = '<strong>Compatibility Filter Active:</strong> <span id="compatibility-message"></span>';
            compatibilityToggle.after(noticeElement);

            filterCompatibleCoolers();

            document.getElementById('compatibility-toggle').addEventListener('change', function () {
                localStorage.setItem('cooler_compatibility_filter', this.checked ? 'on' : 'off');
                filterCompatibleCoolers();
            });

            // Delay to allow content to fully load before striping
            setTimeout(() => applyZebraStriping(), 50);
        });

        function filterCompatibleCoolers() {
            const compatibilityEnabled = localStorage.getItem('cooler_compatibility_filter') !== 'off';
            const noticeElement = document.getElementById('compatibility-notice');
            const messageElement = document.getElementById('compatibility-message');
            document.getElementById('compatibility-toggle').checked = compatibilityEnabled;

            const allRows = document.querySelectorAll('#pcbuild-table tbody tr');

            if (!compatibilityEnabled) {
                noticeElement.style.display = 'none';
                allRows.forEach(row => row.style.display = '');
                applyZebraStriping(); // Apply to all visible rows
                return;
            }

            const selectedCpuSocket = localStorage.getItem('selected_cpu_socket');
            if (selectedCpuSocket) {
                noticeElement.style.display = '';
                messageElement.textContent = `Showing only coolers compatible with ${selectedCpuSocket} socket`;

                let compatibleCount = 0;
                allRows.forEach(row => {
                    const sockets = row.dataset.compatibleSockets?.toUpperCase().split(',') || [];
                    if (sockets.includes(selectedCpuSocket.toUpperCase()) || sockets.includes('ALL')) {
                        row.style.display = '';
                        compatibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (compatibleCount === 0) {
                    noticeElement.innerHTML = `
                        <strong>No compatible coolers found!</strong>
                        <p>We couldn't find any coolers compatible with your ${selectedCpuSocket} socket CPU.</p>
                        <button onclick="document.getElementById('compatibility-toggle').click()" 
                                style="padding:5px 10px; background:#f44336; color:white; border:none; cursor:pointer;">
                            Show All Coolers Anyway
                        </button>
                    `;
                }

                applyZebraStriping(); // Apply to visible rows
            } else {
                noticeElement.style.display = 'none';
                allRows.forEach(row => row.style.display = '');
                applyZebraStriping(); // Apply to all
            }
        }

        function applyZebraStriping() {
            const visibleRows = Array.from(document.querySelectorAll('#pcbuild-table tbody tr')).filter(row => row.style.display !== 'none');
            visibleRows.forEach((row, index) => {
                row.style.backgroundColor = (index % 2 === 0) ? '#d4d4d4' : '#ebebeb';
            });
        }

    </script>

    <script>
    // Height filtering
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("pcbuild-table");
    const sliderContainer = document.getElementById("height-slider");
    const minLabel = document.getElementById("height-min-label");
    const maxLabel = document.getElementById("height-max-label");

    if (!table || !sliderContainer) return;

    const rows = Array.from(table.querySelectorAll("tbody tr"));

    // Extract height values from the "Add to Builder" button data-height attribute
    const heights = rows.map(row => {
        const button = row.querySelector(".add-to-builder");
        return button ? parseFloat(button.dataset.height) || 0 : 0;
    });

    const minHeight = Math.floor(Math.min(...heights));
    const maxHeight = Math.ceil(Math.max(...heights));

    // Set initial min and max height labels
    minLabel.textContent = `${minHeight} mm`;
    maxLabel.textContent = `${maxHeight} mm`;

    // Create the slider elements for height filtering
    sliderContainer.innerHTML = `
        <input type="range" class="min-range-bg" id="min-height" min="${minHeight}" max="${maxHeight}" value="${minHeight}" step="1" style="width: 100%;">
        <input type="range" class="max-range-bg" id="max-height" min="${minHeight}" max="${maxHeight}" value="${maxHeight}" step="1" style="width: 100%; margin-top: 10px;">
    `;

    const minSlider = document.getElementById("min-height");
    const maxSlider = document.getElementById("max-height");

    // Function to apply zebra striping to visible rows
    function applyZebraStripes() {
        let visibleIndex = 0;
        rows.forEach(row => {
            row.classList.remove("zebra-even", "zebra-odd");

            if (row.offsetParent !== null) { // row is visible
                if (visibleIndex % 2 === 0) {
                    row.classList.add("zebra-even");
                } else {
                    row.classList.add("zebra-odd");
                }
                visibleIndex++;
            }
        });
    }

    // Function to filter rows by height range
    function filterByHeight() {
        const minVal = parseFloat(minSlider.value);
        const maxVal = parseFloat(maxSlider.value);

        // Update min and max height labels based on slider values
        minLabel.textContent = `${minVal} mm`;
        maxLabel.textContent = `${maxVal} mm`;

        // Filter rows based on the height range
        rows.forEach(row => {
            const button = row.querySelector(".add-to-builder");
            const height = button ? parseFloat(button.dataset.height) || 0 : 0;
            row.style.display = (height >= minVal && height <= maxVal) ? "" : "none";
        });

        applyZebraStripes(); // Re-apply zebra striping after filtering
    }

    // Event listeners for the height sliders
    minSlider.addEventListener("input", () => {
        if (parseFloat(minSlider.value) > parseFloat(maxSlider.value)) {
            minSlider.value = maxSlider.value;
        }
        filterByHeight();
    });

    maxSlider.addEventListener("input", () => {
        if (parseFloat(maxSlider.value) < parseFloat(minSlider.value)) {
            maxSlider.value = minSlider.value;
        }
        filterByHeight();
    });

    // Initialize the filter
    filterByHeight();
});
</script>

<script>
    // Price filtering
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const sliderContainer = document.getElementById("price-slider");
            const minLabel = document.getElementById("price-min-label");
            const maxLabel = document.getElementById("price-max-label");

            if (!table || !sliderContainer) return;

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const prices = rows.map(row => {
                const priceText = row.querySelector("td:nth-child(6)")?.textContent.replace(/[^0-9.]/g, '') || "0";
                return parseFloat(priceText) || 0;
            });

            const minPrice = Math.floor(Math.min(...prices));
            const maxPrice = Math.ceil(Math.max(...prices));
            let currentMin = minPrice;
            let currentMax = maxPrice;

            minLabel.textContent = `$${minPrice}`;
            maxLabel.textContent = `$${maxPrice}`;

            sliderContainer.innerHTML = `
                <input type="range" class="min-range-bg" id="min-price" min="${minPrice}" max="${maxPrice}" value="${minPrice}" step="1" style="width: 100%;">
                <input type="range" class="max-range-bg" id="max-price" min="${minPrice}" max="${maxPrice}" value="${maxPrice}" step="1" style="width: 100%; margin-top: 10px;">
            `;

            const minSlider = document.getElementById("min-price");
            const maxSlider = document.getElementById("max-price");

            function filterByPrice() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);

                minLabel.textContent = `$${minVal}`;
                maxLabel.textContent = `$${maxVal}`;

                rows.forEach(row => {
                    const priceText = row.querySelector("td:nth-child(6)")?.textContent.replace(/[^0-9.]/g, '') || "0";
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

            filterByPrice();
        });
    </script>


    <script>
    // Color filtering
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("pcbuild-table");
    const tableRows = table.querySelectorAll("tbody tr");
    const colorFilterContainer = document.getElementById("color-filter");
    const colorSet = new Set();
    const VISIBLE_COUNT = 4;
    let expanded = false;

    // Normalize function (e.g., "BLACK", "black" -> "Black")
    function normalizeColor(color) {
        return color.charAt(0).toUpperCase() + color.slice(1).toLowerCase();
    }

    // Collect unique normalized colors
    tableRows.forEach(row => {
        let rawColor = row.querySelector("button.add-to-builder")?.dataset.color || "Unknown";
        let normalizedColor = normalizeColor(rawColor);
        row.querySelector("button.add-to-builder").dataset.colorNormalized = normalizedColor;
        colorSet.add(normalizedColor);
    });

    // Prepare color checkboxes
    const colors = Array.from(colorSet).sort();
    const colorCheckboxElements = [];
    colors.forEach(color => {
        const label = document.createElement("label");
        label.innerHTML = `<input type="checkbox" name="color" value="${color}" checked> ${color}`;
        label.style.display = 'block';
        colorCheckboxElements.push(label);
    });

    // Append color checkboxes to container
    colorCheckboxElements.forEach((el, index) => {
        if (index >= VISIBLE_COUNT) {
            el.style.display = 'none';
        }
        colorFilterContainer.appendChild(el);
    });

    // Add Show more / Show less link
    const colorToggleLink = document.createElement("a");
    colorToggleLink.href = "#";
    colorToggleLink.textContent = "Show more";
    colorToggleLink.style.display = (colorCheckboxElements.length > VISIBLE_COUNT) ? "inline-block" : "none";
    colorToggleLink.style.marginTop = "5px";
    colorToggleLink.style.fontSize = "14px";
    colorToggleLink.style.color = "#0066cc";
    colorFilterContainer.appendChild(colorToggleLink);

    // Zebra stripe function
    function applyZebraStriping() {
        const visibleRows = Array.from(table.querySelectorAll("tbody tr")).filter(row => row.style.display !== "none");
        visibleRows.forEach((row, index) => {
            row.style.backgroundColor = (index % 2 === 0) ? "#d4d4d4" : "#ebebeb";
        });
    }

    const allColorCheckbox = document.getElementById("color-all");

    function updateAllColorCheckboxState() {
        const allBoxes = Array.from(document.querySelectorAll("input[name='color']"));
        const checkedBoxes = allBoxes.filter(cb => cb.checked);
        allColorCheckbox.checked = checkedBoxes.length === allBoxes.length;
    }

    function applyColorFilter() {
        const selectedColors = Array.from(document.querySelectorAll("input[name='color']:checked"))
            .map(cb => cb.value);

        tableRows.forEach(row => {
            const color = row.querySelector("button.add-to-builder")?.dataset.colorNormalized;
            const show = selectedColors.includes(color);
            row.style.display = show ? "" : "none";
        });

        updateAllColorCheckboxState();
        applyZebraStriping();
    }

    // Toggle "All"
    allColorCheckbox.addEventListener("change", function () {
        const allBoxes = document.querySelectorAll("input[name='color']");
        allBoxes.forEach(cb => cb.checked = allColorCheckbox.checked);
        applyColorFilter();
    });

    // Individual checkbox change
    colorFilterContainer.addEventListener("change", function (e) {
        if (e.target.name === "color") {
            applyColorFilter();
        }
    });

    // Show more/less logic
    colorToggleLink.addEventListener("click", function (e) {
        e.preventDefault();
        expanded = !expanded;

        colorCheckboxElements.forEach((el, index) => {
            if (index >= VISIBLE_COUNT) {
                el.style.display = expanded ? "block" : "none";
            }
        });

        colorToggleLink.textContent = expanded ? "Show less" : "Show more";
    });

    // Initial apply
    applyColorFilter();
});
</script>


    <script>
    // Manufacturer filtering
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("pcbuild-table");
    const tableRows = table.querySelectorAll("tbody tr");
    const filterContainer = document.getElementById("manufacturer-filter");
    const manufacturerSet = new Set();

    const VISIBLE_COUNT = 4; // How many manufacturers to show initially
    let expanded = false;

    // Collect unique manufacturers
    tableRows.forEach(row => {
        const manufacturer = row.querySelector("button.add-to-builder")?.dataset.manufacturer || "Unknown";
        manufacturerSet.add(manufacturer);
    });

    // Prepare checkboxes
    const manufacturers = Array.from(manufacturerSet).sort(); // Sort alphabetically
    const checkboxElements = [];

    manufacturers.forEach(manufacturer => {
        const label = document.createElement("label");
        label.innerHTML = `<input type="checkbox" name="manufacturer" value="${manufacturer}" checked> ${manufacturer}`;
        label.style.display = 'block'; // Ensure each on its own line
        checkboxElements.push(label);
    });

    // Append checkboxes to container
    checkboxElements.forEach((el, index) => {
        if (index >= VISIBLE_COUNT) {
            el.style.display = 'none';
        }
        filterContainer.appendChild(el);
    });

    // Add Show more / Show less link
    const toggleLink = document.createElement("a");
    toggleLink.href = "#";
    toggleLink.textContent = "Show more";
    toggleLink.style.display = (checkboxElements.length > VISIBLE_COUNT) ? "inline-block" : "none";
    toggleLink.style.marginTop = "5px";
    toggleLink.style.fontSize = "14px";
    toggleLink.style.color = "#0066cc";
    filterContainer.appendChild(toggleLink);

    // Zebra stripe function
    function applyZebraStriping() {
        const visibleRows = Array.from(table.querySelectorAll("tbody tr")).filter(row => row.style.display !== "none");
        visibleRows.forEach((row, index) => {
            row.style.backgroundColor = (index % 2 === 0) ? "#d4d4d4" : "#ebebeb";
        });
    }

    const allCheckbox = document.getElementById("manufacturer-all");

    function updateAllCheckboxState() {
        const allBoxes = Array.from(document.querySelectorAll("input[name='manufacturer']"));
        const checkedBoxes = allBoxes.filter(cb => cb.checked);
        allCheckbox.checked = checkedBoxes.length === allBoxes.length;
    }

    function applyManufacturerFilter() {
        const selected = Array.from(document.querySelectorAll("input[name='manufacturer']:checked"))
            .map(cb => cb.value);

        tableRows.forEach(row => {
            const manufacturer = row.querySelector("button.add-to-builder")?.dataset.manufacturer;
            const show = selected.includes(manufacturer);
            row.style.display = show ? "" : "none";
        });

        updateAllCheckboxState();
        applyZebraStriping();
    }

    // Toggle "All"
    allCheckbox.addEventListener("change", function () {
        const allBoxes = document.querySelectorAll("input[name='manufacturer']");
        allBoxes.forEach(cb => cb.checked = allCheckbox.checked);
        applyManufacturerFilter();
    });

    // Individual checkbox change
    filterContainer.addEventListener("change", function (e) {
        if (e.target.name === "manufacturer") {
            applyManufacturerFilter();
        }
    });

    // Show more/less logic
    toggleLink.addEventListener("click", function (e) {
        e.preventDefault();
        expanded = !expanded;

        checkboxElements.forEach((el, index) => {
            if (index >= VISIBLE_COUNT) {
                el.style.display = expanded ? "block" : "none";
            }
        });

        toggleLink.textContent = expanded ? "Show less" : "Show more";
    });

    // Initial apply
    applyManufacturerFilter();
});
</script>

<script>
        // SORTING LOGIC
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById("pcbuild-table");
            if (!table) return;

            const headers = table.querySelectorAll(".sortable-header");

            let currentSort = { key: null, direction: 'asc' };

            headers.forEach(header => {
                header.addEventListener('click', function () {
                    const key = this.dataset.key;
                    currentSort.direction = (currentSort.key === key && currentSort.direction === 'asc') ? 'desc' : 'asc';
                    currentSort.key = key;

                    // Reset all header icons
                    headers.forEach(h => {
                        h.innerHTML = `&#9654; ${h.textContent.trim().replace(/^▲|▼|▶/, '')}`;
                    });

                    // Show active arrow direction
                    this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${this.textContent.trim().replace(/^▲|▼|▶/, '')}`;

                    // Sort rows by selected column
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

                    // Try parsing numbers for numeric sort
                    const numA = parseFloat(valA.replace(/[^\d.]/g, ''));
                    const numB = parseFloat(valB.replace(/[^\d.]/g, ''));

                    if (!isNaN(numA) && !isNaN(numB)) {
                        return direction === 'asc' ? numA - numB : numB - numA;
                    }

                    return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                });

                // Apply row backgrounds again after sort
                rows.forEach((row, i) => {
                    row.style.backgroundColor = (i % 2 === 0) ? '#d4d4d4' : '#ebebeb';
                    tbody.appendChild(row);
                });
            }

            // Column index mapping
            function getColumnIndex(key) {
                const mapping = {
                    name: 1,
                    fan_rpm: 2,
                    noise: 3,
                    radiator: 4,
                    rating: 5,
                    price: 6
                };
                return mapping[key];
            }
        });
    </script> 

    <?php
    return ob_get_clean();
}
add_shortcode('pcbuild_parts_cpu_cooler', 'aawp_pcbuild_display_parts_cpu_cooler');
