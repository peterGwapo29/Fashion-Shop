(function () {
  function csrf() {
    const t = document.querySelector('meta[name="csrf-token"]');
    return t ? t.getAttribute("content") : "";
  }

  function reloadProductTable() {
    const dt = $("#productTable").DataTable();
    dt.ajax.reload(null, false);
  }

  // ✅ Soft delete product (set inactive)
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.getAttribute("data-id");

    Swal.fire({
      title: "Set product inactive?",
      text: "You can restore it later.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#563375",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, deactivate",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (!result.isConfirmed) return;

      fetch(`/products/${id}`, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": csrf(),
          "Accept": "application/json"
        }
      })
        .then((r) => r.json())
        .then((data) => {
          Swal.fire({
            title: "Done!",
            text: data.message || "Product is now inactive.",
            icon: "success",
            timer: 1200,
            showConfirmButton: false
          });

          reloadProductTable(); // ✅ no full reload
        })
        .catch((err) => {
          Swal.fire({
            title: "Error!",
            text: "Something went wrong.",
            icon: "error"
          });
          console.error("Error deactivating product:", err);
        });
    });
  });

  // ✅ Restore product (set active)
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.getAttribute("data-id");

    Swal.fire({
      title: "Restore product?",
      text: "This product will become active again.",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#563375",
      cancelButtonColor: "#aaa",
      confirmButtonText: "Yes, restore",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (!result.isConfirmed) return;

      fetch(`/products/${id}/restore`, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrf(),
          "X-HTTP-Method-Override": "PUT",
          "Accept": "application/json"
        }
      })
        .then((r) => r.json())
        .then((data) => {
          Swal.fire({
            title: "Restored!",
            text: data.message || "Product restored successfully.",
            icon: "success",
            timer: 1200,
            showConfirmButton: false
          });

          reloadProductTable();
        })
        .catch((err) => {
          Swal.fire({
            title: "Error!",
            text: "Failed to restore product.",
            icon: "error"
          });
          console.error("Error restoring product:", err);
        });
    });
  });
})();
