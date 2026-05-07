<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Bookings'; $ACTIVE='bookings';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $a=$_POST['action']??'';
    try {
        if ($a==='save') {
            $id=(int)($_POST['id']??0);
            $p=[$_POST['guest'],$_POST['phone'],$_POST['email']??'',$_POST['nid']??'',$_POST['nationality']??'',
                $_POST['room_no'],$_POST['room_type']??'',(float)$_POST['rate'],(int)$_POST['guests'],
                $_POST['check_in'],$_POST['check_out'],$_POST['source']??'Walk-In',$_POST['extras']??'',
                (float)($_POST['discount']??0),(float)($_POST['total']??0),
                $_POST['method']??'Cash',$_POST['pay_status']??'unpaid',$_POST['status']??'pending',$_POST['notes']??''];
            if ($id) {
                $p[]=$id;
                q($conn,"UPDATE bookings SET guest=?,phone=?,email=?,nid=?,nationality=?,room_no=?,room_type=?,rate=?,guests=?,check_in=?,check_out=?,source=?,extras=?,discount=?,total=?,method=?,pay_status=?,status=?,notes=? WHERE id=?",$p);
            } else {
                q($conn,"INSERT INTO bookings (guest,phone,email,nid,nationality,room_no,room_type,rate,guests,check_in,check_out,source,extras,discount,total,method,pay_status,status,notes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",$p);
                $id=$conn->insert_id;
            }
            jsonOut(['ok'=>true,'id'=>$id]);
        }
        if ($a==='delete') { q($conn,"DELETE FROM bookings WHERE id=?",[(int)$_POST['id']],'i'); jsonOut(['ok'=>true]); }
        if ($a==='status') {
            q($conn,"UPDATE bookings SET status=? WHERE id=?",[$_POST['status'],(int)$_POST['id']],'si');
            jsonOut(['ok'=>true]);
        }
        jsonOut(['ok'=>false],400);
    } catch (Throwable $e) { jsonOut(['ok'=>false,'error'=>$e->getMessage()],500); }
}

$bookings = fetchAll($conn,"SELECT * FROM bookings ORDER BY id DESC");
$rooms    = fetchAll($conn,"SELECT no,type,price FROM rooms ORDER BY no");

$kpi = [
  'Total'=>count($bookings),
  'Confirmed'=>count(array_filter($bookings,fn($b)=>$b['status']==='confirmed')),
  'CheckedIn'=>count(array_filter($bookings,fn($b)=>$b['status']==='checked-in')),
  'Pending'=>count(array_filter($bookings,fn($b)=>$b['status']==='pending')),
  'Revenue'=>array_sum(array_map(fn($b)=>(float)$b['total'], array_filter($bookings,fn($b)=>$b['pay_status']==='paid'))),
];

// chart by month (current year)
$year = date('Y');
$months = []; $monthLabels=[];
for ($m=1;$m<=12;$m++){ $monthLabels[]=date('M', mktime(0,0,0,$m,1));
  $months[$m]=(int)scalar($conn,"SELECT COUNT(*) FROM bookings WHERE YEAR(created_at)=? AND MONTH(created_at)=?", [$year,$m],'ii'); }
$srcAgg = fetchAll($conn,"SELECT source, COUNT(*) c FROM bookings GROUP BY source");

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>📅 Booking Management</h2>
  <input class="search" placeholder="Search guest, booking ID, room...">
  <div>👤 Admin</div>
</div>

<div class="kpi kpi-5">
  <div class="card"><div><small>Total</small><h3><?= $kpi['Total'] ?></h3></div><div class="icon blue"><i class="fa-solid fa-calendar-check"></i></div></div>
  <div class="card"><div><small>Confirmed</small><h3><?= $kpi['Confirmed'] ?></h3></div><div class="icon green"><i class="fa-solid fa-check"></i></div></div>
  <div class="card"><div><small>Checked-In</small><h3><?= $kpi['CheckedIn'] ?></h3></div><div class="icon yellow"><i class="fa-solid fa-door-open"></i></div></div>
  <div class="card"><div><small>Pending</small><h3><?= $kpi['Pending'] ?></h3></div><div class="icon orange"><i class="fa-solid fa-hourglass-half"></i></div></div>
  <div class="card"><div><small>Revenue</small><h3><?= bdt($kpi['Revenue']) ?></h3></div><div class="icon purple"><i class="fa-solid fa-sack-dollar"></i></div></div>
