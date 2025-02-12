@extends('layouts.app')

@section('title', 'Karyawan Sudah Memiliki Jadwal Kerja')

@section('content')
    <div class="container mt-5">
        <!-- Judul dengan Bootstrap -->
        <h3 class="mb-4 text-center text-primary fw-bold">
            <i class="fas fa-calendar-check me-2" style="font-size: 1.5rem;"></i> Karyawan yang Sudah Memiliki Jadwal Kerja
        </h3>

        <!-- Notifikasi Alert -->
        <div id="alert-container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2" style="font-size: 1.2rem;"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-circle me-2" style="font-size: 1.2rem;"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Table -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="text-center"><i class="fas fa-hashtag" style="font-size: 1.2rem;"></i> No</th>
                                <th class="text-center"><i class="fas fa-user" style="font-size: 1.2rem;"></i> Nama</th>
                                <th class="text-center"><i class="fas fa-calendar-day" style="font-size: 1.2rem;"></i>
                                    Rentang Tanggal</th>
                                <th class="text-center"><i class="fas fa-clock" style="font-size: 1.2rem;"></i> Shift</th>
                                <th class="text-center"><i class="fas fa-cogs" style="font-size: 1.2rem;"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalKerja as $index => $jadwal)
                                <tr class="" data-row-id="{{ $jadwal->first()->id_karyawan }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $jadwal->first()->karyawan->pengguna->nama }}</td>
                                    <td class="text-center tanggal-range">
                                        {{ date('d-m-Y', strtotime($jadwal->first()->tanggal)) }} -
                                        {{ date('d-m-Y', strtotime($jadwal->last()->tanggal)) }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-{{ $jadwal->first()->shift == 'pagi' ? 'primary' : ($jadwal->first()->shift == 'siang' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($jadwal->first()->shift) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editJadwalModal{{ $jadwal->first()->id_jadwal }}">
                                            <i class="fas fa-edit me-1" style="font-size: 1rem;"></i> Edit
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Edit Jadwal -->
                                <div class="modal fade" id="editJadwalModal{{ $jadwal->first()->id_jadwal }}"
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content shadow-lg">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Edit Jadwal Karyawan</h5>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <form class="editJadwalForm"
                                                data-modal-id="editJadwalModal{{ $jadwal->first()->id_jadwal }}">
                                                @csrf
                                                <input type="hidden" name="id_jadwal"
                                                    value="{{ $jadwal->first()->id_jadwal }}">

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal:</label>
                                                        <input type="date" class="form-control" name="tanggal"
                                                            value="{{ $jadwal->first()->tanggal }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Shift:</label>
                                                        <select class="form-select" name="shift" required>
                                                            <option value="pagi"
                                                                {{ $jadwal->first()->shift == 'pagi' ? 'selected' : '' }}>
                                                                Pagi</option>
                                                            <option value="siang"
                                                                {{ $jadwal->first()->shift == 'siang' ? 'selected' : '' }}>
                                                                Siang</option>
                                                            <option value="malam"
                                                                {{ $jadwal->first()->shift == 'malam' ? 'selected' : '' }}>
                                                                Malam</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.editJadwalForm').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Mencegah form submit default

                    let formData = new FormData(this);
                    let modalId = this.getAttribute('data-modal-id');

                    // Kirim data ke server menggunakan fetch
                    fetch("{{ route('jadwalkerja.perbarui') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
    console.log("Respons dari server:", data); // Debugging respons dari backend

    if (data.success) {
        let row = document.querySelector(`tr[data-row-id="${data.id_karyawan}"]`);
        console.log("Row ditemukan:", row); // Cek apakah baris ditemukan

        if (row) {
            row.querySelector('.tanggal-range').innerText = `${data.tanggal_mulai} - ${data.tanggal_selesai}`;
            
            let shiftBadge = row.querySelector('.badge');
            console.log("Shift sebelum update:", shiftBadge.innerText);

            shiftBadge.innerText = data.shift;
            console.log("Shift setelah update:", shiftBadge.innerText);

            shiftBadge.classList.remove('bg-primary', 'bg-warning', 'bg-danger', 'bg-info');

            if (data.shift.toLowerCase() === 'pagi') {
                shiftBadge.classList.add('bg-primary');
            } else if (data.shift.toLowerCase() === 'siang') {
                shiftBadge.classList.add('bg-warning');
            } else if (data.shift.toLowerCase() === 'malam') {
                shiftBadge.classList.add('bg-danger');
            }

            // Paksa elemen re-render
            shiftBadge.outerHTML = shiftBadge.outerHTML;
        }

        // Tutup modal
        let modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
        modal.hide();
    } else {
        alert("Gagal memperbarui jadwal.");
    }
})

                        .catch(error => console.error("Error:", error));
                });
            });
        });
    </script>

@endsection
