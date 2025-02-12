@extends('layouts.app')

@section('title', 'Karyawan Belum Memiliki Jadwal Kerja')

@section('content')

<div class="container mt-5">
    <!-- Judul dengan Icon -->
    <h3 class="text-primary mb-4 text-center fw-bold">
        <i class="fas fa-calendar-times"></i> Karyawan Belum Memiliki Jadwal Kerja
    </h3>

    <!-- Alert Container -->
    <div id="alert-container"></div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped  table-hover align-middle ">
            <thead class="table-primary">
                <tr>
                    <th class="text-center"><i class="fas fa-hashtag"></i> No</th>
                    <th class="text-center"><i class="fas fa-user"></i> Nama Karyawan</th>
                    <th class="text-center"><i class="fas fa-calendar-day"></i> Tanggal Mulai</th>
                    <th class="text-center"><i class="fas fa-clock"></i> Shift</th>
                    <th class="text-center"><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($karyawan as $index => $k)
                    @if(!$jadwalKerja->has($k->id_karyawan))
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $k->pengguna->nama }}</td>
                            <td class="text-center">
                                <input type="date" name="tanggal" 
                                       class="form-control form-control-sm tanggal-{{ $k->id_karyawan }}" 
                                       style="max-width: 180px; margin: 0 auto;" required>
                            </td>
                            <td class="text-center">
                                <select name="shift" 
                                        class="form-select form-select-sm shift-{{ $k->id_karyawan }}" 
                                        style="max-width: 150px; margin: 0 auto;" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="pagi">Pagi</option>
                                    <option value="siang">Siang</option>
                                    <option value="malam">Malam</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" 
                                        class="btn btn-warning btn-sm simpanJadwal" 
                                        data-karyawan="{{ $k->id_karyawan }}">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.simpanJadwal').forEach(button => {
            button.addEventListener('click', function () {
                let idKaryawan = this.getAttribute('data-karyawan');
                let tanggal = document.querySelector('.tanggal-' + idKaryawan).value;
                let shift = document.querySelector('.shift-' + idKaryawan).value;
    
                if (!tanggal || !shift) {
                    alert("Harap pilih tanggal dan shift sebelum menyimpan.");
                    return;
                }
    
                fetch("{{ route('jadwalkerja.simpan') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id_karyawan: idKaryawan,
                        tanggal: tanggal,
                        shift: shift
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let alertBox = `
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                ${data.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
                        document.getElementById('alert-container').innerHTML = alertBox;
    
                        // Remove row after successful save
                        let row = button.closest('tr');
                        row.remove();
                    } else {
                        alert("Gagal menyimpan jadwal.");
                    }
                })
                .catch(error => console.error("Error:", error));
            });
        });
    });
</script>

@endsection