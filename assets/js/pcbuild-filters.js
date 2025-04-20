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
            rating: button.dataset.rating,
            socket: button.dataset.socket,
            chipset: button.dataset.chipset,
            category: button.dataset.category
        };

        // Save product to localStorage
        localStorage.setItem(`pcbuild_${category}`, JSON.stringify(productData));

        // Category-specific logic
        switch (category) {
            case 'cpu':
                localStorage.setItem('selected_cpu_socket', productData.socket);
                localStorage.setItem('pcbuild_cpu', JSON.stringify(productData));
                break;
            case 'cpu cooler':
                localStorage.setItem('pcbuild_cooler', JSON.stringify(productData.socket));
                break;
            case 'motherboard':
                localStorage.setItem('pcbuild_motherboard', JSON.stringify(productData.socket));
                break;
            case 'memory':
                localStorage.setItem('pcbuild_memory', JSON.stringify(productData.socket));
                break;
            case 'storage':
                localStorage.setItem('pcbuild_storage', JSON.stringify(productData.socket));
                break;
            case 'video card':
                localStorage.setItem('pcbuild_gpu', JSON.stringify(productData.socket));
                break;
            case 'case':
                localStorage.setItem('pcbuild_case', JSON.stringify(productData.socket));
                break;
            case 'power supply':
                localStorage.setItem('pcbuild_psu', JSON.stringify(productData.socket));
                break;
            case 'operating system':
                localStorage.setItem('pcbuild_os', JSON.stringify(productData.socket));
                break;
            case 'monitor':
                localStorage.setItem('pcbuild_monitor', JSON.stringify(productData.socket));
                break;
            default:
                break;
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