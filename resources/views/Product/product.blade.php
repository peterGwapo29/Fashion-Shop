<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <!-- Add Product Button -->
                <div class="flex justify-end mb-4">
                    <button id="openModalBtn" class="px-4 py-2 text-white rounded-md" style="background-color: var(--primary-color);">
                        + Add Product
                    </button>
                </div>

                <!-- Product Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200" id="productTable">
                        <tbody id="product-table-body" class="divide-y divide-gray-200 text-sm text-gray-700">
                            <!-- Dynamic rows will appear here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal-overlay hidden">
        <div class="modal-box">
            <h3 class="modal-title">Add New Product</h3>
            <form id="addProductForm">
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" id="productName" required>
                </div>

                <div class="form-group">
                    <label for="productImage">Product Image</label>
                    <input type="file" id="productImage" accept="image/*" required>
                    <div id="imagePreviewContainer" class="preview-container hidden">
                        <img id="imagePreview" src="" alt="Preview">
                    </div>
                </div>

                <div class="form-group">
                    <label for="productPrice">Price</label>
                    <input type="number" step="0.01" id="productPrice" required>
                </div>

                <div class="form-group">
                    <label for="productCategory">Category</label>
                    <select id="productCategory" name="category_id" required>
                        <option hidden>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="productStock">Stock</label>
                    <input type="number" step="0.01" id="productStock" required>
                </div>

                <div class="modal-actions">
                    <button type="button" id="closeModalBtn" class="btn cancel-btn">Cancel</button>
                    <button type="submit" class="btn add-btn">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="modal-overlay hidden">
        <div class="modal-box">
            <h3 class="modal-title">Edit Product</h3>
            <form id="editProductForm">
                <input type="hidden" id="editProductId">

                <div class="form-group">
                    <label for="editProductName">Product Name</label>
                    <input type="text" id="editProductName" required>
                </div>

                <div class="form-group">
                    <label for="editProductImage">Product Image</label>
                    <input type="file" id="editProductImage" accept="image/*">
                    <div id="editImagePreviewContainer" class="preview-container hidden">
                        <img id="editImagePreview" src="" alt="Preview">
                    </div>
                </div>

                <div class="form-group">
                    <label for="editProductPrice">Price</label>
                    <input type="number" step="0.01" id="editProductPrice" required>
                </div>

                <div class="form-group">
                    <label for="editProductCategory">Category</label>
                    <select id="editProductCategory" name="category_id" required>
                        <option hidden>Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="editProductStock">Stock</label>
                    <input type="number" step="0.01" id="editProductStock" required>
                </div>

                <div class="form-group">
                    <label for="editProductStatus">Status</label>
                    <select id="editProductStatus" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" id="closeEditModalBtn" class="btn cancel-btn">Cancel</button>
                    <button type="submit" class="btn add-btn">Update Product</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
