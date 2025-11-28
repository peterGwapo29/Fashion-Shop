function clearAllCart() {
    Swal.fire({
        title: "Clear all items?",
        text: "This will remove all items from your cart.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e63946",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, clear all"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/cart/clear-all`, {
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
                setTimeout(() => location.reload(), 1200);
            });
        }
    });
}


  
function deleteCartItem(id) {
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
            fetch(`/cart/delete/${id}`, {
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
                setTimeout(() => location.reload(), 1200);
            });
        }
    });
}