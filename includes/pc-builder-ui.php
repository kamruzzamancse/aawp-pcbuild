<?php
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to render full PC Builder UI
function pcbuild_render_ui_shortcode() {
    ob_start();
    $cards = [
        'base',
        'promo',
        'shipping',
        'tax',
        'availability',
        'price',
        'where',
        'buy',
        'cancel'
    ];
    ?>
    <!-- Start of the PC Builder section which contains the UI for selecting and reviewing PC components -->
    <section id="buildOverview">
        <!-- Placeholder for modal that will show component selection details or options -->
        <div id="component_modal"></div>
            <!-- Header section that includes tabs for navigating between component selection and overview -->
            <div class="partsHeader">
                <h3>Choose Your Parts</h3>
                <div class="navNtab">
                <ol>
                    <li>
                        <button class="tab-btn" onclick="openTab(event, 'tab1')">Choose Component</button>
                    </li>
                    <li>
                        <button class="tab-btn active" onclick="openTab(event, 'tab2')">Overview</button>
                    </li>
                </ol>
                </div>
            </div>
            <div class="container">

                <div class="tab_Content_Warpper">
                <!-- Wrapper for all the tabbed content, including component selection and build overview -->
                <div id="tab1" class="tab-content active">
                    <div class="cardWarpper">
                    <!-- Header row that labels each column in the component selection table -->
                    <div class="row">
                        <div class="comp card"><span class="rowHeading">Component</span></div>
                        <div class="selection card"><span class="rowHeading">Selection</span></div>
                        <div class="base card"><span class="rowHeading">Base</span></div>
                        <div class="promo card"><span class="rowHeading">Promo</span></div>
                        <div class="shipping card"><span class="rowHeading">Shipping</span></div>
                        <div class="tax card"><span class="rowHeading">Tax</span></div>
                        <div class="availability card"><span class="rowHeading">Availability</span></div>
                        <div class="price card"><span class="rowHeading">Price</span></div>
                        <div class="where card"><span class="rowHeading">Where</span></div>
                        <div class="buy card"></div>
                        <div class="cancel card"></div>
                    </div>

                    <!-- Row for CPU selection and its associated pricing and availability information -->
                        <div class="row">
                          <div class="comp card">
                              <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/cpu">
                                  <span class="componentName">CPU</span>
                              </a>
                          </div>

                          <div class="selection card">
                              <button class="selectionBTN" data-redirect="/pcbuildparts/products/cpu">
                                  <span style="font-size:20px;">&#43;</span>
                                  <span class="pc-part">Choose a CPU</span>
                              </button>
                          </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Row for CPU Cooler selection with dynamic pricing and vendor details -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/cpu-cooler">
                                    <span class="componentName">CPU Cooler</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/cpu-cooler">
                                        <span>Choose A CPU Cooler</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Row for selecting the motherboard and displaying related data -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/motherboard">
                                    <span class="componentName">Motherboard</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/motherboard">
                                        <span>Choose A Motherboard</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Memory selection row including price, promo, tax, etc. -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/memory">
                                <span class="componentName" data-key="ram">Memory</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/memory">
                                        <span>Choose A Memory</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Storage device selection row with associated info and controls -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/storage">
                                    <span class="componentName">Storage</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/storage">
                                        <span>Choose A Storage</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Row for choosing a GPU or video card with details like price, tax, and source -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/video-card">
                                    <span class="componentName">Video Card</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/video-card">
                                        <span>Choose A Video Card</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- PC case selection row along with its pricing and availability -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/case">
                                    <span class="componentName">Case</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/case">
                                        <span>Choose A Case</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Row for selecting a PSU (Power Supply Unit) and its metadata -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/power-supply">
                                    <span class="componentName">Power Supply</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/power-supply">
                                        <span>Choose A Power Supply</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Operating System selection row with related information -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/operating-system">
                                    <span class="componentName">Operating System</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/operating-system">
                                        <span>Choose A Operating System</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                        <!-- Monitor selection row showing pricing, availability, and purchase options -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/monitor">
                                    <span class="componentName">Monitor</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part" data-redirect="/pcbuildparts/products/monitor">
                                        <span>Choose A Monitor</span>
                                    </a>
                                </button>
                            </div>
                            <?php foreach ($cards as $card) echo "<div class='{$card} card'></div>"; ?>
                        </div>
                    </div>

                    <div id="products_total_price"></div>

                    <div id="checkoutWrapper" style="margin-top: 30px; text-align: right;">
                      <button id="checkoutAllBtn"
                              style="padding: 12px 24px; background: #ff9900; color: #fff; font-weight: bold; font-size: 16px; border: none; border-radius: 8px; cursor: pointer;">
                        Checkout All on Amazon
                      </button>
                    </div>

                </div>

                <div id="tab2" class="tab-content">
                  <div class="cardContiner" id="overviewContainer">
                    <!-- Selected product images will be injected here -->
                  </div>

                  <!-- Add this new div for product details -->
                  <div id="overviewProductDetails" style="margin-top: 30px;"></div>
                </div>

            </div>
        </div>
    </section>

<script>
// Checkout All Button + Redirect Handler
document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("checkoutAllBtn")?.addEventListener("click", function () {
    const rows = document.querySelectorAll(".row");
    const asins = [];
    const associateTag = pcbuild_ajax_object.associate_tag;

    rows.forEach(row => {
      const category = row.querySelector(".componentName")?.textContent.trim().toLowerCase();
      const storedData = localStorage.getItem(`pcbuild_${category}`);
      if (storedData) {
        try {
          const product = JSON.parse(storedData);
          if (product?.asin) asins.push(product.asin);
        } catch (e) {
          console.error(`Invalid JSON for ${category}`, e);
        }
      }
    });

    if (asins.length === 0) return alert("Please select some parts before checking out.");

    let cartUrl = `https://www.amazon.com/gp/aws/cart/add.html?AssociateTag=${associateTag}`;
    asins.forEach((asin, i) => {
      const num = i + 1;
      cartUrl += `&ASIN.${num}=${asin}&Quantity.${num}=1`;
    });

    window.open(cartUrl, "_blank");
  });

  document.querySelectorAll('[data-redirect]').forEach(el => {
    el.addEventListener("click", function () {
      const target = this.getAttribute("data-redirect");
      if (target) window.location.href = target;
    });
  });
});
</script>

