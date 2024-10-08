@extends('index')


@section('judulkonten')
@section('konten')
    
<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    h1{
        font-family: 'Righteous', sans-serif;
    }
</style>


<div class="container mt-1">
    <nav style="--bs-breadcrumb-divider: '/'" aria-label="breadcrumb">
        <ol class="breadcrumb text-dark">
            <li class="breadcrumb-item"><a href="{{ route('laporanTampil') }}" class="text-danger text-decoration-none">Menu Utama Laporan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Absen</li>
            <li class="breadcrumb-item"><a href="{{ route('laporanGajiTampil') }}" class="text-white text-decoration-none">Laporan Gaji</a></li>
            <li class="breadcrumb-item"><a href="{{ route('laporanGuru') }}" class="text-white text-decoration-none">Laporan Guru</a></li>
        </ol>
    </nav>
    <div class="bg-white rounded px-3 py-1 mb-3 d-flex justify-content-between">
        <div class="me-3">
            <h1>Laporan Absen</h1>
            <p>Berikut adalah daftar laporan absen :</p>
        </div>
    </div>

    <!-- Form Filter -->
    <div class="bg-white rounded px-3 py-3 mb-3">
        <form method="GET" action="{{ route('laporanAbsen') }}">
            <!-- Filter Inputs -->
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
                            <input type="month" name="start_bulan" id="start_bulan" class="form-control me-2" value="{{ request()->get('start_bulan') }}" onchange="setMinEndDate()">
                        <span class="me-2 align-self-center">s/d</span>
                        <input type="month" name="end_bulan" id="end_bulan" class="form-control" value="{{ request()->get('end_bulan') }}" min="{{ request()->get('start_bulan') }}">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-warning text-white me-2" data-bs-toggle="modal" data-bs-target="#chartModal" onclick="generateChart()"><i class="fas fa-chart-bar me-2"></i> Generate Chart</button>
                <button type="button" onclick="cetakPDF()" class="btn btn-secondary"><i class="fas fa-print me-2"></i>Cetak PDF</button>
                <button type="submit" class="btn btn-primary ms-2"><i class="fas fa-filter me-2"></i> Filter</button>
                <a href="{{ route('laporanAbsen') }}" class="btn btn-danger ms-2"><i class="fas fa-undo me-2"></i> Reset</a>
            </div>
        </form>
    </div>
    
    <!-- Tabel Laporan Absen -->
    <div class="table-responsive bg-white rounded p-4">
        <table class="table table-striped" id="datatabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Guru</th> 
                    <th>Jumlah Jam/Hari</th>
                    <th>Jumlah Hari/Bulan</th>
                    <th>Tanggal Pencatatan</th>
                    <th>Status Gaji</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($var_absen as $index => $b)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$b->guru->nik}}</td>
                        <td>{{$b->guru->namaguru}}</td> 
                        <td>{{$b->jumlah_jam}} jam</td> <!-- Menghitung total jam -->
                        <td>{{$b->jumlah_hari}} hari</td>
                        <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</td>
                        <td>
                            @if ($b->status_gaji == 'Sudah Dibayar')
                                <span class="badge bg-success">{{$b->status_gaji}}</span>
                            @else
                                <span class="badge bg-danger">{{$b->status_gaji}}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="chartModalLabel">Grafik Total Jam Absen per Bulan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-start mb-3">
                    <label class="me-3"><input type="radio" name="chartType" value="line" checked> Line Chart</label>
                    <label class="me-3"><input type="radio" name="chartType" value="bar"> Bar Chart</label>
                    <label><input type="radio" name="chartType" value="pie"> Pie Chart</label>
                </div>
                <canvas id="chartCanvas"></canvas>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="downloadChart"><i class="fas fa-download me-2"></i> Download Chart as JPG</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i> Close</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let ctx = document.getElementById('chartCanvas').getContext('2d');
        let chart;

        $('#chartModal').on('shown.bs.modal', function () {
            // Hapus chart sebelumnya jika ada
            if (chart) {
                chart.destroy();
            }

            // Data dari server (disesuaikan sesuai backend)
            let chartData = @json($chartData);
            let labels = chartData.map(item => item.bulan);
            let data = chartData.map(item => item.total_jam);

            // Fungsi untuk mendapatkan jenis chart dari checkbox yang dipilih
            function getSelectedChartType() {
                let selectedChart = document.querySelector('input[name="chartType"]:checked');
                return selectedChart ? selectedChart.value : 'line'; // Default ke 'line' jika tidak ada yang dipilih
            }

            // Muat ulang chart berdasarkan jenis chart yang dipilih
            function loadChart() {
                let chartType = getSelectedChartType(); // Ambil nilai chartType yang dipilih

                // Hapus chart sebelumnya jika ada
                if (chart) {
                    chart.destroy();
                }

                chart = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Jam Absen',
                            data: data,
                            backgroundColor: chartType === 'pie' ? [
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)',
                                'rgba(255, 159, 64, 0.5)'
                            ] : 'rgba(255, 193, 7, 0.5)',
                            borderColor: 'rgba(255, 193, 7, 1)',
                            borderWidth: 1,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: chartType !== 'pie' ? { // Hanya tampilkan skala jika bukan pie chart
                            y: {
                                beginAtZero: true
                            }
                        } : {}
                    }
                });
            }

            // Muat chart saat modal ditampilkan
            loadChart();

            // Reload chart setiap kali ada perubahan jenis chart
            document.querySelectorAll('input[name="chartType"]').forEach(function (input) {
                input.addEventListener('change', loadChart);
            });
        });

        // Button download chart
        document.getElementById('downloadChart').addEventListener('click', function () {
            chart.backgroundColor = 'rgba(255, 255, 255, 1)';
            let link = document.createElement('a');
            link.href = chart.toBase64Image('image/jpeg');
            link.download = 'chart_absen.jpg';
            link.click();
        });
    });

</script>


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
            "lengthChange": true, // Menyembunyikan opsi untuk mengubah jumlah data yang ditampilkan per halaman
            "ordering": true     // Mengaktifkan fitur pengurutan
        });
    });

    function cetakPDF() {
        var nama = document.getElementById('nama').value;
        var bulan = document.getElementById('bulan').value;
        var startBulan = document.getElementById('start_bulan').value;
        var endBulan = document.getElementById('end_bulan').value;

        var url = "{{ route('cetakPDFAbsen') }}?" + 
                "nama=" + nama + 
                "&bulan=" + bulan + 
                "&start_bulan=" + startBulan + 
                "&end_bulan=" + endBulan;

        window.open(url, '_blank');
    }
</script>

<script>
    function setMinEndDate() {
        let startDate = document.getElementById('start_bulan').value;
        document.getElementById('end_bulan').setAttribute('min', startDate);
    }
</script>
@endsection
