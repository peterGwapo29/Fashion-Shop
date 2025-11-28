class ProductEditModal {
    constructor() {
        this.modal = document.getElementById("editProductModal");
        this.closeBtn = document.getElementById("closeEditModalBtn");
        this.form = document.getElementById("editProductForm");
        this.idInput = document.getElementById("editProductId");

        // Fields
        this.nameInput = document.getElementById("editProductName");
        this.priceInput = document.getElementById("editProductPrice");
        this.categoryInput = document.getElementById("editProductCategory");
        this.stockInput = document.getElementById("editProductStock");
        this.statusInput = document.getElementById("editProductStatus");
        this.imageInput = document.getElementById("editProductImage");
        this.imagePreview = document.getElementById("editImagePreview");
        this.imagePreviewContainer = document.getElementById("editImagePreviewContainer");

        this.initEvents();
    }

    initEvents() {
        // Close modal
        this.closeBtn?.addEventListener("click", () => this.hideModal());

        // Click outside to close
        this.modal?.addEventListener("click", (e) => {
            if (e.target === this.modal) {
                this.hideModal();
            }
        });

        // Image preview
        this.imageInput?.addEventListener("change", (e) => this.previewImage(e));

        // Form submit
        this.form?.addEventListener("submit", (e) => this.handleSubmit(e));

        // Attach edit button listener dynamically
        $(document).on("click", ".btn-edit", (e) => this.openModal(e));
    }


    showModal() {
        this.modal?.classList.remove("hidden");
    }

    hideModal() {
        this.modal?.classList.add("hidden");
        this.form.reset();
        this.imagePreview.src = "";
        this.imagePreviewContainer.classList.add("hidden");
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
        };
        reader.readAsDataURL(file);
    }

    openModal(e) {
        const id = e.currentTarget.getAttribute("data-id");
        const row = $(`#productTable`).DataTable().row($(e.currentTarget).closest("tr")).data();

        this.idInput.value = id;
        this.nameInput.value = row.name;
        this.priceInput.value = row.price;
        this.categoryInput.value = row.category;

        // ✅ Fixed stock handling
        this.stockInput.value = row.stock;

        this.statusInput.value = row.status ?? "active";
        if (row.image) {
            this.imagePreview.src = `/storage/${row.image}`;
            this.imagePreviewContainer.classList.remove("hidden");
        } else {
            this.imagePreviewContainer.classList.add("hidden");
        }

        this.showModal();
    }

    async handleSubmit(e) {
        e.preventDefault();
        const id = this.idInput.value;
        const formData = new FormData();
        formData.append("name", this.nameInput.value);
        formData.append("price", this.priceInput.value);
        formData.append("category_id", this.categoryInput.value);
        formData.append("stock", this.stockInput.value);
        formData.append("status", this.statusInput.value);

        const file = this.imageInput.files[0];
        if (file) formData.append("image", file);

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        try {
            const response = await fetch(`/products/${id}`, {
                method: "POST", // We'll override method
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "X-HTTP-Method-Override": "PUT", // Laravel PUT override
                    "Accept": "application/json",
                },
                body: formData,
            });

            const result = await response.json();

            if (!response.ok) {
                alert("Failed to update product: " + (result.message || "Unknown error"));
                return;
            }

            // Reload DataTable
            $(`#productTable`).DataTable().ajax.reload();

            this.hideModal();

            Swal.fire({
                position: "center",
                icon: "success",
                title: "Product updated successfully",
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true,
                allowOutsideClick: false,
            });

        } catch (error) {
            console.error("Error updating product:", error);
            alert("⚠️ An error occurred while updating the product.");
        }
    }
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    new ProductEditModal();
});
