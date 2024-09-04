<!DOCTYPE html>
<html>
<head>
    <title>Laporan Gaji</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 20px;
            font-size: 14px; /* Ukuran font lebih besar */
        }
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 5px;
        }
        .kop-surat h1 {
            font-size: 25px; /* Ukuran font untuk judul */
            margin: 0;
        }
        .kop-surat h2 {
            font-size: 15px; /* Ukuran font untuk sub-judul */
            margin: 0;
        }
        .kop-surat h3 {
            font-size: 10px; /* Ukuran font untuk sub-judul */
            margin: 0;
        }
        .kop-surat p {
            font-size: 12px; /* Ukuran font untuk detail */
            margin: 0;
        }
        .content {
            margin-top: 20px;
        }
        .content h3 {
            font-size: 14px; /* Ukuran font untuk sub-judul konten */
            margin-top: 10px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 14px; /* Ukuran font untuk tabel */
        }
        .content table, .content th, .content td {
            border: 1px solid black;
            padding: 6px; /* Padding diperbesar untuk keterbacaan */
            text-align: left;
        }
        .content th {
            background-color: #f2f2f2;
        }
        .signature {
            margin-top: 20px;
            text-align: right;
            font-size: 14px; /* Ukuran font untuk tanda tangan */
        }
        .footer {
            font-size: 12px; /* Ukuran font untuk footer */
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <h1>Laporan Gaji Guru</h1>
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
    </div>

    <div class="content">
        <h3>Data Gaji:</h3>
        <table>
            <tr>
                <td><strong>NIK:</strong></td>
                <td>{{ $gaji->absen->guru->nik }}</td>
            </tr>
            <tr>
                <td><strong>Nama Guru:</strong></td>
                <td>{{ $gaji->absen->guru->namaguru }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Gaji:</strong></td>
                <td>{{ $gaji->tgl_gaji->format('Y-m-d') }}</td>
            </tr>
            <tr>
                <td><strong>Gaji Per Jam:</strong></td>
                <td>Rp {{ number_format(floatval($gaji->absen->guru->gajiperjam), 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Jumlah Jam Kehadiran:</strong></td>
                <td>{{ $gaji->total_jam }}</td>
            </tr>
            <tr>
                <td><strong>Total Gaji:</strong></td>
                <td>Rp {{ number_format(floatval($gaji->total_gaji), 0, ',', '.') }}</td>
            </tr>
        </table>

        <h3>Rincian Potongan:</h3>
        <table>
            <tr>
                <th>Jenis Potongan</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>Pajak (5%)</td>
                <td>Rp {{ number_format(floatval($gaji->total_gaji) * 0.05, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>BPJS Kesehatan (5%)</td>
                <td>Rp {{ number_format(floatval($gaji->total_gaji) * 0.05, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>BPJS Ketenagakerjaan (5.7%)</td>
                <td>Rp {{ number_format(floatval($gaji->total_gaji) * 0.057, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Potongan</th>
                <th>Rp {{ number_format(
                    (floatval($gaji->total_gaji) * 0.05) +
                    (floatval($gaji->total_gaji) * 0.05) +
                    (floatval($gaji->total_gaji) * 0.057),
                    0, ',', '.') 
                }}</th>
            </tr>
        </table>
        
        <h3>Total Gaji Bersih:</h3>
        <table>
            <tr>
                <td><strong>Gaji Bersih:</strong></td>
                <td>Rp {{ number_format(
                    floatval($gaji->total_gaji) -
                    (floatval($gaji->total_gaji) * 0.05) -
                    (floatval($gaji->total_gaji) * 0.05) -
                    (floatval($gaji->total_gaji) * 0.057),
                    0, ',', '.') 
                }}</td>
            </tr>
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
