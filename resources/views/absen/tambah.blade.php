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
                <h4 class="modal-title" id="tambahModalLabel">Tambah Data Absen</h4>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form name="tambahFrom" id="tambahForm" action="/absen/tambah" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nik">Pegawai :</label>
                        <select class="form-select w-100" id="nik" name="nik" required>
                            @foreach ($var_guru as $guru)
                                <option value="{{ $guru->idguru }}">{{ $guru->nik }} | {{ $guru->namaguru }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group m-2">
                        <label>Jumlah Jam/Hari :</label>
                        <input type="number" class="form-control" id="jumlah_jam" name="jumlah_jam" required min="1" max="10">
                    </div>

                    <div class="form-group m-2">
                        <label>Jumlah Hari/Bulan :</label>
                        <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari" required min="1" max="30">
                    </div>

                    <div class="form-group m-2">
                        <label for="tanggal">Tanggal :</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required readonly>
                    </div>

                    <button type="submit" class="btn btn-success" style="margin-top: 20px;"><i class="fas fa-plus me-2"></i> Tambah</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"style=" margin-top: 20px;"><i class="fas fa-times me-2"></i> Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>