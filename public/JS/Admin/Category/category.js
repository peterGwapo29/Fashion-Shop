(function () {
  const categoryTableEl = document.getElementById("categoryTable");
  const editModalEl = document.getElementById("editCategoryModal");
  const addModalEl = document.getElementById("addCategoryModal");

  if (!categoryTableEl || !editModalEl || !addModalEl) return;

  function baseUrl() {
    return location.protocol + "//" + location.host + "/";
  }

  function csrf() {
    const t = document.querySelector('meta[name="csrf-token"]');
    return t ? t.getAttribute("content") : "";
  }

  function openModal(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove("hidden");
  }

  function closeModal(id) {
    const el = document.getElementById(id);
    if (el) el.classList.add("hidden");
  }

  [addModalEl, editModalEl].forEach((modal) => {
    modal.addEventListener("click", (e) => {
      if (e.target === modal) modal.classList.add("hidden");
    });
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
      closeModal("addCategoryModal");
      closeModal("editCategoryModal");
    }
  });

  document.getElementById("openModalBtn")?.addEventListener("click", () => openModal("addCategoryModal"));
  document.getElementById("closeAddModalBtn")?.addEventListener("click", () => closeModal("addCategoryModal"));
  document.getElementById("closeAddModalBtn2")?.addEventListener("click", () => closeModal("addCategoryModal"));

  document.getElementById("closeEditModalBtn")?.addEventListener("click", () => closeModal("editCategoryModal"));
  document.getElementById("closeEditModalBtn2")?.addEventListener("click", () => closeModal("editCategoryModal"));

  const addForm = document.getElementById("addCategoryForm");
  const editForm = document.getElementById("editCategoryForm");

  const editId = document.getElementById("editCategoryId");
  const editName = document.getElementById("editCategoryName");
  const editDesc = document.getElementById("editCategoryDesc");

  const table = new DataTable("#categoryTable", {
    ajax: baseUrl() + "category/list",
    processing: true,
    serverSide: true,
    columns: [
      { data: "category_id", title: "ID" },
      { data: "category_name", title: "Category Name" },
      { data: "description", title: "Description", render: (d) => (d ? d : "—") },
      {
        data: "status",
        title: "Status",
        render: (d) => {
          const s = (d || "active").toLowerCase();
          const isInactive = s === "inactive";
          return `<span class="status-badge ${isInactive ? "status-inactive" : "status-active"}">
            ${isInactive ? "INACTIVE" : "ACTIVE"}
          </span>`;
        }
      },
      {
        data: null,
        title: "Actions",
        orderable: false,
        searchable: false,
        render: (row) => {
          const status = (row.status || "active").toLowerCase();
          const isInactive = status === "inactive";

          const editBtn = isInactive ? "" : `
            <button class="btn-edit" style="display: flex; text-align: center; justify-content: center; align-items: center; gap: 4px;" data-id="${row.category_id}">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
              </svg>
              Edit
            </button>
          `;

          const toggleBtn = isInactive
            ? ` <button class="btn-restore" style="display: flex; text-align: center; justify-content: center; align-items: center; gap: 4px;" data-id="${row.category_id}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 12a9 9 0 1 0 3-6.7"/>
                        <path d="M3 3v6h6"/>
                        </svg>
                        Restore
                  </button>`
            : `<button class="btn-delete" style="display: flex; text-align: center; justify-content: center; align-items: center; gap: 4px;" data-id="${row.category_id}">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                    <path d="M3 6h18"/>
                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                  </svg>
                  Delete
                </button>`;

          return `<div class="button-group">${editBtn}${toggleBtn}</div>`;
        }
      }

    ],
    order: [[0, "desc"]],
  });

  // ADD
  addForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    $.ajax({
      url: baseUrl() + "category",
      method: "POST",
      headers: { "X-CSRF-TOKEN": csrf() },
      data: {
        category_name: document.getElementById("categoryName").value,
        description: document.getElementById("categoryDesc").value,
      },
      success: function (res) {
        closeModal("addCategoryModal");
        addForm.reset();
        table.ajax.reload(null, false);

        Swal.fire({
          icon: "success",
          title: "Saved!",
          text: res.message || "Category created successfully.",
          timer: 1200,
          showConfirmButton: false
        });
      },
      error: function (xhr) {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: xhr.responseJSON?.message || "Failed to add category."
        });
      }
    });
  });

  // OPEN EDIT
  $(document).on("click", "#categoryTable .btn-edit", function () {
    const tr = $(this).closest("tr");
    const row = table.row(tr.hasClass("child") ? tr.prev() : tr).data();

    if (!row) {
      Swal.fire({ icon: "error", title: "Error", text: "Unable to read row data." });
      return;
    }

    const status = (row.status || "active").toLowerCase();
    if (status === "inactive") {
      Swal.fire({
        icon: "info",
        title: "Inactive category",
        text: "Restore this category first before editing.",
        timer: 1400,
        showConfirmButton: false
      });
      return;
    }

    editId.value = row.category_id;
    editName.value = row.category_name;
    editDesc.value = row.description || "";

    openModal("editCategoryModal");
  });


  // UPDATE
  editForm?.addEventListener("submit", function (e) {
    e.preventDefault();

    const id = editId.value;

    $.ajax({
      url: baseUrl() + `category/${id}`,
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": csrf(),
        "X-HTTP-Method-Override": "PUT",
      },
      data: {
        category_name: editName.value,
        description: editDesc.value,
      },
      success: function (res) {
        closeModal("editCategoryModal");
        table.ajax.reload(null, false);

        Swal.fire({
          icon: "success",
          title: "Updated!",
          text: res.message || "Category updated successfully.",
          timer: 1200,
          showConfirmButton: false
        });
      },
      error: function (xhr) {
        Swal.fire({
          icon: "error",
          title: "Failed",
          text: xhr.responseJSON?.message || "Failed to update category."
        });
      }
    });
  });

  // SOFT DELETE (inactive)
  $(document).on("click", "#categoryTable .btn-delete", function () {
    const tr = $(this).closest("tr");
    const row = table.row(tr.hasClass("child") ? tr.prev() : tr).data();

    Swal.fire({
      icon: "warning",
      title: "Set as inactive?",
      text: `This will set "${row.category_name}" to inactive.`,
      showCancelButton: true,
      confirmButtonText: "Yes, deactivate",
      cancelButtonText: "Cancel",
      confirmButtonColor: "#b91c1c"
    }).then((result) => {
      if (!result.isConfirmed) return;

      $.ajax({
        url: baseUrl() + `category/${row.category_id}`,
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrf(),
          "X-HTTP-Method-Override": "DELETE",
        },
        success: function (res) {
          table.ajax.reload(null, false);

          Swal.fire({
            icon: "success",
            title: "Done!",
            text: res.message || "Category set to inactive.",
            timer: 1200,
            showConfirmButton: false
          });
        },
        error: function () {
          Swal.fire({ icon: "error", title: "Failed", text: "Failed to set inactive." });
        }
      });
    });
  });

  // RESTORE (active)
  $(document).on("click", "#categoryTable .btn-restore", function () {
    const tr = $(this).closest("tr");
    const row = table.row(tr.hasClass("child") ? tr.prev() : tr).data();

    Swal.fire({
      icon: "question",
      title: "Restore category?",
      text: `This will restore "${row.category_name}" to active.`,
      showCancelButton: true,
      confirmButtonText: "Yes, restore",
      cancelButtonText: "Cancel",
      confirmButtonColor: "#563375"
    }).then((result) => {
      if (!result.isConfirmed) return;

      $.ajax({
        url: baseUrl() + `category/${row.category_id}/restore`,
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrf(),
          "X-HTTP-Method-Override": "PUT",
        },
        success: function (res) {
          table.ajax.reload(null, false);

          Swal.fire({
            icon: "success",
            title: "Restored!",
            text: res.message || "Category restored successfully.",
            timer: 1200,
            showConfirmButton: false
          });
        },
        error: function () {
          Swal.fire({ icon: "error", title: "Failed", text: "Failed to restore category." });
        }
      });
    });
  });

})();
