@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <!-- Judul dengan Warna Gradient dan Centered -->
    <h2 class="text-center fw-bold mb-4 text-primary">Daftar Karyawan</h2>

    <!-- Notifikasi Sukses -->
    @if (session('sukses'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('sukses') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Notifikasi Gagal -->
    @if (session('gagal'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('gagal') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tombol Tambah dengan Icon dan Warna -->
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('karyawan.tambah') }}" class="btn btn-success shadow-sm d-flex align-items-center">
            <i class="fas fa-plus me-2"></i> Tambah Karyawan
        </a>
    </div>

    @if ($karyawans->isEmpty())
        <p class="text-muted text-center">Belum ada data karyawan.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th><i class="fas fa-user me-2"></i> Nama</th>
                        <th><i class="fas fa-envelope me-2"></i> Email</th>
                        <th><i class="fas fa-briefcase me-2"></i> Posisi</th>
                        <th><i class="fas fa-money-bill-wave me-2"></i> Gaji</th>
                        <th class="text-center"><i class="fas fa-cogs me-2"></i> Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawans as $karyawan)
                        <tr class="align-middle text-center table-light">
                            <td>{{ $karyawan->pengguna->nama ?? 'Tidak Ada' }}</td>
                            <td>{{ $karyawan->pengguna->email ?? 'Tidak Ada' }}</td>
                            <td>{{ $karyawan->posisi }}</td>
                            <td>Rp {{ number_format($karyawan->gaji, 2, ',', '.') }}</td>
                            <td class="text-center d-flex justify-content-center">
                                <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="btn btn-warning btn-sm me-2 shadow-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('karyawan.hapus', $karyawan->id_karyawan) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
