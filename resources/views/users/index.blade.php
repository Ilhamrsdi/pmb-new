@extends('layouts.master')
@section('title')
    @lang('DATA USER')
@endsection
@section('content')
    {{-- Assuming 'components.breadcrumb' is correctly available --}}
    @component('components.breadcrumb')
        @slot('li_1')
            Data Master
        @endslot
        @slot('title')
            Master Data User
        @endslot
    @endcomponent

    {{-- Session Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h6 class="alert-heading">Validation Error:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Manajemen Data Pengguna</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="userList">
                        <div class="row g-4 mb-3">
                            <div class="col-sm-auto">
                                <div>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#createModal">
                                        <i class="ri-add-line align-bottom me-1"></i>
                                        Tambah Pengguna Baru
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="d-flex justify-content-sm-end">
                                    <div class="search-box ms-2">
                                        <input type="text" class="form-control search" placeholder="Cari pengguna...">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================================================================= --}}
                        {{-- START: PERUBAHAN TAMPILAN JADI CARD VIEW (GRID) --}}
                        {{-- ================================================================= --}}

                        <div class="row list form-check-all g-3 mt-3">
                            {{-- Loop through users (assuming $users is passed from controller) --}}
                            @forelse($users as $index => $row)
                                <div class="col-xl-4 col-md-6 user-item">
                                    <div class="card shadow-sm border-secondary border rounded-3 h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-4">
                                                <div class="flex-shrink-0 me-3">
                                                    {{-- Placeholder avatar/icon based on first letter of username --}}
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-info-subtle text-info rounded-circle fs-3">
                                                            {{ strtoupper(substr($row->username, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 overflow-hidden">
                                                    {{-- Index number, kept for List.js compatibility, hidden from display --}}
                                                    <span class="no d-none">{{ $index + 1 }}</span>
                                                    <h5 class="username text-truncate mb-0">{{ $row->username }}</h5>
                                                    <p class="text-muted mb-0"><i class="ri-mail-line align-bottom me-1"></i> <span class="email">{{ $row->email }}</span></p>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-primary-subtle text-primary fs-12 roles">{{ $row->role->name ?? $row->role->role ?? 'N/A' }}</span>
                                                <div class="action-buttons d-flex gap-2">
                                                    <!-- Tombol Edit -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-warning btn-icon waves-effect waves-light rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $row->id }}">
                                                        <i class="ri-pencil-line"></i>
                                                    </button>

                                                    <!-- Tombol Delete -->
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger btn-icon waves-effect waves-light rounded-pill"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteRecordModal{{ $row->id }}">
                                                        <i class="ri-delete-bin-fill"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="card shadow-lg p-5">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                            </lord-icon>
                                            <h5 class="mt-2">Data Pengguna Kosong</h5>
                                            <p class="text-muted mb-0">Silakan tambahkan pengguna baru.</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse

                            {{-- Placeholder for No Result Message (Used by List.js) --}}
                            <div class="col-12 noresult" style="display: none">
                                <div class="card shadow-lg p-5">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                        </lord-icon>
                                        <h5 class="mt-2">Maaf! Hasil Tidak Ditemukan</h5>
                                        <p class="text-muted mb-0">Kami tidak menemukan data yang cocok dengan pencarian Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ================================================================= --}}
                        {{-- END: PERUBAHAN TAMPILAN JADI CARD VIEW (GRID) --}}
                        {{-- ================================================================= --}}


                        <div class="d-flex justify-content-end mt-4">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div>
    <!-- end row -->


    <!-- ======================= MODAL CREATE (Role selection fixed) ======================= -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success p-3">
                    <h5 class="modal-title text-white" id="createModalLabel">Tambah Pengguna Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ old('username') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="text-muted">Password minimal 8 karakter.</small>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label">Role</label>
                            {{-- ASSUMPTION: $roles variable containing all available roles is passed from controller --}}
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Pilih Role</option>
                                @isset($roles)
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name ?? $role->role }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End Modal Create --}}


    <!-- ======================= MODAL EDIT & DELETE (Loop) ======================= -->
    @foreach ($users as $row)
        <!-- Modal Edit -->
        <div class="modal fade" id="editModal{{ $row->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $row->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-warning p-3">
                        <h5 class="modal-title text-white" id="editModalLabel{{ $row->id }}">Edit User:
                            {{ $row->username }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.update', $row->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username', $row->username) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $row->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password_edit" class="form-label">Password Baru (Kosongkan jika tidak ingin
                                    merubah)</label>
                                <input type="password" class="form-control" id="password_edit" name="password">
                                <small class="text-muted">Isi hanya jika Anda ingin mengganti password.</small>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation_edit" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="password_confirmation_edit"
                                    name="password_confirmation">
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                {{-- ASSUMPTION: $roles variable containing all available roles is passed from controller --}}
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Pilih Role</option>
                                    @isset($roles)
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $row->role_id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name ?? $role->role }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-warning">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade zoomIn" id="deleteRecordModal{{ $row->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5">
                        <div class="mt-2 text-center">
                            <i class="ri-delete-bin-line display-5 text-danger"></i>
                            <h4 class="mt-2">Anda Yakin?</h4>
                            <p class="text-muted mx-4 mb-0">Anda akan menghapus pengguna <strong>{{ $row->username }}</strong>
                                secara permanen.</p>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('users.destroy', $row->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn w-sm btn-danger">Yes, Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- End Modal Loop --}}
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/prismjs/prism.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.js/list.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/list.pagination.js/list.pagination.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var userList = new List('userList', {
                // Perubahan: Menargetkan elemen 'user-item' di grid layout
                listClass: 'list',
                valueNames: [
                    'no', // Digunakan untuk urutan/List.js internal
                    'username',
                    'email',
                    'roles'
                ],
                item: 'user-item', // Memberitahu List.js untuk mencari item dengan class ini
                page: 9, // Mengubah menjadi 9 item per halaman agar pas dalam grid (3x3)
                pagination: true
            });

            // Logic to handle 'No Result' message
            userList.on('updated', function(list) {
                // Menampilkan/menyembunyikan elemen noresult di dalam grid
                const noResultElement = document.querySelector('#userList .noresult');
                if (list.matchingItems.length > 0) {
                    noResultElement.style.display = 'none';
                } else {
                    noResultElement.style.display = 'block';
                }
            });
        });
    </script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection