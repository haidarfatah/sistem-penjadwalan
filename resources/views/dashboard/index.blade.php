@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h2 class="text-center mb-4 text-primary fw-bold">Dashboard</h2>

    <div class="row justify-content-center g-4">
        @if(auth()->user()->role === 'admin')
            <!-- Total Karyawan -->
            <div class="col-lg-3 col-md-6">
                <div class="card dashboard-card bg-primary text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-users fa-3x"></i>
                        <h5 class="card-title mt-3">Total Karyawan</h5>
                        <h2 class="count-number">{{ $totalKaryawan ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <!-- Total Penggajian -->
            <div class="col-lg-3 col-md-6">
                <div class="card dashboard-card bg-danger text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-money-bill-wave fa-3x"></i>
                        <h5 class="card-title mt-3">Total Penggajian</h5>
                        <h2 class="count-number">{{ $totalPenggajian ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <!-- Statistik Absensi -->
            @foreach(['hadir' => 'success', 'izin' => 'warning', 'sakit' => 'info', 'alpha' => 'dark'] as $key => $color)
                <div class="col-lg-3 col-md-6">
                    <div class="card dashboard-card bg-{{ $color }} text-white shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-user-{{ $key === 'alpha' ? 'times' : ($key === 'sakit' ? 'md' : 'clock') }} fa-3x"></i>
                            <h5 class="card-title mt-3">{{ ucfirst($key) }} Hari Ini</h5>
                            <h2 class="count-number">{{ $$key ?? 'Tidak ada data' }}</h2>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Dashboard untuk Karyawan -->
    <div class="row justify-content-center g-4">
        @if(auth()->user()->role === 'karyawan')
            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-info text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-check fa-3x"></i>
                        <h5 class="card-title mt-3">Status Kehadiran Hari Ini</h5>
                        <h2 class="count-number">{{ $statusHariIni ?? 'Tidak ada data' }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-warning text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-calendar-alt fa-3x"></i>
                        <h5 class="card-title mt-3">Jadwal Kerja Hari Ini</h5>
                        <h2 class="count-number">{{ $jadwalHariIni ?? 'Tidak ada data' }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card dashboard-card bg-success text-white shadow">
                    <div class="card-body text-center">
                        <i class="fas fa-user-clock fa-3x"></i>
                        <h5 class="card-title mt-3">Total Hadir Bulan Ini</h5>
                        <h2 class="count-number">{{ $totalHadirBulanIni ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
