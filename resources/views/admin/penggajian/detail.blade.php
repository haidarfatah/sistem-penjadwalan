@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Card Utama -->
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-cash-register"></i> Detail Gaji Karyawan: {{ $karyawan->nama }}
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Tabel Detail Gaji -->
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            <tr>
                                <th class="bg-light">Gaji Pokok</th>
                                <td>Rp{{ number_format($karyawan->gaji, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Hadir</th>
                                <td>{{ $hadir }} hari</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Izin</th>
                                <td>{{ $izin }} hari</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Sakit</th>
                                <td>{{ $sakit }} hari</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Alpha</th>
                                <td>{{ $alpha }} hari</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Potongan Alpha (Rp50.000/hari)</th>
                                <td class="text-danger">-Rp{{ number_format($potonganAlpha, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Potongan Izin/Sakit (Rp50.000 per 3 hari jika lebih dari 3)</th>
                                <td class="text-danger">-Rp{{ number_format($potonganIzinSakit, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-success">
                                <th class="bg-success text-white">Total Gaji yang Diterima</th>
                                <td class="bg-success text-white"><strong>Rp{{ number_format($totalGaji, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Tombol Kembali dan Serahkan Gaji -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('gaji.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <form action="{{ route('gaji.serahkan', $karyawan->id_karyawan) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-hand-holding-usd"></i> Serahkan Gaji
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
