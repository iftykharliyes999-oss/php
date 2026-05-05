<?php
require __DIR__.'/includes/db.php';
$PAGE_TITLE='Users'; $ACTIVE='users';

// AJAX actions
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $a = $_POST['action'] ?? '';
    try {
        if ($a==='add') {
            q($conn,"INSERT INTO users (name,email,phone,role,password,status,joined) VALUES (?,?,?,?,?,?,CURDATE())",
              [$_POST['name'],$_POST['email'],$_POST['phone']??'',$_POST['role'],hash('sha256',$_POST['password']),$_POST['status']??'Active']);
            jsonOut(['ok'=>true,'id'=>$conn->insert_id]);
        }
        if ($a==='update') {
            q($conn,"UPDATE users SET name=?,email=?,phone=?,role=?,status=? WHERE id=?",
              [$_POST['name'],$_POST['email'],$_POST['phone']??'',$_POST['role'],$_POST['status'],(int)$_POST['id']],
              'sssssi');
            jsonOut(['ok'=>true]);
        }
        if ($a==='delete') {
            q($conn,"DELETE FROM users WHERE id=?", [(int)$_POST['id']], 'i');
            jsonOut(['ok'=>true]);
        }
        jsonOut(['ok'=>false,'error'=>'unknown action'],400);
    } catch (Throwable $e) { jsonOut(['ok'=>false,'error'=>$e->getMessage()],500); }
}

$users = fetchAll($conn,"SELECT * FROM users ORDER BY id DESC");
$kpiTotal    = count($users);
$kpiActive   = count(array_filter($users, fn($u)=>$u['status']==='Active'));
$kpiManager  = count(array_filter($users, fn($u)=>$u['role']==='Manager'));
$kpiInactive = count(array_filter($users, fn($u)=>$u['status']==='Inactive'));

include __DIR__.'/includes/header.php';
?>
<div class="topbar">
  <h2>👥 User Management</h2>
  <input class="search" id="globalSearch" placeholder="Search user, email, role...">
  <div>👤 Admin</div>
</div>

<div class="kpi">
  <div class="card"><div><small>Total Users</small><h3><?= $kpiTotal ?></h3></div><div class="icon blue"><i class="fa-solid fa-users"></i></div></div>
  <div class="card"><div><small>Active</small><h3><?= $kpiActive ?></h3></div><div class="icon green"><i class="fa-solid fa-user-check"></i></div></div>
  <div class="card"><div><small>Managers</small><h3><?= $kpiManager ?></h3></div><div class="icon yellow"><i class="fa-solid fa-user-tie"></i></div></div>
  <div class="card"><div><small>Inactive</small><h3><?= $kpiInactive ?></h3></div><div class="icon red"><i class="fa-solid fa-user-slash"></i></div></div>
</div>

<div class="grid-form">
  <div class="box">
    <h3><i class="fa-solid fa-user-plus"></i> Add New User</h3>
    <form id="addUserForm">
      <input type="hidden" name="action" value="add">
      <div class="form-group"><label>Full Name</label><input name="name" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
      <div class="form-group"><label>Phone</label><input name="phone" placeholder="+880 1XXX..."></div>
      <div class="form-group"><label>Role</label>
        <select name="role" required>
          <option value="">-- Select Role --</option>
          <option>Manager</option><option>Moderator</option><option>Receptionist</option><option>Housekeeping</option>
        </select></div>
      <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
      <div class="form-group"><label>Status</label>
        <select name="status"><option>Active</option><option>Inactive</option></select></div>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add User</button>
    </form>
  </div>

  <div class="box">
    <h3><i class="fa-solid fa-list"></i> Users List</h3>
    <div class="toolbar">
      <div class="filters">
        <input id="searchInput" placeholder="🔍 Search by name or email...">
        <select id="filterRole"><option value="">All Roles</option><option>Manager</option><option>Moderator</option><option>Receptionist</option><option>Housekeeping</option></select>
        <select id="filterStatus"><option value="">All Status</option><option>Active</option><option>Inactive</option></select>
      </div>
    </div>
    <table>
      <thead><tr><th>User</th><th>Role</th><th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th></tr></thead>
      <tbody id="userTable"></tbody>
    </table>
  </div>
