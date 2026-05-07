<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Payments'; $ACTIVE='payments';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $a=$_POST['action']??'';
    try {
        if ($a==='save') {
            $id=(int)($_POST['id']??0);
            $p=[$_POST['type'],$_POST['category'],$_POST['description'],$_POST['person']??'',
                (float)$_POST['amount'],$_POST['method']??'Cash',$_POST['txn_date'],$_POST['status']??'Paid'];
            if ($id) { $p[]=$id;
              q($conn,"UPDATE transactions SET type=?,category=?,description=?,person=?,amount=?,method=?,txn_date=?,status=? WHERE id=?",$p,'ssssdsssi');
            } else {
              q($conn,"INSERT INTO transactions (type,category,description,person,amount,method,txn_date,status) VALUES (?,?,?,?,?,?,?,?)",$p,'ssssdsss');
              $id=$conn->insert_id;
            }
            jsonOut(['ok'=>true,'id'=>$id]);
        }
        if ($a==='delete') { q($conn,"DELETE FROM transactions WHERE id=?",[(int)$_POST['id']],'i'); jsonOut(['ok'=>true]); }
        jsonOut(['ok'=>false],400);
    } catch (Throwable $e) { jsonOut(['ok'=>false,'error'=>$e->getMessage()],500); }
}

$txns = fetchAll($conn,"SELECT * FROM transactions ORDER BY txn_date DESC, id DESC");

$earn = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type IN ('income','service')");
$exp  = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type='expense'");
$sal  = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE type='salary'");
$profit = $earn - $exp - $sal;
$margin = $earn>0 ? round(($profit/$earn)*100,1) : 0;

// monthly bar data current year
$year = (int)date('Y');
$labels=[]; $incomeArr=[]; $expArr=[];
for ($m=1;$m<=12;$m++){
  $labels[]=date('M', mktime(0,0,0,$m,1));
  $incomeArr[] = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE YEAR(txn_date)=? AND MONTH(txn_date)=? AND type IN ('income','service')",[$year,$m],'ii');
  $expArr[]    = (float)scalar($conn,"SELECT COALESCE(SUM(amount),0) FROM transactions WHERE YEAR(txn_date)=? AND MONTH(txn_date)=? AND type IN ('expense','salary')",[$year,$m],'ii');
}
$pieData = fetchAll($conn,"SELECT category, SUM(amount) v FROM transactions WHERE type IN ('expense','salary') GROUP BY category ORDER BY v DESC");

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>💰 Payments & Finance</h2>
  <input class="search" placeholder="Search transactions...">
  <div>👤 Admin</div>
</div>

<div class="kpi">
  <div class="card"><div><small>Total Earnings</small><h3><?= bdt($earn) ?></h3><span class="trend up">Income</span></div><div class="icon green"><i class="fa-solid fa-sack-dollar"></i></div></div>
  <div class="card"><div><small>Total Expenses</small><h3><?= bdt($exp) ?></h3><span class="trend down">Outflow</span></div><div class="icon red"><i class="fa-solid fa-money-bill-trend-up"></i></div></div>
  <div class="card"><div><small>Salary Paid</small><h3><?= bdt($sal) ?></h3><span class="trend down">Payroll</span></div><div class="icon purple"><i class="fa-solid fa-user-tie"></i></div></div>
  <div class="card"><div><small>Net Profit</small><h3><?= bdt($profit) ?></h3><span class="trend <?= $profit>=0?'up':'down' ?>">Margin <?= $margin ?>%</span></div><div class="icon blue"><i class="fa-solid fa-chart-pie"></i></div></div>
</div>

<div class="grid-2">
  <div class="box"><h3>📊 Income vs Expense (<?= $year ?>)</h3><div class="chart-wrap"><canvas id="barChart"></canvas></div></div>
  <div class="box"><h3>🥧 Expense Breakdown</h3><div class="chart-wrap"><canvas id="pieChart"></canvas></div></div>
</div>

