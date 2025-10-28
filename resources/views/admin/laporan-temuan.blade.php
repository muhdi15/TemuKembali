@extends('admin.layout')

@section('title', 'Laporan Temuan')
@section('page-title', 'Manajemen Laporan Temuan')

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
            <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Daftar Laporan Temuan</h5>
            <button class="btn btn-light btn-sm text-maroon fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle"></i> Tambah Laporan
            </button>
        </div>
        <div class="card-body">
            @if($laporan->isEmpty())
                <p class="text-center text-muted mb-0">Belum ada laporan temuan.</p>
            @else
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Lokasi Temuan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $i => $data)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $data->nama_barang }}</td>
                            <td>{{ $data->kategori }}</td>
                            <td>{{ $data->lokasi_temuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_temuan)->format('d M Y') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $data->status == 'pending' ? 'bg-warning text-dark' : 
                                       ($data->status == 'terverifikasi' ? 'bg-success' : 'bg-secondary') }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td>
                                @if($data->foto)
                                    <img src="{{ asset('storage/'.$data->foto) }}" width="60" class="rounded">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-maroon" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id_laporan_temuan }}"><i class="bi bi-pencil-square"></i></button>
                                <form action="{{ route('admin.laporan-temuan.delete', $data->id_laporan_temuan) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus laporan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $data->id_laporan_temuan }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0 shadow-sm">
                                    <div class="modal-header bg-maroon text-white">
                                        <h5 class="modal-title"><i class="bi bi-pencil"></i> Edit Laporan</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.laporan-temuan.update', $data->id_laporan_temuan) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Nama Barang</label>
                                                    <input type="text" name="nama_barang" value="{{ $data->nama_barang }}" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Lokasi Temuan</label>
                                                    <input type="text" name="lokasi_temuan" value="{{ $data->lokasi_temuan }}" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Tanggal Temuan</label>
                                                    <input type="date" name="tanggal_temuan" value="{{ $data->tanggal_temuan }}" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Kategori</label>
                                                    <select name="kategori" class="form-select" required>
                                                        <option {{ $data->kategori=='Elektronik'?'selected':'' }}>Elektronik</option>
                                                        <option {{ $data->kategori=='Kendaraan'?'selected':'' }}>Kendaraan</option>
                                                        <option {{ $data->kategori=='Dokumen'?'selected':'' }}>Dokumen</option>
                                                        <option {{ $data->kategori=='Pakaian'?'selected':'' }}>Pakaian</option>
                                                        <option {{ $data->kategori=='Tas'?'selected':'' }}>Tas</option>
                                                        <option {{ $data->kategori=='Kunci'?'selected':'' }}>Kunci</option>
                                                        <option {{ $data->kategori=='Lainnya'?'selected':'' }}>Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label>Deskripsi</label>
                                                    <textarea name="deskripsi" rows="5" class="form-control">{{ $data->deskripsi }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Status</label>
                                                    <select name="status" class="form-select">
                                                        <option value="pending" {{ $data->status=='pending'?'selected':'' }}>Pending</option>
                                                        <option value="terverifikasi" {{ $data->status=='terverifikasi'?'selected':'' }}>Terverifikasi</option>
                                                        <option value="ditutup" {{ $data->status=='ditutup'?'selected':'' }}>Ditutup</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Ganti Foto</label>
                                                    <input type="file" name="foto" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button class="btn btn-maroon text-white" type="submit">Simpan Perubahan</button>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-maroon text-white">
                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Laporan Temuan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.laporan-temuan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Lokasi Temuan</label>
                            <input type="text" name="lokasi_temuan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Temuan</label>
                            <input type="date" name="tanggal_temuan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option>Elektronik</option>
                                <option>Kendaraan</option>
                                <option>Dokumen</option>
                                <option>Pakaian</option>
                                <option>Tas</option>
                                <option>Kunci</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Foto Barang (opsional)</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-maroon text-white" type="submit">Simpan</button>
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