</div>

<div class="modal" id="editModal">
  <div class="modal-content">
    <div class="modal-header"><h3>Edit User</h3><button class="close" onclick="closeModal()">&times;</button></div>
    <form id="editForm">
      <input type="hidden" name="action" value="update">
      <input type="hidden" name="id" id="eId">
      <div class="form-group"><label>Full Name</label><input name="name" id="eName" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" id="eEmail" required></div>
      <div class="form-group"><label>Phone</label><input name="phone" id="ePhone"></div>
      <div class="form-group"><label>Role</label>
        <select name="role" id="eRole" required><option>Manager</option><option>Moderator</option><option>Receptionist</option><option>Housekeeping</option></select></div>
      <div class="form-group"><label>Status</label>
        <select name="status" id="eStatus"><option>Active</option><option>Inactive</option></select></div>
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save Changes</button>
    </form>
  </div>
</div>

<script>
let users = <?= json_encode($users) ?>;
const roleColors={"Manager":"purple","Moderator":"blue","Receptionist":"yellow","Housekeeping":"green"};

function render(){
  const s=$('searchInput').value.toLowerCase(), fr=$('filterRole').value, fs=$('filterStatus').value;
  const list = users.filter(u=>(!s || (u.name+u.email).toLowerCase().includes(s)) && (!fr||u.role===fr) && (!fs||u.status===fs));
  const tb=$('userTable'); tb.innerHTML='';
  if(!list.length){ tb.innerHTML='<tr><td colspan="6" style="text-align:center;padding:30px;color:#888;">No users found</td></tr>'; return; }
  list.forEach(u=>{
    const tr=document.createElement('tr');
    tr.innerHTML=`<td><div class="user-cell"><div class="avatar" style="background:${avColor(u.name)}">${initials(u.name)}</div>
        <div class="user-info"><b>${u.name}</b><small>${u.email}</small></div></div></td>
      <td><span class="badge ${roleColors[u.role]||'blue'}">${u.role}</span></td>
      <td>${u.phone||'-'}</td>
      <td><span class="badge ${u.status==='Active'?'green':'red'}">${u.status}</span></td>
      <td>${u.joined||'-'}</td>
      <td><div class="actions">
        <button class="btn btn-sm btn-edit" onclick='editUser(${u.id})'><i class="fa-solid fa-pen"></i></button>
        <button class="btn btn-sm btn-delete" onclick='delUser(${u.id})'><i class="fa-solid fa-trash"></i></button>
      </div></td>`;
    tb.appendChild(tr);
  });
}
function editUser(id){
  const u=users.find(x=>x.id==id); if(!u) return;
  eId.value=u.id; eName.value=u.name; eEmail.value=u.email; ePhone.value=u.phone||''; eRole.value=u.role; eStatus.value=u.status;
  $('editModal').classList.add('show');
}
function closeModal(){ $('editModal').classList.remove('show'); }
async function delUser(id){
  if(!confirm('Delete this user?')) return;
  const r=await api('users.php',{action:'delete',id});
  if(r.ok){ users=users.filter(u=>u.id!=id); render(); toast('🗑 User deleted',true);} else toast(r.error||'Failed',true);
}
$('addUserForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const fd=new FormData(e.target); const data=Object.fromEntries(fd);
  const r=await api('users.php',data);
  if(r.ok){ data.id=r.id; data.joined=new Date().toISOString().slice(0,10); users.unshift(data); render(); e.target.reset(); toast('✔ User added!'); }
  else toast(r.error||'Failed',true);
});
$('editForm').addEventListener('submit', async e=>{
  e.preventDefault();
  const fd=new FormData(e.target); const data=Object.fromEntries(fd);
  const r=await api('users.php',data);
  if(r.ok){ const u=users.find(x=>x.id==data.id); Object.assign(u,data); closeModal(); render(); toast('✔ User updated!'); }
  else toast(r.error||'Failed',true);
});
['searchInput','filterRole','filterStatus'].forEach(id=>$(id).addEventListener('input',render));
$('editModal').addEventListener('click',e=>{ if(e.target.id==='editModal') closeModal(); });
render();
</script>
<?php include __DIR__.'/includes/footer.php'; ?>