<div class="box" style="margin-top:20px;">
  <div class="tabs">
    <?php foreach (['all'=>'All','income'=>'Income','expense'=>'Expenses','salary'=>'Salaries','service'=>'Services'] as $k=>$v): ?>
      <button class="tab <?= $k==='all'?'active':'' ?>" data-tab="<?= $k ?>"><?= $v ?></button>
    <?php endforeach; ?>
  </div>
  <div class="toolbar">
    <div class="filters">
      <input id="txnSearch" placeholder="Search description, category...">
      <select id="filterCategory"><option value="">All Categories</option>
        <option>Booking</option><option>Restaurant</option><option>Service Charge</option><option>Salary</option>
        <option>Utility</option><option>Maintenance</option><option>Supplies</option><option>Marketing</option><option>Other</option>
      </select>
      <input type="month" id="filterMonth">
    </div>
    <div class="actions">
      <button class="btn btn-success btn-sm" onclick="openModal()"><i class="fa-solid fa-plus"></i> Add</button>
    </div>
  </div>
  <table id="txnTable"></table>
</div>

<div class="modal" id="txnModal">
  <div class="modal-content">
    <div class="modal-header"><h3 id="modalTitle">Add Transaction</h3><button class="close" onclick="closeModal()">&times;</button></div>
    <form id="txnForm">
      <input type="hidden" name="action" value="save"><input type="hidden" name="id" id="tId">
      <div class="form-group"><label>Type *</label>
        <select name="type" id="tType" required><option value="income">Income</option><option value="expense">Expense</option><option value="salary">Salary</option><option value="service">Service</option></select></div>
      <div class="form-group"><label>Category *</label>
        <select name="category" id="tCat" required><option>Booking</option><option>Restaurant</option><option>Service Charge</option><option>Salary</option><option>Utility</option><option>Maintenance</option><option>Supplies</option><option>Marketing</option><option>Other</option></select></div>
      <div class="form-group"><label>Description *</label><input name="description" id="tDesc" required></div>
      <div class="form-group"><label>Person/Vendor</label><input name="person" id="tPerson"></div>
      <div class="form-group"><label>Amount (৳) *</label><input type="number" step="0.01" name="amount" id="tAmt" required></div>
      <div class="form-group"><label>Method</label>
        <select name="method" id="tMethod"><option>Cash</option><option>bKash</option><option>Nagad</option><option>Card</option><option>Bank Transfer</option></select></div>
      <div class="form-group"><label>Date *</label><input type="date" name="txn_date" id="tDate" required></div>
      <div class="form-group"><label>Status</label>
        <select name="status" id="tStatus"><option>Paid</option><option>Pending</option><option>Failed</option></select></div>
      <button class="btn btn-primary"><i class="fa-solid fa-check"></i> Save Transaction</button>
    </form>
  </div>
</div>

<script>
let txns = <?= json_encode($txns) ?>;
let currentTab='all';
const fmt=n=>'৳'+Number(n||0).toLocaleString('en-IN');
const typeBadge=t=>({income:'b-green',expense:'b-red',salary:'b-purple',service:'b-cyan'}[t]||'b-gray');
const sBadge=s=>s==='Paid'?'b-green':s==='Pending'?'b-yellow':'b-red';

