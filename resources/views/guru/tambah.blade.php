<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    h4{
        font-family: 'Righteous', sans-serif;
        color: white;
    }

    .bg-blue{
        background-color: #220B44;
    }
</style>

<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="tambahModalLabel">Tambah Guru</h4>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form name="tambahFrom" id="tambahForm" action="/guru/tambah" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="nik">NIK :</label>
                        <input type="number" class="form-control" id="nik" name="nik" required>
                    </div>

                    <div class="form-group m-2">
                        <label>Nama Lengkap :</label>
                        <input type="text" class="form-control" id="namaguru" name="namaguru" required>
                    </div>

                    <div class="form-group m-2">
                        <label>Foto :</label>
                        <input type="file" class="form-control" id="foto" name="foto" required>
                    </div>

                    <div class="form-group m-2">
                        <label>Alamat :</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="4" required></textarea>
                    </div>

                    <div class="form-group m-2">
                        <label>No Telepon :</label>
                        <input type="number" class="form-control" id="tlp" name="tlp" required>
                    </div>

                    <div class="form-group m-2">
                        <label>Gaji Perjam :</label>
                        <input type="text" class="form-control" id="gajiperjam" name="gajiperjam" required>
                    </div>

                    <button type="submit" class="btn btn-success" style="margin-top: 20px;"><i class="fas fa-plus me-2"></i> Tambah</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"style=" margin-top: 20px;"><i class="fas fa-times me-2"></i> Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>