<script>
// Modal Open/Close Logic
document.addEventListener("DOMContentLoaded", function () {
  const partTriggers = document.querySelectorAll(".pc-part");
  const partModal = document.getElementById("cpuModal");
  const modalOverlay = document.getElementById("modalOverlay");
  const popupContent = document.getElementById("popupContent");

  if (partTriggers.length && partModal && modalOverlay && popupContent) {
    partTriggers.forEach(trigger => {
      trigger.addEventListener("click", function () {
        const row = trigger.closest(".row");
        const category = row.querySelector(".componentName")?.textContent.trim() || "CPU";
        partModal.setAttribute('data-current-category', category);

        partModal.style.display = "block";
        modalOverlay.style.display = "block";

        fetch(pcbuild_ajax_object.ajax_url, {
          method: 'POST',
          headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: 'action=load_pcbuild_parts&category=' + encodeURIComponent(category)
        })
        .then(res => res.text())
        .then(html => popupContent.innerHTML = html);
      });
    });

    modalOverlay.addEventListener("click", () => closePartModal());

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && partModal.style.display === "block") {
        closePartModal();
      }
    });
  }

  window.closePartModal = function () {
    partModal.style.display = "none";
    modalOverlay.style.display = "none";
    popupContent.innerHTML = '';
  };
});
</script>

