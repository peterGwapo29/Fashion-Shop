function baseUrl(){ return location.protocol + "//" + location.host + "/"; }

function openModal(id){ document.getElementById(id).classList.remove('hidden'); }
function closeModal(id){ document.getElementById(id).classList.add('hidden'); }

document.addEventListener('click', (e) => {
  const open = e.target.closest('[data-open]');
  const close = e.target.closest('[data-close]');
  if(open) openModal(open.dataset.open);
  if(close) closeModal(close.dataset.close);
});

document.querySelectorAll('.modal-overlay').forEach(ov => {
  ov.addEventListener('click', (e) => {
    if(e.target === ov) ov.classList.add('hidden');
  });
});

$(document).ready(async function(){

  const res = await fetch(baseUrl() + 'dashboard/charts/overview');
  const data = await res.json();

  const ctx1 = document.getElementById('ordersSalesChart');
  const chart1 = new Chart(ctx1, {
    type: 'line',
    data: {
      labels: data.labels,
      datasets: [
        { label: 'Orders', data: data.orders, tension: 0.3 },
        { label: 'Sales', data: data.sales, tension: 0.3 }
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: true } },
      onClick: () => openModal('ordersModal')
    }
  });

  const ctx2 = document.getElementById('marketChart');
  const chart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ['Marketable', 'Non-Marketable'],
      datasets: [{ label: 'Products', data: [data.marketable, data.non_marketable], borderRadius: 10 }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: false } },
      onClick: (evt) => {
        const points = chart2.getElementsAtEventForMode(evt, 'nearest', { intersect:true }, true);
        if(!points.length) return;
        const idx = points[0].index;
        if(idx === 0) openModal('marketableModal');
        if(idx === 1) openModal('nonMarketableModal');
      }
    }
  });

  $('#ordersTable').DataTable({
    ajax: baseUrl() + 'dashboard/table/orders',
    processing: true,
    serverSide: true,
    columns: [
      { data: 'id', render: d => `#${d}` },
      { data: 'customer' },
      { data: 'email' },
      { data: 'payment_method' },
      { data: 'payment_reference' },
      { data: 'total', render: d => `₱${Number(d||0).toFixed(2)}` },
      { data: 'status' },
      { data: 'date' },
    ]
  });

  $('#salesTable').DataTable({
    ajax: baseUrl() + 'dashboard/table/orders',
    processing: true,
    serverSide: true,
    columns: [
      { data: 'id', render: d => `#${d}` },
      { data: 'customer' },
      { data: 'total', render: d => `₱${Number(d||0).toFixed(2)}` },
      { data: 'status' },
      { data: 'date' },
    ]
  });

  $('#marketableTable').DataTable({
    ajax: baseUrl() + 'dashboard/table/products/marketable',
    processing: true,
    serverSide: true,
    columns: [
      { data: 'id' },
      { data: 'name' },
      { data: 'price', render: d => `₱${Number(d||0).toFixed(2)}` },
      { data: 'sold_qty' }
    ]
  });

  $('#nonMarketableTable').DataTable({
    ajax: baseUrl() + 'dashboard/table/products/nonmarketable',
    processing: true,
    serverSide: true,
    columns: [
      { data: 'id' },
      { data: 'name' },
      { data: 'price', render: d => `₱${Number(d||0).toFixed(2)}` },
      { data: 'sold_qty' }
    ]
  });
});
