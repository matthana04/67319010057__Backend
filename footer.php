</main>
<footer class="bg-white mt-10">
  <div class="max-w-6xl mx-auto px-4 py-6 text-sm text-slate-600">
    &copy; <?= date('Y') ?> ร้านค้าออนไลน์ — Theme Blue
  </div>
</footer>
<script>
// Modal quick view
function openQuickView(id){
  fetch('/api/product.php?id='+id).then(r=>r.json()).then(data=>{
    const html = `<div class="p-4"><h2 class="text-lg font-semibold">${data.name}</h2>
    <p class="mt-2">${data.description}</p>
    <p class="mt-2 font-bold">${data.price} THB</p>
    <button onclick="addToCart(${data.id},1)" class="mt-3 px-4 py-2 rounded bg-blue-600 text-white">เพิ่มในตะกร้า</button>
    </div>`;
    const layer = document.getElementById('quickview-layer');
    layer.innerHTML = html;
    layer.classList.remove('hidden');
  });
}
function closeQuickView(){ document.getElementById('quickview-layer').classList.add('hidden'); }
function addToCart(id, qty){
  fetch('/cart_action.php', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action:'add', product_id:id, qty})})
  .then(()=>{ alert('เพิ่มแล้ว'); location.reload(); });
}
</script>
<div id="quickview-layer" class="fixed inset-0 bg-black/40 flex items-center justify-center hidden">
  <div class="bg-white max-w-xl w-full rounded shadow p-4 relative">
    <button onclick="closeQuickView()" class="absolute top-2 right-2 text-slate-500">ปิด</button>
    <div id="quickview-content"></div>
  </div>
</div>
</body>
</html>