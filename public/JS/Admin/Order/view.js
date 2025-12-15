function baseUrl() {
  return location.protocol + "//" + location.host + "/";
}

function formatItems(orderId) {
  return `
    <div class="items-wrap" data-order="${orderId}">
      <div class="items-head">
        <p class="items-title">Order Items</p>
        <span class="items-sub">Items included in this order</span>
      </div>

      <div class="items-body">
        <div class="items-loading">Loading items...</div>
      </div>
    </div>
  `;
}

$.ajaxSetup({
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(document).ready(function () {

  const table = new DataTable('#orderTable', {
    ajax: baseUrl() + 'orderAdmin/list',
    processing: true,
    serverSide: true,
    columns: [
      { className: 'dt-control', orderable: false, data: null, defaultContent: '' },
      { data: 'id', title: 'Order ID' },
      { data: 'customer', title: 'Customer' },
      { data: 'payment_method', title: 'Payment Method' },
      { data: 'payment_reference', title: 'Payment Ref' },
      {
        data: 'total',
        title: 'Total',
        render: function (data) {
          return `₱${Number(data || 0).toFixed(2)}`;
        }
      },
      {
        data: 'status',
        title: 'Status',
        orderable: false,
        render: function (data, type, row) {
          const current = (data || 'pending').toLowerCase();
          const options = ['pending', 'processing', 'shipped', 'paid', 'completed', 'cancelled'];

          const optsHtml = options.map(s => {
            const selected = (s === current) ? 'selected' : '';
            return `<option value="${s}" ${selected}>${s.toUpperCase()}</option>`;
          }).join('');

          // one pill button only (select styled)
          return `
            <select class="status-pill status--${current}" data-id="${row.id}">
              ${optsHtml}
            </select>
          `;
        }
      }
    ],
    order: [[1, 'desc']]
  });

  // Expand row
  $('#orderTable tbody').on('click', 'td.dt-control', function () {
    const tr = $(this).closest('tr');
    const row = table.row(tr);

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
      return;
    }

    row.child(formatItems(row.data().id)).show();
    tr.addClass('shown');

    const orderId = row.data().id;
    const wrap = tr.next('tr').find('.items-wrap .items-body');

    $.get(baseUrl() + `orderAdmin/${orderId}/items`, function (res) {
      if (!res.items || res.items.length === 0) {
        wrap.html(`<div class="items-empty">No items found.</div>`);
        return;
      }

      let html = `
        <div class="items-table-wrap">
          <table class="items-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Image</th>
              </tr>
            </thead>
            <tbody>
      `;

      res.items.forEach(it => {
        const img = it.image
          ? `<img src="${baseUrl()}storage/${it.image}" class="items-img" alt="Product">`
          : `<span class="items-muted">—</span>`;

        html += `
          <tr>
            <td class="items-product">${it.product}</td>
            <td>₱${Number(it.price || 0).toFixed(2)}</td>
            <td>${it.qty}</td>
            <td>₱${Number(it.subtotal || 0).toFixed(2)}</td>
            <td>${img}</td>
          </tr>
        `;
      });

      html += `
            </tbody>
          </table>
        </div>
      `;

      wrap.html(html);

    }).fail(function () {
      wrap.html(`<div class="items-error">Failed to load items.</div>`);
    });
  });

  // Status change
  $('#orderTable tbody').on('change', '.status-pill', function () {
    const orderId = $(this).data('id');
    const newStatus = $(this).val();
    const el = $(this);

    $.ajax({
      url: baseUrl() + `orderAdmin/${orderId}/status`,
      method: 'PUT',
      data: { status: newStatus },
      success: function () {
        el.removeClass(function (i, c) {
          return (c.match(/status--\S+/g) || []).join(' ');
        });
        el.addClass(`status--${newStatus}`);
      },
      error: function (xhr) {
        alert('Failed to update status.');
        console.log(xhr.responseText);
      }
    });
  });

});
