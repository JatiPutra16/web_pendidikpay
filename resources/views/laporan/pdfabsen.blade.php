<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absen</title>
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
    </style>
</head>
<body>
    <!-- KOP Surat -->
    <div class="kop-surat">
        <h1>Laporan Absen Guru</h1>
        <h2>SMK Negeri 1 Cimahi</h2>
        <h3>Jl. Mahar Martanegara No.48, Utama, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40533</h3>
        <p>Telepon: 022-6629683 | Email: info@smkn1-cmi.sch.id</p>
    </div>

    <!-- Header -->
    <div class="header">
        <h5>PendidikPay</h5>
        <h3>Laporan Absen</h3>

        @if(!empty($nik))
            <h4>NIK: {{ $nik }}</h4>
        @endif
        @if(!empty($namaguru))
            <h4>Guru: {{ $namaguru }}</h4>
        @endif
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
                    <th>Jumlah Jam</th>
                    <th>Jumlah Hari</th>
                    <th>Tanggal Pencatatan</th>
                    <th>Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($var_absen as $index => $b)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $b->guru->nik }}</td>
                        <td>{{ $b->guru->namaguru }}</td>
                        <td>{{ $b->jumlah_jam }}</td>
                        <td>{{ $b->jumlah_hari }}</td>
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
