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
                        ? `<img src="${baseUrl()}storage/${data}" width="60" class="rounded">`
                        : 'No image';
                }
            },
            { data: 'status', name: 'status', title: 'Status' },
            {
                data: null,
                title: 'Actions',
                orderable: false,
                searchable: false,
                render: function (row) {
                    return `
                        <div class="button-group">
                            <button class="btn-edit flex flex-row justify-center items-center" data-id="${row.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" 
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen">
                                    <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                </svg>
                                Edit
                            </button>
                            <button class="btn-delete flex flex-row justify-center items-center" data-id="${row.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" 
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash">
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                                Delete
                            </button>
                        </div>
                    `;
                }
            }
        ]
    });
});