<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    overflow-x: hidden; /* Mencegah scroll horizontal */
    margin: 0;
    padding: 0;
}

a {
    text-decoration: none;
}

li {
    list-style: none;
}

#sidebar {
    width: 240px;
    height: 100vh;
    z-index: 1000;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #220B44;
    transition: transform 0.25s ease-in-out;
    transform: translateX(0); /* Sidebar default terbuka */
    display: flex;
    flex-direction: column; /* Mengatur elemen di dalam sidebar dalam kolom */
    justify-content: space-between;
}

.sidebar-closed {
    transform: translateX(-240px); /* Menyembunyikan sidebar */
}

#main-content {
    transition: margin-left 0.25s ease-in-out;
    margin-left: 240px; /* Konten bergeser saat sidebar terbuka */
    width: calc(100% - 240px); /* Lebar konten saat sidebar terbuka */
}

.content-expanded {
    margin-left: 0; /* Konten bergeser saat sidebar tertutup */
    width: 100%; /* Konten memenuhi seluruh lebar layar saat sidebar tertutup */
}

.navbar {
    position: fixed;
    width: 100%;
    z-index: 888;   
}

.content-container {
    margin-top: 80px;
    width: 100%;
}

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 10px;
    color: #fff;
    text-decoration: none;
    transition: background-color 0.3s ease-in;
}

.sidebar-link.active {
    background-color: rgba(255, 255, 255, .075);
    border-left: 3px solid #D03737;
}

.sidebar-link.active i {
    color: #fff;
}

.sidebar-link.active span {
    font-weight: bold;
}

/* Responsif: sidebar otomatis tertutup di layar kecil */
@media (max-width: 768px) {
    #sidebar {
        transform: translateX(-240px); /* Sidebar tertutup di layar kecil */
    }

    #sidebar.sidebar-open {
        transform: translateX(0); /* Membuka sidebar di layar kecil */
    }

    #main-content {
        margin-left: 0;
        width: 100vw; /* Memastikan konten menggunakan lebar penuh di layar kecil */
    }

    .toggle-sidebar-menu {
        display: block;
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .admin{
        margin-right: 0px;
    }
}
</style>

<div>
    <div class="container-fluid">
        <aside id="sidebar" class="p-0 m-0">
            <div class="d-flex bg-white pb-2">
                <button class="toggle-btn" type="button">
                    <img src="{{asset('gambar/icon_app.png')}}" class="img-fluid" width="60px">
                </button>
                <div class="sidebar-logo">
                    <img src="{{asset('gambar/icon_text.png')}}" href="home" class="img-fluid">
                </div>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="{{ url('home') }}" class="sidebar-link {{ Request::is('home') ? 'active' : '' }}" title="Beranda">
                        <i class="fas fa-home"></i>
                        <span>Beranda</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('guru') }}" class="sidebar-link {{ Request::is('guru') ? 'active' : '' }}" title="Data Guru">
                        <i class="fas fa-users"></i>
                        <span>Data Guru</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('absen') }}" class="sidebar-link {{ Request::is('absen') ? 'active' : '' }}" title="Data Absen">
                        <i class="fas fa-user-check"></i>
                        <span>Data Absen</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('gaji') }}" class="sidebar-link {{ Request::is('gaji') ? 'active' : '' }}" title="Data Gaji">
                        <i class="fas fa-coins me-3"></i>
                        <span>Data Gaji</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('laporan') }}" class="sidebar-link {{ Request::is('laporan') ? 'active' : '' }}" title="Laporan">
                        <i class="fas fa-file-alt me-3"></i>
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
    </div>

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


{{-- <script>
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
</script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const toggleSidebarBtn = document.getElementById('toggleSidebar'); // Tombol navbar

        // Toggle sidebar ketika tombol ditekan
        toggleSidebarBtn.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-closed');
            sidebar.classList.toggle('sidebar-open');
            
            // Perbarui lebar konten berdasarkan status sidebar
            if (sidebar.classList.contains('sidebar-closed')) {
                mainContent.classList.add('content-expanded');
            } else {
                mainContent.classList.remove('content-expanded');
            }
        });
    });

    document.addEventListener('click', function (event) {
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarBtn = document.getElementById('toggleSidebar');

        // Tutup sidebar jika klik terjadi di luar sidebar dan tombol toggle
        if (!sidebar.contains(event.target) && !toggleSidebarBtn.contains(event.target) && sidebar.classList.contains('sidebar-open')) {
            sidebar.classList.remove('sidebar-open');
            sidebar.classList.add('sidebar-closed');
            document.getElementById('main-content').classList.add('content-expanded');
        }
    });

</script>




