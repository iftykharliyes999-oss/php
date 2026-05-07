<?php // includes/sidebar.php ?>
<div class="sidebar">
  <h2>🏨 LISORA GRAND</h2>
  <a href="dashboard.php"  class="<?= $ACTIVE==='dashboard'?'active':'' ?>"><i class="fa-solid fa-gauge"></i> Dashboard</a>
  <a href="users.php"      class="<?= $ACTIVE==='users'?'active':'' ?>"><i class="fa-solid fa-user"></i> Users</a>
  <a href="rooms.php"      class="<?= $ACTIVE==='rooms'?'active':'' ?>"><i class="fa-solid fa-bed"></i> Rooms</a>
  <a href="bookings.php"   class="<?= $ACTIVE==='bookings'?'active':'' ?>"><i class="fa-solid fa-calendar"></i> Bookings</a>
  <a href="payments.php"   class="<?= $ACTIVE==='payments'?'active':'' ?>"><i class="fa-solid fa-dollar-sign"></i> Payments</a>
  <a href="customers.php"  class="<?= $ACTIVE==='customers'?'active':'' ?>"><i class="fa-solid fa-users"></i> Customers</a>
  <a href="reports.php"    class="<?= $ACTIVE==='reports'?'active':'' ?>"><i class="fa-solid fa-chart-line"></i> Reports</a>
  <a href="settings.php"   class="<?= $ACTIVE==='settings'?'active':'' ?>"><i class="fa-solid fa-gear"></i> Settings</a>
</div>
