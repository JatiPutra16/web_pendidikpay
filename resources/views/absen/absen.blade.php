@extends('index')

@section('judultitle', ' - Data Absen')

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
            <h1>Data Absen</h1>
            <p>Berikut adalah informasi tentang data absen para guru tiap bulan:</p>
        </div>
        <div class="tombol-container mt-2 d-flex" style="flex-grow: 1; justify-content: right;">
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus pe-2"></i>Tambah Data Absen</button>
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
            </div>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($var_absen as $index => $b)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$b->guru->nik}}</td>
                        <td>{{$b->guru->namaguru}}</td> 
                        <td>{{$b->jumlah_jam}} jam</td>
                        <td>{{$b->jumlah_hari}} hari</td>
                        <td>{{ \Carbon\Carbon::parse($b->tanggal)->format('d M Y') }}</td>
                        <td>
                            @if ($b->status_gaji == 'Sudah Dibayar')
                                <span class="badge bg-success">{{$b->status_gaji}}</span>
                            @else
                                <span class="badge bg-danger">{{$b->status_gaji}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-warning my-1 text-white" onclick="openEditModal({{ $b->idabsen }})" {{ $b->status_gaji == 'Sudah Dibayar' ? 'disabled' : '' }}>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger my-1" onclick="openDeleteModal({{ $b->idabsen }}, '{{ $b->nik }}', '{{ $b->namaguru }}')" {{ $b->status_gaji == 'Sudah Dibayar' ? 'disabled' : '' }}>
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    @include('absen.tambah')

    @include('absen.edit')

    @include('absen.delete')

    <script>
        function openEditModal(id) {
            $('#editModal' + id).modal('show');
        }
    </script>

    <script>
        function openDeleteModal(id, nik, nama) {
            $('#deleteModal').modal('show');
            $('#deleteId').val(id);
            $('#deleteInfo').html('NIK: ' + nik + '<br>Nama Guru: ' + namaguru);
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#datatabel').DataTable({
                "columnDefs": [
                    { "type": "date", "targets": 5 }
                ]
            });

            $('#monthFilter').change(function() {
                var selectedMonth = this.value;
                $.fn.dataTable.ext.search.pop();

                if (selectedMonth) {
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var date = new Date(data[5]); 
                            var month = date.getMonth() + 1;
                            return month === parseInt(selectedMonth);
                        }
                    );
                }
                table.draw();
            });
        });
    </script>

    <script>
        function cetakPDF() {
            var bulan = document.getElementById('monthFilter').value;
            var url = "/absen/cetak-pdf/" + (bulan ? bulan : '');
            window.location.href = url;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
            });
        @elseif(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
            });
        @endif
    </script>
@endsection