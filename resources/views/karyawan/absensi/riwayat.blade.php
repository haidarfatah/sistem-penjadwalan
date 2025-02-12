@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Riwayat Absensi</h3>

    @if(session('sukses'))
        <div class="alert alert-success">{{ session('sukses') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Bukti</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatAbsensi as $index => $absensi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $absensi->tanggal }}</td>
                    <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                    <td>{{ $absensi->jam_keluar ?? '-' }}</td>
                    <td>
                        @if($absensi->status == 'hadir')
                            <span class="badge bg-success">Hadir</span>
                        @elseif($absensi->status == 'izin')
                            <span class="badge bg-warning">Izin</span>
                        @elseif($absensi->status == 'sakit')
                            <span class="badge bg-danger">Sakit</span>
                        @else
                            <span class="badge bg-secondary">{{ $absensi->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($absensi->bukti)
                            <!-- Tombol View untuk membuka modal -->
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                    data-bs-target="#viewBuktiModal" 
                                    data-bukti="{{ asset('storage/' . $absensi->bukti) }}">
                                View
                            </button>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data absensi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('karyawan.absensi.index') }}" class="btn btn-primary">Kembali</a>
</div>

<!-- Modal untuk menampilkan bukti -->
<div class="modal fade" id="viewBuktiModal" tabindex="-1" aria-labelledby="viewBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBuktiModalLabel">Bukti Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="buktiImage" src="" class="img-fluid d-none" alt="Bukti Absensi">
                <iframe id="buktiPdf" src="" class="w-100 d-none" style="height: 500px;"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var buktiModal = document.getElementById("viewBuktiModal");

        buktiModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget; // Tombol yang diklik
            var buktiUrl = button.getAttribute("data-bukti"); // Ambil URL dari data-bukti

            var imageElement = document.getElementById("buktiImage");
            var pdfElement = document.getElementById("buktiPdf");

            // Reset tampilan modal
            imageElement.classList.add("d-none");
            pdfElement.classList.add("d-none");

            if (buktiUrl.endsWith(".jpg") || buktiUrl.endsWith(".jpeg") || buktiUrl.endsWith(".png")) {
                imageElement.src = buktiUrl;
                imageElement.classList.remove("d-none");
            } else if (buktiUrl.endsWith(".pdf")) {
                pdfElement.src = buktiUrl;
                pdfElement.classList.remove("d-none");
            }
        });
    });
</script>
@endpush
