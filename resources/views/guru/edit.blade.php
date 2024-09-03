<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    h5{
        font-family: 'Righteous', sans-serif;
        color: white;
    }

    label{
        font-family: 'Righteous', sans-serif;
        color: #220B44;
    }

    .bg-blue{
        background-color: #220B44;
    }
</style>

@foreach ($var_guru as $index => $b)
    <div class="modal fade" id="editModal{{$b->idguru}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$b->idguru}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="editModalLabel{{$b->idguru}}">Edit Data Guru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm{{$b->idguru}}" action="/guru/update/{{$b->idguru}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group m-2">
                            <label for="nik">NIK :</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ $b->nik }}" required>
                        </div>

                        <div class="form-group m-2">
                            <label>Nama Lengkap :</label>
                            <input type="text" class="form-control" id="namaguru" name="namaguru" value="{{ $b->namaguru }}" required>
                        </div>

                        <div class="form-group m-2">
                            <label>Foto :</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>

                        <div class="form-group m-2">
                            <label>Alamat :</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $b->alamat }}" required>
                        </div>

                        <div class="form-group m-2">
                            <label>No Telepon :</label>
                            <input type="text" class="form-control" id="tlp" name="tlp" value="{{ $b->tlp }}" required>
                        </div>

                        <div class="form-group m-2">
                            <label>Gaji Perjam :</label>
                            <input type="text" class="form-control" id="gajiperjam" name="gajiperjam" value="{{ $b->gajiperjam }}" required>
                        </div>

                            <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"style="margin-top: 20px;">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach