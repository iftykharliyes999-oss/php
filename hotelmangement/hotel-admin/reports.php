<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Reports'; $ACTIVE='reports';

$year = (int)($_GET['year'] ?? date('Y'));
$totalRevenue = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type IN ('income','service') AND YEAR(txn_date)=?",[$year],'i');
$totalExpense = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type IN ('expense','salary') AND YEAR(txn_date)=?",[$year],'i');
$totalBookings= (int)scalar($conn,"SELECT COUNT(*) FROM bookings WHERE YEAR(created_at)=?",[$year],'i');
$avgRate      = (float)scalar($conn,"SELECT COALESCE(AVG(rate),0) FROM bookings WHERE YEAR(created_at)=?",[$year],'i');

// monthly income vs expense
$labels=[]; $incomeArr=[]; $expArr=[];
for ($m=1;$m<=12;$m++){
  $labels[] = date('M', mktime(0,0,0,$m,1));
  $incomeArr[] = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE YEAR(txn_date)=? AND MONTH(txn_date)=? AND type IN ('income','service')",[$year,$m],'ii');
  $expArr[]    = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE YEAR(txn_date)=? AND MONTH(txn_date)=? AND type IN ('expense','salary')",[$year,$m],'ii');
}

$topRooms = fetchAll($conn,"SELECT room_no, room_type, COUNT(*) c, SUM(total) rev FROM bookings WHERE YEAR(created_at)=? GROUP BY room_no, room_type ORDER BY rev DESC LIMIT 5",[$year],'i');
$topGuests= fetchAll($conn,"SELECT guest, phone, COUNT(*) c, SUM(total) rev FROM bookings WHERE YEAR(created_at)=? GROUP BY guest, phone ORDER BY rev DESC LIMIT 5",[$year],'i');
$bySource = fetchAll($conn,"SELECT source, COUNT(*) c FROM bookings WHERE YEAR(created_at)=? GROUP BY source",[$year],'i');
$statusAgg= fetchAll($conn,"SELECT status, COUNT(*) c FROM bookings WHERE YEAR(created_at)=? GROUP BY status",[$year],'i');

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>📈 Reports & Analytics</h2>
  <form method="get" style="display:flex;gap:8px;align-items:center;">
    <label style="font-size:13px;color:#666;">Year</label>
    <select name="year" onchange="this.form.submit()" style="padding:8px;border:1px solid #ddd;border-radius:8px;">
      <?php for ($y=date('Y');$y>=date('Y')-3;$y--): ?>
        <option <?= $y==$year?'selected':'' ?>><?= $y ?></option>
      <?php endfor; ?>
    </select>
  </form>
  <div>👤 Admin</div>
</div>

<div class="kpi">
  <div class="card"><div><small>Total Revenue</small><h3><?= bdt($totalRevenue) ?></h3></div><div class="icon green"><i class="fa-solid fa-sack-dollar"></i></div></div>
  <div class="card"><div><small>Total Expense</small><h3><?= bdt($totalExpense) ?></h3></div><div class="icon red"><i class="fa-solid fa-money-bill"></i></div></div>
  <div class="card"><div><small>Net Profit</small><h3><?= bdt($totalRevenue-$totalExpense) ?></h3></div><div class="icon blue"><i class="fa-solid fa-chart-pie"></i></div></div>
  <div class="card"><div><small>Bookings</small><h3><?= $totalBookings ?></h3><span class="trend up">Avg <?= bdt($avgRate) ?>/night</span></div><div class="icon purple"><i class="fa-solid fa-calendar-check"></i></div></div>
</div>

<div class="grid-2">
  <div class="box"><h3>💹 Revenue vs Expense (<?= $year ?>)</h3><div class="chart-wrap"><canvas id="repBar"></canvas></div></div>
  <div class="box"><h3>📊 Booking Status</h3><div class="chart-wrap"><canvas id="repStatus"></canvas></div></div>
</div>

<div class="grid-3">
  <div class="box"><h3>🏆 Top Rooms</h3>
    <table><thead><tr><th>Room</th><th>Bookings</th><th>Revenue</th></tr></thead><tbody>
    <?php foreach ($topRooms as $r): ?>
      <tr><td><b><?= e($r['room_no']) ?></b><br><small><?= e($r['room_type']) ?></small></td><td><?= (int)$r['c'] ?></td><td><?= bdt($r['rev']) ?></td></tr>
    <?php endforeach; if (!$topRooms) echo '<tr><td colspan="3" style="text-align:center;color:#888;padding:20px">No data</td></tr>'; ?>
    </tbody></table>
  </div>
  <div class="box"><h3>👑 Top Guests</h3>
    <table><thead><tr><th>Guest</th><th>Stays</th><th>Spent</th></tr></thead><tbody>
    <?php foreach ($topGuests as $g): ?>
      <tr><td><b><?= e($g['guest']) ?></b><br><small><?= e($g['phone']) ?></small></td><td><?= (int)$g['c'] ?></td><td><?= bdt($g['rev']) ?></td></tr>
    <?php endforeach; if (!$topGuests) echo '<tr><td colspan="3" style="text-align:center;color:#888;padding:20px">No data</td></tr>'; ?>
    </tbody></table>
  </div>
  <div class="box"><h3>🌐 Sources</h3>
    <div class="chart-wrap" style="height:240px"><canvas id="repSrc"></canvas></div>
  </div>
</div>

<script>
new Chart(document.getElementById('repBar'),{
  type:'bar',
  data:{labels:<?= json_encode($labels) ?>, datasets:[
    {label:'Revenue',data:<?= json_encode($incomeArr) ?>,backgroundColor:'#22c55e',borderRadius:4},
    {label:'Expense',data:<?= json_encode($expArr) ?>,backgroundColor:'#ef4444',borderRadius:4}
  ]},
  options:{maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
});
new Chart(document.getElementById('repStatus'),{
  type:'doughnut',
  data:{labels:<?= json_encode(array_column($statusAgg,'status')) ?>,
    datasets:[{data:<?= json_encode(array_map('intval',array_column($statusAgg,'c'))) ?>,
      backgroundColor:['#f59e0b','#3b82f6','#22c55e','#9ca3af','#ef4444']}]},
  options:{maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
});
new Chart(document.getElementById('repSrc'),{
  type:'pie',
  data:{labels:<?= json_encode(array_column($bySource,'source')) ?>,
    datasets:[{data:<?= json_encode(array_map('intval',array_column($bySource,'c'))) ?>,
      backgroundColor:['#22c55e','#3b82f6','#f59e0b','#a855f7','#ef4444','#06b6d4','#ec4899']}]},
  options:{maintainAspectRatio:false,plugins:{legend:{position:'bottom'}}}
});
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
