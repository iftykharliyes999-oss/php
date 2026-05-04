<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payments & Finance - Hotel Admin Pro</title>

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

/* MAIN */
.main{margin-left:250px;padding:25px;}

/* TOPBAR */
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;}
.search{width:320px;padding:10px;border-radius:10px;border:1px solid #ddd;background:#fff;}

/* KPI */
.kpi{display:grid;grid-template-columns:repeat(4,1fr);gap:15px;}
.card{background:#fff;padding:18px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);transition:0.3s;display:flex;justify-content:space-between;align-items:center;}
.card:hover{transform:translateY(-5px);}
.card small{color:#888;font-size:13px;}
.card h3{font-size:22px;margin-top:4px;}
.card .trend{font-size:11px;margin-top:4px;display:block;}
.trend.up{color:#22c55e;}
.trend.down{color:#ef4444;}

.card .icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;}
.icon.blue{background:#3b82f6;}
.icon.green{background:#22c55e;}
.icon.yellow{background:#eab308;}
.icon.red{background:#ef4444;}
.icon.purple{background:#8b5cf6;}
.icon.cyan{background:#06b6d4;}

/* GRID */
.grid-2{display:grid;grid-template-columns:2fr 1fr;gap:15px;margin-top:20px;}
.grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:15px;margin-top:20px;}
.grid-form{display:grid;grid-template-columns:1fr 2fr;gap:15px;margin-top:20px;}

/* BOX */
.box{background:#fff;padding:18px;border-radius:14px;box-shadow:0 6px 18px rgba(0,0,0,0.05);}
.box h3{margin-bottom:15px;font-size:16px;display:flex;justify-content:space-between;align-items:center;}

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
.btn-sm{padding:6px 10px;font-size:12px;}
.btn-edit{background:#fef9c3;color:#854d0e;}
.btn-edit:hover{background:#fde68a;}
.btn-delete{background:#fee2e2;color:#991b1b;}
.btn-delete:hover{background:#fecaca;}
.btn-outline{background:#fff;border:1px solid #ddd;color:#555;}
.btn-outline:hover{background:#f3f4f6;}

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
.b-cyan{background:#cffafe;color:#155e75;}
.b-gray{background:#f3f4f6;color:#374151;}

.amount-in{color:#16a34a;font-weight:600;}
.amount-out{color:#dc2626;font-weight:600;}

/* TOOLBAR */
.toolbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:15px;gap:10px;flex-wrap:wrap;}
.toolbar .filters{display:flex;gap:10px;flex:1;flex-wrap:wrap;}
.toolbar input,.toolbar select{padding:8px 12px;border:1px solid #ddd;border-radius:8px;font-size:13px;background:#fff;}
.toolbar input{flex:1;max-width:280px;}
.actions{display:flex;gap:6px;}

/* TABS */
.tabs{display:flex;gap:6px;border-bottom:2px solid #eee;margin-bottom:15px;}
.tab{padding:10px 16px;cursor:pointer;border:none;background:none;font-size:14px;font-weight:500;color:#666;border-bottom:2px solid transparent;margin-bottom:-2px;transition:0.2s;}
.tab:hover{color:#2563eb;}
.tab.active{color:#2563eb;border-bottom-color:#2563eb;}

.tab-pane{display:none;}
.tab-pane.active{display:block;}

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

/* CHART CONTAINER */
.chart-wrap{position:relative;height:280px;}

/* SUMMARY ROW */
.summary{display:flex;gap:10px;margin-top:12px;flex-wrap:wrap;}
.summary div{flex:1;min-width:120px;background:#f9fafb;padding:10px;border-radius:8px;font-size:13px;}
.summary strong{display:block;font-size:16px;margin-top:4px;color:#111;}

/* RESPONSIVE */
@media(max-width:992px){
    .grid-2,.grid-3,.grid-form{grid-template-columns:1fr;}
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
<a href="rooms.php"><i class="fa-solid fa-bed"></i> Rooms</a>
<a href="bookings.php"><i class="fa-solid fa-calendar"></i> Bookings</a>
<a href="payments.php" class="active"><i class="fa-solid fa-dollar-sign"></i> Payments</a>
<a href="customers.php"><i class="fa-solid fa-users"></i> Customers</a>
<a href="reports.php"><i class="fa-solid fa-chart-line"></i> Reports</a>
<a href="settings.php"><i class="fa-solid fa-gear"></i> Settings</a>
</div>

<!-- MAIN -->
<div class="main">

<!-- TOPBAR -->
<div class="topbar">
<h2>💰 Payments & Finance</h2>
<input class="search" id="globalSearch" placeholder="Search transactions...">
<div>👤 Admin</div>
</div>

<!-- KPI -->
<div class="kpi">
    <div class="card">
        <div>
            <small>Total Earnings</small>
            <h3 id="kpiEarn">৳0</h3>
            <span class="trend up"><i class="fa-solid fa-arrow-up"></i> Income</span>
        </div>
        <div class="icon green"><i class="fa-solid fa-sack-dollar"></i></div>
    </div>
    <div class="card">
        <div>
            <small>Total Expenses</small>
            <h3 id="kpiExp">৳0</h3>
            <span class="trend down"><i class="fa-solid fa-arrow-down"></i> Outflow</span>
        </div>
        <div class="icon red"><i class="fa-solid fa-money-bill-trend-up"></i></div>
    </div>
    <div class="card">
        <div>
            <small>Salary Paid</small>
            <h3 id="kpiSalary">৳0</h3>
            <span class="trend down">Employee payroll</span>
        </div>
        <div class="icon purple"><i class="fa-solid fa-user-tie"></i></div>
    </div>
    <div class="card">
        <div>
            <small>Net Profit</small>
            <h3 id="kpiProfit">৳0</h3>
            <span class="trend up" id="profitMargin">Margin 0%</span>
        </div>
        <div class="icon blue"><i class="fa-solid fa-chart-pie"></i></div>
    </div>
</div>

<!-- CHARTS -->
<div class="grid-2">
    <div class="box">
        <h3>📊 Income vs Expense (Monthly)
            <select id="yearFilter" style="padding:6px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;">
                <option>2025</option><option selected>2026</option>
            </select>
        </h3>
        <div class="chart-wrap"><canvas id="barChart"></canvas></div>
    </div>
    <div class="box">
        <h3>🥧 Expense Breakdown</h3>
        <div class="chart-wrap"><canvas id="pieChart"></canvas></div>
    </div>
</div>

<!-- SECONDARY ROW -->
<div class="grid-3">
    <div class="box">
        <h3>🏨 Earning Sources</h3>
        <div id="sourceList"></div>
    </div>
    <div class="box">
        <h3>💸 Expense Categories</h3>
        <div id="categoryList"></div>
    </div>
    <div class="box">
        <h3>🛎️ Service Charges</h3>
        <div id="serviceList"></div>
        <div class="summary">
            <div>Total Service<strong id="totalService">৳0</strong></div>
            <div>This Month<strong id="monthService">৳0</strong></div>
        </div>
    </div>
</div>

<!-- TABS - TRANSACTIONS -->
<div class="box" style="margin-top:20px;">
    <div class="tabs">
        <button class="tab active" data-tab="all">All Transactions</button>
        <button class="tab" data-tab="income">Income</button>
        <button class="tab" data-tab="expense">Expenses</button>
        <button class="tab" data-tab="salary">Salaries</button>
        <button class="tab" data-tab="service">Service Charges</button>
    </div>

    <div class="toolbar">
        <div class="filters">
            <input id="txnSearch" placeholder="Search description, category...">
            <select id="filterCategory">
                <option value="">All Categories</option>
                <option>Booking</option><option>Restaurant</option><option>Service Charge</option>
                <option>Salary</option><option>Utility</option><option>Maintenance</option>
                <option>Supplies</option><option>Marketing</option><option>Other</option>
            </select>
            <input type="month" id="filterMonth">
        </div>
        <div class="actions">
            <button class="btn btn-outline btn-sm" onclick="exportCSV()"><i class="fa-solid fa-download"></i> Export CSV</button>
            <button class="btn btn-success btn-sm" onclick="openModal('add')"><i class="fa-solid fa-plus"></i> Add Transaction</button>
        </div>
    </div>

    <div class="tab-pane active" id="tab-all"><table id="txnTable"></table></div>
    <div class="tab-pane" id="tab-income"><table id="incomeTable"></table></div>
    <div class="tab-pane" id="tab-expense"><table id="expenseTable"></table></div>
    <div class="tab-pane" id="tab-salary"><table id="salaryTable"></table></div>
    <div class="tab-pane" id="tab-service"><table id="serviceTable"></table></div>
</div>

</div>

<!-- ADD/EDIT MODAL -->
<div class="modal" id="txnModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Add Transaction</h3>
            <button class="close" onclick="closeModal()">&times;</button>
        </div>
        <form id="txnForm">
            <input type="hidden" id="txnId">
            <div class="form-group">
                <label>Type *</label>
                <select id="txnType" required>
                    <option value="income">Income (Earning)</option>
                    <option value="expense">Expense (Cost)</option>
                    <option value="salary">Salary Payment</option>
                    <option value="service">Service Charge</option>
                </select>
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select id="txnCategory" required>
                    <option>Booking</option>
                    <option>Restaurant</option>
                    <option>Service Charge</option>
                    <option>Salary</option>
                    <option>Utility</option>
                    <option>Maintenance</option>
                    <option>Supplies</option>
                    <option>Marketing</option>
                    <option>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Description / Reference *</label>
                <input id="txnDesc" placeholder="e.g. Room 203 booking - John Doe" required>
            </div>
            <div class="form-group">
                <label>Person / Vendor (optional)</label>
                <input id="txnPerson" placeholder="e.g. Karim (Receptionist) / DESCO">
            </div>
            <div class="form-group">
                <label>Amount (৳) *</label>
                <input type="number" id="txnAmount" min="0" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Payment Method</label>
                <select id="txnMethod">
                    <option>Cash</option><option>bKash</option><option>Nagad</option>
                    <option>Card</option><option>Bank Transfer</option>
                </select>
            </div>
            <div class="form-group">
                <label>Date *</label>
                <input type="date" id="txnDate" required>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="txnStatus">
                    <option>Paid</option><option>Pending</option><option>Failed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-check"></i> Save Transaction</button>
        </form>
    </div>
</div>

<!-- TOAST -->
<div class="toast" id="toast"></div>

<script>
/* ============== DEMO DATA ============== */
let txns = [
    {id:1,type:'income',category:'Booking',desc:'Room 101 - Rahim Ahmed',person:'Rahim Ahmed',amount:8500,method:'Card',date:'2026-05-01',status:'Paid'},
    {id:2,type:'income',category:'Booking',desc:'Room 205 - Sarah Khan',person:'Sarah Khan',amount:12000,method:'bKash',date:'2026-05-02',status:'Paid'},
    {id:3,type:'income',category:'Restaurant',desc:'Dinner Buffet x4',person:'Walk-in',amount:3200,method:'Cash',date:'2026-05-02',status:'Paid'},
    {id:4,type:'service',category:'Service Charge',desc:'Laundry service - Room 305',person:'Mr. Hasan',amount:600,method:'Cash',date:'2026-05-03',status:'Paid'},
    {id:5,type:'service',category:'Service Charge',desc:'Spa booking',person:'Mrs. Lopa',amount:2500,method:'Card',date:'2026-05-03',status:'Paid'},
    {id:6,type:'salary',category:'Salary',desc:'April Salary - Karim (Receptionist)',person:'Karim',amount:18000,method:'Bank Transfer',date:'2026-05-01',status:'Paid'},
    {id:7,type:'salary',category:'Salary',desc:'April Salary - Nasir (Manager)',person:'Nasir',amount:35000,method:'Bank Transfer',date:'2026-05-01',status:'Paid'},
    {id:8,type:'salary',category:'Salary',desc:'April Salary - Rina (Housekeeping)',person:'Rina',amount:12000,method:'Cash',date:'2026-05-01',status:'Paid'},
    {id:9,type:'expense',category:'Utility',desc:'Electricity Bill - April',person:'DESCO',amount:24500,method:'Bank Transfer',date:'2026-05-04',status:'Paid'},
    {id:10,type:'expense',category:'Utility',desc:'Water & Gas - April',person:'WASA/Titas',amount:8200,method:'Cash',date:'2026-05-04',status:'Paid'},
    {id:11,type:'expense',category:'Maintenance',desc:'AC repair - 3 rooms',person:'Cool Tech',amount:6500,method:'Cash',date:'2026-04-28',status:'Paid'},
    {id:12,type:'expense',category:'Supplies',desc:'Toiletries restock',person:'ABC Suppliers',amount:9800,method:'Bank Transfer',date:'2026-04-25',status:'Paid'},
    {id:13,type:'expense',category:'Marketing',desc:'Facebook ads campaign',person:'Meta',amount:5000,method:'Card',date:'2026-04-22',status:'Paid'},
    {id:14,type:'income',category:'Booking',desc:'Conference Hall - Corp event',person:'XYZ Corp',amount:45000,method:'Bank Transfer',date:'2026-04-18',status:'Paid'},
    {id:15,type:'income',category:'Booking',desc:'Room 410 - Family stay',person:'Mr. Imran',amount:15000,method:'Card',date:'2026-04-15',status:'Paid'},
    {id:16,type:'expense',category:'Other',desc:'Office stationery',person:'Local shop',amount:1200,method:'Cash',date:'2026-04-10',status:'Paid'},
    {id:17,type:'income',category:'Restaurant',desc:'Lunch orders - week',person:'Various',amount:18500,method:'Cash',date:'2026-04-08',status:'Paid'},
    {id:18,type:'service',category:'Service Charge',desc:'Airport pickup',person:'Mr. Tom',amount:1500,method:'Cash',date:'2026-04-05',status:'Paid'},
];

let currentTab = 'all';
let editId = null;

/* ============== HELPERS ============== */
const fmt = n => '৳' + Number(n).toLocaleString('en-IN');
const $ = id => document.getElementById(id);

function toast(msg, err){
    const t = $('toast');
    t.textContent = msg;
    t.className = 'toast show' + (err?' error':'');
    setTimeout(()=>t.classList.remove('show'),2200);
}

function badgeFor(type){
    const m = {income:'b-green',expense:'b-red',salary:'b-purple',service:'b-cyan'};
    return m[type] || 'b-gray';
}
function statusBadge(s){
    if(s==='Paid') return 'b-green';
    if(s==='Pending') return 'b-yellow';
    return 'b-red';
}

/* ============== KPI + RENDER ============== */
function calcKPI(){
    const earn = txns.filter(t=>t.type==='income'||t.type==='service').reduce((s,t)=>s+(+t.amount||0),0);
    const exp  = txns.filter(t=>t.type==='expense').reduce((s,t)=>s+(+t.amount||0),0);
    const sal  = txns.filter(t=>t.type==='salary').reduce((s,t)=>s+(+t.amount||0),0);
    const profit = earn - exp - sal;
    const margin = earn>0 ? ((profit/earn)*100).toFixed(1) : 0;

    $('kpiEarn').textContent = fmt(earn);
    $('kpiExp').textContent = fmt(exp);
    $('kpiSalary').textContent = fmt(sal);
    $('kpiProfit').textContent = fmt(profit);
    const pm = $('profitMargin');
    pm.textContent = `Margin ${margin}%`;
    pm.className = 'trend ' + (profit>=0?'up':'down');
}

function rowHtml(t, withType){
    return `<tr>
        <td><strong>#${t.id}</strong></td>
        <td>${t.date}</td>
        ${withType?`<td><span class="badge ${badgeFor(t.type)}">${t.type.toUpperCase()}</span></td>`:''}
        <td>${t.category}</td>
        <td>${t.desc}<br><small style="color:#888">${t.person||'-'}</small></td>
        <td><span class="badge b-gray">${t.method}</span></td>
        <td class="${(t.type==='income'||t.type==='service')?'amount-in':'amount-out'}">
            ${(t.type==='income'||t.type==='service')?'+':'-'}${fmt(t.amount)}
        </td>
        <td><span class="badge ${statusBadge(t.status)}">${t.status}</span></td>
        <td>
            <button class="btn btn-sm btn-edit" onclick="editTxn(${t.id})"><i class="fa-solid fa-pen"></i></button>
            <button class="btn btn-sm btn-delete" onclick="delTxn(${t.id})"><i class="fa-solid fa-trash"></i></button>
        </td>
    </tr>`;
}

function tableHead(withType){
    return `<thead><tr>
        <th>ID</th><th>Date</th>${withType?'<th>Type</th>':''}<th>Category</th>
        <th>Description</th><th>Method</th><th>Amount</th><th>Status</th><th>Actions</th>
    </tr></thead>`;
}

function renderTables(){
    const search = $('txnSearch').value.toLowerCase();
    const cat = $('filterCategory').value;
    const month = $('filterMonth').value;

    const filter = arr => arr.filter(t=>{
        if(search && !(t.desc+t.person+t.category).toLowerCase().includes(search)) return false;
        if(cat && t.category!==cat) return false;
        if(month && !t.date.startsWith(month)) return false;
        return true;
    });

    const all = filter(txns);
    $('txnTable').innerHTML = tableHead(true) + '<tbody>' + (all.length?all.map(t=>rowHtml(t,true)).join(''):'<tr><td colspan="9" style="text-align:center;color:#888;padding:30px">No transactions found</td></tr>') + '</tbody>';

    ['income','expense','salary','service'].forEach(type=>{
        const data = filter(txns.filter(t=>t.type===type));
        const tbl = $(type+'Table');
        tbl.innerHTML = tableHead(false) + '<tbody>' + (data.length?data.map(t=>rowHtml(t,false)).join(''):'<tr><td colspan="8" style="text-align:center;color:#888;padding:30px">No records</td></tr>') + '</tbody>';
    });
}

/* ============== AGGREGATE LISTS ============== */
function renderAggregates(){
    const groupSum = (arr, key) => {
        const m = {};
        arr.forEach(t=> m[t[key]] = (m[t[key]]||0) + (+t.amount||0));
        return Object.entries(m).sort((a,b)=>b[1]-a[1]);
    };
    const renderList = (id, data, color) => {
        const total = data.reduce((s,[,v])=>s+v,0) || 1;
        $(id).innerHTML = data.length ? data.map(([k,v])=>`
            <div style="margin-bottom:10px">
                <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:4px">
                    <span>${k}</span><strong>${fmt(v)}</strong>
                </div>
                <div style="background:#f3f4f6;border-radius:6px;height:6px;overflow:hidden">
                    <div style="height:100%;width:${(v/total*100).toFixed(0)}%;background:${color}"></div>
                </div>
            </div>`).join('') : '<p style="color:#888;font-size:13px">No data</p>';
    };

    renderList('sourceList', groupSum(txns.filter(t=>t.type==='income'),'category'), '#22c55e');
    renderList('categoryList', groupSum(txns.filter(t=>t.type==='expense'||t.type==='salary'),'category'), '#ef4444');

    const services = txns.filter(t=>t.type==='service');
    renderList('serviceList', groupSum(services,'desc').slice(0,5), '#06b6d4');
    const totalSvc = services.reduce((s,t)=>s+(+t.amount||0),0);
    const monthKey = new Date().toISOString().slice(0,7);
    const monthSvc = services.filter(t=>t.date.startsWith(monthKey)).reduce((s,t)=>s+(+t.amount||0),0);
    $('totalService').textContent = fmt(totalSvc);
    $('monthService').textContent = fmt(monthSvc);
}

/* ============== CHARTS ============== */
let barChart, pieChart;
function renderCharts(){
    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    const year = $('yearFilter').value;
    const income = Array(12).fill(0), expense = Array(12).fill(0);
    txns.forEach(t=>{
        const [y,m] = t.date.split('-');
        if(y!==year) return;
        const idx = parseInt(m)-1;
        if(t.type==='income'||t.type==='service') income[idx]+=+t.amount;
        else expense[idx]+=+t.amount;
    });

    if(barChart) barChart.destroy();
    barChart = new Chart($('barChart'), {
        type:'bar',
        data:{labels:months,datasets:[
            {label:'Income',data:income,backgroundColor:'#22c55e',borderRadius:6},
            {label:'Expense',data:expense,backgroundColor:'#ef4444',borderRadius:6},
        ]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
    });

    // pie - expense breakdown
    const expByCat = {};
    txns.filter(t=>t.type==='expense'||t.type==='salary').forEach(t=>{
        expByCat[t.category]=(expByCat[t.category]||0)+(+t.amount||0);
    });
    const colors = ['#ef4444','#8b5cf6','#f59e0b','#06b6d4','#3b82f6','#ec4899','#10b981','#6b7280'];
    if(pieChart) pieChart.destroy();
    pieChart = new Chart($('pieChart'), {
        type:'doughnut',
        data:{labels:Object.keys(expByCat),datasets:[{data:Object.values(expByCat),backgroundColor:colors}]},
        options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
    });
}

/* ============== CRUD ============== */
function openModal(mode, id){
    editId = null;
    $('modalTitle').textContent = 'Add Transaction';
    $('txnForm').reset();
    $('txnDate').value = new Date().toISOString().slice(0,10);
    if(mode==='edit' && id){
        const t = txns.find(x=>x.id===id);
        if(!t) return;
        editId = id;
        $('modalTitle').textContent = 'Edit Transaction #'+id;
        $('txnType').value = t.type;
        $('txnCategory').value = t.category;
        $('txnDesc').value = t.desc;
        $('txnPerson').value = t.person||'';
        $('txnAmount').value = t.amount;
        $('txnMethod').value = t.method;
        $('txnDate').value = t.date;
        $('txnStatus').value = t.status;
    }
    $('txnModal').classList.add('show');
}
function closeModal(){ $('txnModal').classList.remove('show'); }

function editTxn(id){ openModal('edit', id); }

function delTxn(id){
    if(!confirm('Delete this transaction?')) return;
    txns = txns.filter(t=>t.id!==id);
    refreshAll();
    toast('Transaction deleted');
}

$('txnForm').addEventListener('submit', e=>{
    e.preventDefault();
    const data = {
        type:$('txnType').value, category:$('txnCategory').value,
        desc:$('txnDesc').value.trim(), person:$('txnPerson').value.trim(),
        amount:+$('txnAmount').value, method:$('txnMethod').value,
        date:$('txnDate').value, status:$('txnStatus').value
    };
    if(!data.desc || !data.amount){ toast('Please fill required fields',true); return; }
    if(editId){
        const i = txns.findIndex(t=>t.id===editId);
        txns[i] = {id:editId, ...data};
        toast('Transaction updated');
    } else {
        const id = Math.max(0,...txns.map(t=>t.id))+1;
        txns.unshift({id, ...data});
        toast('Transaction added');
    }
    closeModal();
    refreshAll();
});

/* ============== EXPORT ============== */
function exportCSV(){
    const rows = [['ID','Date','Type','Category','Description','Person','Method','Amount','Status']];
    txns.forEach(t=>rows.push([t.id,t.date,t.type,t.category,t.desc,t.person,t.method,t.amount,t.status]));
    const csv = rows.map(r=>r.map(v=>`"${(v||'').toString().replace(/"/g,'""')}"`).join(',')).join('\n');
    const blob = new Blob([csv],{type:'text/csv'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'transactions_'+new Date().toISOString().slice(0,10)+'.csv';
    a.click();
    toast('CSV exported');
}

/* ============== TABS ============== */
document.querySelectorAll('.tab').forEach(b=>{
    b.addEventListener('click',()=>{
        document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(x=>x.classList.remove('active'));
        b.classList.add('active');
        $('tab-'+b.dataset.tab).classList.add('active');
        currentTab = b.dataset.tab;
    });
});

/* ============== FILTERS ============== */
['txnSearch','filterCategory','filterMonth'].forEach(id=>{
    $(id).addEventListener('input', renderTables);
});
$('globalSearch').addEventListener('input', e=>{
    $('txnSearch').value = e.target.value;
    renderTables();
});
$('yearFilter').addEventListener('change', renderCharts);

/* ============== INIT ============== */
function refreshAll(){
    calcKPI();
    renderTables();
    renderAggregates();
    renderCharts();
}
refreshAll();
</script>

</body>
</html>
