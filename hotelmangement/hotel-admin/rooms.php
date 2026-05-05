<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Rooms'; $ACTIVE='rooms';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $a = $_POST['action'] ?? '';
    try {
        if ($a==='save') {
            $id=(int)($_POST['id']??0);
            $params=[$_POST['no'],$_POST['type'],(int)$_POST['floor'],(int)$_POST['cap'],
                     (float)$_POST['price'],$_POST['bed'],$_POST['amenities']??'',
                     $_POST['status'],$_POST['description']??''];
            if ($id) {
                $params[]=$id;
                q($conn,"UPDATE rooms SET no=?,type=?,floor=?,cap=?,price=?,bed=?,amenities=?,status=?,description=? WHERE id=?",
                  $params,'ssiidssssi');
            } else {
                q($conn,"INSERT INTO rooms (no,type,floor,cap,price,bed,amenities,status,description) VALUES (?,?,?,?,?,?,?,?,?)",
                  $params,'ssiidssss');
                $id=$conn->insert_id;
            }
            jsonOut(['ok'=>true,'id'=>$id]);
        }
        if ($a==='delete') {
            q($conn,"DELETE FROM rooms WHERE id=?", [(int)$_POST['id']],'i');
            jsonOut(['ok'=>true]);
        }
        jsonOut(['ok'=>false],400);
    } catch (Throwable $e) { jsonOut(['ok'=>false,'error'=>$e->getMessage()],500); }
}

$rooms = fetchAll($conn,"SELECT * FROM rooms ORDER BY no");
$kpiTotal=count($rooms);
$kpiAvail=count(array_filter($rooms,fn($r)=>$r['status']==='available'));
$kpiOcc  =count(array_filter($rooms,fn($r)=>$r['status']==='occupied'));
$kpiMaint=count(array_filter($rooms,fn($r)=>$r['status']==='maintenance'));

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>🛏️ Room Management</h2>
  <input class="search" id="globalSearch" placeholder="Search room number, type...">
  <div>👤 Admin</div>
</div>

<div class="kpi">
  <div class="card"><div><small>Total Rooms</small><h3><?= $kpiTotal ?></h3></div><div class="icon blue"><i class="fa-solid fa-hotel"></i></div></div>
  <div class="card"><div><small>Available</small><h3><?= $kpiAvail ?></h3></div><div class="icon green"><i class="fa-solid fa-door-open"></i></div></div>
  <div class="card"><div><small>Occupied</small><h3><?= $kpiOcc ?></h3></div><div class="icon yellow"><i class="fa-solid fa-bed"></i></div></div>
  <div class="card"><div><small>Maintenance</small><h3><?= $kpiMaint ?></h3></div><div class="icon red"><i class="fa-solid fa-screwdriver-wrench"></i></div></div>
</div>

<div class="grid-form">
  <div class="box">
    <h3>➕ Add / Edit Room</h3>
    <form id="roomForm">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="id" id="roomId">
      <div class="form-group"><label>Room Number *</label><input id="roomNo" name="no" required></div>
      <div class="form-group"><label>Room Type *</label>
        <select id="roomType" name="type" required><option>Single</option><option>Double</option><option>Deluxe</option><option>Suite</option><option>Family</option><option>Presidential</option></select></div>
      <div class="form-row">
        <div class="form-group"><label>Floor</label><input type="number" id="roomFloor" name="floor" min="0"></div>
        <div class="form-group"><label>Capacity</label><input type="number" id="roomCap" name="cap" min="1" value="2"></div>
      </div>
      <div class="form-group"><label>Price / Night (৳) *</label><input type="number" id="roomPrice" name="price" min="0" required></div>
      <div class="form-group"><label>Bed Type</label>
        <select id="roomBed" name="bed"><option>Single Bed</option><option>Double Bed</option><option>Queen</option><option>King</option><option>Twin Beds</option></select></div>
      <div class="form-group"><label>Amenities</label><input id="roomAmen" name="amenities" placeholder="AC, WiFi, TV"></div>
      <div class="form-group"><label>Status</label>
        <select id="roomStatus" name="status">
          <option value="available">Available</option>
          <option value="occupied">Occupied</option>
          <option value="maintenance">Maintenance</option>
          <option value="cleaning">Cleaning</option>
        </select></div>
      <div class="form-group"><label>Description</label><textarea id="roomDesc" name="description" rows="2"></textarea></div>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> <span id="submitBtnText">Save Room</span></button>
    </form>
  </div>

  <div class="box">
    <div class="toolbar">
      <div class="filters">
        <input id="roomSearch" placeholder="Search room...">
        <select id="filterType"><option value="">All Types</option><option>Single</option><option>Double</option><option>Deluxe</option><option>Suite</option><option>Family</option><option>Presidential</option></select>
        <select id="filterStatus"><option value="">All Status</option><option value="available">Available</option><option value="occupied">Occupied</option><option value="maintenance">Maintenance</option><option value="cleaning">Cleaning</option></select>
      </div>
      <div class="actions view-toggle">
        <button id="viewGrid" class="active" onclick="setView('grid')"><i class="fa-solid fa-grip"></i></button>
        <button id="viewTable" onclick="setView('table')"><i class="fa-solid fa-list"></i></button>
      </div>
    </div>
    <div id="gridView" class="rooms-grid"></div>
    <div id="tableView" style="display:none"><table id="roomTable"></table></div>
  </div>
