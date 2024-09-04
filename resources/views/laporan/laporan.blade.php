@extends('index')

@section('judultitle', ' - Laporan Gaji')

@section('judulkonten')

@section('konten')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    
    h1 {
        font-family: 'Righteous', sans-serif;
    }
    
    .card-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }
    
    .report-card {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        text-align: center;
        height: 400px;
    }
    
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    
    .report-card i {
        font-size: 50px;
        color: #220B44; 
    }
    
    .report-card h3 {
        font-size: 24px;
        color: #220B44; 
    }

    .report-card p {
        font-size: 14px;
        color: #343a40;
    }

    .report-card button {
        padding: 10px 20px;
        font-size: 16px;
        color: white;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        cursor: pointer;
    }

    .report-card button .fas {
        margin-left: 8px;
        color: white; /* Warna putih untuk ikon panah */
    }

</style>

<div class="container mt-3">
    <div class="bg-white rounded px-3 py-1 mb-3 d-flex justify-content-between">
        <div class="me-3">
            <h1>Laporan</h1>
            <p>Berikut adalah daftar seluruh laporan:</p>
        </div>
    </div>
    <div class="bg-white rounded p-4">
        <div class="card-container">
            <div class="report-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Laporan Absen</h3>
                <p>Menampilkan laporan kehadiran guru dalam satu bulan atau periode tertentu.</p>
                <button onclick="window.location.href='{{ url('/laporanabsen') }}'" class="btn btn-success">Lihat Laporan<a class="fas fa-arrow-right ms-2"></a></button>
            </div>
            <div class="report-card">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Laporan Gaji</h3>
                <p>Melihat laporan pembayaran gaji guru berdasarkan data yang ada.</p>
                <button onclick="window.location.href='{{ url('/laporangaji') }}'" class="btn btn-success">Lihat Laporan<a class="fas fa-arrow-right ms-2"></a></button>
            </div>
            <div class="report-card">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Laporan Guru</h3>
                <p>Mengakses informasi lengkap mengenai data guru yang terdaftar.</p>
                <button onclick="window.location.href='{{ url('/laporanguru') }}'" class="btn btn-success">Lihat Laporan<a class="fas fa-arrow-right ms-2"></a></button>
            </div>
        </div>
    </div>
</div>

@endsection
