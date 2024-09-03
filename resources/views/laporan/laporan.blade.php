@extends('index')

@section('judultitle', ' - Laporan Gaji')

@section('judulkonten')

@section('konten')
    
<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    h1{
        font-family: 'Righteous', sans-serif;
    }
</style>

<!-- Include jQuery and jQuery UI -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

<div class="container mt-3">
    <div class="bg-white rounded px-3 py-1 mb-3 d-flex justify-content-between">
        <div class="me-3">
            <h1>Laporan Penggajian</h1>
            <p>Berikut adalah daftar laporan penggajian :</p>
        </div>
    </div>

    <!-- Form Filter -->
    <div class="bg-white rounded px-3 py-3 mb-3">
        <form method="GET" action="{{ route('filterGaji') }}">
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
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('laporanGaji') }}" class="btn btn-secondary ms-2">Reset</a>
            </div>
        </form>
    </div>
    
    <!-- Tabel Laporan Gaji -->
    <div class="table-responsive bg-white rounded p-4">
        <table class="table table-striped" id="datatabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Gaji/Jam</th>
                    <th>Jumlah Jam Kehadiran</th>
                    <th>Total Gaji</th>
                    <th>Gaji Bersih</th>
                    <th>Tanggal Gaji</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($var_gaji as $index => $b)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{ $b->absen->guru->nik }}</td>
                    <td>{{ $b->absen->guru->namaguru }}</td>
                    <td>RP {{ number_format($b->absen->guru->gajiperjam, 0, ',', '.') }}</td>
                    <td>{{$b->total_jam}}</td>
                    <td>RP {{ number_format($b->total_gaji, 0, ',', '.') }}</td>
                    <td>RP {{ number_format($b->gaji_bersih, 0, ',', '.') }}</td>
                    <td>{{ date('Y-m-d', strtotime($b->tgl_gaji)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(function() {
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
            minLength: 2
        });
    });
</script>

@endsection
