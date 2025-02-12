@extends('layouts.app')

@section('title', 'Rekap Absensi Karyawan')

@section('content')

<div class="container mt-4">
    <h3 class="text-primary mb-4 text-center fw-bold">
        <i class="fas fa-calendar-check"></i> Rekap Absensi Karyawan
    </h3>

    <!-- Form untuk memilih tanggal -->
    <form action="{{ route('absensi.index') }}" method="GET" class="mb-4">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Tampilkan
                </button>
            </div>
        </div>
    </form>

    <!-- Table Rekap Absensi -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawanMasuk as $index => $karyawan)
                    @php
                        // Cek apakah karyawan ini sudah absen atau belum
                        $absen = $absensi->where('id_karyawan', $karyawan->id_karyawan)->first();
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $karyawan->pengguna->nama }}</td>
                        <td>{{ $tanggal }}</td>
                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                        <td>{{ $absen->jam_keluar ?? '-' }}</td>
                        <td>
                            @if($absen)
                                @if($absen->status == 'hadir')
                                    <span class="badge bg-success"><i class="fas fa-check-circle"></i> Hadir</span>
                                @elseif($absen->status == 'izin')
                                    <span class="badge bg-warning"><i class="fas fa-file-earmark-check"></i> Izin</span>
                                @elseif($absen->status == 'sakit')
                                    <span class="badge bg-danger"><i class="fas fa-file-earmark-x"></i> Sakit</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-user-times"></i> Tanpa Keterangan</span>
                                @endif
                            @else
                                <span class="badge bg-dark"><i class="fas fa-times-circle"></i> Belum Absen</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada karyawan yang dijadwalkan masuk pada tanggal ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
