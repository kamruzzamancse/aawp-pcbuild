<?php
if (!defined('ABSPATH')) {
    exit;
}

// Shortcode to render full PC Builder UI
function pcbuild_render_ui_shortcode() {
    ob_start();
    ?>
    <!-- START: PC Builder Section -->
    <section id="buildOverview">
        <!-- ====modal===== -->
        <div id="component_modal"></div>
            <!-- ===parts header==== -->
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
                <!-- =========url section===== -->
                <!-- [URL and markup section unchanged for brevity] -->

                <div class="tab_Content_Warpper">
                <!-- =====over view======= -->
                <div id="tab1" class="tab-content active">
                    <div class="cardWarpper">
                    <!-- =======row heading===== -->
                    <div class="row">
                        <div class="comp card"><span class="rowHeading">Component</span></div>
                        <div class="selection card"><span class="rowHeading">Selection</span></div>
                        <div class="base card"><span class="rowHeading">Base</span></div>
                        <div class="promo card"><span class="rowHeading">Promo</span></div>
                        <div class="shiping card"><span class="rowHeading">Shipping</span></div>
                        <div class="tax card"><span class="rowHeading">Tax</span></div>
                        <div class="availability card"><span class="rowHeading">Availability</span></div>
                        <div class="price card"><span class="rowHeading">Price</span></div>
                        <div class="where card"><span class="rowHeading">Where</span></div>
                        <div class="buy card"></div>
                        <div class="cancel card"></div>
                    </div>

                    <!-- =======cpu====== -->
                    <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">CPU</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Chose a CPU</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======CPU Cooler====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">CPU Cooler</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A CPU Cooler</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Motherboard====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Motherboard</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style="font-size:20px;">&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Motherboard</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Memory====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Memory</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Memory</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Storage====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Storage</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Storage</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Video Card====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Video Card</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Video Card</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Case====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Case</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Case</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Power Supply====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Power Supply</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Power Supply</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Operating System====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Operating System</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Operating System</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>
                        <!-- =======Monitor====== -->
                        <div class="row">
                            <div class="comp card">
                                <a href="javascript:void(0)" class="pc-part">
                                    <span class="componentName">Monitor</span>
                                </a>
                            </div>
                            <div class="selection card">
                                <button class="selectionBTN">
                                    <span style='font-size:20px;'>&#43;</span>
                                    <a href="javascript:void(0)" class="pc-part">
                                        <span>Choose A Monitor</span>
                                    </a>
                                </button>
                            </div>
                            <div class="base card"></div>
                            <div class="promo card"></div>
                            <div class="shiping card"></div>
                            <div class="tax card"></div>
                            <div class="availability card"></div>
                            <div class="price card"></div>
                            <div class="where card"></div>
                            <div class="buy card"></div>
                            <div class="cancel card"></div>
                        </div>

                    </div>

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
                </div>

            </div>
        </div>
    </section>
    <!-- END: PC Builder Section -->

    <!-- Popup Modal -->
    <div class="modal-overlay" id="modalOverlay"></div>

    <!-- Modal Content Area -->
    <div id="cpuModal" class="popup-window">
      <button onclick="closeCpuModal()" class="close-btn">X</button>
      <div id="popupContent">
        <!-- This is where the shortcode content will load -->
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
          const partTriggers = document.querySelectorAll(".pc-part");
          const partModal = document.getElementById("cpuModal");
          const modalOverlay = document.getElementById("modalOverlay");
          const popupContent = document.getElementById("popupContent");

          // === Restore previous selections from localStorage ===
          const rows = document.querySelectorAll(".row");
          rows.forEach(row => {
            const categorySpan = row.querySelector(".componentName");
            if (categorySpan) {
              const category = categorySpan.textContent.trim().toLowerCase();
              const savedData = localStorage.getItem(`pcbuild_${category}`);
              if (savedData) {
                const parsedData = JSON.parse(savedData);
                updateRow(category, parsedData);
              }
            }
          });

          // === Setup click triggers to open modal and load content ===
          if (partTriggers.length && partModal && modalOverlay && popupContent) {
            partTriggers.forEach(trigger => {
              trigger.addEventListener("click", function () {
                const row = trigger.closest(".row");
                const categorySpan = row.querySelector(".componentName");
                const category = categorySpan ? categorySpan.textContent.trim() : "CPU";

                // Store current category in modal for future use
                partModal.setAttribute('data-current-category', category);

                // Show modal
                partModal.style.display = "block";
                modalOverlay.style.display = "block";

                // Load content via AJAX
                fetch(pcbuild_ajax_object.ajax_url, {
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                  },
                  body: 'action=load_pcbuild_parts&category=' + encodeURIComponent(category)
                })
                .then(response => response.text())
                .then(html => {
                  popupContent.innerHTML = html;
                });
              });
            });

            // Close modal when overlay is clicked
            modalOverlay.addEventListener("click", function () {
              closePartModal();
            });
          }

          // === Handle Add to Builder button clicks ===
          document.addEventListener("click", function (e) {
            if (e.target.classList.contains("add-to-builder")) {
              const button = e.target;

              const title = button.dataset.title;
              const image = button.dataset.image;
              const base = button.dataset.base;
              const promo = button.dataset.promo;
              const shipping = button.dataset.shipping;
              const tax = button.dataset.tax;
              const availability = button.dataset.availability;
              const price = button.dataset.price;
              const category = button.dataset.category;
              const affiliateUrl = button.dataset.affiliateUrl;
              const asin = button.dataset.asin;

              const productData = {
                title, image, base, promo, shipping, tax, availability, price, affiliateUrl, asin
              };

              localStorage.setItem(`pcbuild_${category.toLowerCase()}`, JSON.stringify(productData));

              updateRow(category, productData);
              closePartModal();
            }
          });

          function updateRow(category, data) {
            const rows = document.querySelectorAll(".row");

            rows.forEach(row => {
              const categorySpan = row.querySelector(".componentName");
              if (categorySpan && categorySpan.textContent.trim().toLowerCase() === category.toLowerCase()) {

                // Safe fallback values
                const base = data.base || '';
                const promo = data.promo || '';
                const shipping = data.shipping || '';
                const tax = data.tax || '';
                const availability = data.availability || '';
                const price = data.price || '';
                const affiliateUrl = data.affiliateUrl || '#';

                // Truncate and escape title
                const truncatedTitle = data.title.length > 75 ? data.title.slice(0, 75) + "..." : data.title;
                const escapedTitle = truncatedTitle.replace(/</g, "&lt;").replace(/>/g, "&gt;");

                if (row.querySelector(".selection")) {
                  row.querySelector(".selection").innerHTML = `
                    <div class="product-selected" style="display: flex; align-items: center; gap: 12px;">
                      <img src="${data.image}" alt="${escapedTitle}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                      <div style="flex: 1;">
                        <strong style="font-size: 14px; display: block;">${escapedTitle}</strong>
                      </div>
                    </div>
                  `;
                }

                // ✅ Update data fields
                if (row.querySelector(".base")) row.querySelector(".base").textContent = base;
                if (row.querySelector(".promo")) row.querySelector(".promo").textContent = promo;
                if (row.querySelector(".shiping")) row.querySelector(".shiping").textContent = shipping;
                if (row.querySelector(".tax")) row.querySelector(".tax").textContent = tax;
                if (row.querySelector(".availability")) row.querySelector(".availability").textContent = availability;
                if (row.querySelector(".price")) row.querySelector(".price").textContent = price;

                // ✅ Where column with Amazon logo
                if (row.querySelector(".where")) {
                  row.querySelector(".where").innerHTML = `
                    <a href="${affiliateUrl}" target="_blank" rel="nofollow noopener">
                      <img src="https://cdna.pcpartpicker.com/static/img/vendor-logos/logo2_merchant_amazon.png" 
                        alt="Buy on Amazon" style="width:80px; height:auto;" />
                    </a>`;
                }

                // ✅ Buy button
                if (row.querySelector(".buy")) {
                  row.querySelector(".buy").innerHTML = `
                    <a href="${affiliateUrl}" target="_blank" rel="nofollow noopener">
                      <button style="background:#28a745; color:#fff; border:none; padding:6px 12px; border-radius:6px; cursor:pointer;">
                        Buy
                      </button>
                    </a>`;
                }

                // ✅ Cancel button
                if (row.querySelector(".cancel")) {
                  row.querySelector(".cancel").innerHTML = `
                    <button class="remove-from-builder" data-category="${category}"
                      style="background:none; border:none; font-size:30px; font-weight:bold; cursor:pointer; color:#ccc; line-height:1;">
                      &times;
                    </button>`;
                }
              }
            });
        }

        document.addEventListener("click", function (e) {
          if (e.target.classList.contains("remove-from-builder")) {
            const category = e.target.dataset.category.toLowerCase();

            // Remove from localStorage
            localStorage.removeItem(`pcbuild_${category}`);

            // Reset the row to initial state (page refresh also works)
            location.reload(); // Or manually clear the row if you prefer
          }
        });

        document.getElementById("checkoutAllBtn").addEventListener("click", function () {
          const rows = document.querySelectorAll(".row");
          let asins = [];
          const associateTag = pcbuild_ajax_object.associate_tag;
          //console.log(associateTag);

          rows.forEach(row => {
            const categorySpan = row.querySelector(".componentName");
            if (categorySpan) {
              const category = categorySpan.textContent.trim().toLowerCase();
              const storedData = localStorage.getItem(`pcbuild_${category}`);
              if (storedData) {
                try {
                  const product = JSON.parse(storedData);
                  if (product.asin) {
                    asins.push(product.asin);
                  }
                } catch (e) {
                  console.error(`Invalid JSON for ${category}`, e);
                }
              }
            }
          });

          if (asins.length === 0) {
            alert("Please select some parts before checking out.");
            return;
          }

          // Build Amazon cart URL
          let cartUrl = `https://www.amazon.com/gp/aws/cart/add.html?AssociateTag=${associateTag}`;
          asins.forEach((asin, index) => {
            const num = index + 1;
            cartUrl += `&ASIN.${num}=${asin}&Quantity.${num}=1`;
          });

          window.open(cartUrl, "_blank");
        });

          // === Function to close modal ===
          window.closePartModal = function () {
            partModal.style.display = "none";
            modalOverlay.style.display = "none";
            popupContent.innerHTML = '';
          };

      });

    </script>


<script>
  document.querySelector('.tab-btn').addEventListener('click', function() {
    alert('Hello');
  });
</script>


    <style>

    .where img {
      filter: drop-shadow(1px 1px 2px rgba(0,0,0,0.5));
    }

    #cpuModal {
      display: none;
      position: fixed;
      top: 150px;
      left: 50%;
      transform: translateX(-50%);
      width: 1470px;
      max-width: 100%;
      background: #fff;
      border-radius: 10px;
      padding: 50px;
      z-index: 1001;
      overflow-y: auto;
      max-height: 90vh;
    }

    .modal-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 1000;
    }

    .popup-window {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 1470px;
      max-width: 95%;
      background: #fff;
      z-index: 9999;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      background: transparent;
      border: none;
      font-size: 20px;
      cursor: pointer;
      font-weight: bold;
      color: #000;
    }
    </style>

  <?php
  return ob_get_clean();
}
add_shortcode('pcbuild_ui', 'pcbuild_render_ui_shortcode');

  
