<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
   <?php $__env->slot('header', null, []); ?> 
    <div class="page-head">
      <div>
        <h2 class="page-title">Product Management</h2>
        <p class="page-sub">Manage your products, stock, and categories.</p>
      </div>

      <button id="openModalBtn" class="btn-primary">
        + Add Product
      </button>
    </div>
   <?php $__env->endSlot(); ?>

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/product.css')); ?>">

  <div class="page-wrap">
    <div class="panel">
      <div class="panel-top">
        <h3>Products</h3>
        <p>Search, sort, and manage your store inventory.</p>
      </div>

      <div class="table-wrap">
        <table id="productTable" class="dt-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Category</th>
              <th>Image</th>
              <th>Status</th>
              <th style="width:180px;">Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  
  <div id="addProductModal" class="modal-overlay hidden">
    <div class="modal-box">
      <div class="modal-top">
        <h3>Add New Product</h3>
        <button type="button" class="modal-close" id="closeModalBtn">✕</button>
      </div>

      <div class="modal-body">
        <form id="addProductForm" class="form-grid">
          <div class="form-group full">
            <label for="productName">Product Name</label>
            <input type="text" id="productName" required>
          </div>

          <div class="form-group">
            <label for="productPrice">Price</label>
            <input type="number" step="0.01" id="productPrice" required>
          </div>

          <div class="form-group">
            <label for="productStock">Stock</label>
            <input type="number" step="1" id="productStock" required>
          </div>

          <div class="form-group full">
            <label for="productCategory">Category</label>
            <select id="productCategory" name="category_id" required>
              <option hidden>Select Category</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->category_id); ?>"><?php echo e($category->category_name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <div class="form-group full">
            <label for="productImage">Product Image</label>
            <input type="file" id="productImage" accept="image/*" required>
            <div id="imagePreviewContainer" class="preview-container hidden">
              <img id="imagePreview" src="" alt="Preview">
            </div>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-secondary" id="closeModalBtn2">Cancel</button>
            <button type="submit" class="btn-primary">Add Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  
  <div id="editProductModal" class="modal-overlay hidden">
    <div class="modal-box">
      <div class="modal-top">
        <h3>Edit Product</h3>
        <button type="button" class="modal-close" id="closeEditModalBtn">✕</button>
      </div>

      <div class="modal-body">
        <form id="editProductForm" class="form-grid">
          <input type="hidden" id="editProductId">

          <div class="form-group full">
            <label for="editProductName">Product Name</label>
            <input type="text" id="editProductName" required>
          </div>

          <div class="form-group">
            <label for="editProductPrice">Price</label>
            <input type="number" step="0.01" id="editProductPrice" required>
          </div>

          <div class="form-group">
            <label for="editProductStock">Stock</label>
            <input type="number" step="1" id="editProductStock" required>
          </div>

          <div class="form-group full">
            <label for="editProductCategory">Category</label>
            <select id="editProductCategory" name="category_id" required>
              <option hidden>Select Category</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->category_id); ?>"><?php echo e($category->category_name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>

          <div class="form-group full">
            <label for="editProductStatus">Status</label>
            <select id="editProductStatus" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>

          <div class="form-group full">
            <label for="editProductImage">Product Image</label>
            <input type="file" id="editProductImage" accept="image/*">
            <div id="editImagePreviewContainer" class="preview-container hidden">
              <img id="editImagePreview" src="" alt="Preview">
            </div>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-secondary" id="closeEditModalBtn2">Cancel</button>
            <button type="submit" class="btn-primary">Update Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\petergwapo\FashionStore\resources\views/Product/product.blade.php ENDPATH**/ ?>