</div>

<div class="grid-2">
  <div class="box"><h3>📊 Bookings <?= $year ?></h3><div class="chart-wrap"><canvas id="bookingChart"></canvas></div></div>
  <div class="box"><h3>🥧 Booking Sources</h3><div class="chart-wrap"><canvas id="sourceChart"></canvas></div></div>
</div>

<div class="grid-form">
  <div class="box">
    <h3>➕ New Reservation</h3>
    <form id="bookForm">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" id="bId">
      <div class="form-group"><label>Guest Name *</label><input name="guest" id="bGuest" required></div>
      <div class="form-row">
        <div class="form-group"><label>Phone *</label><input name="phone" id="bPhone" required></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" id="bEmail"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>NID/Passport</label><input name="nid" id="bNid"></div>
        <div class="form-group"><label>Nationality</label><input name="nationality" id="bNat" value="Bangladeshi"></div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Room *</label>
          <select name="room_no" id="bRoom" required onchange="setRoom()">
            <option value="">Select room</option>
            <?php foreach ($rooms as $r): ?>
              <option value="<?= e($r['no']) ?>" data-type="<?= e($r['type']) ?>" data-price="<?= e($r['price']) ?>">
                <?= e($r['no']) ?> - <?= e($r['type']) ?> (<?= bdt($r['price']) ?>)
              </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="room_type" id="bRoomType">
          <input type="hidden" name="rate" id="bRate">
        </div>
        <div class="form-group"><label>Guests</label>
          <select name="guests" id="bGuests"><?php for($i=1;$i<=6;$i++): ?><option<?= $i==2?' selected':''?>><?= $i ?></option><?php endfor; ?></select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group"><label>Check-In *</label><input type="date" name="check_in" id="bCheckIn" required onchange="calcPrice()"></div>
        <div class="form-group"><label>Check-Out *</label><input type="date" name="check_out" id="bCheckOut" required onchange="calcPrice()"></div>
      </div>
      <div class="form-group"><label>Source</label>
        <select name="source"><option>Walk-In</option><option>Website</option><option>Phone Call</option><option>Booking.com</option><option>Agoda</option><option>Airbnb</option><option>Travel Agent</option><option>Corporate</option></select>
      </div>
      <div class="form-group"><label>Extra Services</label>
        <div class="check-row">
          <label><input type="checkbox" class="extra" value="500" data-name="Breakfast" onchange="calcPrice()"> 🍳 Breakfast (৳500)</label>
          <label><input type="checkbox" class="extra" value="800" data-name="Airport Pickup" onchange="calcPrice()"> 🚖 Airport Pickup (৳800)</label>
          <label><input type="checkbox" class="extra" value="1500" data-name="Spa" onchange="calcPrice()"> 💆 Spa (৳1500)</label>
          <label><input type="checkbox" class="extra" value="600" data-name="Laundry" onchange="calcPrice()"> 🧺 Laundry (৳600)</label>
          <label><input type="checkbox" class="extra" value="1000" data-name="Mini Bar" onchange="calcPrice()"> 🍷 Mini Bar (৳1000)</label>
        </div>
        <input type="hidden" name="extras" id="bExtras">
      </div>
      <div class="form-group"><label>Discount (%)</label><input type="number" name="discount" id="bDisc" min="0" max="100" value="0" oninput="calcPrice()"></div>
      <div class="price-summary">
        <div><span>Room (<span id="pNights">0</span> nights)</span><span id="pRoom">৳0</span></div>
        <div><span>Extras</span><span id="pExtras">৳0</span></div>
        <div><span>VAT (15%)</span><span id="pVat">৳0</span></div>
        <div><span>Service (10%)</span><span id="pSvc">৳0</span></div>
        <div><span>Discount</span><span id="pDiscV">-৳0</span></div>
        <div class="total"><span>TOTAL</span><span id="pTotal">৳0</span></div>
        <input type="hidden" name="total" id="bTotal" value="0">
      </div>
      <div class="form-row">
        <div class="form-group"><label>Method</label>
          <select name="method"><option>Cash</option><option>bKash</option><option>Nagad</option><option>Card</option><option>Bank Transfer</option></select></div>
        <div class="form-group"><label>Payment</label>
          <select name="pay_status"><option value="paid">Paid</option><option value="partial">Partial</option><option value="unpaid" selected>Unpaid</option></select></div>
      </div>
      <div class="form-group"><label>Status</label>
        <select name="status"><option value="pending">Pending</option><option value="confirmed">Confirmed</option><option value="checked-in">Checked-In</option><option value="checked-out">Checked-Out</option><option value="cancelled">Cancelled</option></select></div>
      <div class="form-group"><label>Notes</label><textarea name="notes" rows="2"></textarea></div>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> <span id="submitBtnText">Create Booking</span></button>
    </form>
  </div>

  <div class="box">
    <div class="tabs">
      <?php foreach (['all','pending','confirmed','checked-in','checked-out','cancelled'] as $t): ?>
        <button class="tab <?= $t==='all'?'active':''?>" data-tab="<?= $t ?>"><?= ucfirst($t) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="toolbar">
      <div class="filters">
        <input id="bSearch" placeholder="Search guest, room, ID...">
        <select id="filterSource"><option value="">All Sources</option><option>Walk-In</option><option>Website</option><option>Phone Call</option><option>Booking.com</option><option>Agoda</option><option>Travel Agent</option><option>Corporate</option></select>
      </div>
    </div>
    <table id="bookTable"></table>
  </div>
