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
                </div>

                <div id="tab2" class="tab-content">
                    <div class="cardContiner">
                    <div class="componentCard" id="CHASSIS" onclick="component_card_modal(event,id)">
                        <h3>CHASSIS</h3>
                        <h5>CHASSIS NAME</h5>
                        <div class="editBox">
                        <i class="fa-regular fa-circle-check"></i> EDIT
                        </div>
                    </div>
                    <div class="componentCard" id="CPU" onclick="component_card_modal(event,id)">
                        <h3>CPU</h3>
                        <h5>CPU NAME</h5>
                        <div class="editBox">
                        <i class="fa-regular fa-circle-check"></i> EDIT
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END: PC Builder Section -->
    <?php
    return ob_get_clean();
}

add_shortcode('pcbuild_ui', 'pcbuild_render_ui_shortcode');

?>

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

    // Hide modal on overlay click
    modalOverlay.addEventListener("click", function () {
      closePartModal();
    });
  }

  document.addEventListener("click", function (e) {
  if (e.target.classList.contains("add-to-builder")) {
    const button = e.target;

    // Get all data attributes from the button
    const title = button.dataset.title;
    const image = button.dataset.image;
    const base = button.dataset.base;
    const promo = button.dataset.promo;
    const shipping = button.dataset.shipping;
    const tax = button.dataset.tax;
    const availability = button.dataset.availability;
    const price = button.dataset.price;
    const category = button.dataset.category;

    const rows = document.querySelectorAll(".row");
    rows.forEach(row => {
      const categorySpan = row.querySelector(".componentName");
      if (categorySpan && categorySpan.textContent.trim().toLowerCase() === category.toLowerCase()) {

        // Update selection column
        const selectionCard = row.querySelector(".selection");
        if (selectionCard) {
          selectionCard.innerHTML = `
            <div class="product-selected" style="display:flex; gap:10px; align-items:center;">
              <img src="${image}" alt="${title}" style="width:50px; height:50px; object-fit:cover;">
              <div>
                <strong>${title}</strong><br>
              </div>
            </div>
          `;
        }

        // Update other respective columns
        if (row.querySelector(".base")) row.querySelector(".base").textContent = base;
        if (row.querySelector(".promo")) row.querySelector(".promo").textContent = promo;
        if (row.querySelector(".shiping")) row.querySelector(".shiping").textContent = shipping;
        if (row.querySelector(".tax")) row.querySelector(".tax").textContent = tax;
        if (row.querySelector(".availability")) row.querySelector(".availability").textContent = availability;
        if (row.querySelector(".price")) row.querySelector(".price").textContent = price;

        // Optionally close modal
        closePartModal();
      }
    });
  }
});


});

function closePartModal() {
  document.getElementById("cpuModal").style.display = "none";
  document.getElementById("modalOverlay").style.display = "none";
  document.getElementById("popupContent").innerHTML = '';
}
</script>

<style>

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

  
