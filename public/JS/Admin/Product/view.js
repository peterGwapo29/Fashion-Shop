function baseUrl() {
    return location.protocol + "//" + location.host + "/";
}

$(document).ready(function () {
    new DataTable('#productTable', {
        ajax: baseUrl() + 'product/list',
        processing: true,
        serverSide: true,
        columns: [
            { data: 'id', name: 'id', title: 'ID' },
            { data: 'name', name: 'name', title: 'Product Name' },
            { data: 'price', name: 'price', title: 'Price' },
            { data: 'stock', name: 'stock', title: 'Stock' },
            { data: 'category', name: 'category', title: 'Category' },
            { 
                data: 'image',
                name: 'image',
                title: 'Image',
                render: function (data) {
                    return data
                        ? `<img src="${baseUrl()}storage/${data}" class="img-thumb" alt="Product">`
                        : `<span class="muted">No image</span>`;
                }

            },
            {
                data: 'status',
                name: 'status',
                title: 'Status',
                render: function (data) {
                    const s = (data || '').toString().toLowerCase();
                    const cls = (s === 'active') ? 'status-active' : 'status-inactive';
                    return `<span class="status-pill ${cls}">${(s || 'inactive').toUpperCase()}</span>`;
                }
                },
                {
                    data: null,
                    title: 'Actions',
                    orderable: false,
                    searchable: false,
                    render: function (row) {
                        const status = (row.status || '').toLowerCase();
                        const isInactive = status === 'inactive';

                        const editBtn = `
                        <button class="btn-edit" style="display: flex; text-align: center; justify-content: center; align-items: center; gap: 4px;" data-id="${row.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                            </svg>
                            Edit
                        </button>
                        `;

                        const deleteBtn = `
                        <button class="btn-delete" style="display: flex; text-align: center; justify-content: center; align-items: center; gap: 4px;" data-id="${row.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                            <path d="M3 6h18"/>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                            </svg>
                            Delete
                        </button>
                        `;

                        const restoreBtn = `
                        <button class="btn-restore" style="display: flex; text-align: center; justify-content: center; align-items: center; gap: 4px;" data-id="${row.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 3-6.7"/>
                            <path d="M3 3v6h6"/>
                            </svg>
                            Restore
                        </button>
                        `;

                        return `
                        <div class="button-group">
                            ${isInactive ? '' : editBtn}
                            ${isInactive ? restoreBtn : deleteBtn}
                        </div>
                        `;
                    }
                    }

        ]
    });
});

$('#closeModalBtn, #closeModalBtn2').on('click', function(){
  $('#addProductModal').addClass('hidden');
});

$('#closeEditModalBtn, #closeEditModalBtn2').on('click', function(){
  $('#editProductModal').addClass('hidden');
});

