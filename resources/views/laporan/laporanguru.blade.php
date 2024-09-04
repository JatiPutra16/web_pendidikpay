@extends('index')

@section('judultitle', ' - Laporan Data Guru')

@section('judulkonten')

@section('konten')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    h1{
        font-family: 'Righteous', sans-serif;
    }
</style>

<div class="container mt-3">
    <div class="bg-white rounded px-3 py-1 mb-3 d-flex justify-content-between">
        <div class="me-3">
            <h1>Laporan Data Guru</h1>
            <p>Berikut adalah daftar laporan data Guru :</p>
        </div>
    </div>

    <!-- Form Filter -->
<div class="bg-white rounded px-3 py-3 mb-3">
    <form method="GET" id="filterForm">
        <div class="row">
            <!-- Filter Nama -->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nama">Nama Guru</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama Guru" value="{{ request()->get('nama') }}">
                </div>
            </div>
            
            <!-- Filter Per Bulan -->
            <div class="col-md-3">
                <div class="form-group">
                    <label for="bulan">Bulan</label>
                    <input type="month" name="bulan" id="bulan" class="form-control" value="{{ request()->get('bulan') }}">
                </div>
            </div>

            <!-- Filter Periode Rentang Bulan -->
            <div class="col-md-5">
                <div class="form-group">
                    <label for="periode">Periode Rentang Bulan</label>
                    <div class="d-flex">
                        <input type="month" name="start_bulan" id="start_bulan" class="form-control me-2" value="{{ request()->get('start_bulan') }}">
                        <span class="me-2 align-self-center">s/d</span>
                        <input type="month" name="end_bulan" id="end_bulan" class="form-control" value="{{ request()->get('end_bulan') }}">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            <button type="button" onclick="cetakPDF()" class="btn btn-secondary"><i class="fas fa-print me-2"></i>Cetak PDF</button>
            <button type="submit" class="btn btn-primary ms-2">Filter</button>
            <a href="{{ route('laporanGuru') }}" class="btn btn-danger ms-2">Reset</a>
        </div>
    </form>
</div>

<!-- Tabel Data Guru -->
<div class="table-responsive bg-white rounded p-4">
    <table class="table table-striped" id="datatabel">
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Guru</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Gaji/jam</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody id="dataTableBody">
        @foreach ($var_guru as $index => $guru)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $guru->nik }}</td>
                <td>{{ $guru->namaguru }}</td>
                <td>{{ $guru->alamat }}</td>
                <td>{{ $guru->tlp }}</td>
                <td>Rp {{ number_format(floatval($guru->gajiperjam), 0, ',', '.') }}</td>
                <td>{{ $guru->created_at->format('d M Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    $(function() {
        // Mengaktifkan autocomplete pada input nama
        $("#nama").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('autocompleteGuru') }}",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            minLength: 1,  // Minimum karakter sebelum menampilkan suggestion
            select: function(event, ui) {
                // Mengisi input dengan nilai yang dipilih
                $('#nama').val(ui.item.value);
                return false;
            }
        });

        // Mengaktifkan DataTables pada tabel dan menonaktifkan search box
        $('#datatabel').DataTable({
            "searching": false,  // Nonaktifkan search box
            "paging": true,      // Mengaktifkan pagination
            "info": true,        // Menampilkan informasi jumlah data
            "lengthChange": false, // Menyembunyikan opsi untuk mengubah jumlah data yang ditampilkan per halaman
            "ordering": true     // Mengaktifkan fitur pengurutan
        });
    });

    function cetakPDF() {
        var nama = document.getElementById('nama').value;
        var bulan = document.getElementById('bulan').value;
        var startBulan = document.getElementById('start_bulan').value;
        var endBulan = document.getElementById('end_bulan').value;

        var url = "{{ route('cetakPDFGuru') }}?" + 
                "nama=" + encodeURIComponent(nama) + 
                "&bulan=" + encodeURIComponent(bulan) + 
                "&start_bulan=" + encodeURIComponent(startBulan) + 
                "&end_bulan=" + encodeURIComponent(endBulan);

        window.open(url, '_blank');
    }
</script>
@endsection
