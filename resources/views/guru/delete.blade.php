<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    h5{
        font-family: 'Righteous', sans-serif;
        color: white;
    }

    .modal-body p{
        font-family: 'Poppins', sans-serif;
        color: #220B44;
    }

    .bg-blue{
        background-color: #220B44;
    }
</style>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus Data Guru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data guru dengan informasi berikut?</p>
                <div id="deleteInfo" style="color: bg-blue; font-weight: bold;"></div>
            </div>
            <div class="modal-footer">
                <form method="POST" action="/guru/delete">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="idguru" id="deleteId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
