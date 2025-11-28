@extends('layouts.cart-layout')

@section('title', 'My Wishlist')

@section('content')
<div class="cart-container">

    <h2>My Wishlist</h2>

    @if($wishlistItems->isEmpty())
        <p>Your wishlist is empty.</p>
    @else
    <!-- FILTERS -->
    <div class="filter-sort-container">
        <select id="filter-category" class="filter-select">
            <option value="all">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ strtolower($cat->category_name) }}">{{ $cat->category_name }}</option>
            @endforeach
        </select>

        <select id="sort-products" class="filter-select">
            <option value="featured">Featured</option>
            <option value="newest">Newest</option>
            <option value="highlow">Price: High-Low</option>
            <option value="lowhigh">Price: Low-High</option>
        </select>

        @if(!$wishlistItems->isEmpty())
            <button class="btn-clear-all" onclick="clearAllWishlist()">Clear All</button>
        @endif
    </div>


    <div id="wishlist-container" class="wishlist-grid">
        @foreach($wishlistItems as $item)
        <div class="product-card" 
            data-category="{{ strtolower($item->product->category->category_name) }}"
            data-wishlist-id="{{ $item->id }}">
            <img src="/storage/{{ $item->product->image }}" alt="{{ $item->product->name }}">
            
            <div class="product-info">
                <h3>{{ $item->product->name }}</h3>
                <p>₱{{ number_format($item->product->price, 2) }}</p>
                <p>Stock: {{ $item->product->stock }}</p>
            </div>

            <div class="product-actions">
                <button class="btn-primary" onclick="addToCart({{ $item->product->id }}, {{ $item->id }})">
                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                </button>

                <button class="btn-delete" onclick="removeWishlistItem({{ $item->id }})">
                    Remove
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function removeWishlistItem(id) {
    Swal.fire({
        title: "Remove this item?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e63946",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, remove it"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/wishlist/remove/${id}`, {
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

                // Remove the product card from DOM
                const item = document.querySelector(`.product-card[data-wishlist-id='${id}']`);
                if(item) item.remove();
            });
        }
    });
}

// Add to cart (and remove from wishlist dynamically)
function addToCart(productId, wishlistId) {
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
            timer: 1200,
            showConfirmButton: false
        });

        if(data.status === 'success') {
            updateCartCount(); // update cart counter

            // Remove from wishlist dynamically
            fetch(`/wishlist/remove/${wishlistId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(removeData => {
                const item = document.querySelector(`.product-card[data-wishlist-id='${wishlistId}']`);
                if(item) item.remove();
            });
        }
    });
}

// Update cart count dynamically
function updateCartCount() {
    fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            document.getElementById("cart-count").innerText = data.count ?? 0;
        });
}


window.addEventListener("DOMContentLoaded", () => {
    const categoryFilter = document.getElementById("filter-category");
    const sortFilter = document.getElementById("sort-products");

    function filterWishlist() {
        const selectedCategory = categoryFilter.value;
        const sortOption = sortFilter.value;
        const items = document.querySelectorAll("#wishlist-container .product-card");

        // Filter by category
        items.forEach(item => {
            const itemCategory = item.getAttribute("data-category");
            if (selectedCategory === "all" || itemCategory === selectedCategory) {
                item.style.display = "flex";
            } else {
                item.style.display = "none";
            }
        });

        // Sort by price or newest
        const container = document.getElementById("wishlist-container");
        let visibleItems = Array.from(items).filter(i => i.style.display !== "none");

        visibleItems.sort((a, b) => {
            const priceA = parseFloat(a.querySelector(".product-info p:nth-child(2)").innerText.replace('₱',''));
            const priceB = parseFloat(b.querySelector(".product-info p:nth-child(2)").innerText.replace('₱',''));
            switch(sortOption) {
                case 'highlow': return priceB - priceA;
                case 'lowhigh': return priceA - priceB;
                case 'newest': 
                case 'featured': return 0; // default order (no change)
            }
        });

        visibleItems.forEach(item => container.appendChild(item));
    }

    categoryFilter.addEventListener("change", filterWishlist);
    sortFilter.addEventListener("change", filterWishlist);
});


function clearAllWishlist() {
    Swal.fire({
        title: "Clear all items?",
        text: "This will remove all items from your wishlist.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e63946",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, clear all"
    }).then((result) => {
        if(result.isConfirmed) {
            fetch('/wishlist/clear-all', {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire({
                    icon: "success",
                    title: "Cleared!",
                    text: data.message,
                    timer: 1200,
                    showConfirmButton: false
                });

                // Remove all items from DOM
                const container = document.getElementById("wishlist-container");
                container.innerHTML = '<p>Your wishlist is empty.</p>';

                // Update wishlist counter
                updateWishlistCount();
            });
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

// Call updateWishlistCount() on page load
window.addEventListener("DOMContentLoaded", () => {
    updateWishlistCount();
});


</script>
@endpush
