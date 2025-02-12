@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Absensi Karyawan</h3>

        @if (session('sukses'))
            <div class="alert alert-success">{{ session('sukses') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($absensiHariIni)
            @if ($absensiHariIni->status == 'izin')
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle"></i> Anda telah mengajukan <strong>izin</strong> pada tanggal
                    {{ $absensiHariIni->tanggal }}.
                </div>
            @elseif($absensiHariIni->status == 'sakit')
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Anda telah mengajukan <strong>sakit</strong> pada tanggal
                    {{ $absensiHariIni->tanggal }}.
                </div>
            @elseif($absensiHariIni->jam_masuk)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Anda sudah <strong>absen masuk</strong> pada pukul
                    {{ $absensiHariIni->jam_masuk }}.
                </div>
            @endif
        @endif


        @if (!$absensiHariIni)
            <!-- Tombol Absen Masuk -->
            <form action="{{ route('karyawan.absensi.masuk') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary"
                    {{ $absensiHariIni && $absensiHariIni->status !== 'hadir' ? 'disabled' : '' }}>
                    Absen Masuk
                </button>
            </form>
        @elseif(!$absensiHariIni->jam_keluar && $absensiHariIni->status == 'hadir')
            <!-- Tombol Absen Keluar -->
            <form action="{{ route('karyawan.absensi.keluar') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning" 
                {{ !$absensiHariIni || $absensiHariIni->jam_keluar || $absensiHariIni->status !== 'hadir' ? 'disabled' : '' }}>
                Absen Keluar
            </button>
            </form>
        @else
            <!-- Notifikasi jika sudah absen atau izin/sakit -->
            <div class="alert alert-info">Anda sudah menyelesaikan absensi hari ini atau mengajukan izin/sakit.</div>
        @endif

        <hr>

        <h4>Izin/Sakit</h4>
        <form action="{{ route('karyawan.absensi.izinSakit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <select name="status" class="form-control" required>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="file" name="bukti_absensi" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Ajukan Izin/Sakit</button>
        </form>

        <hr>
        <a href="{{ route('karyawan.absensi.riwayat') }}" class="btn btn-secondary">Lihat Riwayat Absensi</a>

    </div>
@endsection
