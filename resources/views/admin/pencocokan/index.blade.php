@extends('admin.layout')

@section('title', 'Pencocokan Data')
@section('page-title', 'Pencocokan Data Barang')

@section('content')
<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- REKOMENDASI OTOMATIS --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-maroon text-white">
            <h5 class="mb-0"><i class="bi bi-stars me-2"></i>Rekomendasi Otomatis Sistem</h5>
        </div>
        <div class="card-body">
            @if(empty($rekomendasi))
                <p class="text-muted text-center mb-0">Belum ada kecocokan yang ditemukan.</p>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Barang Hilang</th>
                            <th>Barang Temuan</th>
                            <th>Kategori</th>
                            <th>Skor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekomendasi as $i => $r)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $r['hilang']->nama_barang }}</td>
                            <td>{{ $r['temuan']->nama_barang }}</td>
                            <td>{{ $r['hilang']->kategori }}</td>
                            <td><span class="badge bg-success">{{ $r['skor'] }}%</span></td>
                            <td>
                                <a href="{{ route('admin.pencocokan.detail', [$r['hilang']->id_laporan_hilang, $r['temuan']->id_laporan_temuan]) }}" class="btn btn-sm btn-outline-maroon">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <form action="{{ route('admin.pencocokan.simpan') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id_laporan_hilang" value="{{ $r['hilang']->id_laporan_hilang }}">
                                    <input type="hidden" name="id_laporan_temuan" value="{{ $r['temuan']->id_laporan_temuan }}">
                                    <input type="hidden" name="hasil_pencocokan" value="cocok">
                                    <button type="submit" class="btn btn-sm btn-maroon text-white"><i class="bi bi-check-circle"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    {{-- Pencocokan Manual --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-maroon text-white">
            <h5 class="mb-0"><i class="bi bi-hand-index-thumb me-2"></i>Pencocokan Manual</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pencocokan.simpan') }}" method="POST" class="row g-3 mb-4">
                @csrf
                <div class="col-md-4">
                    <label class="form-label">Laporan Kehilangan</label>
                    <select name="id_laporan_hilang" class="form-select" required>
                        <option value="">Pilih...</option>
                        @foreach($laporanHilang as $h)
                            <option value="{{ $h->id_laporan_hilang }}">{{ $h->nama_barang }} - {{ $h->lokasi_hilang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Laporan Temuan</label>
                    <select name="id_laporan_temuan" class="form-select" required>
                        <option value="">Pilih...</option>
                        @foreach($laporanTemuan as $t)
                            <option value="{{ $t->id_laporan_temuan }}">{{ $t->nama_barang }} - {{ $t->lokasi_temuan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Hasil</label>
                    <select name="hasil_pencocokan" class="form-select">
                        <option value="cocok">Cocok</option>
                        <option value="tidak">Tidak</option>
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-maroon text-white"><i class="bi bi-plus-circle"></i> Tambah</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Barang Hilang</th>
                            <th>Barang Temuan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pencocokanManual as $i => $p)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $p->laporanHilang->nama_barang ?? '-' }}</td>
                            <td>{{ $p->laporanTemuan->nama_barang ?? '-' }}</td>
                            <td>
                                @if($p->status == 'selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($p->hasil_pencocokan == 'cocok')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Cocok</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pencocokan)->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.pencocokan.detail', [$p->laporanHilang->id_laporan_hilang, $p->laporanTemuan->id_laporan_temuan]) }}" class="btn btn-sm btn-outline-maroon"><i class="bi bi-eye"></i></a>
                                @if($p->hasil_pencocokan == 'cocok' && $p->status != 'selesai')
                                <form action="{{ route('admin.pencocokan.konfirmasi', $p->id_pencocokan) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success" onclick="return confirm('Konfirmasi bahwa barang ini telah dikembalikan?')"><i class="bi bi-check2-circle"></i></button>
                                </form>
                                @endif
                                <form action="{{ route('admin.pencocokan.hapus', $p->id_pencocokan) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">Belum ada pencocokan manual.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
