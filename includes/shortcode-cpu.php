<?php
function aawp_pcbuild_display_parts_cpu($atts) {
    $atts = shortcode_atts(array('category' => 'CPU'), $atts);
    $input_category = sanitize_title($atts['category']);

    /* $category_map = [
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
    ]; */

    $category_map = [
        'cpu' => 'CPU',
    ];

    $category = $category_map[$input_category] ?? 'CPU';
    $products = aawp_pcbuild_get_products($category);

    if (!is_array($products) || empty($products['SearchResult']['Items'])) {
        return '<p class="aawp-error">No products found or error fetching data. Please try again later.</p>';
    }

    // Pagination setup
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
            <div style="width:250px; background:#f9f9f9; padding:20px; border-radius:8px;">
                <div style="margin-bottom:20px;"><strong>Part</strong> | <strong>List</strong></div>
                <div style="margin-bottom:20px;"><label><input type="checkbox" checked disabled /> Compatibility Filter</label></div>
                <div style="margin-bottom:20px;">
                    <div>PARTS: <strong id="parts_count"></strong></div>
                    <div>TOTAL: <strong id="parts_total_price"></strong></div>
                </div>
                <!-- <div style="margin-bottom:20px;">ESTIMATED WATTAGE: <strong style="color:#007bff;">120W</strong></div> -->
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
                        <span class="filter-title">MANUFACTURER</span>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="manufacturer-options">
                        <label><input type="checkbox" name="manufacturer" value="all" checked> All</label><br>
                        <label><input type="checkbox" name="manufacturer" value="amd"> AMD</label><br>
                        <label><input type="checkbox" name="manufacturer" value="intel"> Intel</label>
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
                        <strong>CORE COUNT</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="core-filter" style="display: block;">
                        <div id="core-slider" style="margin-top: 15px;"></div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-top: 6px;">
                            <span id="core-min-label">0</span>
                            <span id="core-max-label">0</span>
                        </div>
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>BASE CLOCK</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="base-clock-filter" style="display: block;">
                        <div id="base-clock-slider" style="margin-top: 15px;"></div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-top: 6px;">
                            <span id="base-clock-min-label">0</span>
                            <span id="base-clock-max-label">0</span>
                        </div>
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>BOOST CLOCK</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="boost-clock-filter" style="display: block;">
                        <div id="boost-clock-slider" style="margin-top: 15px;"></div>
                        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-top: 6px;">
                            <span id="boost-clock-min-label">0</span>
                            <span id="boost-clock-max-label">0</span>
                        </div>
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>MICROARCHITECTURE</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="microarchitecture-filter" style="display: block; flex-direction: column; gap: 4px; margin-top: 10px;">
                        <!-- Dynamically generated checkboxes including "All" -->
                    </div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top:20px;">
                    <div class="filter-header">
                        <strong>SOCKET</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="socket-filter" style="display: block;"></div>
                </div>
                <div class="filter-group" style="margin-bottom: 20px; margin-top: 20px;">
                    <div class="filter-header">
                        <strong>SERIES</strong>
                        <button class="filter-toggle">−</button>
                    </div>
                    <div class="filter-options" id="series-filter" style="display: block;">
                        <!-- Filter options will be dynamically populated here -->
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
                            <th class="sortable-header" data-key="core_count">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Core Count
                                </span>
                            </th>
                            <th class="sortable-header" data-key="base_clock">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Base Clock
                                </span>
                            </th>
                            <th class="sortable-header" data-key="boost_clock">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Boost Clock
                                </span>
                            </th>
                            <th class="sortable-header" data-key="microarch">
                                <span class="sort-header-label">
                                    <span class="sort-arrow">&#9654;</span> Microarchitecture
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
                            $image = $item['Images']['Primary']['Large']['URL'] ?? $item['Images']['Primary']['Medium']['URL'] ?? $item['Images']['Primary']['Small']['URL'] ?? '';
                            $raw_image = esc_url($image);
                            $price = $item['Offers']['Listings'][0]['Price']['DisplayAmount'] ?? 'N/A';
                            $base_price = $price;
                            $availability = $item['Offers']['Listings'][0]['Availability']['Message'] ?? 'In Stock';
                            $product_url = $item['DetailPageURL'] ?? '#';
                            $features = $item['ItemInfo']['Features']['DisplayValues'] ?? [];
                            $features_string = implode(' ', $features);
                            $combined_string = $features_string . ' ' . $full_title;

                            // Extract new data points
                            preg_match('/(\d+)[ -]?[Cc]ore/', $features_string, $core_match);
                            preg_match('/(\d+(\.\d+)?)[ ]?GHz/i', $features_string, $base_match);
                            preg_match('/(?:Boost Clock|Max Boost|Turbo Clock|Turbo Frequency|up to)[^\d]*([\d\.]+)\s?GHz/i', $features_string, $boost_match);
                            preg_match('/Zen\s?[\d\.]+|Zen\s?[a-zA-Z]+/', $features_string, $arch_match);
                            preg_match('/(AMD\s+(A6|A8|A10|A12|Athlon(?:\sII)?(?:\sX[2-4])?|E2-Series|EPYC|FX|Opteron|Phenom\sII\sX[2-6]|Ryzen\s[3-9](?:\sPRO)?|Sempron(?:\sX2)?|Threadripper)|Intel\s+(Celeron|Core\s(?:2\s(Duo|Extreme|Quad)|i[3-9]|i7\sExtreme|Core\sUltra\s[5-9])|Pentium(?:\sGold)?|Processor|Xeon\sE3?))/i', $features_string . ' ' . $full_title, $series_match);

                            // Replace your current socket detection with this:
                            $socket = '-';

                            // 1. Check TechnicalInfo first (most reliable)
                            if (isset($item['ItemInfo']['TechnicalInfo']['DisplayValues'])) {
                                foreach ($item['ItemInfo']['TechnicalInfo']['DisplayValues'] as $techInfo) {
                                    if (preg_match('/(AM[0-9]+|LGA\s?[0-9]+|sTRX4|TR4|sWRX8)/i', $techInfo, $matches)) {
                                        $socket = strtoupper(preg_replace('/^Socket\s*/i', '', $matches[0]));
                                        break;
                                    }
                                }
                            }

                            // 2. Fallback to Features
                            if ($socket === '-' && !empty($features_string)) {
                                preg_match('/(AM[0-9]+|LGA\s?[0-9]+|sTRX4|TR4|sWRX8)/i', $features_string, $matches);
                                if (!empty($matches)) {
                                    $socket = strtoupper(preg_replace('/^Socket\s*/i', '', $matches[0]));
                                }
                            }

                            // 3. Final fallback
                            if ($socket === '-' && !empty($product_url)) {
                                // Consider parsing from URL if needed
                            }

                            // Extract chipset
                            preg_match('/(?:X|B|A|Z|H)[0-9]{3}/i', $features_string, $chipset_match);
                            $chipset = $chipset_match[0] ?? '';

                            $core_count = $core_match[1] ?? '-';
                            $base_clock = $base_match[1] ?? '-';
                            $boost_clock = $boost_match[1] ?? '-';
                            $microarch = $arch_match[0] ?? '-';
                            $series = $series_match[0] ?? '-';
                            $rating = $item['CustomerReviews']['StarRating']['DisplayValue'] ?? null;
                            $rating_count = $item['CustomerReviews']['Count'] ?? null;
                            $rating_display = ($rating !== null && $rating_count !== null) ? number_format($rating, 1) . ' / 5 (' . number_format($rating_count) . ' reviews)' : '-';
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
                                    data-rating="<?php echo isset($rating_display) ? esc_attr($rating_display) : ''; ?>"
                                    data-socket="<?php echo isset($socket) ? esc_attr($socket) : ''; ?>"
                                    data-chipset="<?php echo isset($chipset) ? esc_attr($chipset) : ''; ?>"
                                    data-series="<?php echo isset($series) ? esc_attr($series) : ''; ?>"
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
        document.addEventListener("DOMContentLoaded", function () {
    const seriesFilterContainer = document.getElementById("series-filter");

    // Dynamically generate the series filter checkboxes from buttons
    const allSeries = [];
    document.querySelectorAll('.add-to-builder').forEach(button => {
        const series = button.getAttribute('data-series');
        if (series && !allSeries.includes(series)) {
            allSeries.push(series);  // Add unique series to the list
        }
    });

    // Create the "All" checkbox first
    const allCheckboxLabel = document.createElement("label");
    const allCheckbox = document.createElement("input");
    allCheckbox.type = "checkbox";
    allCheckbox.className = "series-filter";
    allCheckbox.value = "All";
    allCheckbox.checked = true;  // Set "All" to be checked by default

    allCheckboxLabel.appendChild(allCheckbox);
    allCheckboxLabel.appendChild(document.createTextNode("All"));
    allCheckboxLabel.style.display = "block";  // Ensure it appears on a new line

    // Append the "All" checkbox to the container
    seriesFilterContainer.appendChild(allCheckboxLabel);

    // Create checkboxes for each unique series
    allSeries.forEach(series => {
        const label = document.createElement("label");
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.className = "series-filter";
        checkbox.value = series;

        label.appendChild(checkbox);
        label.appendChild(document.createTextNode(series));
        label.style.display = "block";  // Ensure each checkbox appears on a new line

        // Append the generated label (with checkbox) to the container
        seriesFilterContainer.appendChild(label);
    });

    // Function to filter the series
    function filterBySeries() {
        const selectedSeries = Array.from(document.querySelectorAll(".series-filter"))
            .filter(filter => filter.checked && filter.value !== "All")
            .map(filter => filter.value.toLowerCase());

        const rows = Array.from(document.querySelectorAll("#pcbuild-table tbody tr"));

        rows.forEach(row => {
            const series = row.querySelector("button.add-to-builder")?.getAttribute("data-series")?.toLowerCase();
            if (!selectedSeries.length || selectedSeries.includes(series)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Function to check/uncheck the "All" checkbox based on the individual checkboxes
    function updateAllCheckboxState() {
        const allCheckbox = document.querySelector("input[value='All']");
        const seriesCheckboxes = document.querySelectorAll(".series-filter[value!='All']");
        const totalCheckboxes = seriesCheckboxes.length;
        const checkedCheckboxes = Array.from(seriesCheckboxes).filter(cb => cb.checked).length;

        // If all checkboxes are checked, check "All" checkbox
        if (checkedCheckboxes === totalCheckboxes) {
            allCheckbox.checked = true;
        } else {
            allCheckbox.checked = false;
        }
    }

    // Add event listeners to checkboxes for filtering
    const seriesFilters = document.querySelectorAll(".series-filter");
    seriesFilters.forEach(filter => {
        filter.addEventListener("change", function () {
            if (this.value === "All") {
                // If "All" checkbox is checked/unchecked, toggle all other checkboxes
                const allChecked = this.checked;
                seriesFilters.forEach(cb => {
                    if (cb.value !== "All") {
                        cb.checked = allChecked;
                    }
                });
            } else {
                // Update the "All" checkbox state based on the selection of individual checkboxes
                const allCheckbox = document.querySelector("input[value='All']");
                allCheckbox.checked = false; // Uncheck "All" checkbox if any checkbox is unchecked
            }

            filterBySeries();  // Apply the filter
            updateAllCheckboxState();  // Update the "All" checkbox state based on individual checkbox status
        });
    });

    // Initial filtering based on default selection
    filterBySeries();
});

    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const filterContainer = document.getElementById("socket-filter");

            if (!table || !filterContainer) return;

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const socketSet = new Set();

            // Extract unique socket values from data attributes in the "Add to Builder" buttons
            rows.forEach(row => {
                const btn = row.querySelector(".add-to-builder");
                const socket = btn?.getAttribute("data-socket")?.trim();
                if (socket) socketSet.add(socket);
            });

            const socketList = Array.from(socketSet).sort();

            // Add the "All" checkbox
            const allCheckboxWrapper = document.createElement("label");
            allCheckboxWrapper.style.display = "block";
            allCheckboxWrapper.innerHTML = `
                <input type="checkbox" class="socket-checkbox" value="all" checked>
                All
            `;
            filterContainer.appendChild(allCheckboxWrapper);

            // Add checkboxes for each socket type
            socketList.forEach(socket => {
                const label = document.createElement("label");
                label.style.display = "block";
                label.innerHTML = `
                    <input type="checkbox" class="socket-checkbox" value="${socket}">
                    ${socket}
                `;
                filterContainer.appendChild(label);
            });

            const checkboxes = () => filterContainer.querySelectorAll(".socket-checkbox");
            const allCheckbox = () => filterContainer.querySelector(".socket-checkbox[value='all']");

            function filterBySocket() {
                const selected = Array.from(checkboxes())
                    .filter(cb => cb.checked && cb.value !== "all")
                    .map(cb => cb.value);

                if (allCheckbox().checked || selected.length === 0) {
                    rows.forEach(row => row.style.display = "");
                } else {
                    rows.forEach(row => {
                        const btn = row.querySelector(".add-to-builder");
                        const socket = btn?.getAttribute("data-socket")?.trim();
                        row.style.display = selected.includes(socket) ? "" : "none";
                    });
                }
            }

            filterContainer.addEventListener("change", function (e) {
                const target = e.target;

                if (target.value === "all") {
                    if (target.checked) {
                        checkboxes().forEach(cb => {
                            if (cb.value !== "all") cb.checked = false;
                        });
                    }
                } else {
                    allCheckbox().checked = false;
                }

                filterBySocket();
            });

            filterBySocket(); // Apply filtering on load
        });
    </script>

    <script>
        // microarchitecture filtering
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const filterContainer = document.getElementById("microarchitecture-filter");

            if (!table || !filterContainer) return;

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const microSet = new Set();

            // Collect all unique microarchitectures
            rows.forEach(row => {
                const microText = row.querySelector("td:nth-child(5)")?.textContent.trim();
                if (microText) microSet.add(microText);
            });

            const microList = Array.from(microSet).sort();

            // Create "All" checkbox
            const allCheckboxWrapper = document.createElement("label");
            allCheckboxWrapper.style.display = "block";
            allCheckboxWrapper.innerHTML = `
                <input type="checkbox" class="micro-checkbox" value="all" checked>
                All
            `;
            filterContainer.appendChild(allCheckboxWrapper);

            // Create individual checkboxes
            microList.forEach(micro => {
                const id = `micro-${micro.replace(/\s+/g, '-').toLowerCase()}`;
                const label = document.createElement("label");
                label.style.display = "block";
                label.innerHTML = `
                    <input type="checkbox" class="micro-checkbox" value="${micro}">
                    ${micro}
                `;
                filterContainer.appendChild(label);
            });

            const checkboxes = () => filterContainer.querySelectorAll(".micro-checkbox");
            const allCheckbox = () => filterContainer.querySelector(".micro-checkbox[value='all']");

            function filterByMicro() {
                const selected = Array.from(checkboxes())
                    .filter(cb => cb.checked && cb.value !== "all")
                    .map(cb => cb.value);

                if (allCheckbox().checked || selected.length === 0) {
                    rows.forEach(row => row.style.display = "");
                } else {
                    rows.forEach(row => {
                        const microText = row.querySelector("td:nth-child(5)")?.textContent.trim();
                        row.style.display = selected.includes(microText) ? "" : "none";
                    });
                }
            }

            filterContainer.addEventListener("change", function (e) {
                const target = e.target;

                if (target.value === "all") {
                    if (target.checked) {
                        // Uncheck all others
                        checkboxes().forEach(cb => {
                            if (cb.value !== "all") cb.checked = false;
                        });
                    }
                } else {
                    allCheckbox().checked = false;
                }

                filterByMicro();
            });

            // Initial filter
            filterByMicro();
        });
    </script>

    <script>
        // BOOST CLOCK RANGE SLIDER FILTER
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const sliderContainer = document.getElementById("boost-clock-slider");
            const minLabel = document.getElementById("boost-clock-min-label");
            const maxLabel = document.getElementById("boost-clock-max-label");

            if (!table || !sliderContainer) return;

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const boostClocks = rows.map(row => {
                const clockText = row.querySelector("td:nth-child(4)")?.textContent.replace(/[^\d.]/g, '') || "0";
                return parseFloat(clockText) || 0;
            });

            const minClock = Math.floor(Math.min(...boostClocks));
            const maxClock = Math.ceil(Math.max(...boostClocks));
            let currentMin = minClock;
            let currentMax = maxClock;

            // Set default labels
            minLabel.textContent = `${minClock} GHz`;
            maxLabel.textContent = `${maxClock} GHz`;

            // Create 2 sliders
            sliderContainer.innerHTML = `
                <input type="range" class="min-range-bg" id="min-boost-clock" min="${minClock}" max="${maxClock}" value="${minClock}" step="0.1" style="width: 100%;">
                <input type="range" class="max-range-bg" id="max-boost-clock" min="${minClock}" max="${maxClock}" value="${maxClock}" step="0.1" style="width: 100%; margin-top: 10px;">
            `;

            const minSlider = document.getElementById("min-boost-clock");
            const maxSlider = document.getElementById("max-boost-clock");

            function filterByBoostClock() {
                const minVal = parseFloat(minSlider.value);
                const maxVal = parseFloat(maxSlider.value);
                currentMin = minVal;
                currentMax = maxVal;

                minLabel.textContent = `${minVal} GHz`;
                maxLabel.textContent = `${maxVal} GHz`;

                rows.forEach(row => {
                    const clockText = row.querySelector("td:nth-child(4)")?.textContent.replace(/[^\d.]/g, '') || "0";
                    const boostClock = parseFloat(clockText) || 0;

                    row.style.display = (boostClock >= minVal && boostClock <= maxVal) ? "" : "none";
                });
            }

            minSlider.addEventListener("input", () => {
                if (parseFloat(minSlider.value) > parseFloat(maxSlider.value)) {
                    minSlider.value = maxSlider.value;
                }
                filterByBoostClock();
            });

            maxSlider.addEventListener("input", () => {
                if (parseFloat(maxSlider.value) < parseFloat(minSlider.value)) {
                    maxSlider.value = minSlider.value;
                }
                filterByBoostClock();
            });

            // Initial filter apply
            filterByBoostClock();
        });
    </script>

    <script>
    // BASE CLOCK RANGE SLIDER FILTER
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("pcbuild-table");
        const sliderContainer = document.getElementById("base-clock-slider");
        const minLabel = document.getElementById("base-clock-min-label");
        const maxLabel = document.getElementById("base-clock-max-label");

        if (!table || !sliderContainer) return;

        const rows = Array.from(table.querySelectorAll("tbody tr"));
        const baseClocks = rows.map(row => {
            const clockText = row.querySelector("td:nth-child(3)")?.textContent.replace(/[^\d.]/g, '') || "0";
            return parseFloat(clockText) || 0;
        });

        const minClock = Math.floor(Math.min(...baseClocks));
        const maxClock = Math.ceil(Math.max(...baseClocks));
        let currentMin = minClock;
        let currentMax = maxClock;

        // Set default labels
        minLabel.textContent = `${minClock} GHz`;
        maxLabel.textContent = `${maxClock} GHz`;

        // Create 2 sliders
        sliderContainer.innerHTML = `
            <input type="range" class="min-range-bg" id="min-base-clock" min="${minClock}" max="${maxClock}" value="${minClock}" step="0.1" style="width: 100%;">
            <input type="range" class="max-range-bg" id="max-base-clock" min="${minClock}" max="${maxClock}" value="${maxClock}" step="0.1" style="width: 100%; margin-top: 10px;">
        `;

        const minSlider = document.getElementById("min-base-clock");
        const maxSlider = document.getElementById("max-base-clock");

        function filterByBaseClock() {
            const minVal = parseFloat(minSlider.value);
            const maxVal = parseFloat(maxSlider.value);
            currentMin = minVal;
            currentMax = maxVal;

            minLabel.textContent = `${minVal} GHz`;
            maxLabel.textContent = `${maxVal} GHz`;

            rows.forEach(row => {
                const clockText = row.querySelector("td:nth-child(3)")?.textContent.replace(/[^\d.]/g, '') || "0";
                const baseClock = parseFloat(clockText) || 0;

                row.style.display = (baseClock >= minVal && baseClock <= maxVal) ? "" : "none";
            });
        }

        minSlider.addEventListener("input", () => {
            if (parseFloat(minSlider.value) > parseFloat(maxSlider.value)) {
                minSlider.value = maxSlider.value;
            }
            filterByBaseClock();
        });

        maxSlider.addEventListener("input", () => {
            if (parseFloat(maxSlider.value) < parseFloat(minSlider.value)) {
                maxSlider.value = minSlider.value;
            }
            filterByBaseClock();
        });

        // Initial filter apply
        filterByBaseClock();
    });
