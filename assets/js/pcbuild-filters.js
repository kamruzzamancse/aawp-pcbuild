//UPDATE PARTS COUNT/TOTAL IN HEADER 
window.addEventListener('DOMContentLoaded', () => {
    const partsCountEl = document.getElementById('parts_count');
    const partsTotalEl = document.getElementById('parts_total_price');

    const parts = localStorage.getItem('cartPartsCount') || 0;
    const total = localStorage.getItem('cartTotal') || 0;

    if (partsCountEl) partsCountEl.textContent = parts;
    if (partsTotalEl) partsTotalEl.textContent = `$${parseFloat(total).toFixed(2)}`;
});
  
// SEARCH FILTER
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
  

// ADD TO BUILDER FUNCTIONALITY
document.querySelectorAll(".add-to-builder").forEach(button => {
    button.addEventListener("click", () => {
        const category = button.dataset.category?.toLowerCase() || 'other';

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
            rating: button.dataset.rating || '',
            socket: button.dataset.socket || '',
            chipset: button.dataset.chipset || '',
            category
        };

        // Save product to localStorage
        localStorage.setItem(`pcbuild_${category}`, JSON.stringify(productData));

        // CPU-specific logic
        if (category === 'cpu') {
            localStorage.setItem('selected_cpu_socket', productData.socket);
            localStorage.setItem('pcbuild_cpu', JSON.stringify(productData));
            //filterByCompatibility(); // Optional, if GPU compatibility is handled
        }

        // Motherboard-specific logic
        if (category === 'motherboard') {
            localStorage.setItem('selected_motherboard_socket', productData.socket);
            localStorage.setItem('selected_motherboard_chipset', productData.chipset);
        }

        // UI update or redirect
        if (window.location.pathname.includes("/pcbuildparts/pc-build-parts")) {
            if (typeof updateRow === "function") {
                updateRow(category, productData);
            }
        } else {
            window.location.href = "/pcbuildparts/pc-build-parts/";
        }
    });
});


// Function to filter GPUs based on selected CPU
function filterGPUByCPUSelected() {
    const selectedCPU = localStorage.getItem('pcbuild_cpu');
    const gpuRows = document.querySelectorAll('.gpu-row');

    // If no CPU is selected, hide all GPU rows
    if (!selectedCPU) {
        gpuRows.forEach(row => row.style.display = 'none');
    } else {
        // Otherwise, show all GPU rows
        gpuRows.forEach(row => row.style.display = 'table-row');
    }
}

// Ensure GPU rows are filtered when the page loads based on existing localStorage data
document.addEventListener("DOMContentLoaded", function() {
    filterGPUByCPUSelected();  // Check if CPU is selected when page is loaded
});


// SCROLL TO TABLE ON PAGINATION
const params = new URLSearchParams(window.location.search);
if (params.has('pcbuild_page')) {
    const tableElement = document.getElementById("pcbuild-table");
    if (tableElement) {
        tableElement.scrollIntoView({ behavior: "smooth" });
    }
}
});

//RATING FILTER CHECKBOXES
const ratingFilter = document.getElementById("rating-filter");
if (ratingFilter) {
    ratingFilter.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            // Ensure only one rating is selected at a time
            ratingFilter.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            this.checked = true;

            const selectedValue = this.value;
            const rows = document.querySelectorAll("#pcbuild-table tbody tr");

            rows.forEach(row => {
                const ratingText = row.querySelector("td:nth-child(6)")?.innerText || '';
                const match = ratingText.match(/^(\d(\.\d)?)/);
                const rating = match ? parseFloat(match[1]) : 0;

                let show = false;
                if (selectedValue === 'all') {
                    show = true;
                } else if (selectedValue === 'unrated') {
                    show = rating === 0;
                } else {
                    show = Math.floor(rating) === parseInt(selectedValue);
                }

                row.style.display = show ? '' : 'none';
            });
        });
    });
}