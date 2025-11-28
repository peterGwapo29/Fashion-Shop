document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-delete")) {
        const button = e.target.closest(".btn-delete");
        const id = button.getAttribute("data-id");

        // SweetAlert confirmation
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/products/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                },
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success",
                timer: 1500,
                showConfirmButton: false
                });

                // 🔄 Reload the DataTable or page after short delay
                setTimeout(() => {
                location.reload();
                }, 1600);
            })
            .catch(err => {
                Swal.fire({
                title: "Error!",
                text: "Something went wrong.",
                icon: "error"
                });
                console.error("Error deleting product:", err);
            });
        }
        });
    }
});