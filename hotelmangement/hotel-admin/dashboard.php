<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Dashboard'; $ACTIVE='dashboard';

// KPI
$today = date('Y-m-d');
$newBookings = (int)scalar($conn,"SELECT COUNT(*) FROM bookings WHERE DATE(created_at)=?", [$today]);
$checkIn     = (int)scalar($conn,"SELECT COUNT(*) FROM bookings WHERE check_in=? AND status IN ('confirmed','checked-in')", [$today]);
$checkOut    = (int)scalar($conn,"SELECT COUNT(*) FROM bookings WHERE check_out=? AND status IN ('checked-in','checked-out')", [$today]);
$revenue     = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type IN ('income','service')");

// Room availability
$roomsTotal  = (int)scalar($conn,"SELECT COUNT(*) FROM rooms");
$roomsAvail  = (int)scalar($conn,"SELECT COUNT(*) FROM rooms WHERE status='available'");
$roomsOcc    = (int)scalar($conn,"SELECT COUNT(*) FROM rooms WHERE status='occupied'");
$roomsMaint  = (int)scalar($conn,"SELECT COUNT(*) FROM rooms WHERE status='maintenance'");

// Revenue last 7 days
$labels=[]; $values=[];
for ($i=6;$i>=0;$i--){
    $d = date('Y-m-d', strtotime("-$i days"));
    $labels[] = date('D', strtotime($d));
    $values[] = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type IN ('income','service') AND txn_date=?", [$d]);
}

// Booking by source
$sources = fetchAll($conn,"SELECT source, COUNT(*) c, COALESCE(SUM(total),0) rev FROM bookings GROUP BY source ORDER BY rev DESC LIMIT 4");
$totalSrc = array_sum(array_column($sources,'c')) ?: 1;

// Recent bookings
$recent = fetchAll($conn,"SELECT id, guest, room_no, room_type, status FROM bookings ORDER BY created_at DESC LIMIT 5");

include __DIR__.'/includes/header.php';
?>

<div class="topbar">
  <h2>📊 Dashboard</h2>
  <input class="search" placeholder="Search room, guest, booking...">
  <div>👤 Admin</div>
</div>

<div class="kpi">
  <div class="card"><div><small>New Bookings (today)</small><h3><?= $newBookings ?></h3></div><div class="icon blue"><i class="fa-solid fa-calendar-plus"></i></div></div>
  <div class="card"><div><small>Check-In (today)</small><h3><?= $checkIn ?></h3></div><div class="icon green"><i class="fa-solid fa-door-open"></i></div></div>
  <div class="card"><div><small>Check-Out (today)</small><h3><?= $checkOut ?></h3></div><div class="icon yellow"><i class="fa-solid fa-right-from-bracket"></i></div></div>
  <div class="card"><div><small>Total Revenue</small><h3><?= bdt($revenue) ?></h3></div><div class="icon purple"><i class="fa-solid fa-sack-dollar"></i></div></div>
</div>

<div class="grid-2">
  <div>
    <div class="box"><h3>Revenue Overview (Last 7 days)</h3>
      <div class="chart-wrap"><canvas id="chart1"></canvas></div>
    </div>

    <div class="box" style="margin-top:15px;">
      <h3>Booking by Source</h3>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;align-items:center;">
        <div style="max-width:220px;margin:auto;"><canvas id="platformChart"></canvas></div>
        <div style="font-size:13px;">
          <?php foreach ($sources as $s): $pct = round($s['c']*100/$totalSrc); ?>
            <div style="margin-bottom:6px;">● <b><?= e($s['source']) ?></b> — <?= $pct ?>% — <?= bdt($s['rev']) ?></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="box" style="margin-top:15px;">
      <h3>Recent Bookings</h3>
      <table>
        <thead><tr><th>ID</th><th>Guest</th><th>Room</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($recent as $b):
          $cls = ['pending'=>'b-yellow','confirmed'=>'b-blue','checked-in'=>'b-green','checked-out'=>'b-gray','cancelled'=>'b-red'][$b['status']] ?? 'b-gray'; ?>
          <tr>
            <td>#<?= (int)$b['id'] ?></td>
            <td><?= e($b['guest']) ?></td>
            <td><?= e($b['room_no']) ?> - <?= e($b['room_type']) ?></td>
            <td><span class="badge <?= $cls ?>"><?= e($b['status']) ?></span></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="right-box">
    <div class="box"><h3>Room Availability</h3>
      <p style="margin:6px 0;">🟢 Available: <b><?= $roomsAvail ?></b></p>
      <p style="margin:6px 0;">🟡 Occupied: <b><?= $roomsOcc ?></b></p>
      <p style="margin:6px 0;">🔴 Maintenance: <b><?= $roomsMaint ?></b></p>
      <p style="margin:6px 0;">📦 Total: <b><?= $roomsTotal ?></b></p>
    </div>
    <div class="box"><h3>Tasks</h3>
      <div class="task">Room Cleaning - Floor 3</div>
      <div class="task">Maintenance Check AC</div>
      <div class="task">Laundry Update</div>
    </div>
    <div class="box"><h3>Recent Activities</h3>
      <div class="activity">New booking received</div>
      <div class="activity">Payment received <?= bdt(2500) ?></div>
      <div class="activity">Room 101 cleaned</div>
      <div class="activity">Check-out completed</div>
    </div>
  </div>
</div>

<script>
new Chart(document.getElementById('chart1'),{
  type:'line',
  data:{ labels: <?= json_encode($labels) ?>,
    datasets:[{label:'Revenue', data: <?= json_encode($values) ?>,
      borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.2)', fill:true, tension:0.4 }]
  },
  options:{maintainAspectRatio:false}
});
new Chart(document.getElementById('platformChart'),{
  type:'doughnut',
  data:{
    labels: <?= json_encode(array_column($sources,'source')) ?>,
    datasets:[{
      data: <?= json_encode(array_map('intval', array_column($sources,'c'))) ?>,
      backgroundColor:['#22c55e','#3b82f6','#f59e0b','#a855f7'], cutout:'70%'
    }]
  },
  options:{maintainAspectRatio:false, plugins:{legend:{position:'bottom'}}}
});
</script>

<?php include __DIR__.'/includes/footer.php'; ?>
