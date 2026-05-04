<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Bookings - Hotel Admin Pro</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Inter,Segoe UI,sans-serif;}
body{background:#f6f8fb;color:#111;}

/* SIDEBAR */
.sidebar{position:fixed;left:0;top:0;width:250px;height:100vh;background:#fff;border-right:1px solid #eee;padding:20px;}
.sidebar h2{margin-bottom:25px;font-size:18px;}
.sidebar a{display:flex;gap:10px;padding:10px;border-radius:10px;text-decoration:none;color:#555;margin-bottom:5px;transition:0.2s;}
.sidebar a:hover{background:#eef6ff;color:#2563eb;transform:translateX(5px);}
.sidebar a.active{background:#2563eb;color:#fff;}

.main{margin-left:250px;padding:25px;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.search{width:320px;padding:10px;border-radius:10px;border:1px solid #ddd;background:#fff;}

/* KPI */
.kpi{display:grid;grid-template-columns:repeat(5,1fr);gap:15px;}
.card{background:#fff;padding:18px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);transition:0.3s;display:flex;justify-content:space-between;align-items:center;}
.card:hover{transform:translateY(-5px);}
.card small{color:#888;font-size:12px;}
.card h3{font-size:20px;margin-top:4px;}
.card .icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;}
.icon.blue{background:#3b82f6;} .icon.green{background:#22c55e;} .icon.yellow{background:#eab308;}
.icon.red{background:#ef4444;} .icon.purple{background:#8b5cf6;} .icon.cyan{background:#06b6d4;}

/* GRID */
.grid-2{display:grid;grid-template-columns:2fr 1fr;gap:15px;margin-top:20px;}
.grid-form{display:grid;grid-template-columns:1fr 2fr;gap:15px;margin-top:20px;}

/* BOX */
.box{background:#fff;padding:18px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);}
.box h3{margin-bottom:15px;font-size:16px;display:flex;justify-content:space-between;align-items:center;}

/* FORM */
.form-group{margin-bottom:12px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.form-group label{display:block;font-size:13px;margin-bottom:5px;color:#444;font-weight:500;}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;font-size:14px;background:#f9fafb;transition:0.2s;}
.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:#2563eb;background:#fff;}
.form-group .check-row{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px;}
.form-group .check-row label{display:flex;align-items:center;gap:5px;font-size:12px;background:#f3f4f6;padding:6px 10px;border-radius:20px;cursor:pointer;font-weight:400;margin:0;}
.form-group .check-row input{width:auto;}

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
.btn-checkin{background:#dcfce7;color:#166534;}
.btn-checkout{background:#fed7aa;color:#9a3412;}

/* TOOLBAR */
.toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;gap:10px;flex-wrap:wrap;}
.toolbar .filters{display:flex;gap:10px;flex:1;flex-wrap:wrap;}
.toolbar input,.toolbar select{padding:8px 12px;border:1px solid #ddd;border-radius:8px;font-size:13px;background:#fff;}
.toolbar input{flex:1;max-width:280px;}
.actions{display:flex;gap:6px;}

/* TABS */
.tabs{display:flex;gap:6px;border-bottom:2px solid #eee;margin-bottom:15px;flex-wrap:wrap;}
.tab{padding:10px 16px;cursor:pointer;border:none;background:none;font-size:14px;font-weight:500;color:#666;border-bottom:2px solid transparent;margin-bottom:-2px;transition:0.2s;}
.tab:hover{color:#2563eb;}
.tab.active{color:#2563eb;border-bottom-color:#2563eb;}

/* TABLE */
table{width:100%;border-collapse:collapse;margin-top:10px;}
th,td{text-align:left;padding:12px 10px;border-bottom:1px solid #eee;font-size:14px;vertical-align:middle;}
th{background:#f8fafc;font-weight:600;color:#374151;}
tr:hover td{background:#f9fafb;}

.badge{padding:4px 10px;border-radius:6px;font-size:12px;font-weight:500;}
.b-green{background:#dcfce7;color:#166534;}
.b-yellow{background:#fef9c3;color:#854d0e;}
.b-red{background:#fee2e2;color:#991b1b;}
.b-blue{background:#dbeafe;color:#1e40af;}
.b-purple{background:#f3e8ff;color:#6b21a8;}
.b-cyan{background:#cffafe;color:#155e75;}
.b-orange{background:#ffedd5;color:#9a3412;}
.b-gray{background:#f3f4f6;color:#374151;}

.guest-cell{display:flex;align-items:center;gap:10px;}
.avatar{width:36px;height:36px;border-radius:50%;background:#2563eb;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:13px;}

/* MODAL */
.modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:100;align-items:center;justify-content:center;}
.modal.show{display:flex;}
.modal-content{background:#fff;padding:25px;border-radius:14px;width:90%;max-width:600px;max-height:90vh;overflow-y:auto;}
.modal-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;padding-bottom:10px;border-bottom:1px solid #eee;}
.modal-header .close{cursor:pointer;font-size:22px;color:#888;background:none;border:none;}

/* TOAST */
.toast{position:fixed;bottom:25px;right:25px;background:#22c55e;color:#fff;padding:12px 20px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.15);display:none;z-index:200;}
.toast.show{display:block;animation:slide 0.3s ease;}
.toast.error{background:#ef4444;}
@keyframes slide{from{transform:translateX(100%);opacity:0;}to{transform:translateX(0);opacity:1;}}

/* PRICE BOX */
.price-summary{background:#f0f9ff;border:1px dashed #2563eb;border-radius:10px;padding:12px;margin-bottom:12px;}
.price-summary div{display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px;}
.price-summary .total{font-size:16px;font-weight:700;color:#2563eb;border-top:1px solid #c7e0ff;padding-top:6px;margin-top:6px;}

.chart-wrap{position:relative;height:260px;}

/* CALENDAR / TIMELINE */
.timeline-row{display:flex;align-items:center;gap:10px;padding:10px;border-bottom:1px solid #f3f4f6;}
.timeline-room{width:80px;font-weight:600;font-size:13px;}
.timeline-bar{flex:1;height:30px;background:#f3f4f6;border-radius:6px;position:relative;overflow:hidden;}
.bar-segment{position:absolute;height:100%;border-radius:6px;color:#fff;font-size:11px;display:flex;align-items:center;padding:0 8px;white-space:nowrap;overflow:hidden;}

@media(max-width:992px){
    .grid-2,.grid-form{grid-template-columns:1fr;}
    .kpi{grid-template-columns:repeat(2,1fr);}
    .form-row{grid-template-columns:1fr;}
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>🏨 LISORA GRAND</h2>
<a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a>
<a href="users.php"><i class="fa-solid fa-user"></i> Users</a>
<a href="rooms.php"><i class="fa-solid fa-bed"></i> Rooms</a>
<a href="bookings.php" class="active"><i class="fa-solid fa-calendar"></i> Bookings</a>
<a href="payments.php"><i class="fa-solid fa-dollar-sign"></i> Payments</a>
<a href="customers.php"><i class="fa-solid fa-users"></i> Customers</a>
<a href="reports.php"><i class="fa-solid fa-chart-line"></i> Reports</a>
<a href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a>
</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">
<h2>📅 Booking Management</h2>
<input class="search" id="globalSearch" placeholder="Search guest, booking ID, room...">
<div>👤 Admin</div>
</div>

<!-- KPI -->
<div class="kpi">
    <div class="card"><div><small>Total Bookings</small><h3 id="kpiTotal">0</h3></div><div class="icon blue"><i class="fa-solid fa-calendar-check"></i></div></div>
    <div class="card"><div><small>Confirmed</small><h3 id="kpiConfirmed">0</h3></div><div class="icon green"><i class="fa-solid fa-check"></i></div></div>
    <div class="card"><div><small>Checked-In</small><h3 id="kpiCheckedIn">0</h3></div><div class="icon yellow"><i class="fa-solid fa-door-open"></i></div></div>
    <div class="card"><div><small>Pending</small><h3 id="kpiPending">0</h3></div><div class="icon orange" style="background:#f97316"><i class="fa-solid fa-hourglass-half"></i></div></div>
    <div class="card"><div><small>Revenue</small><h3 id="kpiRevenue">৳0</h3></div><div class="icon purple"><i class="fa-solid fa-sack-dollar"></i></div></div>
</div>

<!-- CHARTS -->
<div class="grid-2">
    <div class="box">
        <h3>📊 Bookings This Year</h3>
        <div class="chart-wrap"><canvas id="bookingChart"></canvas></div>
    </div>
    <div class="box">
        <h3>🥧 Booking Sources</h3>
        <div class="chart-wrap"><canvas id="sourceChart"></canvas></div>
    </div>
</div>

<!-- ADD BOOKING + LIST -->
<div class="grid-form">

<!-- ADD BOOKING -->
<div class="box">
    <h3>➕ New Reservation</h3>
    <form id="bookForm">
        <input type="hidden" id="bookId">
        <div class="form-group">
            <label>Guest Name *</label>
            <input id="gName" placeholder="Mr/Mrs Full Name" required>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Phone *</label><input id="gPhone" placeholder="+880..." required></div>
            <div class="form-group"><label>Email</label><input type="email" id="gEmail" placeholder="email@..."></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>NID / Passport *</label><input id="gNid" placeholder="ID number" required></div>
            <div class="form-group"><label>Nationality</label><input id="gNat" value="Bangladeshi"></div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Room *</label>
                <select id="bRoom" required onchange="calcPrice()">
                    <option value="">Select room</option>
                    <option value="101|Single|2500">101 - Single (৳2500)</option>
                    <option value="102|Double|4500">102 - Double (৳4500)</option>
                    <option value="201|Deluxe|6500">201 - Deluxe (৳6500)</option>
                    <option value="301|Suite|12000">301 - Suite (৳12000)</option>
                    <option value="302|Suite|12500">302 - Suite (৳12500)</option>
                    <option value="401|Family|9500">401 - Family (৳9500)</option>
                    <option value="501|Presidential|25000">501 - Presidential (৳25000)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Guests *</label>
                <select id="bGuests" required onchange="calcPrice()">
                    <option>1</option><option selected>2</option><option>3</option><option>4</option><option>5</option><option>6</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group"><label>Check-In *</label><input type="date" id="bCheckIn" required onchange="calcPrice()"></div>
            <div class="form-group"><label>Check-Out *</label><input type="date" id="bCheckOut" required onchange="calcPrice()"></div>
        </div>

        <div class="form-group">
            <label>Booking Source</label>
            <select id="bSource">
                <option>Walk-In</option>
                <option>Website</option>
                <option>Phone Call</option>
                <option>Booking.com</option>
                <option>Agoda</option>
                <option>Airbnb</option>
                <option>Travel Agent</option>
                <option>Corporate</option>
            </select>
        </div>

        <div class="form-group">
            <label>Extra Services</label>
            <div class="check-row">
                <label><input type="checkbox" class="extra" value="500" data-name="Breakfast"> 🍳 Breakfast (৳500)</label>
                <label><input type="checkbox" class="extra" value="800" data-name="Airport Pickup"> 🚖 Airport Pickup (৳800)</label>
                <label><input type="checkbox" class="extra" value="1500" data-name="Spa"> 💆 Spa (৳1500)</label>
                <label><input type="checkbox" class="extra" value="600" data-name="Laundry"> 🧺 Laundry (৳600)</label>
                <label><input type="checkbox" class="extra" value="1000" data-name="Mini Bar"> 🍷 Mini Bar (৳1000)</label>
            </div>
        </div>

        <div class="form-group">
            <label>Discount (%)</label>
            <input type="number" id="bDiscount" min="0" max="100" value="0" onchange="calcPrice()" oninput="calcPrice()">
        </div>

        <div class="price-summary" id="priceBox">
            <div><span>Room (<span id="pNights">0</span> nights)</span><span id="pRoom">৳0</span></div>
            <div><span>Extra Services</span><span id="pExtras">৳0</span></div>
            <div><span>Subtotal</span><span id="pSub">৳0</span></div>
            <div><span>VAT (15%)</span><span id="pVat">৳0</span></div>
            <div><span>Service Charge (10%)</span><span id="pSvc">৳0</span></div>
            <div><span>Discount</span><span id="pDisc">-৳0</span></div>
            <div class="total"><span>TOTAL</span><span id="pTotal">৳0</span></div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Payment Method</label>
                <select id="bMethod">
                    <option>Cash</option><option>bKash</option><option>Nagad</option><option>Card</option><option>Bank Transfer</option>
                </select>
            </div>
            <div class="form-group">
                <label>Payment Status</label>
                <select id="bPayStatus">
                    <option value="paid">Paid</option>
                    <option value="partial">Partial</option>
                    <option value="unpaid" selected>Unpaid</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Special Requests</label>
            <textarea id="bNotes" rows="2" placeholder="Late check-in, allergies, baby cot..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> <span id="submitBtnText">Create Booking</span></button>
    </form>
</div>

<!-- BOOKING LIST -->
<div class="box">
    <div class="tabs">
        <button class="tab active" data-tab="all">All</button>
        <button class="tab" data-tab="pending">Pending</button>
        <button class="tab" data-tab="confirmed">Confirmed</button>
        <button class="tab" data-tab="checked-in">Checked-In</button>
        <button class="tab" data-tab="checked-out">Checked-Out</button>
        <button class="tab" data-tab="cancelled">Cancelled</button>
    </div>

    <div class="toolbar">
        <div class="filters">
            <input id="bSearch" placeholder="Search guest, room, ID...">
            <select id="filterSource">
                <option value="">All Sources</option>
                <option>Walk-In</option><option>Website</option><option>Phone Call</option>
                <option>Booking.com</option><option>Agoda</option><option>Airbnb</option>
                <option>Travel Agent</option><option>Corporate</option>
            </select>
            <input type="date" id="filterDate">
        </div>
        <div class="actions">
            <button class="btn btn-outline btn-sm" onclick="exportCSV()"><i class="fa-solid fa-download"></i> Export</button>
        </div>
    </div>

    <table id="bookTable"></table>
</div>

</div>

<!-- ROOM AVAILABILITY TIMELINE -->
<div class="box" style="margin-top:20px;">
    <h3>🗓️ Room Availability (Next 14 days)
        <input type="date" id="timelineStart" style="padding:6px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;">
    </h3>
    <div id="timeline"></div>
</div>

</div>

<!-- VIEW MODAL -->
<div class="modal" id="viewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="viewTitle">Booking Details</h3>
            <button class="close" onclick="closeView()">&times;</button>
        </div>
        <div id="viewBody"></div>
    </div>
</div>

<div class="toast" id="toast"></div>

<script>
/* ============== DEMO DATA ============== */
let bookings = [
    {id:1001,guest:'Rahim Ahmed',phone:'+8801711111111',email:'rahim@gmail.com',nid:'1234567890',nat:'Bangladeshi',
     room:'201',roomType:'Deluxe',rate:6500,guests:2,checkIn:'2026-05-04',checkOut:'2026-05-07',
     source:'Website',extras:[{name:'Breakfast',price:500}],discount:5,method:'Card',payStatus:'paid',
     status:'checked-in',notes:'Late check-in around 11 PM',createdAt:'2026-05-01'},
    {id:1002,guest:'Sarah Khan',phone:'+8801822222222',email:'sarah@yahoo.com',nid:'9876543210',nat:'Bangladeshi',
     room:'301',roomType:'Suite',rate:12000,guests:2,checkIn:'2026-05-05',checkOut:'2026-05-09',
     source:'Booking.com',extras:[{name:'Airport Pickup',price:800},{name:'Spa',price:1500}],discount:10,method:'bKash',payStatus:'paid',
     status:'confirmed',notes:'Honeymoon couple - decoration please',createdAt:'2026-05-02'},
    {id:1003,guest:'John Smith',phone:'+1234567890',email:'john@gmail.com',nid:'P12345678',nat:'American',
     room:'501',roomType:'Presidential',rate:25000,guests:3,checkIn:'2026-05-10',checkOut:'2026-05-15',
     source:'Travel Agent',extras:[{name:'Breakfast',price:500},{name:'Mini Bar',price:1000}],discount:0,method:'Bank Transfer',payStatus:'partial',
     status:'confirmed',notes:'VIP guest - butler service required',createdAt:'2026-05-03'},
    {id:1004,guest:'Lopa Begum',phone:'+8801933333333',email:'',nid:'5556667770',nat:'Bangladeshi',
     room:'102',roomType:'Double',rate:4500,guests:2,checkIn:'2026-05-03',checkOut:'2026-05-04',
     source:'Walk-In',extras:[],discount:0,method:'Cash',payStatus:'paid',
     status:'checked-out',notes:'',createdAt:'2026-05-03'},
    {id:1005,guest:'Imran Hossain',phone:'+8801544444444',email:'imran@hotmail.com',nid:'1112223330',nat:'Bangladeshi',
     room:'401',roomType:'Family',rate:9500,guests:5,checkIn:'2026-05-08',checkOut:'2026-05-12',
     source:'Phone Call',extras:[{name:'Breakfast',price:500}],discount:0,method:'Cash',payStatus:'unpaid',
     status:'pending',notes:'Family with 2 kids',createdAt:'2026-05-04'},
    {id:1006,guest:'XYZ Corp Event',phone:'+8801666666666',email:'event@xyz.com',nid:'CORP-001',nat:'Corporate',
     room:'301',roomType:'Suite',rate:12000,guests:4,checkIn:'2026-04-18',checkOut:'2026-04-20',
     source:'Corporate',extras:[],discount:15,method:'Bank Transfer',payStatus:'paid',
     status:'checked-out',notes:'Conference event',createdAt:'2026-04-15'},
    {id:1007,guest:'Tom Wilson',phone:'+447700900111',email:'tom@uk.com',nid:'P88991122',nat:'British',
     room:'202',roomType:'Deluxe',rate:7000,guests:2,checkIn:'2026-05-15',checkOut:'2026-05-18',
     source:'Agoda',extras:[{name:'Airport Pickup',price:800}],discount:0,method:'Card',payStatus:'unpaid',
     status:'cancelled',notes:'Cancelled by guest',createdAt:'2026-05-01'},
];

let editId = null;
let currentTab = 'all';
let bookingChart, sourceChart;

const $ = id => document.getElementById(id);
const fmt = n => '৳' + Number(n).toLocaleString('en-IN');
const initials = n => n.split(' ').slice(0,2).map(x=>x[0]||'').join('').toUpperCase();
const colors = ['#3b82f6','#22c55e','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899'];
const avColor = n => colors[n.charCodeAt(0)%colors.length];

function toast(msg, err){
    const t=$('toast'); t.textContent=msg;
    t.className='toast show'+(err?' error':'');
    setTimeout(()=>t.classList.remove('show'),2200);
}

function statusBadge(s){
    const m={pending:'b-yellow','confirmed':'b-blue','checked-in':'b-green','checked-out':'b-gray',cancelled:'b-red'};
    return m[s]||'b-gray';
}
function payBadge(s){
    const m={paid:'b-green',partial:'b-yellow',unpaid:'b-red'};
    return m[s]||'b-gray';
}

function nights(ci, co){
    if(!ci||!co) return 0;
    return Math.max(0,(new Date(co)-new Date(ci))/86400000);
}

function calcTotal(b){
    const n = nights(b.checkIn, b.checkOut);
    const room = n * b.rate;
    const extras = (b.extras||[]).reduce((s,x)=>s+(+x.price||0),0);
    const sub = room + extras;
    const vat = sub*0.15;
    const svc = sub*0.10;
    const grand = sub+vat+svc;
    const disc = grand*((b.discount||0)/100);
    return {n,room,extras,sub,vat,svc,disc,total:grand-disc};
}

/* ============== KPI ============== */
function calcKPI(){
    $('kpiTotal').textContent = bookings.length;
    $('kpiConfirmed').textContent = bookings.filter(b=>b.status==='confirmed').length;
    $('kpiCheckedIn').textContent = bookings.filter(b=>b.status==='checked-in').length;
    $('kpiPending').textContent = bookings.filter(b=>b.status==='pending').length;
    const rev = bookings.filter(b=>b.status!=='cancelled').reduce((s,b)=>s+calcTotal(b).total,0);
    $('kpiRevenue').textContent = fmt(Math.round(rev));
}

/* ============== TABLE ============== */
function getFiltered(){
    const s = $('bSearch').value.toLowerCase();
    const src = $('filterSource').value;
    const date = $('filterDate').value;
    return bookings.filter(b=>{
        if(currentTab!=='all' && b.status!==currentTab) return false;
        if(s && !((b.guest+b.phone+b.room+b.id).toLowerCase()).includes(s)) return false;
        if(src && b.source!==src) return false;
        if(date && !(b.checkIn<=date && b.checkOut>=date)) return false;
        return true;
    });
}

function renderTable(){
    const data = getFiltered();
    $('bookTable').innerHTML = `
        <thead><tr>
            <th>ID</th><th>Guest</th><th>Room</th><th>Check-In</th><th>Check-Out</th>
            <th>Nights</th><th>Total</th><th>Source</th><th>Payment</th><th>Status</th><th>Actions</th>
        </tr></thead>
        <tbody>${data.length ? data.map(b=>{
            const t = calcTotal(b);
            return `<tr>
                <td><strong>#${b.id}</strong></td>
                <td><div class="guest-cell"><div class="avatar" style="background:${avColor(b.guest)}">${initials(b.guest)}</div>
                    <div><strong>${b.guest}</strong><br><small style="color:#888">${b.phone}</small></div></div></td>
                <td><span class="badge b-blue">${b.room}</span><br><small style="color:#888">${b.roomType}</small></td>
                <td>${b.checkIn}</td>
                <td>${b.checkOut}</td>
                <td>${t.n}</td>
                <td><strong>${fmt(Math.round(t.total))}</strong></td>
                <td><span class="badge b-purple">${b.source}</span></td>
                <td><span class="badge ${payBadge(b.payStatus)}">${b.payStatus}</span></td>
                <td><span class="badge ${statusBadge(b.status)}">${b.status}</span></td>
                <td style="white-space:nowrap">
                    <button class="btn btn-sm btn-view" onclick="viewBooking(${b.id})" title="View"><i class="fa-solid fa-eye"></i></button>
                    ${b.status==='confirmed'?`<button class="btn btn-sm btn-checkin" onclick="changeStatus(${b.id},'checked-in')" title="Check-In"><i class="fa-solid fa-door-open"></i></button>`:''}
                    ${b.status==='checked-in'?`<button class="btn btn-sm btn-checkout" onclick="changeStatus(${b.id},'checked-out')" title="Check-Out"><i class="fa-solid fa-right-from-bracket"></i></button>`:''}
                    ${b.status==='pending'?`<button class="btn btn-sm btn-checkin" onclick="changeStatus(${b.id},'confirmed')" title="Confirm"><i class="fa-solid fa-check"></i></button>`:''}
                    <button class="btn btn-sm btn-edit" onclick="editBooking(${b.id})" title="Edit"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-sm btn-delete" onclick="cancelBooking(${b.id})" title="Cancel/Delete"><i class="fa-solid fa-xmark"></i></button>
                </td>
            </tr>`;
        }).join('') : '<tr><td colspan="11" style="text-align:center;color:#888;padding:30px">No bookings found</td></tr>'}
        </tbody>`;
}

/* ============== CHARTS ============== */
function renderCharts(){
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const counts = Array(12).fill(0);
    const year = String(new Date().getFullYear());
    bookings.forEach(b=>{
        const [y,m] = b.checkIn.split('-');
        if(y===year) counts[+m-1]++;
    });
    if(bookingChart) bookingChart.destroy();
    bookingChart = new Chart($('bookingChart'),{
        type:'line',
        data:{labels:months,datasets:[{label:'Bookings',data:counts,borderColor:'#2563eb',backgroundColor:'rgba(37,99,235,0.15)',fill:true,tension:0.4,borderWidth:2}]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}}}
    });

    const srcMap={};
    bookings.forEach(b=>srcMap[b.source]=(srcMap[b.source]||0)+1);
    if(sourceChart) sourceChart.destroy();
    sourceChart = new Chart($('sourceChart'),{
        type:'doughnut',
        data:{labels:Object.keys(srcMap),datasets:[{data:Object.values(srcMap),backgroundColor:['#3b82f6','#22c55e','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899','#6b7280']}]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
    });
}

/* ============== TIMELINE ============== */
function renderTimeline(){
    const startVal = $('timelineStart').value || new Date().toISOString().slice(0,10);
    const start = new Date(startVal);
    const days = 14;
    const rooms = ['101','102','201','202','301','302','401','501'];

    let html = '<div style="overflow-x:auto"><div style="min-width:800px">';
    html += '<div style="display:flex;gap:10px;padding:10px;border-bottom:2px solid #eee"><div style="width:80px;font-weight:600;font-size:13px">Room</div><div style="flex:1;display:grid;grid-template-columns:repeat('+days+',1fr);font-size:11px;text-align:center;color:#666">';
    for(let i=0;i<days;i++){
        const d = new Date(start); d.setDate(d.getDate()+i);
        html += `<div>${d.getDate()}/${d.getMonth()+1}</div>`;
    }
    html += '</div></div>';

    rooms.forEach(rm=>{
        const rmBookings = bookings.filter(b=>b.room===rm && b.status!=='cancelled');
        html += `<div class="timeline-row"><div class="timeline-room">Room ${rm}</div><div class="timeline-bar">`;
        rmBookings.forEach(b=>{
            const ci = new Date(b.checkIn), co = new Date(b.checkOut);
            const startIdx = (ci-start)/86400000;
            const endIdx = (co-start)/86400000;
            if(endIdx<0 || startIdx>days) return;
            const left = Math.max(0,startIdx)/days*100;
            const width = (Math.min(days,endIdx)-Math.max(0,startIdx))/days*100;
            const color = b.status==='checked-in'?'#22c55e':b.status==='confirmed'?'#3b82f6':b.status==='pending'?'#eab308':'#9ca3af';
            html += `<div class="bar-segment" style="left:${left}%;width:${width}%;background:${color}" title="${b.guest} - ${b.checkIn} to ${b.checkOut}">${b.guest.split(' ')[0]}</div>`;
        });
        html += `</div></div>`;
    });
    html += '</div></div>';
    $('timeline').innerHTML = html;
}

/* ============== PRICE CALC (FORM) ============== */
function calcPrice(){
    const roomVal = $('bRoom').value;
    const rate = roomVal ? +roomVal.split('|')[2] : 0;
    const n = nights($('bCheckIn').value, $('bCheckOut').value);
    const extras = [...document.querySelectorAll('.extra:checked')].reduce((s,el)=>s+(+el.value),0);
    const room = n*rate;
    const sub = room+extras;
    const vat = sub*0.15;
    const svc = sub*0.10;
    const grand = sub+vat+svc;
    const disc = grand*((+$('bDiscount').value||0)/100);
    const total = grand-disc;
    $('pNights').textContent = n;
    $('pRoom').textContent = fmt(room);
    $('pExtras').textContent = fmt(extras);
    $('pSub').textContent = fmt(sub);
    $('pVat').textContent = fmt(Math.round(vat));
    $('pSvc').textContent = fmt(Math.round(svc));
    $('pDisc').textContent = '-'+fmt(Math.round(disc));
    $('pTotal').textContent = fmt(Math.round(total));
}
document.querySelectorAll('.extra').forEach(el=>el.addEventListener('change',calcPrice));

/* ============== CRUD ============== */
$('bookForm').addEventListener('submit', e=>{
    e.preventDefault();
    const roomVal = $('bRoom').value;
    if(!roomVal){ toast('Select room',true); return; }
    const ci = $('bCheckIn').value, co = $('bCheckOut').value;
    if(nights(ci,co)<=0){ toast('Check-out must be after check-in',true); return; }

    const [room,roomType,rate] = roomVal.split('|');
    const extras = [...document.querySelectorAll('.extra:checked')].map(el=>({name:el.dataset.name,price:+el.value}));

    const data = {
        guest:$('gName').value.trim(), phone:$('gPhone').value.trim(), email:$('gEmail').value.trim(),
        nid:$('gNid').value.trim(), nat:$('gNat').value.trim(),
        room, roomType, rate:+rate, guests:+$('bGuests').value,
        checkIn:ci, checkOut:co, source:$('bSource').value,
        extras, discount:+$('bDiscount').value||0,
        method:$('bMethod').value, payStatus:$('bPayStatus').value,
        status:editId ? bookings.find(b=>b.id===editId).status : 'pending',
        notes:$('bNotes').value.trim(),
        createdAt: editId ? bookings.find(b=>b.id===editId).createdAt : new Date().toISOString().slice(0,10)
    };

    if(editId){
        const i = bookings.findIndex(b=>b.id===editId);
        bookings[i] = {id:editId, ...data};
        toast('Booking updated');
        editId = null;
        $('submitBtnText').textContent='Create Booking';
    } else {
        const id = Math.max(1000,...bookings.map(b=>b.id))+1;
        bookings.unshift({id, ...data});
        toast('Booking created #'+id);
    }
    $('bookForm').reset();
    $('bDiscount').value=0; $('gNat').value='Bangladeshi';
    calcPrice();
    refreshAll();
});

function editBooking(id){
    const b = bookings.find(x=>x.id===id); if(!b) return;
    editId = id;
    $('gName').value=b.guest; $('gPhone').value=b.phone; $('gEmail').value=b.email;
    $('gNid').value=b.nid; $('gNat').value=b.nat;
    $('bRoom').value = `${b.room}|${b.roomType}|${b.rate}`;
    $('bGuests').value=b.guests; $('bCheckIn').value=b.checkIn; $('bCheckOut').value=b.checkOut;
    $('bSource').value=b.source; $('bDiscount').value=b.discount;
    $('bMethod').value=b.method; $('bPayStatus').value=b.payStatus; $('bNotes').value=b.notes;
    document.querySelectorAll('.extra').forEach(el=>{
        el.checked = (b.extras||[]).some(x=>x.name===el.dataset.name);
    });
    $('submitBtnText').textContent='Update Booking';
    calcPrice();
    window.scrollTo({top:0,behavior:'smooth'});
}

function cancelBooking(id){
    const b = bookings.find(x=>x.id===id); if(!b) return;
    if(b.status==='cancelled' || b.status==='checked-out'){
        if(!confirm('Permanently delete this booking?')) return;
        bookings = bookings.filter(x=>x.id!==id);
        toast('Booking deleted');
    } else {
        if(!confirm('Cancel this booking?')) return;
        b.status = 'cancelled';
        toast('Booking cancelled');
    }
    refreshAll();
}

function changeStatus(id, st){
    const b = bookings.find(x=>x.id===id); if(!b) return;
    b.status = st;
    toast('Status: '+st);
    refreshAll();
}

function viewBooking(id){
    const b = bookings.find(x=>x.id===id); if(!b) return;
    const t = calcTotal(b);
    $('viewTitle').textContent = `Booking #${b.id}`;
    $('viewBody').innerHTML = `
        <div style="display:flex;gap:12px;align-items:center;margin-bottom:15px">
            <div class="avatar" style="width:60px;height:60px;font-size:20px;background:${avColor(b.guest)}">${initials(b.guest)}</div>
            <div>
                <h3 style="margin:0">${b.guest}</h3>
                <small style="color:#888">${b.phone} · ${b.email||'-'}</small><br>
                <small style="color:#888">NID/Passport: ${b.nid} · ${b.nat}</small>
            </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:14px;background:#f9fafb;padding:12px;border-radius:10px">
            <div><strong>Room:</strong> ${b.room} (${b.roomType})</div>
            <div><strong>Guests:</strong> ${b.guests}</div>
            <div><strong>Check-In:</strong> ${b.checkIn}</div>
            <div><strong>Check-Out:</strong> ${b.checkOut}</div>
            <div><strong>Nights:</strong> ${t.n}</div>
            <div><strong>Source:</strong> ${b.source}</div>
            <div><strong>Status:</strong> <span class="badge ${statusBadge(b.status)}">${b.status}</span></div>
            <div><strong>Payment:</strong> <span class="badge ${payBadge(b.payStatus)}">${b.payStatus}</span> via ${b.method}</div>
        </div>
        ${b.extras.length?`<div style="margin-top:10px"><strong>Extra Services:</strong><br>${b.extras.map(x=>`<span class="badge b-cyan" style="margin:3px 3px 0 0;display:inline-block">${x.name} - ৳${x.price}</span>`).join('')}</div>`:''}
        ${b.notes?`<div style="margin-top:10px"><strong>Notes:</strong><br><p style="color:#666;margin-top:4px">${b.notes}</p></div>`:''}
        <div class="price-summary" style="margin-top:15px">
            <div><span>Room (${t.n} nights × ${fmt(b.rate)})</span><span>${fmt(t.room)}</span></div>
            <div><span>Extra Services</span><span>${fmt(t.extras)}</span></div>
            <div><span>Subtotal</span><span>${fmt(t.sub)}</span></div>
            <div><span>VAT (15%)</span><span>${fmt(Math.round(t.vat))}</span></div>
            <div><span>Service Charge (10%)</span><span>${fmt(Math.round(t.svc))}</span></div>
            <div><span>Discount (${b.discount}%)</span><span>-${fmt(Math.round(t.disc))}</span></div>
            <div class="total"><span>TOTAL</span><span>${fmt(Math.round(t.total))}</span></div>
        </div>
        <div style="margin-top:15px;display:flex;gap:6px;flex-wrap:wrap">
            <button class="btn btn-outline btn-sm" onclick="window.print()"><i class="fa-solid fa-print"></i> Print Invoice</button>
            <button class="btn btn-edit btn-sm" onclick="closeView();editBooking(${b.id})"><i class="fa-solid fa-pen"></i> Edit</button>
        </div>
    `;
    $('viewModal').classList.add('show');
}
function closeView(){ $('viewModal').classList.remove('show'); }

/* ============== EXPORT ============== */
function exportCSV(){
    const rows = [['ID','Guest','Phone','Room','Type','Check-In','Check-Out','Nights','Total','Source','Payment','Status']];
    bookings.forEach(b=>{const t=calcTotal(b);rows.push([b.id,b.guest,b.phone,b.room,b.roomType,b.checkIn,b.checkOut,t.n,Math.round(t.total),b.source,b.payStatus,b.status]);});
    const csv = rows.map(r=>r.map(v=>`"${(v||'').toString().replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv],{type:'text/csv'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'bookings_'+new Date().toISOString().slice(0,10)+'.csv';
    a.click();
    toast('CSV exported');
}

/* ============== TABS / FILTERS ============== */
document.querySelectorAll('.tab').forEach(b=>{
    b.addEventListener('click',()=>{
        document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active'));
        b.classList.add('active');
        currentTab = b.dataset.tab;
        renderTable();
    });
});
['bSearch','filterSource','filterDate'].forEach(id=>$(id).addEventListener('input', renderTable));
$('globalSearch').addEventListener('input', e=>{ $('bSearch').value=e.target.value; renderTable(); });
$('timelineStart').addEventListener('change', renderTimeline);

/* ============== INIT ============== */
function refreshAll(){ calcKPI(); renderTable(); renderCharts(); renderTimeline(); }
$('timelineStart').value = new Date().toISOString().slice(0,10);
$('bCheckIn').value = new Date().toISOString().slice(0,10);
const tmr = new Date(); tmr.setDate(tmr.getDate()+1);
$('bCheckOut').value = tmr.toISOString().slice(0,10);
calcPrice();
refreshAll();
</script>

</body>
</html>
