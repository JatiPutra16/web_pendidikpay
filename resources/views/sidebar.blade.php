<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
}

a {
    text-decoration: none;
}

li {
    list-style: none;
}

#sidebar {
    width: 60px;
    height: 100vh;
    position: fixed;
    left: 0;
    z-index: 9999;
    overflow-x: hidden;
    overflow-y: auto;
}

.navbar{
    position: fixed;
    width: 97%;
    margin-left: 60px;
    z-index: 888;
    align-content: center;
}

.content-container{
    margin-top: 80px;
    margin-left: 80px;
    width: 94%;
}
</style>

<div>
    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex bg-white pb-2">
                <button class="toggle-btn" type="button">
                    <img src="{{asset('gambar/icon_app.png')}}" class="img-fluid">
                </button>
                <div class="sidebar-logo">
                    <img src="{{asset('gambar/icon_text.png')}}" href="home" class="img-fluid">
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="home" class="sidebar-link" title="Beranda">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="guru" class="sidebar-link" title="Data Guru">
                        <i class="fas fa-users"></i>
                        <span>Data Guru</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="absen" class="sidebar-link" title="Data Absen">
                        <i class="fas fa-user-check"></i>
                        <span>Data Absen</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="gaji" class="sidebar-link" title="Data Gaji"> 
                        <i class="fas fa-coins"></i>
                        <span>Data Gaji</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="laporan" class="sidebar-link" title="Laporan"> 
                        <i class="fas fa-file-alt"></i> 
                        <span>Laporan</span>
                    </a>
                </li>
            </ul>            
            
            <div class="d-flex bg-white">
                <li class="sidebar-footer bg-white">
                    <a class="sidebar-link" href="https://www.smkn1-cmi.sch.id/" target="_blank">
                        <img src="{{asset('gambar/icon_smk.png')}}" class="img-fluid">
                    </a>
                </li>
                <div class="sidebar-logo sidebar-link">
                    <a href="https://www.smkn1-cmi.sch.id/" target="_blank">SMK Negeri 1 Cimahi</a>
                </div>
            </div>
            <div class="d-flex bg-white">
                <i class="sidebar-footer bg-white">
                    <a class="sidebar-link" href="https://www.instagram.com/rpl.stmnpbdg/" target="_blank">
                        <img src="{{asset('gambar/icon_rpl.png')}}" class="img-fluid">
                    </a>
                </i>
                <div class="sidebar-logo">
                    <a href="https://www.instagram.com/rpl.stmnpbdg/" target="_blank">Rekayasa 
                    <p>
                        Perangkat Lunak
                    </a>
                </div>
            </div>
            <form id="logoutForm" action="{{ route('logout') }}" method="post">
                @csrf
                <li class="sidebar-footer bg-red" title="Logout">
                    <a href="logout" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="lni lni-exit"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </form>
        </aside>

        <!--  lOGOUT MODAL -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin keluar?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



<script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous">
</script>


<script>
const hamBurger = document.querySelector(".toggle-btn");

hamBurger.addEventListener("click", function () {
document.querySelector("#sidebar").classList.toggle("expand");
});

document.addEventListener("DOMContentLoaded", function () {
            var navbarToggler = document.querySelector(".navbar-toggler");
            var navbarCollapse = document.querySelector("#navbarSupportedContent");

            navbarCollapse.addEventListener("click", function () {
                navbarToggler.click();
            });
        });
</script>



