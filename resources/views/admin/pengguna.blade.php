@extends('admin.layout')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-maroon text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-people me-2"></i>Daftar Pengguna</h5>
            <button class="btn btn-light btn-sm text-maroon fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-person-plus"></i> Tambah Pengguna
            </button>
        </div>
        <div class="card-body">
            @if($pengguna->isEmpty())
                <p class="text-center text-muted mb-0">Belum ada data pengguna.</p>
            @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Tanggal Buat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengguna as $i => $user)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>
                            <td><span class="badge {{ $user->role == 'admin' ? 'bg-danger' : 'bg-secondary' }}">{{ ucfirst($user->role) }}</span></td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-maroon" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id_pengguna }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.pengguna.delete', $user->id_pengguna) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus pengguna ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $user->id_pengguna }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 shadow-sm">
                                    <div class="modal-header bg-maroon text-white">
                                        <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Pengguna</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.pengguna.update', $user->id_pengguna) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Username</label>
                                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password Baru (opsional)</label>
                                                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="role" class="form-select">
                                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-maroon text-white">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-maroon text-white">
                <h5 class="modal-title"><i class="bi bi-person-plus"></i> Tambah Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.pengguna.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-maroon text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-maroon { background-color: #c46a78 !important; }
.text-maroon { color: #9b1b30 !important; }
.btn-maroon { background-color: #c46a78; border: none; }
.btn-maroon:hover { background-color: #a84157; }
.btn-outline-maroon { border: 1px solid #c46a78; color: #9b1b30; }
.btn-outline-maroon:hover { background-color: #c46a78; color: #fff; }
</style>
@endpush
@endsection
