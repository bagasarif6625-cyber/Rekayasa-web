@extends('admin.template')

@section('title', 'Data Users')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0">Data Users</h1>
        <button type="button" class="btn btn-primary" id="btn-add-user">Tambah User</button>
    </div>

    <div id="alert-container"></div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="users-table">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="user-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="user-modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="user-id">
                    <div class="mb-3">
                        <label class="form-label" for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="8">
                        <small class="text-muted" id="password-help">Minimal 8 karakter.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="role">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="" selected disabled>Pilih Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="user-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <style>
        #users-table_wrapper .dt-layout-row {
            align-items: center;
            margin: 0 0 1rem;
        }

        #users-table_wrapper .dt-layout-row:last-child {
            margin: 1rem 0 0;
        }

        #users-table_wrapper .dt-layout-cell {
            display: flex;
            align-items: center;
        }

        #users-table_wrapper .dt-layout-end {
            justify-content: flex-end;
        }

        #users-table_wrapper .dt-search input,
        #users-table_wrapper .dt-length select {
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
        }

        #users-table_wrapper .dt-search input {
            margin-left: 0.5rem;
        }

        #users-table_wrapper .dt-length select {
            margin-right: 0.35rem;
        }

        #users-table_wrapper .dt-paging-button {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            margin-left: 0.25rem;
            padding: 0.375rem 0.75rem;
        }

        #users-table_wrapper .dt-paging-button.current {
            background: #0d6efd;
            border-color: #0d6efd;
            color: #fff !important;
        }

        @media (max-width: 576px) {
            #users-table_wrapper .dt-layout-row {
                gap: 0.75rem;
            }

            #users-table_wrapper .dt-layout-cell {
                justify-content: flex-start;
            }
        }
    </style>
    <script>
        const apiHeaders = {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${API_TOKEN}`
        };

        const modalElement = document.getElementById('user-modal');
        const userModal = new bootstrap.Modal(modalElement);

        let usersDataTable = null;

        function showAlert(message, type = 'success') {
            document.getElementById('alert-container').innerHTML =
                `<div class="alert alert-${type} alert-dismissible fade show" role="alert">${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>`;
        }

        function escapeHtml(value) {
            return $('<div>').text(value ?? '').html();
        }

        async function loadUsers() {
            const response = await fetch('/api/users', { headers: apiHeaders });
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Gagal memuat data user.');
            }

            const rows = (result.data || []).map((user, index) => `
                <tr>
                    <td>${index + 1}</td>
                    <td>${escapeHtml(user.name)}</td>
                    <td>${escapeHtml(user.email)}</td>
                    <td>${escapeHtml(user.phone)}</td>
                    <td>${escapeHtml(user.address)}</td>
                    <td>${escapeHtml(user.role)}</td>
                    <td class="text-nowrap">
                        <button class="btn btn-warning btn-sm btn-edit" data-id="${user.id}">Edit</button>
                        <button class="btn btn-danger btn-sm btn-delete" data-id="${user.id}">Hapus</button>
                    </td>
                </tr>
            `).join('');

            if (usersDataTable) {
                usersDataTable.destroy();
                usersDataTable = null;
            }

            $('#users-table tbody').html(rows);
            usersDataTable = new DataTable('#users-table', {
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                layout: {
                    topStart: 'pageLength',
                    topEnd: 'search',
                    bottomStart: 'info',
                    bottomEnd: 'paging'
                },
                order: [[0, 'asc']],
                columnDefs: [
                    { orderable: false, targets: 6 }
                ],
                language: {
                    lengthMenu: '_MENU_ entries per page',
                    search: 'Search:',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    zeroRecords: 'Tidak ada data yang cocok.',
                    emptyTable: 'Belum ada data user.',
                    paginate: {
                        first: '«',
                        last: '»',
                        next: '›',
                        previous: '‹'
                    }
                }
            });
        }

        function openCreateModal() {
            document.getElementById('user-form').reset();
            document.getElementById('user-id').value = '';
            document.getElementById('password').required = true;
            document.getElementById('password-help').textContent = 'Wajib diisi. Minimal 8 karakter.';
            document.getElementById('user-modal-title').textContent = 'Tambah User';
            userModal.show();
        }

        async function openEditModal(id) {
            const response = await fetch(`/api/users/${id}`, { headers: apiHeaders });
            const result = await response.json();

            if (!response.ok) {
                showAlert(result.message || 'Gagal mengambil data user.', 'danger');
                return;
            }

            const user = result.data;
            document.getElementById('user-id').value = user.id;
            document.getElementById('name').value = user.name ?? '';
            document.getElementById('email').value = user.email ?? '';
            document.getElementById('password').value = '';
            document.getElementById('password').required = false;
            document.getElementById('password-help').textContent = 'Kosongkan jika tidak ingin mengubah password.';
            document.getElementById('phone').value = user.phone ?? '';
            document.getElementById('address').value = user.address ?? '';
            document.getElementById('role').value = user.role ?? '';
            document.getElementById('user-modal-title').textContent = 'Edit User';
            userModal.show();
        }

        document.getElementById('btn-add-user').addEventListener('click', openCreateModal);

        document.getElementById('users-table').addEventListener('click', async (event) => {
            const editButton = event.target.closest('.btn-edit');
            const deleteButton = event.target.closest('.btn-delete');

            if (editButton) {
                await openEditModal(editButton.dataset.id);
            }

            if (deleteButton && confirm('Hapus user ini?')) {
                const response = await fetch(`/api/users/${deleteButton.dataset.id}`, {
                    method: 'DELETE',
                    headers: apiHeaders
                });
                const result = await response.json();

                if (!response.ok) {
                    showAlert(result.message || 'Gagal menghapus user.', 'danger');
                    return;
                }

                showAlert(result.message);
                await loadUsers();
            }
        });

        document.getElementById('user-form').addEventListener('submit', async (event) => {
            event.preventDefault();
            const id = document.getElementById('user-id').value;
            const payload = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                role: document.getElementById('role').value
            };
            const password = document.getElementById('password').value;
            if (password) payload.password = password;

            const submitButton = document.getElementById('user-submit');
            submitButton.disabled = true;

            try {
                const response = await fetch(id ? `/api/users/${id}` : '/api/users', {
                    method: id ? 'PUT' : 'POST',
                    headers: apiHeaders,
                    body: JSON.stringify(payload)
                });
                const result = await response.json();

                if (!response.ok) {
                    const errors = result.errors ? Object.values(result.errors).flat().join('<br>') : (result.message || 'Gagal menyimpan user.');
                    showAlert(errors, 'danger');
                    return;
                }

                userModal.hide();
                showAlert(result.message);
                await loadUsers();
            } finally {
                submitButton.disabled = false;
            }
        });

        loadUsers().catch((error) => showAlert(error.message, 'danger'));
    </script>
@endsection
