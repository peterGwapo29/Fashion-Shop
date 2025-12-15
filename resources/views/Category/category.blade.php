<x-app-layout>
  <x-slot name="header">
    <div class="page-head">
      <div>
        <h2 class="page-title">Category Management</h2>
        <p class="page-sub">Manage your categories.</p>
      </div>

      <button id="openModalBtn" class="btn-primary">
        + Add Category
      </button>
    </div>
  </x-slot>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/category.css') }}">

  <div class="page-wrap">
    <div class="panel">
      <div class="panel-top">
        <h3>Categories</h3>
        <p>Create, edit, and remove categories.</p>
      </div>

      <div class="table-wrap">
        <table id="categoryTable" class="dt-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category Name</th>
              <th>Description</th>
              <th>Status</th>
              <th style="width:220px;">Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- ADD MODAL --}}
  <div id="addCategoryModal" class="modal-overlay hidden">
    <div class="modal-box">
      <div class="modal-top">
        <h3>Add Category</h3>
        <button type="button" class="modal-close" id="closeAddModalBtn">✕</button>
      </div>

      <div class="modal-body">
        <form id="addCategoryForm" class="form-grid">
          <div class="form-group full">
            <label>Category Name</label>
            <input type="text" id="categoryName" required>
          </div>

          <div class="form-group full">
            <label>Description</label>
            <textarea id="categoryDesc" rows="4" placeholder="Optional..."></textarea>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-secondary" id="closeAddModalBtn2">Cancel</button>
            <button type="submit" class="btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- EDIT MODAL --}}
  <div id="editCategoryModal" class="modal-overlay hidden">
    <div class="modal-box">
      <div class="modal-top">
        <h3>Edit Category</h3>
        <button type="button" class="modal-close" id="closeEditModalBtn">✕</button>
      </div>

      <div class="modal-body">
        <form id="editCategoryForm" class="form-grid">
          <input type="hidden" id="editCategoryId">

          <div class="form-group full">
            <label>Category Name</label>
            <input type="text" id="editCategoryName" required>
          </div>

          <div class="form-group full">
            <label>Description</label>
            <textarea id="editCategoryDesc" rows="4" placeholder="Optional..."></textarea>
          </div>

          <div class="modal-actions">
            <button type="button" class="btn-secondary" id="closeEditModalBtn2">Cancel</button>
            <button type="submit" class="btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-app-layout>