<script>
// Add to Builder Logic
document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("add-to-builder")) {
      const btn = e.target;
      const category = btn.dataset.category.toLowerCase();
      const productData = {
        title: btn.dataset.title,
        image: btn.dataset.image,
        base: btn.dataset.base,
        promo: btn.dataset.promo,
        shipping: btn.dataset.shipping,
        tax: btn.dataset.tax,
        availability: btn.dataset.availability,
        price: btn.dataset.price,
        affiliateUrl: btn.dataset.affiliateUrl,
        asin: btn.dataset.asin,
        rating: btn.dataset.rating || ''
      };

      localStorage.setItem(`pcbuild_${category}`, JSON.stringify(productData));
      updateRow(category, productData);
      closePartModal();
    }
  });
});
</script>

<script>
// Update Row + Total Calculation
function updateRow(category, data) {
  const rows = document.querySelectorAll(".row");
  rows.forEach(row => {
    const rowCat = row.querySelector(".componentName")?.textContent.trim().toLowerCase();
    if (rowCat === category) {
      const htmlSafe = str => str.replace(/</g, "&lt;").replace(/>/g, "&gt;");
      const truncated = data.title.length > 70 ? data.title.slice(0, 70) + "..." : data.title;
      const escapedTitle = htmlSafe(truncated);

      row.querySelector(".selection").innerHTML = `
        <div class="product-selected" style="display: flex; align-items: center; gap: 12px;">
          <img src="${data.image}" alt="${escapedTitle}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
          <div style="flex: 1;"><strong style="font-size: 14px;">${escapedTitle}</strong></div>
        </div>`;

      row.querySelector(".base").textContent = data.base || '';
      row.querySelector(".promo").textContent = data.promo || '';
      row.querySelector(".shipping").textContent = data.shipping || '';
      row.querySelector(".tax").textContent = data.tax || '';
      row.querySelector(".availability").textContent = data.availability || '';
      row.querySelector(".price").textContent = data.price || '';

      row.querySelector(".where").innerHTML = `
        <a href="${data.affiliateUrl}" target="_blank" rel="nofollow noopener">
          <img src="http://localhost/pcbuildparts/wp-content/uploads/2025/04/amazon-logo.png" alt="Amazon" style="width:80px;">
        </a>`;

      row.querySelector(".buy").innerHTML = `
        <a href="${data.affiliateUrl}" target="_blank" rel="nofollow noopener">
          <button style="background:#28a745; color:#fff; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;">
            Buy
          </button>
        </a>`;

      row.querySelector(".cancel").innerHTML = `
        <button class="remove-from-builder" data-category="${category}"
          style="background:none; border:none; font-size:30px; font-weight:bold; cursor:pointer; color:#ccc;">
          &times;
        </button>`;
    }
  });

  calculateTotalPrice();
}

function calculateTotalPrice() {
  let total = 0, parts = 0;
  document.querySelectorAll('.row .price').forEach(el => {
    const price = parseFloat(el.textContent.replace(/[^0-9.]/g, ''));
    if (!isNaN(price)) {
      total += price;
      parts++;
    }
  });

  localStorage.setItem('cartTotal', total.toFixed(2));
  localStorage.setItem('cartPartsCount', parts);

  document.getElementById('products_total_price')?.textContent = `Total: $${total.toFixed(2)}`;
  document.getElementById('parts_count')?.textContent = parts;
  document.getElementById('parts_total_price')?.textContent = `$${total.toFixed(2)}`;
}
</script>

<script>
// Remove from Builder
document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-from-builder")) {
      const category = e.target.dataset.category.toLowerCase();
      localStorage.removeItem(`pcbuild_${category}`);
      location.reload(); // Or call updateRow(category, null) to clear UI without reload
    }
  });
});
</script>




