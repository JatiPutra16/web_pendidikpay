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

<div class="container mt-2">
    <div class="bg-white rounded px-3 py-1 mb-3 d-flex justify-content-between">
        <div class="me-3">
            <h1>Data Guru</h1>
            <p>Berikut adalah informasi tentang para guru honorer:</p>
        </div>
        <div class="tombol-container mt-2 d-flex" style="flex-grow: 1; justify-content: right;">
            <button class="btn btn-success mb-3" data-toggle="modal" data-target="#tambahModal"><i class="fas fa-plus pe-2"></i>Tambah Data Guru</button>
        </div>
    </div>
    <div class="table-responsive bg-white rounded p-4">
        <table class="table table-striped" id="datatabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Foto</th>
                    <th>Nama Guru</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>Gaji/jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($var_guru as $index => $b)
                <tr>
                    <td>{{$index+1}}</td>
                    <td>{{$b->nik}}</td>
                    <td><img src="{{ asset('foto_guru/'.$b->foto) }}" alt="" width="100" height="100" title="gambar"></td>
                    <td>{{$b->namaguru}}</td>
                    <td>{{$b->alamat}}</td>
                    <td>{{$b->tlp}}</td>
                    <td>Rp {{ number_format(floatval($b->gajiperjam), 0, ',', '.') }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-warning my-1" onclick="openEditModal({{ $b->idguru }})">
                                <i class="fas fa-edit text-white"></i>
                            </button>
                            <button class="btn btn-danger my-1" onclick="openDeleteModal({{ $b->idguru }}, '{{ $b->nik }}', '{{ $b->namaguru }}')">
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

    @include('guru.tambah')

    @include('guru.edit')

    @include('guru.delete')

    <script>
        function openEditModal(id) {
            $('#editModal' + id).modal('show');
        }
    </script>

    <script>
        function openDeleteModal(id, nik, namaguru) {
            $('#deleteModal').modal('show');
            $('#deleteId').val(id);
            $('#deleteInfo').html('NIK: ' + nik + '<br>Nama Guru: ' + namaguru);
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatabel').DataTable();
        });
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