@extends('admin/master')
@section('content')
    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-3">
        <div class="card text-center p-3">
          <div class="card-body">
            <i class="bi bi-person-fill fs-2 text-primary"></i>
            <h5 class="mt-3 mb-0 fw-semibold">Pengguna</h5>
            <p class="fs-4 fw-bold text-dark mb-0">124</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <div class="card-body">
            <i class="bi bi-exclamation-circle fs-2 text-danger"></i>
            <h5 class="mt-3 mb-0 fw-semibold">Laporan Hilang</h5>
            <p class="fs-4 fw-bold text-dark mb-0">45</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <div class="card-body">
            <i class="bi bi-box-seam fs-2 text-success"></i>
            <h5 class="mt-3 mb-0 fw-semibold">Laporan Temuan</h5>
            <p class="fs-4 fw-bold text-dark mb-0">30</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card text-center p-3">
          <div class="card-body">
            <i class="bi bi-link-45deg fs-2 text-info"></i>
            <h5 class="mt-3 mb-0 fw-semibold">Pencocokan</h5>
            <p class="fs-4 fw-bold text-dark mb-0">12</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="card p-4">
      <h5 class="fw-semibold mb-3">Laporan Terbaru</h5>
      <div class="table-responsive">
        <table class="table align-middle table-striped">
          <thead class="table-primary">
            <tr>
              <th>#</th>
              <th>Nama Pelapor</th>
              <th>Jenis Laporan</th>
              <th>Nama Barang</th>
              <th>Tanggal</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Andi Pratama</td>
              <td><span class="badge bg-danger">Hilang</span></td>
              <td>Dompet Cokelat</td>
              <td>12 Okt 2025</td>
              <td><span class="badge bg-warning text-dark">Menunggu</span></td>
              <td><button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button></td>
            </tr>
            <tr>
              <td>2</td>
              <td>Siti Aulia</td>
              <td><span class="badge bg-success">Temuan</span></td>
              <td>HP Samsung A14</td>
              <td>13 Okt 2025</td>
              <td><span class="badge bg-success">Terverifikasi</span></td>
              <td><button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button></td>
            </tr>
            <tr>
              <td>3</td>
              <td>Budi Hartono</td>
              <td><span class="badge bg-danger">Hilang</span></td>
              <td>STNK Motor</td>
              <td>14 Okt 2025</td>
              <td><span class="badge bg-secondary">Ditutup</span></td>
              <td><button class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection