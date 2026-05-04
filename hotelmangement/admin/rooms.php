<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Rooms - Hotel Admin Pro</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Inter,Segoe UI,sans-serif;}
body{background:#f6f8fb;color:#111;}

/* SIDEBAR */
.sidebar{position:fixed;left:0;top:0;width:250px;height:100vh;background:#fff;border-right:1px solid #eee;padding:20px;}
.sidebar h2{margin-bottom:25px;font-size:18px;}
.sidebar a{display:flex;gap:10px;padding:10px;border-radius:10px;text-decoration:none;color:#555;margin-bottom:5px;transition:0.2s;}
.sidebar a:hover{background:#eef6ff;color:#2563eb;transform:translateX(5px);}
.sidebar a.active{background:#2563eb;color:#fff;}

/* MAIN */
.main{margin-left:250px;padding:25px;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.search{width:320px;padding:10px;border-radius:10px;border:1px solid #ddd;background:#fff;}

/* KPI */
.kpi{display:grid;grid-template-columns:repeat(4,1fr);gap:15px;}
.card{background:#fff;padding:18px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);transition:0.3s;display:flex;justify-content:space-between;align-items:center;}
.card:hover{transform:translateY(-5px);}
.card small{color:#888;font-size:13px;}
.card h3{font-size:22px;margin-top:4px;}
.card .icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;}
.icon.blue{background:#3b82f6;}
.icon.green{background:#22c55e;}
.icon.yellow{background:#eab308;}
.icon.red{background:#ef4444;}
.icon.purple{background:#8b5cf6;}

/* BOX */
.box{background:#fff;padding:18px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);margin-top:20px;}
.box h3{margin-bottom:15px;font-size:16px;}

/* GRID FOR FORM */
.grid-form{display:grid;grid-template-columns:1fr 2fr;gap:15px;margin-top:20px;}

/* FORM */
.form-group{margin-bottom:12px;}
.form-group label{display:block;font-size:13px;margin-bottom:5px;color:#444;font-weight:500;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;font-size:14px;background:#f9fafb;transition:0.2s;}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:#2563eb;background:#fff;}

.btn{padding:10px 18px;border:none;border-radius:8px;cursor:pointer;font-size:14px;transition:0.2s;display:inline-flex;align-items:center;gap:6px;}
.btn-primary{background:#2563eb;color:#fff;width:100%;justify-content:center;}
.btn-primary:hover{background:#1d4ed8;}
.btn-success{background:#22c55e;color:#fff;}
.btn-success:hover{background:#16a34a;}
.btn-outline{background:#fff;border:1px solid #ddd;color:#555;}
.btn-outline:hover{background:#f3f4f6;}
.btn-sm{padding:6px 10px;font-size:12px;}
.btn-edit{background:#fef9c3;color:#854d0e;}
.btn-edit:hover{background:#fde68a;}
.btn-delete{background:#fee2e2;color:#991b1b;}
.btn-delete:hover{background:#fecaca;}
.btn-view{background:#dbeafe;color:#1e40af;}
.btn-view:hover{background:#bfdbfe;}

/* TOOLBAR */
.toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;gap:10px;flex-wrap:wrap;}
.toolbar .filters{display:flex;gap:10px;flex:1;flex-wrap:wrap;}
.toolbar input,.toolbar select{padding:8px 12px;border:1px solid #ddd;border-radius:8px;font-size:13px;background:#fff;}
.toolbar input{flex:1;max-width:280px;}
.actions{display:flex;gap:6px;}
.view-toggle button{padding:8px 12px;border:1px solid #ddd;background:#fff;cursor:pointer;}
.view-toggle button.active{background:#2563eb;color:#fff;border-color:#2563eb;}
.view-toggle button:first-child{border-radius:8px 0 0 8px;}
.view-toggle button:last-child{border-radius:0 8px 8px 0;}

/* TABLE */
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{text-align:left;padding:12px 10px;border-bottom:1px solid #eee;font-size:14px;}
th{background:#f8fafc;font-weight:600;color:#374151;}
tr:hover td{background:#f9fafb;}

.badge{padding:4px 10px;border-radius:6px;font-size:12px;font-weight:500;}
.b-green{background:#dcfce7;color:#166534;}
.b-yellow{background:#fef9c3;color:#854d0e;}
.b-red{background:#fee2e2;color:#991b1b;}
.b-blue{background:#dbeafe;color:#1e40af;}
.b-purple{background:#f3e8ff;color:#6b21a8;}
.b-gray{background:#f3f4f6;color:#374151;}

/* GRID VIEW (Room cards) */
.rooms-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:15px;margin-top:10px;}
.room-card{background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,0.05);transition:0.3s;border:1px solid #eee;}
.room-card:hover{transform:translateY(-5px);box-shadow:0 10px 24px rgba(0,0,0,0.08);}
.room-img{height:140px;background:linear-gradient(135deg,#3b82f6,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:36px;position:relative;}
.room-img .price{position:absolute;bottom:8px;right:10px;background:rgba(0,0,0,0.55);padding:4px 10px;border-radius:8px;font-size:13px;font-weight:600;}
.room-img .stat{position:absolute;top:8px;left:10px;}
.room-body{padding:14px;}
.room-body h4{font-size:16px;margin-bottom:4px;}
.room-body p{font-size:13px;color:#666;margin-bottom:10px;}
.room-meta{display:flex;justify-content:space-between;font-size:12px;color:#555;margin-bottom:10px;}
.room-actions{display:flex;gap:6px;}
.room-actions button{flex:1;}

/* MODAL */
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:100;align-items:center;justify-content:center;}
.modal.show{display:flex;}
.modal-content{background:#fff;padding:25px;border-radius:14px;width:90%;max-width:520px;max-height:90vh;overflow-y:auto;}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;padding-bottom:10px;border-bottom:1px solid #eee;}
.modal-header .close{cursor:pointer;font-size:22px;color:#888;background:none;border:none;}

/* TOAST */
.toast{position:fixed;bottom:25px;right:25px;background:#22c55e;color:#fff;padding:12px 20px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.15);display:none;z-index:200;}
.toast.show{display:block;animation:slide 0.3s ease;}
.toast.error{background:#ef4444;}
@keyframes slide{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}

@media(max-width:992px){
    .grid-form{grid-template-columns:1fr;}
    .kpi{grid-template-columns:repeat(2,1fr);}
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>🏨 LISORA GRAND</h2>
<a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
<a href="users.php"><i class="fa-solid fa-user"></i> Users</a>
<a href="rooms.php" class="active"><i class="fa-solid fa-bed"></i> Rooms</a>
<a href="bookings.php"><i class="fa-solid fa-calendar"></i> Bookings</a>
<a href="payments.php"><i class="fa-solid fa-dollar-sign"></i> Payments</a>
<a href="customers.php"><i class="fa-solid fa-users"></i> Customers</a>
<a href="reports.php"><i class="fa-solid fa-chart-line"></i> Reports</a>
<a href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a>
</div>

<!-- MAIN -->
<div class="main">

<!-- TOPBAR -->
<div class="topbar">
<h2>🛏️ Room Management</h2>
<input class="search" id="globalSearch" placeholder="Search room number, type...">
<div>👤 Admin</div>
</div>

<!-- KPI -->
<div class="kpi">
    <div class="card">
        <div><small>Total Rooms</small><h3 id="kpiTotal">0</h3></div>
        <div class="icon blue"><i class="fa-solid fa-hotel"></i></div>
    </div>
    <div class="card">
        <div><small>Available</small><h3 id="kpiAvail">0</h3></div>
        <div class="icon green"><i class="fa-solid fa-door-open"></i></div>
    </div>
    <div class="card">
        <div><small>Occupied</small><h3 id="kpiOcc">0</h3></div>
        <div class="icon yellow"><i class="fa-solid fa-bed"></i></div>
    </div>
    <div class="card">
        <div><small>Maintenance</small><h3 id="kpiMaint">0</h3></div>
        <div class="icon red"><i class="fa-solid fa-screwdriver-wrench"></i></div>
    </div>
</div>

<!-- ADD ROOM + LIST -->
<div class="grid-form">

<!-- ADD ROOM FORM -->
<div class="box">
    <h3>➕ Add New Room</h3>
    <form id="roomForm">
        <input type="hidden" id="roomId">
        <div class="form-group">
            <label>Room Number *</label>
            <input id="roomNo" placeholder="e.g. 101" required>
        </div>
        <div class="form-group">
            <label>Room Type *</label>
            <select id="roomType" required>
                <option>Single</option>
                <option>Double</option>
                <option>Deluxe</option>
                <option>Suite</option>
                <option>Family</option>
                <option>Presidential</option>
            </select>
        </div>
        <div class="form-group">
            <label>Floor</label>
            <input type="number" id="roomFloor" placeholder="e.g. 2" min="0">
        </div>
        <div class="form-group">
            <label>Capacity (Persons)</label>
            <input type="number" id="roomCap" placeholder="e.g. 2" min="1" value="2">
        </div>
        <div class="form-group">
            <label>Price / Night (৳) *</label>
            <input type="number" id="roomPrice" min="0" required>
        </div>
        <div class="form-group">
            <label>Bed Type</label>
            <select id="roomBed">
                <option>Single Bed</option>
                <option>Double Bed</option>
                <option>Queen</option>
                <option>King</option>
                <option>Twin Beds</option>
            </select>
        </div>
        <div class="form-group">
            <label>Amenities (comma separated)</label>
            <input id="roomAmen" placeholder="AC, WiFi, TV, Mini Bar">
        </div>
        <div class="form-group">
            <label>Status</label>
            <select id="roomStatus">
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
                <option value="cleaning">Cleaning</option>
            </select>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea id="roomDesc" rows="2" placeholder="Short description..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> <span id="submitBtnText">Save Room</span></button>
    </form>
</div>

<!-- ROOM LIST -->
<div class="box">
    <div class="toolbar">
        <div class="filters">
            <input id="roomSearch" placeholder="Search room...">
            <select id="filterType">
                <option value="">All Types</option>
                <option>Single</option><option>Double</option><option>Deluxe</option>
                <option>Suite</option><option>Family</option><option>Presidential</option>
            </select>
            <select id="filterStatus">
                <option value="">All Status</option>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="maintenance">Maintenance</option>
                <option value="cleaning">Cleaning</option>
            </select>
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

</div>

<!-- VIEW DETAILS MODAL -->
<div class="modal" id="viewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="viewTitle">Room Details</h3>
            <button class="close" onclick="closeView()">&times;</button>
        </div>
        <div id="viewBody"></div>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
/* ============== DEMO DATA ============== */
let rooms = [
    {id:1,no:'101',type:'Single',floor:1,cap:1,price:2500,bed:'Single Bed',amenities:'AC, WiFi, TV',status:'available',desc:'Cozy single room with city view'},
    {id:2,no:'102',type:'Double',floor:1,cap:2,price:4500,bed:'Double Bed',amenities:'AC, WiFi, TV, Mini Bar',status:'occupied',desc:'Spacious double room'},
    {id:3,no:'201',type:'Deluxe',floor:2,cap:2,price:6500,bed:'Queen',amenities:'AC, WiFi, TV, Mini Bar, Balcony',status:'available',desc:'Deluxe room with balcony'},
    {id:4,no:'202',type:'Deluxe',floor:2,cap:3,price:7000,bed:'King',amenities:'AC, WiFi, TV, Mini Bar, Bathtub',status:'maintenance',desc:'Under repair - AC fix'},
    {id:5,no:'301',type:'Suite',floor:3,cap:4,price:12000,bed:'King',amenities:'AC, WiFi, TV, Living Room, Kitchen',status:'occupied',desc:'Premium suite with living area'},
    {id:6,no:'302',type:'Suite',floor:3,cap:4,price:12500,bed:'King',amenities:'AC, WiFi, TV, Jacuzzi, Balcony',status:'available',desc:'Suite with jacuzzi'},
    {id:7,no:'401',type:'Family',floor:4,cap:5,price:9500,bed:'Twin Beds',amenities:'AC, WiFi, TV, 2 Bathrooms',status:'cleaning',desc:'Family room - 2 bedrooms'},
    {id:8,no:'501',type:'Presidential',floor:5,cap:6,price:25000,bed:'King',amenities:'AC, WiFi, TV, Pool, Butler, Bar',status:'available',desc:'Top-tier presidential suite'},
];

let editId = null;
let view = 'grid';

const $ = id => document.getElementById(id);
const fmt = n => '৳' + Number(n).toLocaleString('en-IN');

function toast(msg, err){
    const t=$('toast');
    t.textContent=msg;
    t.className='toast show'+(err?' error':'');
    setTimeout(()=>t.classList.remove('show'),2200);
}

function statusBadge(s){
    const m={available:'b-green',occupied:'b-yellow',maintenance:'b-red',cleaning:'b-blue'};
    return m[s]||'b-gray';
}
function statusIcon(s){
    const m={available:'fa-door-open',occupied:'fa-bed',maintenance:'fa-screwdriver-wrench',cleaning:'fa-broom'};
    return m[s]||'fa-circle';
}

/* ============== KPI ============== */
function calcKPI(){
    $('kpiTotal').textContent = rooms.length;
    $('kpiAvail').textContent = rooms.filter(r=>r.status==='available').length;
    $('kpiOcc').textContent = rooms.filter(r=>r.status==='occupied').length;
    $('kpiMaint').textContent = rooms.filter(r=>r.status==='maintenance').length;
}

/* ============== RENDER ============== */
function getFiltered(){
    const s = $('roomSearch').value.toLowerCase();
    const t = $('filterType').value;
    const st = $('filterStatus').value;
    return rooms.filter(r=>{
        if(s && !(r.no+r.type+r.amenities+r.desc).toLowerCase().includes(s)) return false;
        if(t && r.type!==t) return false;
        if(st && r.status!==st) return false;
        return true;
    });
}

function renderGrid(){
    const data = getFiltered();
    if(!data.length){ $('gridView').innerHTML='<p style="color:#888;padding:30px;text-align:center;grid-column:1/-1">No rooms found</p>'; return; }
    $('gridView').innerHTML = data.map(r=>`
        <div class="room-card">
            <div class="room-img">
                <i class="fa-solid fa-bed"></i>
                <span class="badge ${statusBadge(r.status)} stat"><i class="fa-solid ${statusIcon(r.status)}"></i> ${r.status}</span>
                <span class="price">${fmt(r.price)}/night</span>
            </div>
            <div class="room-body">
                <h4>Room ${r.no} <small style="color:#888;font-weight:400">- ${r.type}</small></h4>
                <p>${r.desc||'-'}</p>
                <div class="room-meta">
                    <span><i class="fa-solid fa-layer-group"></i> Floor ${r.floor||'-'}</span>
                    <span><i class="fa-solid fa-user"></i> ${r.cap} guest${r.cap>1?'s':''}</span>
                    <span><i class="fa-solid fa-bed"></i> ${r.bed}</span>
                </div>
                <div class="room-actions">
                    <button class="btn btn-sm btn-view" onclick="viewRoom(${r.id})"><i class="fa-solid fa-eye"></i></button>
                    <button class="btn btn-sm btn-edit" onclick="editRoom(${r.id})"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-sm btn-delete" onclick="delRoom(${r.id})"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>`).join('');
}

function renderTable(){
    const data = getFiltered();
    $('roomTable').innerHTML = `
        <thead><tr>
            <th>Room #</th><th>Type</th><th>Floor</th><th>Capacity</th>
            <th>Bed</th><th>Price/Night</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody>
        ${data.length ? data.map(r=>`
            <tr>
                <td><strong>${r.no}</strong></td>
                <td><span class="badge b-blue">${r.type}</span></td>
                <td>${r.floor||'-'}</td>
                <td>${r.cap}</td>
                <td>${r.bed}</td>
                <td><strong>${fmt(r.price)}</strong></td>
                <td><span class="badge ${statusBadge(r.status)}">${r.status}</span></td>
                <td>
                    <button class="btn btn-sm btn-view" onclick="viewRoom(${r.id})"><i class="fa-solid fa-eye"></i></button>
                    <button class="btn btn-sm btn-edit" onclick="editRoom(${r.id})"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-sm btn-delete" onclick="delRoom(${r.id})"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>`).join('') : '<tr><td colspan="8" style="text-align:center;color:#888;padding:30px">No rooms found</td></tr>'}
        </tbody>`;
}

function renderAll(){
    calcKPI();
    if(view==='grid') renderGrid();
    else renderTable();
}

/* ============== VIEW SWITCH ============== */
function setView(v){
    view=v;
    $('viewGrid').classList.toggle('active',v==='grid');
    $('viewTable').classList.toggle('active',v==='table');
    $('gridView').style.display = v==='grid'?'grid':'none';
    $('tableView').style.display = v==='table'?'block':'none';
    renderAll();
}

/* ============== CRUD ============== */
$('roomForm').addEventListener('submit', e=>{
    e.preventDefault();
    const data = {
        no:$('roomNo').value.trim(),
        type:$('roomType').value,
        floor:+$('roomFloor').value||0,
        cap:+$('roomCap').value||1,
        price:+$('roomPrice').value,
        bed:$('roomBed').value,
        amenities:$('roomAmen').value.trim(),
        status:$('roomStatus').value,
        desc:$('roomDesc').value.trim()
    };
    if(!data.no || !data.price){ toast('Please fill required fields',true); return; }

    // check duplicate room number
    const dup = rooms.find(r=>r.no===data.no && r.id!==editId);
    if(dup){ toast('Room number already exists!',true); return; }

    if(editId){
        const i = rooms.findIndex(r=>r.id===editId);
        rooms[i] = {id:editId, ...data};
        toast('Room updated successfully');
        editId = null;
        $('submitBtnText').textContent = 'Save Room';
    } else {
        const id = Math.max(0,...rooms.map(r=>r.id))+1;
        rooms.unshift({id, ...data});
        toast('Room added successfully');
    }
    $('roomForm').reset();
    renderAll();
});

function editRoom(id){
    const r = rooms.find(x=>x.id===id);
    if(!r) return;
    editId = id;
    $('roomNo').value=r.no; $('roomType').value=r.type; $('roomFloor').value=r.floor;
    $('roomCap').value=r.cap; $('roomPrice').value=r.price; $('roomBed').value=r.bed;
    $('roomAmen').value=r.amenities; $('roomStatus').value=r.status; $('roomDesc').value=r.desc;
    $('submitBtnText').textContent = 'Update Room';
    window.scrollTo({top:0,behavior:'smooth'});
}

function delRoom(id){
    if(!confirm('Delete this room?')) return;
    rooms = rooms.filter(r=>r.id!==id);
    toast('Room deleted');
    renderAll();
}

function viewRoom(id){
    const r = rooms.find(x=>x.id===id);
    if(!r) return;
    $('viewTitle').textContent = `Room ${r.no} - ${r.type}`;
    $('viewBody').innerHTML = `
        <div style="background:linear-gradient(135deg,#3b82f6,#8b5cf6);height:120px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:48px;margin-bottom:15px"><i class="fa-solid fa-bed"></i></div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:14px">
            <div><strong>Status:</strong> <span class="badge ${statusBadge(r.status)}">${r.status}</span></div>
            <div><strong>Floor:</strong> ${r.floor||'-'}</div>
            <div><strong>Capacity:</strong> ${r.cap} persons</div>
            <div><strong>Bed:</strong> ${r.bed}</div>
            <div><strong>Price:</strong> ${fmt(r.price)}/night</div>
            <div><strong>Type:</strong> ${r.type}</div>
        </div>
        <div style="margin-top:15px"><strong>Amenities:</strong><br>
            ${(r.amenities||'').split(',').map(a=>`<span class="badge b-blue" style="margin:3px 3px 0 0;display:inline-block">${a.trim()}</span>`).join('')}
        </div>
        <div style="margin-top:15px"><strong>Description:</strong><br><p style="color:#666;margin-top:5px">${r.desc||'-'}</p></div>
    `;
    $('viewModal').classList.add('show');
}
function closeView(){ $('viewModal').classList.remove('show'); }

/* ============== FILTERS ============== */
['roomSearch','filterType','filterStatus'].forEach(id=>{
    $(id).addEventListener('input', renderAll);
});
$('globalSearch').addEventListener('input', e=>{
    $('roomSearch').value = e.target.value;
    renderAll();
});

renderAll();
</script>

</body>
</html>
