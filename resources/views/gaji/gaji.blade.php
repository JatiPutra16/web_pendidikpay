@extends('index')

@section('judultitle', ' - Data Guru')

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
            <h1>Data Gaji</h1>
            <p>Berikut adalah informasi tentang laporan gaji para guru:</p>
        </div>
        <div class="tombol-container mt-2 d-flex" style="flex-grow: 1; justify-content: right;">
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#tambahModal"><i class="lni lni-plus pe-2"></i>Bayar Gaji Pendidik</button>
        </div>
    </div>
    <div class="table-responsive bg-white rounded p-4">
            <div class="d-flex justify-content-between">
                <div class="filter-container mb-3">
                    <select id="monthFilter" class="form-select">
                        <option value="">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div>
                    <button onclick="cetakPDF()" class="btn btn-secondary"><i class="fas fa-print me-2"></i>Cetak PDF</button>
                </div>
            </div>
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
                    <th>Aksi</th>
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
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button onclick="cetakPDFprive({{$b->idgaji}})" class="btn btn-primary my-1 w-100">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                            <button onclick="openDeleteModal({{ $b->idgaji }}, '{{ $b->absen->guru->nik }}', '{{ $b->absen->guru->namaguru }}')" class="btn btn-danger my-1 w-100">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </div>
                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

    @include('gaji.tambah')

    @include('gaji.delete')

    <script>
        function openDeleteModal(id, nik, nama) {
            $('#deleteModal').modal('show');
            $('#deleteId').val(id);
            $('#deleteInfo').html('NIK: ' + nik + '<br>Nama Guru: ' + nama); // Gunakan parameter nama
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatabel').DataTable({
                "columnDefs": [
                    { "type": "date", "targets": 7 } // Ensure this targets the 'Tanggal Gaji' column correctly
                ]
            });

            $('#monthFilter').change(function() {
                var selectedMonth = this.value;
                $.fn.dataTable.ext.search.pop(); // Clear previous search

                if (selectedMonth) {
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var date = new Date(data[7]); // Ensure this is the index of 'Tanggal Gaji'
                            var month = date.getMonth() + 1; // getMonth() is zero-based
                            return month === parseInt(selectedMonth);
                        }
                    );
                } else {
                    $.fn.dataTable.ext.search.pop(); // Remove filter if no month is selected
                }
                table.draw();
            });
        });
    </script>

    <script>
        function cetakPDF(id = null) {
            var bulan = document.getElementById('monthFilter').value;
            var url = "/gaji/cetak-pdf/" + (bulan ? bulan : 'all');
            if (id) {
                url += '/' + id;
            }
            window.location.href = url;
        }

        function cetakPDFprive(idgaji) {
            var url = "/gaji/cetak-pdf-prive/" + idgaji;
            window.location.href = url;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

@endsection