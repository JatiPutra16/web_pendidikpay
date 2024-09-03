<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absen</title>
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
            padding: 5px;
            text-align: left;
            font-size: 10px;
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
        <h5>Laporan Absen</h5>
        <h3>Bulan: {{ $namaBulan }} {{ $tahun }}</h3>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Guru</th>
                    <th>Jumlah Jam</th>
                    <th>Jumlah Hari</th>
                    <th>Tanggal Pencatatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($absen as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->guru->nik }}</td>
                        <td>{{ $item->guru->namaguru }}</td>
                        <td>{{ $item->jumlah_jam }}</td>
                        <td>{{ $item->jumlah_hari }}</td>
                        <td>{{ date('Y-m-d', strtotime($item->tanggal)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="signature">
        <p>Mengetahui,</p>
        <p><strong>Kepala Sekolah</strong></p>
        <br><br>
        <p>(_______________________)</p>
    </div>

    <div class="footer">
        <p>PendidikPay</p>
    </div>
</body>
</html>