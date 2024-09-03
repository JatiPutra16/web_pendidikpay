<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
    
    h3{
        font-family: 'Righteous', sans-serif;
        color: white;
    }

    .bg-blue{
        background-color: #220B44;
    }

    .card {
        transition: transform 0.2s;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .card-body {
        text-align: center; 
    }

    .card-body h5 {
        font-family: 'Righteous', sans-serif;
        text-align: center;
    }

    .tentang-text label{
        font-family: 'Poppins', sans-serif;
        color: white;
    }

    .profil-text h2, h5{
        font-family: 'Righteous', sans-serif;
        color: white;
    }

    .profil-text label{
        font-family: 'Poppins', sans-serif;
        color: white;
    }

    

</style>

<div class="main">
    <nav class="navbar navbar-expand-lg navbar-dark bg-white">
        <button class="bg-danger navbar-toggler ms-auto me-5" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggle" aria-controls="navbarToggle"  aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse mt-1" id="navbarToggle">
            <ul class="container navbar-nav me-auto ">
                <li class="nav-item menu">
                    <a class="nav-link" href="home" style="cursor: pointer">
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="nav-item menu disabled" style="cursor: pointer">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#tentangModal">
                        <span>Tentang</span>
                    </a>
                </li>
                <li class="nav-item menu disabled" style="cursor: pointer">
                    <a class="nav-link" data-toggle="modal" data-target="#kontakModal">
                        <span>Kontak</span>
                    </a>
                </li>
                <li class="nav-item menu disabled" style="cursor: pointer">
                    <a class="nav-link" data-toggle="modal" data-target="#profilModal">
                        <span>Profil</span>
                    </a>
                </li>
                <li class="admin bg-white p-1 rounded ms-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <span>Hello Admin</span>
                            <img src="{{asset('gambar/account.png')}}" class="avatar img-fluid">
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
    <!--  TENTANG MODAL -->
    <div class="modal fade " id="tentangModal" tabindex="-1" aria-labelledby="tentangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h3 class="modal-title" id="tentangModalLabel">Tentang Aplikasi</h3>
                </div>
                <div class="modal-body bg-blue" style="max-height: 500px; overflow-y: auto;"> 
                    <div>
                        <img src="{{asset('gambar/Header_web.png')}}" class="img-fluid rounded">
                    </div>
                    <div class="bg-blue p-3">
                        <div class="tentang-text">
                            <label style="text-align: justify;">Pendidik Pay merupakan aplikasi inovatif yang dirancang khusus untuk meningkatkan pengalaman penggajian bagi guru di SMK Negeri 1 Cimahi. Aplikasi ini berfokus pada tiga pilar utama: efisiensi keuangan, transparansi dalam penggajian, dan peningkatan keterlibatan guru. Melalui Pendidik Pay, guru dapat dengan mudah mengelola profil pribadi mereka, mengajukan permintaan penggajian tambahan, dan mengakses laporan keuangan pribadi mereka kapan saja dan di mana saja. Dengan mengadopsi sistem perhitungan otomatis yang berbasis kinerja, aplikasi ini menjamin pembayaran gaji yang adil dan proporsional, memastikan setiap guru menerima kompensasi yang sesuai dengan kontribusi mereka.</label>
                            <br></br>
                            <label style="text-align: justify;">Salah satu keunggulan Pendidik Pay adalah fokusnya pada kemudahan akses terhadap informasi penting. Guru akan menerima notifikasi gaji secara real-time, membantu mereka dalam perencanaan keuangan pribadi dengan lebih baik. Selain itu, dukungan untuk pelaporan pajak yang disediakan oleh aplikasi ini memudahkan guru dalam memenuhi kewajiban pajak mereka, mengurangi kekhawatiran dan kesulitan administratif. Dengan berbagai fitur yang ditawarkan, Pendidik Pay tidak hanya bertujuan untuk memperbaiki proses penggajian tetapi juga bertujuan untuk menciptakan lingkungan kerja yang lebih kondusif dan memotivasi di SMK Negeri 1 Cimahi. Aplikasi ini mewujudkan komitmen sekolah untuk memastikan kesejahteraan guru, sekaligus mendukung efisiensi operasional dan transparansi finansial.</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-blue">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

<!-- KONTAK MODEL -->
<div class="modal fade" id="kontakModal" tabindex="-1" aria-labelledby="kontakModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h3 class="modal-title" id="kontakModalLabel">Kontak Pembuat</h3>
            </div>
            <div class="modal-body bg-blue">
                <div class="container">
                    <div>
                        <div>
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-danger text-white mt-3">Informasi Kontak</div>
                                <div class="card-body text-dark m-1">
                                    <a href="mailto:jatibintang16@gmail.com" class="text-decoration-none">
                                        <div class="card card-body m-1">
                                            <p class="card-text">
                                                <i class="fas fa-envelope"></i>
                                                <span class="ms-2">Email: <span>
                                                jatibintang16@gmail.com
                                            </p>
                                        </div>
                                    </a>
                                    <a href="tel:+6282120344425" class="text-decoration-none">
                                        <div class="card card-body m-1">
                                            <p class="card-text">
                                                <i class="fas fa-phone"></i>
                                                <span class="ms-2">Nomor Handphone: </span> 
                                                +6282120344425
                                            </p>
                                        </div>
                                    </a>
                                    <a href="https://www.instagram.com/jt.putraa/" class="text-decoration-none" target="_blank">
                                        <div class="card card-body m-1">
                                            <p class="card-text">
                                                <i class="fab fa-instagram"></i> 
                                                <span class="ms-2">Instagram: </span>
                                                jt.putraa
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card border-danger mb-3">
                                <div class="card-header bg-danger text-white mt-3">Alamat</div>
                                <div class="card-body text-dark m-1">
                                    <a href="https://www.google.com/maps?q=Jl.+Bukit+Permata+G2+No.+39,+Cilame,+Ngamparah+Kabupaten+Bandung+Barat,+Indonesia" class="text-decoration-none" target="_blank">
                                        <div class="card card-body m-1">
                                            <p class="card-text">
                                                <i class="fas fa-map-marker-alt"></i> 
                                                <span class="ms-2">Alamat: </span>
                                                Jl. Bukit Permata G2 No. 39, Cilame, Ngamparah Kabupaten Bandung Barat, Indonesia
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- PROFILE MODAL -->
<div class="modal fade" id="profilModal" tabindex="-1" aria-labelledby="tentangModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h3 class="modal-title" id="tentangModalLabel">Profil Pembuat</h3>
            </div>
            <div class="modal-body bg-blue">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{asset('gambar/jati.png')}}" class="img-fluid rounded-circle mb-3 mb-md-0" style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="profil-text">
                                <h2>Jati Bintang</h2>
                                <h5>Samudera Kharisma Putra</h5>
                                <br>
                                <h5>Informasi Profil</h5>
                                <label style="text-align: justify;">Jati Bintang Samudera Kharisma Putra yang kerap disapa Jati ialah seorang yang berasal dari Bandung dan lahir pada 16 Juni 2006. Dia telah menempuh pendidikan formal di SD Negeri Padasuka Mandiri 3, SMP Negeri 3 Ngamprah, dan SMK Negeri 1 Cimahi. Pada tahun 2022, Jati melanjutkan Pendidikan di SMK Negeri 1 Cimahi, Jurusan RPL (Rekayasa Perangkat Lunak).</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-blue">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>





