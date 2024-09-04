<!DOCTYPE html>
<html>
<head>
    <title>Laporan Gaji</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 40px;
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }
        .kop-surat h1 {
            font-size: 24px;
            margin: 0;
        }
        .kop-surat h2 {
            font-size: 18px;
            margin: 0;
        }
        .kop-surat h3 {
            font-size: 14px;
            margin: 0;
        }
        .kop-surat p {
            font-size: 12px;
            margin: 0;
        }
        .header {
            text-align: left;
            margin-bottom: 30px;
        }
        .header h5 {
            font-size: 16px;
            margin: 5px 0;
        }
        .header h3, .header h4 {
            font-size: 14px;
            margin: 5px 0;
        }
        .content {
            margin-top: 20px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            font-size: 14px;
        }
        .footer {
            font-size: 12px;
            text-align: center;
            margin-top: 50px;
        }
        .totals {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- KOP Surat -->
    <div class="kop-surat">
        <h1>Laporan Gaji Guru</h1>
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
    </div>

    <!-- Header -->
    <div class="header">
        <h5>PendidikPay</h5>
        <h3>Laporan Gaji</h3>

        @if(isset($bulan))
            <h4>Bulan: {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</h4>
        @endif
        @if(isset($start_bulan) && isset($end_bulan))
            <h4>Periode: {{ \Carbon\Carbon::parse($start_bulan)->translatedFormat('F Y') }} - {{ \Carbon\Carbon::parse($end_bulan)->translatedFormat('F Y') }}</h4>
        @endif
    </div>

    <!-- Konten -->
    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Guru</th>
                    <th>Gaji Per Jam</th>
                    <th>Jumlah Jam Kehadiran</th>
                    <th>Total Gaji</th>
                    <th>Gaji Bersih</th>
                    <th>Tanggal Gaji</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gaji as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $b->absen->guru->nik }}</td>
                        <td>{{ $b->absen->guru->namaguru }}</td>
                        <td>Rp {{ number_format(floatval($b->absen->guru->gajiperjam), 0, ',', '.') }}</td>
                        <td>{{ $b->total_jam }}</td>
                        <td>Rp {{ number_format($b->total_gaji, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($b->gaji_bersih, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($b->tgl_gaji)->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Total Gaji -->
        <div class="totals">
            <h4>Total Gaji: Rp {{ number_format($total_gaji, 0, ',', '.') }}</h4>
            <h4>Total Jam Kehadiran: {{ $total_jam }} Jam</h4>
            <h4>Total Gaji Bersih: Rp {{ number_format($total_gaji_bersih, 0, ',', '.') }}</h4>
        </div>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p>Mengetahui,</p>
        <p><strong>Kepala Sekolah</strong></p>
        <br><br>
        <p>(_______________________)</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami.</p>
        <p>PendidikPay © {{ date('Y') }}</p>
    </div>
</body>
</html>
