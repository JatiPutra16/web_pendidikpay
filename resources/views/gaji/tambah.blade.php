<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    h4 {
        font-family: 'Righteous', sans-serif;
        color: white;
    }

    .bg-blue {
        background-color: #220B44;
    }

    .hidden {
        display: none;
    }
</style>

<!-- Modal Tambah Data Gaji -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue">
                <h4 class="modal-title" id="tambahModalLabel">Tambah Data Gaji</h4>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="tambahForm" id="tambahForm" action="/gaji/tambah" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="idabsen" class="fw-bold">Pegawai :</label>
                        <select class="form-select" id="idabsen" name="idabsen" required>
                            <option value="" disabled selected>Pilih Pegawai</option>
                            @foreach($absen_with_guru as $data)
                                <option value="{{ $data['idabsen'] }}">{{ $data['namaguru'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input otomatis untuk Gaji/Jam -->
                    <div class="form-group m-2">
                        <label for="gajiperjam" class="fw-bold">Gaji/Jam :</label>
                        <input type="text" class="form-control" id="gajiperjam" name="gajiperjam" readonly>
                    </div>

                    <!-- Input otomatis untuk Jumlah Jam Kehadiran -->
                    <div class="form-group m-2">
                        <label for="total_jam" class="fw-bold">Jumlah Jam Kehadiran :</label>
                        <input type="text" class="form-control" id="total_jam" name="total_jam" readonly>
                    </div>

                    <!-- Input otomatis untuk Total Gaji -->
                    <div class="form-group m-2">
                        <label for="total_gaji" class="fw-bold">Total Gaji:</label>
                        <input type="text" class="form-control" id="total_gaji" name="total_gaji" readonly>
                    </div>

                    <!-- Detail Gaji -->
                    <div class="form-group m-2 hidden" id="gajiDetailContainer">
                        <hr>
                        <label for="gajiDetail" class="fw-bold">Detail Potongan Gaji:</label>
                        <ul id="gajiDetail" class="list-unstyled">
                            <li><b>Gaji Kotor:</b> <span id="detailTotalGaji">-</span></li>
                            <li><b>Pajak (5%):</b> <span id="detailPajak">-</span></li>
                            <li><b>BPJS Kesehatan (5%):</b> <span id="detailBPJSKesehatan">-</span></li>
                            <li><b>BPJS Ketenagakerjaan (5.7%):</b> <span id="detailBPJSKetenagakerjaan">-</span></li>
                        </ul>
                        <hr>
                    </div>

                    <!-- Input otomatis untuk Gaji Bersih -->
                    <div class="form-group m-2">
                        <label for="gaji_bersih" class="fw-bold">Gaji Bersih:</label>
                        <input type="text" class="form-control" id="gaji_bersih" name="gaji_bersih" readonly>
                    </div>

                    <!-- Tanggal Gaji -->
                    <div class="form-group m-2">
                        <label for="tgl_gaji" class="fw-bold">Tanggal Gaji:</label>
                        <input type="date" class="form-control" id="tgl_gaji" name="tgl_gaji" value="{{ date('Y-m-d') }}" readonly>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit" class="btn btn-success" style="margin-top: 20px;"><i class="fas fa-plus me-2"></i> Bayar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"style=" margin-top: 20px;"><i class="fas fa-times me-2"></i> Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const idAbsenSelect = document.getElementById('idabsen'); // Deklarasikan idAbsenSelect
        const gajiPerJamInput = document.getElementById('gajiperjam');
        const totalJamInput = document.getElementById('total_jam');
        const totalGajiInput = document.getElementById('total_gaji');
        const gajiBersihInput = document.getElementById('gaji_bersih');

        // Elemen detail gaji
        const gajiDetailContainer = document.getElementById('gajiDetailContainer');
        const detailTotalGaji = document.getElementById('detailTotalGaji');
        const detailPajak = document.getElementById('detailPajak');
        const detailBPJSKesehatan = document.getElementById('detailBPJSKesehatan');
        const detailBPJSKetenagakerjaan = document.getElementById('detailBPJSKetenagakerjaan');

        idAbsenSelect.addEventListener('change', function () {
            const selectedId = this.value;

            // Fetch data gaji per jam
            fetch(`/absen/gajiperjam/${selectedId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Gaji per Jam Data:', data);
                    gajiPerJamInput.value = 'RP ' + parseFloat(data).toLocaleString();
                    updateTotalGaji();
                })
                .catch(error => console.error('Error fetching gaji per jam:', error));

            // Fetch data absensi
            fetch(`/absen/data/${selectedId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Absen Data:', data);
                    if (data) {
                        const totalJam = data.jumlah_jam * data.jumlah_hari;
                        totalJamInput.value = totalJam;
                        updateTotalGaji();
                    }
                })
                .catch(error => console.error('Error fetching absen data:', error));

            // Tampilkan detail gaji setelah memilih pegawai
            gajiDetailContainer.classList.remove('hidden');
        });

        function updateTotalGaji() {
            const totalJam = parseFloat(totalJamInput.value);
            const gajiPerJam = parseFloat(gajiPerJamInput.value.replace('RP ', '').replace(/,/g, ''));

            if (!isNaN(totalJam) && !isNaN(gajiPerJam)) {
                const totalGaji = totalJam * gajiPerJam;
                totalGajiInput.value = 'RP ' + Math.round(totalGaji).toLocaleString();
                detailTotalGaji.textContent = 'RP ' + Math.round(totalGaji).toLocaleString();

                let gajiBersih = totalGaji;
                const pajak = totalGaji * 0.05;
                const bpjsKesehatan = totalGaji * 0.05;
                const bpjsKetenagakerjaan = totalGaji * 0.057;

                gajiBersih -= pajak + bpjsKesehatan + bpjsKetenagakerjaan;

                gajiBersihInput.value = 'RP ' + Math.round(gajiBersih).toLocaleString();
                detailPajak.textContent = 'RP ' + Math.round(pajak).toLocaleString();
                detailBPJSKesehatan.textContent = 'RP ' + Math.round(bpjsKesehatan).toLocaleString();
                detailBPJSKetenagakerjaan.textContent = 'RP ' + Math.round(bpjsKetenagakerjaan).toLocaleString();
            } else {
                totalGajiInput.value = '';
                gajiBersihInput.value = '';
                detailTotalGaji.textContent = '-';
                detailPajak.textContent = '-';
                detailBPJSKesehatan.textContent = '-';
                detailBPJSKetenagakerjaan.textContent = '-';
            }
        }

        totalJamInput.addEventListener('input', updateTotalGaji);
        gajiPerJamInput.addEventListener('input', updateTotalGaji);
    });
</script>
