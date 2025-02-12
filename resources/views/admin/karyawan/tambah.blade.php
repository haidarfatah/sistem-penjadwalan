@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="container mt-5">
    <h3 class="text-primary fw-bold mb-4">
        <i class="fas fa-user-plus"></i> Tambah Karyawan
    </h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('karyawan.simpan') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <!-- Input Nama -->
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" required>
                    </div>

                    <!-- Input Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan Email" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <!-- Input Password -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>

                    <!-- Input Gaji (Otomatis diisi) -->
                    <div class="col-md-6">
                        <label for="gaji" class="form-label">Gaji</label>
                        <input type="text" name="gaji" id="gaji" class="form-control" readonly required>
                    </div>
                </div>

                <!-- Input Posisi (Radio Buttons) -->
                <div class="mb-3">
                    <label class="form-label">Posisi</label>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input posisi-radio" type="radio" name="posisi" id="operatorProduksi" value="Operator Produksi" required>
                                <label class="form-check-label" for="operatorProduksi">
                                    <i class="fas fa-industry"></i> Operator Produksi (Rp 3.000.000)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input posisi-radio" type="radio" name="posisi" id="tenagaProduksi" value="Tenaga Produksi" required>
                                <label class="form-check-label" for="tenagaProduksi">
                                    <i class="fas fa-cogs"></i> Tenaga Produksi (Rp 2.500.000)
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input posisi-radio" type="radio" name="posisi" id="staffGudang" value="Staff Gudang" required>
                                <label class="form-check-label" for="staffGudang">
                                    <i class="fas fa-warehouse"></i> Staff Gudang (Rp 2.800.000)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan dan Batal -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk Mengisi Gaji Otomatis -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const gajiInput = document.getElementById("gaji");
        const posisiRadios = document.querySelectorAll(".posisi-radio");

        posisiRadios.forEach(radio => {
            radio.addEventListener("change", function () {
                switch (this.value) {
                    case "Operator Produksi":
                        gajiInput.value = 3000000;
                        break;
                    case "Tenaga Produksi":
                        gajiInput.value = 2500000;
                        break;
                    case "Staff Gudang":
                        gajiInput.value = 2800000;
                        break;
                }
            });
        });
    });
</script>

@endsection
