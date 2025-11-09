@extends('admin.layout')

@section('title', 'Detail Pencocokan')
@section('page-title', 'Detail Perbandingan Laporan')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-maroon text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-search me-2"></i>Perbandingan Data Laporan</h5>
            <a href="{{ route('admin.pencocokan') }}" class="btn btn-light btn-sm text-maroon fw-semibold"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 border-end">
                    <h6 class="fw-bold text-maroon mb-3">Laporan Kehilangan</h6>
                    <img src="{{ $hilang->foto ? asset('storage/'.$hilang->foto) : 'https://via.placeholder.com/300x200?text=Tidak+Ada+Foto' }}" class="img-fluid rounded mb-3 shadow-sm">
                    <table class="table table-borderless small">
                        <tr><th>Nama Pemilik</th><td>{{ $hilang->pengguna->nama }}</td></tr>
                        <tr><th>Nama Barang</th><td>{{ $hilang->nama_barang }}</td></tr>
                        <tr><th>Kategori</th><td>{{ $hilang->kategori }}</td></tr>
                        <tr><th>Lokasi Hilang</th><td>{{ $hilang->lokasi_hilang }}</td></tr>
                        <tr><th>Tanggal Hilang</th><td>{{ \Carbon\Carbon::parse($hilang->tanggal_hilang)->format('d M Y') }}</td></tr>
                        <tr><th>Deskripsi</th><td>{{ $hilang->deskripsi }}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-maroon mb-3">Laporan Temuan</h6>
                    <img src="{{ $temuan->foto ? asset('storage/'.$temuan->foto) : 'https://via.placeholder.com/300x200?text=Tidak+Ada+Foto' }}" class="img-fluid rounded mb-3 shadow-sm">
                    <table class="table table-borderless small">
                        <tr><th>Nama Penemu</th><td>{{ $temuan->pengguna->nama }}</td></tr>
                        <tr><th>Nama Barang</th><td>{{ $temuan->nama_barang }}</td></tr>
                        <tr><th>Kategori</th><td>{{ $temuan->kategori }}</td></tr>
                        <tr><th>Lokasi Temuan</th><td>{{ $temuan->lokasi_temuan }}</td></tr>
                        <tr><th>Tanggal Temuan</th><td>{{ \Carbon\Carbon::parse($temuan->tanggal_temuan)->format('d M Y') }}</td></tr>
                        <tr><th>Deskripsi</th><td>{{ $temuan->deskripsi }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light text-center">
            <h5 class="fw-bold text-maroon">Skor Kecocokan: <span class="text-success">{{ round($skor, 1) }}%</span></h5>

            @if(isset($pencocokan) && $pencocokan->status != 'selesai')
            <form action="{{ route('admin.pencocokan.konfirmasi', $pencocokan->id_pencocokan) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success mt-2">
                    <i class="bi bi-check2-circle"></i> Konfirmasi Barang Telah Dikembalikan
                </button>
            </form>
            @elseif(isset($pencocokan) && $pencocokan->status == 'selesai')
            <p class="text-success fw-semibold mt-2 mb-0"><i class="bi bi-check-circle"></i> Barang telah dikonfirmasi dikembalikan kepada pemilik.</p>
            @endif
        </div>
    </div>
</div>
@endsection