function render(){
  const s=$('txnSearch').value.toLowerCase(), c=$('filterCategory').value, m=$('filterMonth').value;
  const list=txns.filter(t=>{
    if(currentTab!=='all' && t.type!==currentTab) return false;
    if(c && t.category!==c) return false;
    if(m && !t.txn_date.startsWith(m)) return false;
    if(s && !((t.description+t.category+(t.person||'')).toLowerCase().includes(s))) return false;
    return true;
  });
  $('txnTable').innerHTML=`
    <thead><tr><th>ID</th><th>Date</th><th>Type</th><th>Category</th><th>Description</th><th>Method</th><th>Amount</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>${list.length?list.map(t=>`
      <tr><td>#${t.id}</td><td>${t.txn_date}</td>
        <td><span class="badge ${typeBadge(t.type)}">${t.type.toUpperCase()}</span></td>
        <td>${t.category}</td>
        <td>${t.description}<br><small style="color:#888">${t.person||'-'}</small></td>
        <td><span class="badge b-gray">${t.method}</span></td>
        <td class="${(t.type==='income'||t.type==='service')?'amount-in':'amount-out'}">
          ${(t.type==='income'||t.type==='service')?'+':'-'}${fmt(t.amount)}</td>
        <td><span class="badge ${sBadge(t.status)}">${t.status}</span></td>
        <td><button class="btn btn-sm btn-edit" onclick="editTxn(${t.id})"><i class="fa-solid fa-pen"></i></button>
          <button class="btn btn-sm btn-delete" onclick="delTxn(${t.id})"><i class="fa-solid fa-trash"></i></button></td>
      </tr>`).join(''):'<tr><td colspan="9" style="text-align:center;color:#888;padding:30px">No transactions</td></tr>'}</tbody>`;
}
document.querySelectorAll('.tab').forEach(t=>t.addEventListener('click',()=>{
  document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active'));
  t.classList.add('active'); currentTab=t.dataset.tab; render();
}));
['txnSearch','filterCategory','filterMonth'].forEach(id=>$(id).addEventListener('input',render));

function openModal(){ $('modalTitle').textContent='Add Transaction'; $('txnForm').reset(); $('tId').value=''; $('tDate').value=new Date().toISOString().slice(0,10); $('txnModal').classList.add('show'); }
function closeModal(){ $('txnModal').classList.remove('show'); }
function editTxn(id){
  const t=txns.find(x=>x.id==id); if(!t) return;
  $('modalTitle').textContent='Edit Transaction';
  $('tId').value=t.id; $('tType').value=t.type; $('tCat').value=t.category; $('tDesc').value=t.description;
  $('tPerson').value=t.person||''; $('tAmt').value=t.amount; $('tMethod').value=t.method;
  $('tDate').value=t.txn_date; $('tStatus').value=t.status; $('txnModal').classList.add('show');
}
async function delTxn(id){
  if(!confirm('Delete?')) return;
  const r=await api('payments.php',{action:'delete',id});
  if(r.ok){ txns=txns.filter(x=>x.id!=id); render(); toast('🗑 Deleted',true);} else toast(r.error,true);
}
$('txnForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const data=Object.fromEntries(new FormData(e.target));
  const r=await api('payments.php',data);
  if(!r.ok){ toast(r.error||'Failed',true); return; }
  if(data.id){ const i=txns.findIndex(x=>x.id==data.id); txns[i]={...txns[i],...data,id:+data.id}; toast('Updated'); }
  else { txns.unshift({...data,id:r.id}); toast('Added'); }
  closeModal(); render();
});
$('txnModal').addEventListener('click',e=>{ if(e.target.id==='txnModal') closeModal(); });

new Chart(document.getElementById('barChart'),{
  type:'bar',
  data:{labels:<?= json_encode($labels) ?>, datasets:[
    {label:'Income', data:<?= json_encode($incomeArr) ?>, backgroundColor:'#22c55e', borderRadius:4},
    {label:'Expense', data:<?= json_encode($expArr) ?>, backgroundColor:'#ef4444', borderRadius:4}
  ]},
  options:{maintainAspectRatio:false, plugins:{legend:{position:'bottom'}}}
});
new Chart(document.getElementById('pieChart'),{
  type:'doughnut',
  data:{ labels:<?= json_encode(array_column($pieData,'category')) ?>,
    datasets:[{ data:<?= json_encode(array_map('floatval',array_column($pieData,'v'))) ?>,
      backgroundColor:['#ef4444','#f59e0b','#3b82f6','#a855f7','#06b6d4','#22c55e','#ec4899','#8b5cf6'] }] },
  options:{maintainAspectRatio:false, plugins:{legend:{position:'bottom'}}}
});

render();
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
