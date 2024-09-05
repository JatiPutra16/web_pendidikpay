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

@foreach ($var_absen as $index => $b)
    <div class="modal fade" id="editModal{{$b->idabsen}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$b->idabsen}}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <h5 class="modal-title" id="editModalLabel{{$b->idabsen}}">Edit Data Absen Guru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm{{$b->idabsen}}" action="/absen/update/{{$b->idabsen}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>NIK :</label>
                            <select class="form-control" id="nik" name="nik" required>
                            @foreach ($var_guru as $guru)
                                <option value="{{ $guru->idguru }}" {{ $guru->idguru == $b->idguru ? 'selected' : '' }}>{{ $guru->nik }} | {{ $guru->namaguru }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group m-2">
                            <label>Jumlah Jam/Hari :</label>
                            <input type="number" class="form-control" id="jumlah_jam" name="jumlah_jam" value="{{ $b->jumlah_jam }}" required min="1" max="10">
                        </div>

                        <div class="form-group m-2">
                            <label>Jumlah Hari/Bulan :</label>
                            <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari" value="{{ $b->jumlah_hari }}" required min="1" max="30">
                        </div>

                        <div class="form-group">
                            <label>Tanggal:</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $b->tanggal}}" required>
                        </div>

                        <button type="submit" class="btn btn-success" style="margin-top: 20px;"><i class="fas fa-save me-2"></i> Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"style=" margin-top: 20px;"><i class="fas fa-times me-2"></i> Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