</script>

    <script>
    // CORE COUNT RANGE SLIDER FILTER
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("pcbuild-table");
        const sliderContainer = document.getElementById("core-slider");
        const minLabel = document.getElementById("core-min-label");
        const maxLabel = document.getElementById("core-max-label");

        if (!table || !sliderContainer) return;

        const rows = Array.from(table.querySelectorAll("tbody tr"));
        const coreCounts = rows.map(row => {
            const coreText = row.querySelector("td:nth-child(2)")?.textContent.trim() || "0";
            return parseInt(coreText) || 0;
        });

        const minCore = Math.min(...coreCounts);
        const maxCore = Math.max(...coreCounts);
        let currentMin = minCore;
        let currentMax = maxCore;

        // Set default labels
        minLabel.textContent = `${minCore}`;
        maxLabel.textContent = `${maxCore}`;

        // Create 2 sliders
        sliderContainer.innerHTML = `
            <input type="range" class="min-range-bg" id="min-core" min="${minCore}" max="${maxCore}" value="${minCore}" step="1" style="width: 100%;">
            <input type="range" class="max-range-bg" id="max-core" min="${minCore}" max="${maxCore}" value="${maxCore}" step="1" style="width: 100%; margin-top: 10px;">
        `;

        const minSlider = document.getElementById("min-core");
        const maxSlider = document.getElementById("max-core");

        function filterByCore() {
            const minVal = parseInt(minSlider.value);
            const maxVal = parseInt(maxSlider.value);
            currentMin = minVal;
            currentMax = maxVal;

            minLabel.textContent = `${minVal}`;
            maxLabel.textContent = `${maxVal}`;

            rows.forEach(row => {
                const coreText = row.querySelector("td:nth-child(2)")?.textContent.trim() || "0";
                const coreCount = parseInt(coreText) || 0;

                row.style.display = (coreCount >= minVal && coreCount <= maxVal) ? "" : "none";
            });
        }

        minSlider.addEventListener("input", () => {
            if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
                minSlider.value = maxSlider.value;
            }
            filterByCore();
        });

        maxSlider.addEventListener("input", () => {
            if (parseInt(maxSlider.value) < parseInt(minSlider.value)) {
                maxSlider.value = minSlider.value;
            }
            filterByCore();
        });

        // Initial filter apply
        filterByCore();
    });
