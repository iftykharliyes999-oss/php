<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Hotel Admin Pro</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Inter,Segoe UI;
}

body{
    background:#f6f8fb;
    color:#111;
}

/* SIDEBAR */
.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:250px;
    height:100vh;
    background:#fff;
    border-right:1px solid #eee;
    padding:20px;
}

.sidebar h2{
    margin-bottom:25px;
    font-size:18px;
}

.sidebar a{
    display:flex;
    gap:10px;
    padding:10px;
    border-radius:10px;
    text-decoration:none;
    color:#555;
    margin-bottom:5px;
    transition:0.2s;
}

.sidebar a:hover{
    background:#eef6ff;
    color:#2563eb;
    transform:translateX(5px);
}

/* MAIN */
.main{
    margin-left:250px;
    padding:25px;
}

/* TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.search{
    width:320px;
    padding:10px;
    border-radius:10px;
    border:1px solid #ddd;
    background:#fff;
}

/* KPI */
.kpi{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
}

.card{
    background:#fff;
    padding:15px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:15px;
    margin-top:20px;
}

/* BOX */
.box{
    background:#fff;
    padding:15px;
    border-radius:14px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

th,td{
    text-align:left;
    padding:10px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.badge{
    padding:4px 8px;
    border-radius:6px;
    font-size:12px;
}

.green{background:#dcfce7;color:#166534;}
.yellow{background:#fef9c3;color:#854d0e;}
.red{background:#fee2e2;color:#991b1b;}

/* RIGHT */
.right-box{
    display:flex;
    flex-direction:column;
    gap:15px;
}

/* TASK */
.task{
    padding:10px;
    border-left:4px solid #22c55e;
    background:#f9fafb;
    border-radius:8px;
    margin-bottom:8px;
    font-size:13px;
}

/* ACTIVITY */
.activity{
    padding:10px;
    border-left:4px solid #3b82f6;
    background:#f8fafc;
    border-radius:8px;
    margin-bottom:8px;
    font-size:13px;
}

/* CHART */
.chart-box{
    height:260px;
}
</style>

</head>
<body>

<!-- SIDEBAR (NOW REAL ADMIN NAV SYSTEM) -->
<div class="sidebar">
<h2>🏨 LISORA GRAND</h2>

<a href="dashboard.php"><i class="fa-solid fa-grid"></i> Dashboard</a>
<a href="users.php"><i class="fa-solid fa-user"></i> Users</a>
<a href="rooms.php"><i class="fa-solid fa-bed"></i> Rooms</a>
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
<h2>Dashboard</h2>
<input class="search" placeholder="Search room, guest, booking...">
<div>👤 Admin</div>
</div>

<!-- KPI -->
<div class="kpi">

<div class="card">
<small>New Bookings</small>
<h3>840</h3>
</div>

<div class="card">
<small>Check-in</small>
<h3>231</h3>
</div>

<div class="card">
<small>Check-out</small>
<h3>124</h3>
</div>

<div class="card">
<small>Total Revenue</small>
<h3>$123,980</h3>
</div>

</div>

<!-- GRID -->
<div class="grid">

<!-- LEFT -->
<div>

<div class="box chart-box">
<h3>Revenue Overview</h3>
<canvas id="chart1"></canvas>
</div>

<!-- PLATFORM -->
<div class="box" style="margin-top:15px;">
<h3>Booking by Platform</h3>

<div style="max-width:220px; margin:auto;">
    <canvas id="platformChart"></canvas>
</div>

<div style="margin-top:12px; font-size:13px;">
    <div>🟢 Direct: <b id="d1">0%</b> — $<span id="r1">0</span></div>
    <div>🔵 Website: <b id="d2">0%</b> — $<span id="r2">0</span></div>
    <div>📘 Facebook: <b id="d3">0%</b> — $<span id="r3">0</span></div>
    <div>🟣 Others: <b id="d4">0%</b> — $<span id="r4">0</span></div>
</div>

</div>

<!-- BOOKINGS -->
<div class="box" style="margin-top:15px;">
<h3>Booking List</h3>

<table>
<tr>
<th>Guest</th>
<th>Room</th>
<th>Status</th>
</tr>

<tr>
<td>Rahim</td>
<td>Deluxe</td>
<td><span class="badge green">Checked-in</span></td>
</tr>

<tr>
<td>Karim</td>
<td>Standard</td>
<td><span class="badge yellow">Pending</span></td>
</tr>

<tr>
<td>Sabbir</td>
<td>Suite</td>
<td><span class="badge red">Cancelled</span></td>
</tr>

</table>

</div>

</div>

<!-- RIGHT -->
<div class="right-box">

<div class="box">
<h3>Room Availability</h3>
<p>✔ Occupied: 286</p>
<p>✔ Reserved: 87</p>
<p>✔ Available: 32</p>
</div>

<div class="box">
<h3>Tasks</h3>
<div class="task">Room Cleaning - Floor 3</div>
<div class="task">Maintenance Check AC</div>
<div class="task">Laundry Update</div>
</div>

<div class="box">
<h3>Recent Activities</h3>
<div class="activity">New booking from Rahim</div>
<div class="activity">Payment received $200</div>
<div class="activity">Room 101 cleaned</div>
<div class="activity">Check-out completed</div>
</div>

</div>

</div>

</div>

<script>

/* LINE CHART */
new Chart(document.getElementById('chart1'),{
type:'line',
data:{
labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
datasets:[{
label:'Revenue',
data:[20000,30000,25000,40000,35000,45000,50000],
borderColor:'#3b82f6',
backgroundColor:'rgba(59,130,246,0.2)',
fill:true,
tension:0.4
}]
}
});

const data = {
    direct: { percent: 50, revenue: 50000 },
    website: { percent: 25, revenue: 25000 },
    facebook: { percent: 15, revenue: 15000 },
    others: { percent: 10, revenue: 10000 }
};

/* DONUT */
new Chart(document.getElementById('platformChart'), {
type: 'doughnut',
data: {
labels: ['Direct', 'Website', 'Facebook', 'Others'],
datasets: [{
data: [50,25,15,10],
backgroundColor:['#22c55e','#3b82f6','#1877F2','#a855f7'],
cutout:'70%'
}]
}
});

/* ANIMATION */
function animate(id,target,suffix=""){
let el=document.getElementById(id);
let c=0;
let step=target/60;
let i=setInterval(()=>{
c+=step;
if(c>=target){c=target;clearInterval(i);}
el.innerText=Math.floor(c)+suffix;
},20);
}

animate("d1",50,"%");
animate("d2",25,"%");
animate("d3",15,"%");
animate("d4",10,"%");

animate("r1",50000);
animate("r2",25000);
animate("r3",15000);
animate("r4",10000);

</script>

</body>
</html>