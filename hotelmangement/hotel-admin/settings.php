<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Settings'; $ACTIVE='settings';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    try {
        if (($_POST['action']??'')==='save') {
            foreach ($_POST as $k=>$v) {
                if ($k==='action') continue;
                q($conn,"INSERT INTO settings (k,v) VALUES (?,?) ON DUPLICATE KEY UPDATE v=VALUES(v)", [$k,(string)$v]);
            }
            jsonOut(['ok'=>true]);
        }
        jsonOut(['ok'=>false],400);
    } catch (Throwable $e) { jsonOut(['ok'=>false,'error'=>$e->getMessage()],500); }
}

$rows = fetchAll($conn,"SELECT k,v FROM settings");
$S = [];
foreach ($rows as $r) $S[$r['k']] = $r['v'];
function s($S,$k,$d=''){ return e($S[$k] ?? $d); }

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>⚙️ Settings</h2>
  <div></div>
  <div>👤 Admin</div>
</div>

<form id="settingsForm">
  <input type="hidden" name="action" value="save">

  <div class="settings-grid">
    <div class="box">
      <h3>🏨 Hotel Information</h3>
      <div class="form-group"><label>Hotel Name</label><input name="hotel_name" value="<?= s($S,'hotel_name') ?>"></div>
      <div class="form-group"><label>Email</label><input type="email" name="hotel_email" value="<?= s($S,'hotel_email') ?>"></div>
      <div class="form-group"><label>Phone</label><input name="hotel_phone" value="<?= s($S,'hotel_phone') ?>"></div>
      <div class="form-group"><label>Address</label><textarea name="hotel_address" rows="2"><?= s($S,'hotel_address') ?></textarea></div>
    </div>

    <div class="box">
      <h3>💵 Financial</h3>
      <div class="form-group"><label>Currency</label>
        <select name="currency">
          <?php foreach (['BDT','USD','EUR','INR','GBP'] as $c): ?>
            <option <?= ($S['currency']??'')===$c?'selected':'' ?>><?= $c ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-row">
        <div class="form-group"><label>VAT (%)</label><input type="number" step="0.01" name="vat_percent" value="<?= s($S,'vat_percent','15') ?>"></div>
        <div class="form-group"><label>Service Charge (%)</label><input type="number" step="0.01" name="service_percent" value="<?= s($S,'service_percent','10') ?>"></div>
      </div>
      <div class="form-group"><label>Timezone</label>
        <select name="timezone">
          <?php foreach (['Asia/Dhaka','Asia/Kolkata','Asia/Karachi','UTC','Asia/Dubai'] as $tz): ?>
            <option <?= ($S['timezone']??'')===$tz?'selected':'' ?>><?= $tz ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <div class="settings-grid">
    <div class="box">
      <h3>🔔 Notifications</h3>
      <div class="form-group"><label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="notify_email" value="1" <?= !empty($S['notify_email'])?'checked':'' ?> style="width:auto"> Email new bookings</label></div>
      <div class="form-group"><label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="notify_sms" value="1" <?= !empty($S['notify_sms'])?'checked':'' ?> style="width:auto"> SMS reminders</label></div>
      <div class="form-group"><label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="notify_payment" value="1" <?= !empty($S['notify_payment'])?'checked':'' ?> style="width:auto"> Payment alerts</label></div>
    </div>

    <div class="box">
      <h3>🛡️ Booking Policies</h3>
      <div class="form-group"><label>Check-in Time</label><input type="time" name="checkin_time" value="<?= s($S,'checkin_time','14:00') ?>"></div>
      <div class="form-group"><label>Check-out Time</label><input type="time" name="checkout_time" value="<?= s($S,'checkout_time','12:00') ?>"></div>
      <div class="form-group"><label>Cancellation Policy</label>
        <textarea name="cancel_policy" rows="3"><?= s($S,'cancel_policy','Free cancellation up to 24 hours before check-in.') ?></textarea>
      </div>
    </div>
  </div>

  <div class="box" style="margin-top:20px;text-align:right;">
    <button class="btn btn-primary" style="width:auto;padding:12px 30px;"><i class="fa-solid fa-save"></i> Save Settings</button>
  </div>
</form>

<script>
$('settingsForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const fd=new FormData(e.target);
  // ensure unchecked checkboxes are sent as 0
  ['notify_email','notify_sms','notify_payment'].forEach(k=>{ if(!fd.has(k)) fd.set(k,'0'); });
  const r=await api('settings.php',Object.fromEntries(fd));
  if(r.ok) toast('✔ Settings saved');
  else toast(r.error||'Failed',true);
});
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
