@extends('layouts.admin')

@section('title', 'Users Management - CourseHub')

@section('content')
<div class="container py-5">

    <!-- Header & Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <small class="text-primary fw-bold text-uppercase">ADMIN PANEL</small>
            <h1 class="fw-bold mt-1 mb-0">Users Management</h1>
            <p class="text-secondary fs-6 mb-0">Manage roles, permissions, and accounts of all platform members.</p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                <i class="bi bi-people me-1"></i> Users
            </a>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-book me-1"></i> Courses
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-tags me-1"></i> Categories
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-star me-1"></i> Reviews
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Mini Stats Pills -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-muted fw-bold">All Users</small>
                    <h4 class="fw-bold mb-0">{{ $rolesCount['all'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users.index', ['role' => 'student']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-primary fw-bold">Students</small>
                    <h4 class="fw-bold text-primary mb-0">{{ $rolesCount['students'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users.index', ['role' => 'teacher']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-success fw-bold">Teachers</small>
                    <h4 class="fw-bold text-success mb-0">{{ $rolesCount['teachers'] }}</h4>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
                    <small class="text-danger fw-bold">Admins</small>
                    <h4 class="fw-bold text-danger mb-0">{{ $rolesCount['admins'] }}</h4>
                </div>
            </a>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-people-fill text-primary me-2"></i>Users List
            </h5>

            <!-- Search & Filter Form -->
            <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2 col-md-6">
                @if(request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by name or email..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-primary px-3">Search</button>
                @if(request('search') || request('role'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-light border">Reset</a>
                @endif
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Joined At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-muted fw-bold">#{{ $user->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="text-muted small">{{ $user->email }}</div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role === 'teacher')
                                    <span class="badge bg-success">Teacher</span>
                                @else
                                    <span class="badge bg-primary">Student</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- زر تعديل الرتبة -->
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-warning edit-role-btn"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-role="{{ $user->role }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editRoleModal"
                                            title="Change Role">
                                        <i class="bi bi-shield-lock"></i>
                                    </button>

                                    <!-- زر الحذف -->
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-muted border">Current</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4 d-flex justify-content-end">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- Modal تعديل رتبة المستخدم -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form id="editRoleForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-shield-lock text-warning me-2"></i>Change User Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-secondary small mb-3">
                        Updating role for: <strong id="modalUserName" class="text-dark"></strong>
                    </p>
                    <div class="mb-3">
                        <label for="modalRoleSelect" class="form-label text-muted fw-semibold">Select New Role</label>
                        <select name="role" id="modalRoleSelect" class="form-select" required>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Save Role</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.querySelectorAll('.edit-role-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const name = this.getAttribute('data-name');
        const role = this.getAttribute('data-role');

        document.getElementById('modalUserName').innerText = name;
        document.getElementById('modalRoleSelect').value = role;
        document.getElementById('editRoleForm').action = `/admin/users/${id}`;
    });
});
</script>
@endsection
@endsection