</div>

<script>
let bookings = <?= json_encode($bookings) ?>;
let currentTab='all';

const fmt=n=>'৳'+Number(n||0).toLocaleString('en-IN');
const sBadge=s=>({'pending':'b-yellow','confirmed':'b-blue','checked-in':'b-green','checked-out':'b-gray','cancelled':'b-red'}[s]||'b-gray');

function render(){
  const s=$('bSearch').value.toLowerCase(), src=$('filterSource').value;
  const list = bookings.filter(b=>{
    if(currentTab!=='all' && b.status!==currentTab) return false;
    if(src && b.source!==src) return false;
    if(s && !((b.guest+b.room_no+b.id+(b.phone||'')).toLowerCase().includes(s))) return false;
    return true;
  });
  $('bookTable').innerHTML = `
    <thead><tr><th>ID</th><th>Guest</th><th>Room</th><th>Dates</th><th>Total</th><th>Pay</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>${list.length?list.map(b=>`
      <tr>
        <td>#${b.id}</td>
        <td><div class="guest-cell"><div class="avatar" style="background:${avColor(b.guest)}">${initials(b.guest)}</div>
          <div><b>${b.guest}</b><br><small style="color:#888">${b.phone||''}</small></div></div></td>
        <td><b>${b.room_no}</b><br><small>${b.room_type||''}</small></td>
        <td>${b.check_in}<br><small>→ ${b.check_out}</small></td>
        <td><b>${fmt(b.total)}</b></td>
        <td><span class="badge ${b.pay_status==='paid'?'b-green':b.pay_status==='partial'?'b-yellow':'b-red'}">${b.pay_status}</span></td>
        <td><span class="badge ${sBadge(b.status)}">${b.status}</span></td>
        <td>
          <button class="btn btn-sm btn-edit" onclick="editBook(${b.id})"><i class="fa-solid fa-pen"></i></button>
          <button class="btn btn-sm btn-delete" onclick="delBook(${b.id})"><i class="fa-solid fa-trash"></i></button>
        </td>
      </tr>`).join(''):'<tr><td colspan="8" style="text-align:center;color:#888;padding:30px">No bookings</td></tr>'}</tbody>`;
}

