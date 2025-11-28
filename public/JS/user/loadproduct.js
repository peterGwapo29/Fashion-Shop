function loadProducts() {
    let category = document.getElementById("filter-category").value;
    let sort = document.getElementById("sort-products").value;

    fetch(`/filter-products?category=${category}&sort=${sort}`)
        .then(res => res.json())
        .then(data => {
            let container = document.getElementById("products-container");
            container.innerHTML = "";

            if (data.length === 0) {
                container.innerHTML = "<p>No products found.</p>";
                return;
            }

            data.forEach(product => {
                container.innerHTML += `
                <div class="product-card">
                    <img src="/storage/${product.image}" alt="${product.name}">
                    <div class="line"></div>

                    <h3>${product.name}</h3>
                    <p class="price">₱${product.price}</p>
                    <p class="stock">Stock: ${product.stock}</p>

                    <div class="product-actions">
                        <button class="btn-add-cart cta" onclick="addToCart(${product.id})">
                            <span class="hover-underline-animation">
                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </span>
                        </button>

                        <button class="btn-wishlist" onclick="addToWishlist(${product.id})">
                            <i id="wishlist-icon-${product.id}" class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                </div>`;
            });
        });
}

// Auto-load on page ready
window.addEventListener("DOMContentLoaded", () => {
    loadProducts();

    document.getElementById("filter-category").addEventListener("change", loadProducts);
    document.getElementById("sort-products").addEventListener("change", loadProducts);
});

function updateCartCount() {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            document.getElementById("cart-count").innerText = data.count ?? 0;
        });
}

function addToCart(productId) {
    fetch('/add-to-cart', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: data.status,
            title: data.message,
            timer: 1500,
            showConfirmButton: false
        });

        if (data.status === 'success') {
            updateCartCount(); // update counter immediately
        }
    });
}

// Update wishlist counter dynamically
function updateWishlistCount() {
    fetch('/wishlist/count')
        .then(res => res.json())
        .then(data => {
            document.getElementById("wishlist-count").innerText = data.count ?? 0;
        });
}

// Call this when adding to wishlist
function addToWishlist(productId) {
    fetch("/wishlist/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: data.status === 'success' ? 'success' : 'info',
            title: data.message,
            timer: 1200,
            showConfirmButton: false
        });
        updateWishlistCount(); // <--- update counter
    });
}

// Call updateWishlistCount() when removing from wishlist
function removeWishlistItem(wishlistId) {
    fetch(`/wishlist/remove/${wishlistId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(data => {
        Swal.fire({
            icon: "success",
            title: "Removed!",
            text: data.message,
            timer: 1200,
            showConfirmButton: false
        });
        updateWishlistCount(); // <--- update counter
        setTimeout(() => location.reload(), 1200);
    });
}

// Auto-update on page load
window.addEventListener("DOMContentLoaded", () => {
    updateWishlistCount();
});

function toggleWishlist(productId) {
    fetch("/wishlist/add", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(res => res.json())
    .then(data => {
        const icon = document.getElementById(`wishlist-icon-${productId}`);
        if (!icon) return;

        if (data.status === 'success') {
            // Add the filled-heart class and fa-solid
            icon.classList.add('fa-solid', 'filled-heart');
            icon.classList.remove('fa-regular');
        } else if (data.status === 'info') {
            // Remove from wishlist: revert to default
            icon.classList.add('fa-regular');
            icon.classList.remove('fa-solid', 'filled-heart');
        }

        // Update wishlist counter
        updateWishlistCount();

        Swal.fire({
            icon: data.status === 'success' ? 'success' : 'info',
            title: data.message,
            timer: 1200,
            showConfirmButton: false
        });
    });
}
