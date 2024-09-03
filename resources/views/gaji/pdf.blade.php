<!DOCTYPE html>
<html>
<head>
    <title>Laporan Gaji</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 40px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            margin-top: 20px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px; /* Kurangi padding jika perlu */
            text-align: left;
            font-size: 10px; /* Ukuran font yang lebih kecil */
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            font-size: 0.8em;
            text-align: right;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PendidikPay</h1>
        <h5>Daftar Laporan Gaji</h5>
        <h3>Bulan: {{ $namaBulan }} {{ $tahun }}</h3>
    </div>

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
                        <td>{{ $b->total_gaji }}</td>
                        <td>{{ $b->gaji_bersih }}</td>
                        <td>{{ date('Y-m-d', strtotime($b->tgl_gaji)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="signature">
        <p>Mengetahui,</p>
        <p><strong>Manager Keuangan</strong></p>
        <br><br>
        <p>(_______________________)</p>
    </div>

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami.</p>
        <p>PendidikPay © {{ date('Y') }}</p>
    </div>
</body>
</html>