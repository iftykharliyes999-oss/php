<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Users - Hotel Admin Pro</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assact/stylea.css">

</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>🏨 LISORA GRAND</h2>

        <a href="dashboard.php"><i class="fa-solid fa-grid"></i> Dashboard</a>
        <a href="users.php" class="active"><i class="fa-solid fa-user"></i> Users</a>
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
            <h2>User Management</h2>
            <input class="search" placeholder="Search user, email, role...">
            <div>👤 Admin</div>
        </div>

        <!-- KPI -->
        <div class="kpi">

            <div class="card">
                <div>
                    <small>Total Users</small>
                    <h3 id="kpiTotal">0</h3>
                </div>
                <div class="icon blue"><i class="fa-solid fa-users"></i></div>
            </div>

            <div class="card">
                <div>
                    <small>Active</small>
                    <h3 id="kpiActive">0</h3>
                </div>
                <div class="icon green"><i class="fa-solid fa-user-check"></i></div>
            </div>

            <div class="card">
                <div>
                    <small>Managers</small>
                    <h3 id="kpiManager">0</h3>
                </div>
                <div class="icon yellow"><i class="fa-solid fa-user-tie"></i></div>
            </div>

            <div class="card">
                <div>
                    <small>Inactive</small>
                    <h3 id="kpiInactive">0</h3>
                </div>
                <div class="icon red"><i class="fa-solid fa-user-slash"></i></div>
            </div>

        </div>

        <!-- GRID -->
        <div class="grid">

            <!-- LEFT: ADD USER FORM -->
            <div class="box">
                <h3><i class="fa-solid fa-user-plus"></i> Add New User</h3>

                <form id="addUserForm">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="fName" placeholder="e.g. Rahim Uddin" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="fEmail" placeholder="user@hotel.com" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" id="fPhone" placeholder="+880 1XXX-XXXXXX">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select id="fRole" required>
                            <option value="">-- Select Role --</option>
                            <option value="Manager">Manager</option>
                            <option value="Moderator">Moderator</option>
                            <option value="Receptionist">Receptionist</option>
                            <option value="Housekeeping">Housekeeping</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="fPass" placeholder="Set a password" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="fStatus">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add User
                    </button>

                </form>

            </div>

            <!-- RIGHT: USER LIST -->
            <div class="box">
                <h3><i class="fa-solid fa-list"></i> Users List</h3>

                <div class="toolbar">
                    <div class="filters">
                        <input type="text" id="searchInput" placeholder="🔍 Search by name or email...">
                        <select id="filterRole">
                            <option value="">All Roles</option>
                            <option>Manager</option>
                            <option>Moderator</option>
                            <option>Receptionist</option>
                            <option>Housekeeping</option>
                        </select>
                        <select id="filterStatus">
                            <option value="">All Status</option>
                            <option>Active</option>
                            <option>Inactive</option>
                        </select>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Role</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTable">
                    </tbody>
                </table>

            </div>

        </div>

    </div>

    <!-- EDIT MODAL -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit User</h3>
                <button class="close" onclick="closeModal()">&times;</button>
            </div>

            <form id="editForm">
                <input type="hidden" id="eId">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" id="eName" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="eEmail" required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" id="ePhone">
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <select id="eRole" required>
                        <option>Manager</option>
                        <option>Moderator</option>
                        <option>Receptionist</option>
                        <option>Housekeeping</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select id="eStatus">
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Changes
                </button>
            </form>

        </div>
    </div>

    <!-- TOAST -->
    <div class="toast" id="toast">Action completed!</div>

    <script>
        /* DEMO DATA (database pore connect korbo) */
        let users = [{
                id: 1,
                name: "Rahim Uddin",
                email: "rahim@lisora.com",
                phone: "+880 1711-111111",
                role: "Manager",
                status: "Active",
                joined: "2025-01-12"
            },
            {
                id: 2,
                name: "Karim Hasan",
                email: "karim@lisora.com",
                phone: "+880 1822-222222",
                role: "Moderator",
                status: "Active",
                joined: "2025-02-08"
            },
            {
                id: 3,
                name: "Sabbir Ahmed",
                email: "sabbir@lisora.com",
                phone: "+880 1933-333333",
                role: "Receptionist",
                status: "Inactive",
                joined: "2025-03-15"
            },
            {
                id: 4,
                name: "Nusrat Jahan",
                email: "nusrat@lisora.com",
                phone: "+880 1644-444444",
                role: "Housekeeping",
                status: "Active",
                joined: "2025-04-02"
            },
            {
                id: 5,
                name: "Tanvir Khan",
                email: "tanvir@lisora.com",
                phone: "+880 1555-555555",
                role: "Manager",
                status: "Active",
                joined: "2025-04-22"
            }
        ];

        const roleColors = {
            "Manager": "purple",
            "Moderator": "blue",
            "Receptionist": "yellow",
            "Housekeeping": "green"
        };

        function initial(name) {
            return name.split(" ").map(n => n[0]).slice(0, 2).join("").toUpperCase();
        }

        function avatarColor(name) {
            const colors = ["#2563eb", "#22c55e", "#eab308", "#ef4444", "#a855f7", "#0ea5e9"];
            let h = 0;
            for (let c of name) h = (h + c.charCodeAt(0)) % colors.length;
            return colors[h];
        }

        function render() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const fRole = document.getElementById('filterRole').value;
            const fStatus = document.getElementById('filterStatus').value;

            const filtered = users.filter(u => {
                const matchSearch = u.name.toLowerCase().includes(search) || u.email.toLowerCase().includes(search);
                const matchRole = !fRole || u.role === fRole;
                const matchStatus = !fStatus || u.status === fStatus;
                return matchSearch && matchRole && matchStatus;
            });

            const tbody = document.getElementById('userTable');
            tbody.innerHTML = '';

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;padding:30px;color:#888;">No users found</td></tr>';
            }

            filtered.forEach(u => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
            <td>
                <div class="user-cell">
                    <div class="avatar" style="background:${avatarColor(u.name)}">${initial(u.name)}</div>
                    <div class="user-info">
                        <b>${u.name}</b>
                        <small>${u.email}</small>
                    </div>
                </div>
            </td>
            <td><span class="badge ${roleColors[u.role]||'blue'}">${u.role}</span></td>
            <td>${u.phone||'-'}</td>
            <td><span class="badge ${u.status==='Active'?'green':'red'}">${u.status}</span></td>
            <td>${u.joined}</td>
            <td>
                <div class="actions">
                    <button class="btn btn-sm btn-edit" onclick="editUser(${u.id})"><i class="fa-solid fa-pen"></i></button>
                    <button class="btn btn-sm btn-delete" onclick="deleteUser(${u.id})"><i class="fa-solid fa-trash"></i></button>
                </div>
            </td>
        `;
                tbody.appendChild(tr);
            });

            updateKPI();
        }

        function updateKPI() {
            document.getElementById('kpiTotal').innerText = users.length;
            document.getElementById('kpiActive').innerText = users.filter(u => u.status === 'Active').length;
            document.getElementById('kpiManager').innerText = users.filter(u => u.role === 'Manager').length;
            document.getElementById('kpiInactive').innerText = users.filter(u => u.status === 'Inactive').length;
        }

        function showToast(msg, color = '#22c55e') {
            const t = document.getElementById('toast');
            t.innerText = msg;
            t.style.background = color;
            t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), 2200);
        }

        /* ADD */
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const newUser = {
                id: users.length ? Math.max(...users.map(u => u.id)) + 1 : 1,
                name: document.getElementById('fName').value.trim(),
                email: document.getElementById('fEmail').value.trim(),
                phone: document.getElementById('fPhone').value.trim(),
                role: document.getElementById('fRole').value,
                status: document.getElementById('fStatus').value,
                joined: new Date().toISOString().split('T')[0]
            };

            if (users.some(u => u.email === newUser.email)) {
                showToast('Email already exists!', '#ef4444');
                return;
            }

            users.push(newUser);
            render();
            this.reset();
            showToast('✔ User added successfully!');
        });

        /* DELETE */
        function deleteUser(id) {
            if (!confirm('Are you sure you want to delete this user?')) return;
            users = users.filter(u => u.id !== id);
            render();
            showToast('🗑 User deleted', '#ef4444');
        }

        /* EDIT */
        function editUser(id) {
            const u = users.find(x => x.id === id);
            if (!u) return;

            document.getElementById('eId').value = u.id;
            document.getElementById('eName').value = u.name;
            document.getElementById('eEmail').value = u.email;
            document.getElementById('ePhone').value = u.phone;
            document.getElementById('eRole').value = u.role;
            document.getElementById('eStatus').value = u.status;

            document.getElementById('editModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('show');
        }

        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = parseInt(document.getElementById('eId').value);
            const u = users.find(x => x.id === id);
            if (!u) return;

            u.name = document.getElementById('eName').value.trim();
            u.email = document.getElementById('eEmail').value.trim();
            u.phone = document.getElementById('ePhone').value.trim();
            u.role = document.getElementById('eRole').value;
            u.status = document.getElementById('eStatus').value;

            closeModal();
            render();
            showToast('✔ User updated!');
        });

        /* FILTERS */
        document.getElementById('searchInput').addEventListener('input', render);
        document.getElementById('filterRole').addEventListener('change', render);
        document.getElementById('filterStatus').addEventListener('change', render);

        /* CLOSE MODAL ON BACKDROP */
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        render();
    </script>

</body>

</html>