@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-primary fw-bold mb-4 text-center">
        <i class="fas fa-file-invoice-dollar"></i> Rekap Gaji Karyawan
    </h3>

    <!-- Tabel Rekap Gaji yang Responsif -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Posisi</th>
                    <th>Gaji Pokok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->pengguna->nama }}</td>
                    <td>{{ $data->posisi }}</td>
                    <td>Rp{{ number_format($data->gaji, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('gaji.detail', $data->id_karyawan) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Lihat Detail
                        </a>
                        {{-- Uncomment the following line to enable Edit button if required --}}
                        {{-- <a href="{{ route('gaji.edit', $data->id_karyawan) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