</script>

    <script>
        //PRICE RANGE SLIDER FILTER
        document.addEventListener("DOMContentLoaded", function () {
            const table = document.getElementById("pcbuild-table");
            const sliderContainer = document.getElementById("price-slider");
            const minLabel = document.getElementById("price-min-label");
            const maxLabel = document.getElementById("price-max-label");

            if (!table || !sliderContainer) return;

            const rows = Array.from(table.querySelectorAll("tbody tr"));
            const prices = rows.map(row => {
                const priceText = row.querySelector("td:nth-child(7)")?.textContent.replace(/[^0-9.]/g, '') || "0";
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
                <input type="range" class="min-range-bg" id="min-price" min="${minPrice}" max="${maxPrice}" value="${minPrice}" step="1" style="width: 100%;">
                <input type="range" class="max-range-bg" id="max-price" min="${minPrice}" max="${maxPrice}" value="${maxPrice}" step="1" style="width: 100%; margin-top: 10px;">
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
                    const priceText = row.querySelector("td:nth-child(7)")?.textContent.replace(/[^0-9.]/g, '') || "0";
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
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = document.getElementById('pcbuild-table');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const manufacturerCheckboxes = document.querySelectorAll('#manufacturer-options input[type="checkbox"]');

            function getSelectedManufacturers() {
                const selected = [];
                manufacturerCheckboxes.forEach(cb => {
                    if (cb.checked && cb.value !== 'all') {
                        selected.push(cb.value.toLowerCase());
                    }
                });
            return selected;
            }

            function updateManufacturerFilter() {
                const selected = getSelectedManufacturers();

                rows.forEach(row => {
                    const nameCell = row.querySelector('td');
                    const nameText = nameCell ? nameCell.textContent.toLowerCase() : '';
                    const isVisible = selected.length === 0 || selected.some(m => nameText.includes(m));
                    row.style.display = isVisible ? '' : 'none';
                });
            }

            // When "All" is checked, uncheck others and show all
            manufacturerCheckboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    if (this.value === 'all') {
                        if (this.checked) {
                            manufacturerCheckboxes.forEach(other => {
                                if (other !== this) other.checked = false;
                            });
                        }
                    } else {
                        document.querySelector('#manufacturer-options input[value="all"]').checked = false;
                    }

                    // If no manufacturer selected, default to showing all
                    const anyChecked = Array.from(manufacturerCheckboxes).some(cb => cb.checked && cb.value !== 'all');
                    if (!anyChecked) {
                        document.querySelector('#manufacturer-options input[value="all"]').checked = true;
                    }

                    updateManufacturerFilter();
                });
            });

            // Initial filter application
            updateManufacturerFilter();
        });
    </script>


    <script>
        // SORTING LOGIC
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
                        h.innerHTML = `&#9654; ${h.textContent.trim().replace(/^▲|▼|\▶/, '')}`;
                    });

                    // Show arrow direction on clicked header
                    this.innerHTML = `${currentSort.direction === 'asc' ? '▲' : '▼'} ${this.textContent.trim().replace(/^▲|▼|\▶/, '')}`;

                    // Sort rows based on clicked column
                    sortTableByKey(key, currentSort.direction);
                });
            });

            // Sort rows function
            function sortTableByKey(key, direction) {
                const tbody = table.querySelector("tbody");
                const rows = Array.from(tbody.querySelectorAll("tr"));

                rows.sort((a, b) => {
                    const getText = row => row.querySelector(`td:nth-child(${getColumnIndex(key)})`)?.innerText.trim().toLowerCase() || '';
                    const valA = getText(a);
                    const valB = getText(b);

                    // If both values are numbers, sort numerically
                    if (!isNaN(parseFloat(valA)) && !isNaN(parseFloat(valB))) {
                        return direction === 'asc' ? parseFloat(valA) - parseFloat(valB) : parseFloat(valB) - parseFloat(valA);
                    }

                    // Otherwise sort alphabetically
                    return direction === 'asc' ? valA.localeCompare(valB) : valB.localeCompare(valA);
                });

                // Apply alternating row backgrounds after sort
                rows.forEach((row, i) => {
                    row.style.backgroundColor = (i % 2 === 0) ? '#d4d4d4' : '#ebebeb';
                    tbody.appendChild(row);
                });
            }

            // Column index mapping based on data-key
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
    
    <?php
    return ob_get_clean();
}
add_shortcode('pcbuild_parts_cpu', 'aawp_pcbuild_display_parts_cpu');