document.querySelectorAll('.tab').forEach(t=>t.addEventListener('click',()=>{
  document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active'));
  t.classList.add('active'); currentTab=t.dataset.tab; render();
}));
['bSearch','filterSource'].forEach(id=>$(id).addEventListener('input',render));

function setRoom(){
  const o=$('bRoom').selectedOptions[0]; if(!o||!o.value) return;
  $('bRoomType').value=o.dataset.type; $('bRate').value=o.dataset.price; calcPrice();
}
function calcPrice(){
  const rate=+$('bRate').value||0;
  const ci=$('bCheckIn').value, co=$('bCheckOut').value;
  let nights=0; if(ci && co) nights=Math.max(0,Math.round((new Date(co)-new Date(ci))/86400000));
  const room = rate*nights;
  let extras=0; const exNames=[];
  document.querySelectorAll('.extra:checked').forEach(c=>{ extras+=+c.value; exNames.push(c.dataset.name); });
  $('bExtras').value=exNames.join(', ');
  const sub=room+extras;
  const vat=sub*0.15, svc=sub*0.10;
  const disc=(sub+vat+svc)*((+$('bDisc').value||0)/100);
  const total=Math.max(0,sub+vat+svc-disc);
  $('pNights').textContent=nights; $('pRoom').textContent=fmt(room); $('pExtras').textContent=fmt(extras);
  $('pVat').textContent=fmt(vat); $('pSvc').textContent=fmt(svc);
  $('pDiscV').textContent='-'+fmt(disc); $('pTotal').textContent=fmt(total);
  $('bTotal').value=total.toFixed(2);
}

function editBook(id){
  const b=bookings.find(x=>x.id==id); if(!b) return;
  $('bId').value=b.id; $('bGuest').value=b.guest; $('bPhone').value=b.phone; $('bEmail').value=b.email||'';
  $('bNid').value=b.nid||''; $('bNat').value=b.nationality||'';
  $('bRoom').value=b.room_no; setRoom(); $('bGuests').value=b.guests;
  $('bCheckIn').value=b.check_in; $('bCheckOut').value=b.check_out;
  $('bDisc').value=b.discount; calcPrice();
  $('submitBtnText').textContent='Update Booking'; window.scrollTo({top:0,behavior:'smooth'});
}
async function delBook(id){
  if(!confirm('Delete this booking?')) return;
  const r=await api('bookings.php',{action:'delete',id});
  if(r.ok){ bookings=bookings.filter(x=>x.id!=id); render(); toast('🗑 Booking deleted',true);} else toast(r.error,true);
}

$('bookForm').addEventListener('submit', async e=>{
  e.preventDefault(); calcPrice();
  const data=Object.fromEntries(new FormData(e.target));
  const r=await api('bookings.php',data);
  if(!r.ok){ toast(r.error||'Failed',true); return; }
  if(data.id){ const i=bookings.findIndex(x=>x.id==data.id); bookings[i]={...bookings[i],...data,id:+data.id}; toast('Booking updated'); }
  else { bookings.unshift({...data,id:r.id}); toast('Booking created'); }
  e.target.reset(); $('bId').value=''; $('submitBtnText').textContent='Create Booking'; render();
});

new Chart(document.getElementById('bookingChart'),{
  type:'bar',
  data:{labels:<?= json_encode($monthLabels) ?>, datasets:[{label:'Bookings', data:<?= json_encode(array_values($months)) ?>, backgroundColor:'#3b82f6', borderRadius:6}]},
  options:{maintainAspectRatio:false,plugins:{legend:{display:false}}}
});
new Chart(document.getElementById('sourceChart'),{
  type:'pie',
  data:{ labels:<?= json_encode(array_column($srcAgg,'source')) ?>,
    datasets:[{ data:<?= json_encode(array_map('intval',array_column($srcAgg,'c'))) ?>,
      backgroundColor:['#22c55e','#3b82f6','#f59e0b','#a855f7','#ef4444','#06b6d4','#ec4899','#8b5cf6'] }]
  },
  options:{maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
});

render();
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
