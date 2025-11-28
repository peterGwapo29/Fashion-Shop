class ProductModal {
    constructor() {
        // Modal elements
        this.modal = document.getElementById("addProductModal");
        this.openBtn = document.getElementById("openModalBtn");
        this.closeBtn = document.getElementById("closeModalBtn");

        // Image preview
        this.imageInput = document.getElementById("productImage");
        this.imagePreviewContainer = document.getElementById("imagePreviewContainer");
        this.imagePreview = document.getElementById("imagePreview");

        // Form
        this.form = document.getElementById("addProductForm");

        // Success modal
        this.successModal = document.getElementById("successModal");
        this.closeSuccessBtn = document.getElementById("closeSuccessBtn");

        this.initEvents();
    }

    initEvents() {
        // ✅ Only attach events if the elements exist
        if (this.openBtn)
            this.openBtn.addEventListener("click", () => this.showModal());

        if (this.closeBtn)
            this.closeBtn.addEventListener("click", () => this.hideModal());

        if (this.closeSuccessBtn)
            this.closeSuccessBtn.addEventListener("click", () => this.hideSuccessModal());

        if (this.imageInput)
            this.imageInput.addEventListener("change", (e) => this.previewImage(e));

        if (this.form)
            this.form.addEventListener("submit", (e) => this.handleSubmit(e));

        // ✅ Safe window listener
        window.addEventListener("click", (e) => {
            if (e.target === this.modal) this.hideModal();
            if (e.target === this.successModal) this.hideSuccessModal();
        });
    }

    showModal() {
        this.modal?.classList.remove("hidden");
    }

    hideModal() {
        this.modal?.classList.add("hidden");
        this.resetForm();
    }

    hideSuccessModal() {
        this.successModal?.classList.add("hidden");
    }

    previewImage(e) {
        const file = e.target.files[0];
        if (!file) {
            this.imagePreview.src = "";
            this.imagePreviewContainer.classList.add("hidden");
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            this.imagePreview.src = event.target.result;
            this.imagePreviewContainer.classList.remove("hidden");
            this.imagePreviewContainer.style.maxHeight = "200px";
            this.imagePreviewContainer.style.overflow = "auto";
        };
        reader.readAsDataURL(file);
    }

    async handleSubmit(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append("name", document.getElementById("productName").value);
        formData.append("price", document.getElementById("productPrice").value);
        formData.append("stock", document.getElementById("productStock").value);
        formData.append("category_id", document.getElementById("productCategory").value);

        const imageFile = document.getElementById("productImage").files[0];
        if (imageFile) formData.append("image", imageFile);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        try {
            const response = await fetch("/products", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json",
                },
                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                console.error("❌ Error:", result);
                return;
            }
            console.log("✅ Product Saved:", result);

             Swal.fire({
                position: "center",
                icon: "success",
                title: "Product added successfully",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                allowOutsideClick: false,
            }).then((_) => {
                location.reload();
            });

            this.hideModal();
            this.resetForm();
            this.addProductToGrid(result.product);

        } catch (error) {
            console.error("⚠️ Request failed:", error);
            Swal.fire({
                icon: "error",
                title: "Failed to add product",
                text: result.message || "Unknown error occurred",
            });
        }
    }

    addProductToGrid(product) {
        const container = document.getElementById("product-container");
        if (!container) return;

        const card = document.createElement("div");
        card.classList.add("bg-white", "rounded-lg", "shadow", "p-4", "text-center");

        const imgSrc = product.image ? `/storage/${product.image}` : "https://via.placeholder.com/150";

        card.innerHTML = `
            <img src="${imgSrc}" alt="${product.name}" class="w-full h-48 object-cover rounded-md mb-2">
            <h3 class="text-lg font-semibold">${product.name}</h3>
            <p class="text-gray-700">₱${product.price}</p>
            ${product.stock ? `<p class="line-through text-gray-400">₱${product.stock}</p>` : ""}
        `;

        container.prepend(card);
    }

    resetForm() {
        if (!this.form) return;
        this.form.reset();
        this.imagePreview.src = "";
        this.imagePreviewContainer.classList.add("hidden");
    }
}

// ✅ Safe initialization after DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    new ProductModal();
});