</div>

<script>
let rooms = <?= json_encode($rooms) ?>;
let editId=null, view='grid';
const fmt=n=>'৳'+Number(n).toLocaleString('en-IN');
const sBadge=s=>({available:'b-green',occupied:'b-yellow',maintenance:'b-red',cleaning:'b-blue'}[s]||'b-gray');
const sIcon =s=>({available:'fa-door-open',occupied:'fa-bed',maintenance:'fa-screwdriver-wrench',cleaning:'fa-broom'}[s]||'fa-circle');

function getFiltered(){
  const s=$('roomSearch').value.toLowerCase(), t=$('filterType').value, st=$('filterStatus').value;
  return rooms.filter(r=>{
    if(s && !((r.no+r.type+(r.amenities||'')+(r.description||'')).toLowerCase().includes(s))) return false;
    if(t && r.type!==t) return false;
    if(st && r.status!==st) return false;
    return true;
  });
}
function renderGrid(){
  const data=getFiltered();
  $('gridView').innerHTML = data.length ? data.map(r=>`
    <div class="room-card">
      <div class="room-img"><i class="fa-solid fa-bed"></i>
        <span class="badge ${sBadge(r.status)} stat"><i class="fa-solid ${sIcon(r.status)}"></i> ${r.status}</span>
        <span class="price">${fmt(r.price)}/night</span></div>
      <div class="room-body">
        <h4>Room ${r.no} <small style="color:#888;font-weight:400">- ${r.type}</small></h4>
        <p>${r.description||'-'}</p>
        <div class="room-meta">
          <span><i class="fa-solid fa-layer-group"></i> Floor ${r.floor||'-'}</span>
          <span><i class="fa-solid fa-user"></i> ${r.cap}</span>
          <span><i class="fa-solid fa-bed"></i> ${r.bed}</span>
        </div>
        <div class="room-actions">
          <button class="btn btn-sm btn-edit" onclick="editRoom(${r.id})"><i class="fa-solid fa-pen"></i></button>
          <button class="btn btn-sm btn-delete" onclick="delRoom(${r.id})"><i class="fa-solid fa-trash"></i></button>
        </div>
      </div>
    </div>`).join('') : '<p style="grid-column:1/-1;text-align:center;color:#888;padding:30px">No rooms found</p>';
}
function renderTable(){
  const data=getFiltered();
  $('roomTable').innerHTML = `
    <thead><tr><th>Room #</th><th>Type</th><th>Floor</th><th>Cap</th><th>Bed</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>${data.length?data.map(r=>`
      <tr><td><b>${r.no}</b></td><td><span class="badge b-blue">${r.type}</span></td>
        <td>${r.floor||'-'}</td><td>${r.cap}</td><td>${r.bed||'-'}</td><td><b>${fmt(r.price)}</b></td>
        <td><span class="badge ${sBadge(r.status)}">${r.status}</span></td>
        <td><button class="btn btn-sm btn-edit" onclick="editRoom(${r.id})"><i class="fa-solid fa-pen"></i></button>
            <button class="btn btn-sm btn-delete" onclick="delRoom(${r.id})"><i class="fa-solid fa-trash"></i></button></td></tr>
    `).join(''):'<tr><td colspan="8" style="text-align:center;color:#888;padding:30px">No rooms found</td></tr>'}</tbody>`;
}
function renderAll(){ view==='grid'?renderGrid():renderTable(); }
function setView(v){ view=v; $('viewGrid').classList.toggle('active',v==='grid'); $('viewTable').classList.toggle('active',v==='table');
  $('gridView').style.display=v==='grid'?'grid':'none'; $('tableView').style.display=v==='table'?'block':'none'; renderAll(); }

function editRoom(id){
  const r=rooms.find(x=>x.id==id); if(!r) return;
  $('roomId').value=r.id; $('roomNo').value=r.no; $('roomType').value=r.type;
  $('roomFloor').value=r.floor; $('roomCap').value=r.cap; $('roomPrice').value=r.price;
  $('roomBed').value=r.bed||'Single Bed'; $('roomAmen').value=r.amenities||'';
  $('roomStatus').value=r.status; $('roomDesc').value=r.description||'';
  $('submitBtnText').textContent='Update Room'; window.scrollTo({top:0,behavior:'smooth'});
}
async function delRoom(id){
  if(!confirm('Delete this room?')) return;
  const r=await api('rooms.php',{action:'delete',id});
  if(r.ok){ rooms=rooms.filter(x=>x.id!=id); renderAll(); toast('🗑 Room deleted',true);} else toast(r.error||'Failed',true);
}
$('roomForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const data=Object.fromEntries(new FormData(e.target));
  const r=await api('rooms.php',data);
  if(!r.ok){ toast(r.error||'Failed',true); return; }
  if(data.id){
    const i=rooms.findIndex(x=>x.id==data.id); rooms[i]={...rooms[i],...data,id:+data.id};
    toast('Room updated');
  } else { rooms.unshift({...data,id:r.id}); toast('Room added'); }
  e.target.reset(); $('roomId').value=''; $('submitBtnText').textContent='Save Room';
  renderAll();
});
['roomSearch','filterType','filterStatus'].forEach(id=>$(id).addEventListener('input',renderAll));
renderAll();
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