<script>
  
  // Function to handle tab switching
  function openTab(evt, tabId) {
    // Hide all tab contents and deactivate all tab buttons
    document.querySelectorAll(".tab-content").forEach(tab => tab.classList.remove("active"));
    document.querySelectorAll(".tab-btn").forEach(btn => btn.classList.remove("active"));

    // Show the selected tab content and activate the clicked tab button
    document.getElementById(tabId).classList.add("active");
    evt.currentTarget.classList.add("active");

    // If switching to the "Overview" tab, load stored product overview images
    if (tabId === "tab2") {
      loadOverviewImagesOnly();
    }
  }

  // Load only the overview image cards for each saved product in localStorage
  function loadOverviewImagesOnly() {
    const container = document.getElementById("overviewContainer");
    container.innerHTML = "";

    // Filter localStorage keys for saved PC build items
    const keys = Object.keys(localStorage).filter(key => key.startsWith("pcbuild_"));

    keys.forEach(key => {
      try {
        const data = JSON.parse(localStorage.getItem(key));
        const category = key.replace("pcbuild_", "");

        // Create image card for each category
        const imgCard = `
          <div onclick="showProductDetails('${category}')" style="
            width: 120px; height: 120px; border: 1px solid #ccc; border-radius: 10px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            margin: 10px; cursor: pointer; transition: 0.3s;" 
            onmouseover="this.style.boxShadow='0 4px 8px rgba(0,0,0,0.1)'"
            onmouseout="this.style.boxShadow='none'">
            <img src="${data.image}" alt="${data.title}" style="width: 60px; height: 60px; object-fit: contain;">
            <p style="font-size: 12px; margin-top: 5px;">${category}</p>
          </div>
          <div id="details_${category}" class="product-details" style="margin-top:10px;"></div>
        `;
        container.insertAdjacentHTML("beforeend", imgCard);
      } catch (e) {
        console.error("Invalid localStorage data", key, e);
      }
    });
  }

  // Display detailed information about a selected product
  function showProductDetails(category) {
    const data = JSON.parse(localStorage.getItem(`pcbuild_${category}`));
    const detailsWrapper = document.getElementById('overviewProductDetails');

    if (!data || !detailsWrapper) return;

    // Build the product detail layout
    detailsWrapper.innerHTML = `
      <div class="product-detail-card" style="
        display: flex;
        flex-direction: row;
        gap: 24px;
        background: #ffffff;
        padding: 20px;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      ">
        <div class="product-detail-img" style="flex: 1; max-width: 320px;">
          <img src="${data.image}" alt="${data.title}" style="width: 100%; border-radius: 8px; object-fit: contain;">
        </div>

        <div class="product-detail-content" style="flex: 2;">
          <h2 style="font-size: 22px; color: #111; margin-bottom: 12px;">${data.title}</h2>

          <table class="product-specs" style="width: 100%; border-collapse: collapse; font-size: 14px; color: #333;">
            ${
              Object.entries(data).map(([key, val]) => {
                // Skip non-display keys
                if (['image', 'title', 'affiliateUrl', 'asin', 'promo', 'tax'].includes(key)) return '';

                // Special handling for "Rating"
                if (key === 'rating') {
                  return `
                    <tr style="border-bottom: 1px solid #f5f5f5;">
                      <td style="padding: 6px 10px; font-weight: 600; color: #444; width: 160px;">Seller Rating</td>
                      <td style="padding: 6px 10px; color: #f39c12;">${val}</td>
                    </tr>
                  `;
                }

                // Default product detail rows
                const formattedKey = key
                  .replace(/([A-Z])/g, ' $1')
                  .replace(/^./, str => str.toUpperCase())
                  .replace('About', 'About This Item');

                return `
                  <tr style="border-bottom: 1px solid #f5f5f5;">
                    <td style="padding: 6px 10px; font-weight: 600; color: #444; width: 160px;">${formattedKey}</td>
                    <td style="padding: 6px 10px; color: #222;">${val}</td>
                  </tr>
                `;
              }).join('')
            }
          </table>
        </div>
      </div>
    `;
  }

</script>

  <?php
  return ob_get_clean();
}
add_shortcode('pcbuild_ui', 'pcbuild_render_ui_shortcode');

  
