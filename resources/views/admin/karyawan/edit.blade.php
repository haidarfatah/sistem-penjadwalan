@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
<div class="container mt-5">
    <h3 class="text-primary mb-4 text-center fw-bold">
        <i class="fas fa-user-edit"></i> Edit Karyawan
    </h3>

    <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <!-- Nama Lengkap -->
            <div class="col-md-6">
                <label for="nama" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ $karyawan->pengguna->nama }}" required>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $karyawan->pengguna->email }}" required>
            </div>
        </div>

        <!-- Gaji (Readonly) -->
        <div class="mb-3">
            <label for="gaji" class="form-label fw-semibold">Gaji</label>
            <input type="text" name="gaji" id="gaji" class="form-control bg-light" value="{{ number_format($karyawan->gaji, 0, ',', '.') }}" readonly required>
        </div>

        <!-- Posisi -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Posisi</label>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input posisi-radio" type="radio" name="posisi" id="operatorProduksi" value="Operator Produksi" 
                            {{ $karyawan->posisi == 'Operator Produksi' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="operatorProduksi">
                            <i class="fas fa-industry"></i> Operator Produksi (Rp 3.000.000)
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input posisi-radio" type="radio" name="posisi" id="tenagaProduksi" value="Tenaga Produksi" 
                            {{ $karyawan->posisi == 'Tenaga Produksi' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="tenagaProduksi">
                            <i class="fas fa-cogs"></i> Tenaga Produksi (Rp 2.500.000)
                        </label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input posisi-radio" type="radio" name="posisi" id="staffGudang" value="Staff Gudang" 
                            {{ $karyawan->posisi == 'Staff Gudang' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="staffGudang">
                            <i class="fas fa-warehouse"></i> Staff Gudang (Rp 2.800.000)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan & Batal -->
        <div class="d-flex justify-content-between mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>



<!-- JavaScript untuk Mengisi Gaji Otomatis -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const gajiInput = document.getElementById("gaji");
        const posisiRadios = document.querySelectorAll(".posisi-radio");

        function setGaji(posisi) {
            switch (posisi) {
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
        }

        // Atur gaji saat halaman dimuat
        let posisiTerpilih = document.querySelector(".posisi-radio:checked");
        if (posisiTerpilih) {
            setGaji(posisiTerpilih.value);
        }

        // Ubah gaji saat posisi berubah
        posisiRadios.forEach(radio => {
            radio.addEventListener("change", function () {
                setGaji(this.value);
            });
        });
    });
</script>

@endsection
