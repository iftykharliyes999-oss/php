<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Customers'; $ACTIVE='customers';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $a=$_POST['action']??'';
    try {
        if ($a==='save') {
            $id=(int)($_POST['id']??0);
            $p=[$_POST['name'],$_POST['email']??'',$_POST['phone']??'',$_POST['nid']??'',
                $_POST['nationality']??'Bangladeshi',$_POST['address']??'',(int)($_POST['vip']??0)];
            if ($id) { $p[]=$id;
              q($conn,"UPDATE customers SET name=?,email=?,phone=?,nid=?,nationality=?,address=?,vip=? WHERE id=?",$p,'ssssssii');
            } else {
              q($conn,"INSERT INTO customers (name,email,phone,nid,nationality,address,vip) VALUES (?,?,?,?,?,?,?)",$p,'ssssssi');
              $id=$conn->insert_id;
            }
            jsonOut(['ok'=>true,'id'=>$id]);
        }
        if ($a==='delete') { q($conn,"DELETE FROM customers WHERE id=?",[(int)$_POST['id']],'i'); jsonOut(['ok'=>true]); }
        jsonOut(['ok'=>false],400);
    } catch (Throwable $e) { jsonOut(['ok'=>false,'error'=>$e->getMessage()],500); }
}

// load customers + booking aggregates
$customers = fetchAll($conn,"
  SELECT c.*,
    (SELECT COUNT(*) FROM bookings b WHERE b.phone=c.phone) AS bookings_count,
    (SELECT COALESCE(SUM(total),0) FROM bookings b WHERE b.phone=c.phone AND b.pay_status='paid') AS total_spent
  FROM customers c ORDER BY c.id DESC");

$kpiTotal=count($customers);
$kpiVip=count(array_filter($customers,fn($c)=>$c['vip']));
$kpiForeign=count(array_filter($customers,fn($c)=>strtolower($c['nationality']??'')!=='bangladeshi'));
$kpiSpent=array_sum(array_map(fn($c)=>(float)$c['total_spent'],$customers));

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>👤 Customer Management</h2>
  <input class="search" placeholder="Search guest, phone, NID...">
  <div>👤 Admin</div>
</div>

<div class="kpi">
  <div class="card"><div><small>Total Guests</small><h3><?= $kpiTotal ?></h3></div><div class="icon blue"><i class="fa-solid fa-users"></i></div></div>
  <div class="card"><div><small>VIP</small><h3><?= $kpiVip ?></h3></div><div class="icon yellow"><i class="fa-solid fa-crown"></i></div></div>
  <div class="card"><div><small>Foreign</small><h3><?= $kpiForeign ?></h3></div><div class="icon cyan"><i class="fa-solid fa-globe"></i></div></div>
  <div class="card"><div><small>Total Revenue</small><h3><?= bdt($kpiSpent) ?></h3></div><div class="icon green"><i class="fa-solid fa-sack-dollar"></i></div></div>
</div>

<div class="grid-form">
  <div class="box">
    <h3>➕ Add Customer</h3>
    <form id="cForm">
      <input type="hidden" name="action" value="save"><input type="hidden" name="id" id="cId">
      <div class="form-group"><label>Full Name *</label><input name="name" id="cName" required></div>
      <div class="form-group"><label>Phone *</label><input name="phone" id="cPhone" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" id="cEmail"></div>
      <div class="form-group"><label>NID / Passport</label><input name="nid" id="cNid"></div>
      <div class="form-group"><label>Nationality</label><input name="nationality" id="cNat" value="Bangladeshi"></div>
      <div class="form-group"><label>Address</label><textarea name="address" id="cAddr" rows="2"></textarea></div>
      <div class="form-group"><label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="vip" value="1" id="cVip" style="width:auto;"> ⭐ Mark as VIP</label></div>
      <button class="btn btn-primary"><i class="fa-solid fa-check"></i> <span id="submitBtnText">Save Customer</span></button>
    </form>
  </div>

  <div class="box">
    <div class="toolbar">
      <div class="filters">
        <input id="cSearch" placeholder="🔍 Search name, phone, email...">
        <select id="cFilterVip"><option value="">All</option><option value="1">VIP only</option><option value="0">Regular</option></select>
      </div>
    </div>
    <table>
      <thead><tr><th>Customer</th><th>Contact</th><th>Nationality</th><th>Bookings</th><th>Spent</th><th>Tier</th><th>Actions</th></tr></thead>
      <tbody id="cTable"></tbody>
    </table>
  </div>
</div>

<script>
let customers = <?= json_encode($customers) ?>;
const fmt=n=>'৳'+Number(n||0).toLocaleString('en-IN');
function render(){
  const s=$('cSearch').value.toLowerCase(), v=$('cFilterVip').value;
  const list=customers.filter(c=>(!s||(c.name+(c.phone||'')+(c.email||'')+(c.nid||'')).toLowerCase().includes(s)) && (v===''||String(c.vip)===v));
  const tb=$('cTable'); tb.innerHTML='';
  if(!list.length){ tb.innerHTML='<tr><td colspan="7" style="text-align:center;padding:30px;color:#888">No customers</td></tr>'; return; }
  list.forEach(c=>{
    const tr=document.createElement('tr');
    tr.innerHTML=`
      <td><div class="user-cell"><div class="avatar" style="background:${avColor(c.name)}">${initials(c.name)}</div>
        <div class="user-info"><b>${c.name}</b><small>${c.address||''}</small></div></div></td>
      <td>${c.phone||'-'}<br><small style="color:#888">${c.email||''}</small></td>
      <td>${c.nationality||'-'}</td>
      <td><b>${c.bookings_count||0}</b></td>
      <td><b>${fmt(c.total_spent)}</b></td>
      <td>${+c.vip?'<span class="badge b-yellow">⭐ VIP</span>':'<span class="badge b-gray">Regular</span>'}</td>
      <td><button class="btn btn-sm btn-edit" onclick="editC(${c.id})"><i class="fa-solid fa-pen"></i></button>
          <button class="btn btn-sm btn-delete" onclick="delC(${c.id})"><i class="fa-solid fa-trash"></i></button></td>`;
    tb.appendChild(tr);
  });
}
function editC(id){
  const c=customers.find(x=>x.id==id); if(!c) return;
  $('cId').value=c.id; $('cName').value=c.name; $('cPhone').value=c.phone||''; $('cEmail').value=c.email||'';
  $('cNid').value=c.nid||''; $('cNat').value=c.nationality||''; $('cAddr').value=c.address||''; $('cVip').checked=!!+c.vip;
  $('submitBtnText').textContent='Update Customer'; window.scrollTo({top:0,behavior:'smooth'});
}
async function delC(id){
  if(!confirm('Delete?')) return;
  const r=await api('customers.php',{action:'delete',id});
  if(r.ok){ customers=customers.filter(x=>x.id!=id); render(); toast('🗑 Deleted',true);} else toast(r.error,true);
}
$('cForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const fd=new FormData(e.target);
  if(!fd.get('vip')) fd.set('vip','0');
  const r=await api('customers.php',Object.fromEntries(fd));
  if(!r.ok){ toast(r.error||'Failed',true); return; }
  const data=Object.fromEntries(fd); data.bookings_count=0; data.total_spent=0;
  if(data.id){ const i=customers.findIndex(x=>x.id==data.id); customers[i]={...customers[i],...data,id:+data.id}; toast('Updated'); }
  else { customers.unshift({...data,id:r.id}); toast('Added'); }
  e.target.reset(); $('cId').value=''; $('submitBtnText').textContent='Save Customer'; render();
});
['cSearch','cFilterVip'].forEach(id=>$(id).addEventListener('input',render));
render();
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
