@extends('index')

@section('judultitle', 'Beranda')

@section('konten')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    h1, h2, h3 {
        font-family: 'Righteous', sans-serif;
        text-align: center;
        margin-top: 20px;
    }

    p {
        font-family: 'Poppins', sans-serif;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .col {
        margin: 0.5em;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
        font-family: 'Poppins', sans-serif;
        transition: background-color 0.3s;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .card-title {
        font-family: 'Righteous', sans-serif;
    }

    #current-time {
        font-size: 2em;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .col-md-9, .col-md-3 {
            flex: 1 1 100%;
        }
    }

    #calendar {
        max-width: 100%; /* Atur lebar maksimal kalender */
    }
</style>

<div class="wrapper d-block">
    <div class="container-fluid mt-3">
        <div class="row">
            <!-- Grid Kiri (9) -->
            <div class="col-md-9">
                <div class="row">
                    <!-- Card Data Guru -->
                    <div class="col-md-4">
                        <div class="card">
                            <i class="fas fa-user-tie fa-5x pt-3"></i> 
                            <div class="card-body">
                                <h5 class="card-title">Data Guru</h5>
                                <h3 class="card-title">{{ $jumlahGuru }}</h3>
                                <p class="card-text">Menyajikan informasi tentang data diri dari para guru.</p>
                                <a href="/guru" class="btn btn-danger">Lihat Data <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Data Absen -->
                    <div class="col-md-4">
                        <div class="card">
                            <i class="fas fa-chalkboard-teacher fa-5x pt-3"></i> 
                            <div class="card-body">
                                <h5 class="card-title">Data Absen</h5>
                                <h3 class="card-title">{{ $jumlahAbsen }}</h3>
                                <p class="card-text">Menyajikan catatan kehadiran dan waktu mengajar dari para guru.</p>
                                <a href="/absen" class="btn btn-danger">Lihat Data <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Data Gaji -->
                    <div class="col-md-4">
                        <div class="card">
                            <i class="fas fa-money-bill-wave fa-5x pt-3"></i>
                            <div class="card-body">
                                <h5 class="card-title">Data Gaji</h5>
                                <h3 class="card-title">{{ $jumlahGaji }}</h3>
                                <p class="card-text">Menyajikan informasi mengenai laporan gaji dari para guru.</p>
                                <a href="/gaji" class="btn btn-danger">Lihat Data <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Card Grafik Kenaikan Gaji -->
                <div class="col-lg-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Grafik Kenaikan Gaji per Bulan</h5>
                            <canvas id="grafikGaji"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Grid Kanan (3) -->
            <div class="col-md-3 h-100">
                <!-- Card Jam Saat Ini -->
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">Jam Saat Ini</h5>
                        <div id="current-time"></div>
                        <div id="calendar" class="mt-3""></div>
                    </div>
                </div>
    
                <!-- Card 5 Pegawai Terbaru -->
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pegawai Terbaru</h5>
                            <table class="table">
                                <tbody>
                                    @foreach ($guruTerbaru as $guru)
                                        <tr>
                                            <td><img src="{{ asset('foto_guru/' . $guru->foto) }}" alt="{{ $guru->namaguru }}" style="width: 50px; height: 50px; border-radius: 50%;"></td>
                                            <td class="ms-3 text-start">{{ $guru->namaguru }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer Section -->
    <div class="container-fluid mt-5">
        <hr>
        <div id="testimonialCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner text-center">
                <div class="carousel-item active">
                    <p>"PendidikPay telah membuat proses penggajian kami lebih efisien dan transparan. Kami sangat merekomendasikan!"</p>
                </div>
                <div class="carousel-item">
                    <p>"Dengan PendidikPay, saya tidak perlu khawatir tentang keterlambatan gaji lagi. Sangat membantu!"</p>
                </div>
                <div class="carousel-item">
                    <p>"Platform yang mudah digunakan dan sangat bermanfaat bagi kesejahteraan guru."</p>
                </div>
            </div>
            <a class="carousel-control-prev" href="#testimonialCarousel" role="button" data-slide="prev">
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#testimonialCarousel" role="button" data-slide="next">
                <span class="sr-only">Next</span>
            </a>
        </div>
        <hr class="mt-1">
        <div class="faq-section bg-light mt-5">
            <h2 class="faq-title">Pertanyaan Yang Sering Diajukan</h2>
            <div id="faqAccordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Bagaimana cara kerja PendidikPay?<i class="fas fa-chevron-down ms-3"></i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqAccordion">
                        <div class="card-body">
                            PendidikPay bekerja dengan mengotomatiskan proses penggajian guru berdasarkan kinerja dan kehadiran mereka, memastikan pembayaran yang tepat waktu dan transparan.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Apakah data saya aman di PendidikPay?<i class="fas fa-chevron-down ms-3"></i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                        <div class="card-body">
                            Ya, kami menggunakan teknologi keamanan terbaru untuk memastikan bahwa semua data guru terlindungi dengan baik.
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana cara saya menghubungi tim dukungan?<i class="fas fa-chevron-down ms-3"></i>
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqAccordion">
                        <div class="card-body">
                            Anda dapat menghubungi tim dukungan kami melalui formulir kontak di bawah ini atau melalui email jatibintang16@gmail.com.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="contact bg-light pt-2 mt-5 pb-4 rounded p-5 mb-3">
            <h2 class="text-center">Hubungi Kami</h2>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" class="form-control" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan</label>
                    <textarea class="form-control" id="message" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-danger w-50">Kirim Pesan <i class="fas fa-paper-plane ms-2"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
<script src="{{asset('bs/js/clock.js')}}"></script>

<script>
    // Script untuk Jam Saat Ini
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        document.getElementById('current-time').textContent = timeString;
    }
    setInterval(updateTime, 1000);
    updateTime(); // Initial call to set the time immediately

    $(document).ready(function() {
        var today = new Date();
        $('#calendar').fullCalendar({
            header: {
                left : 'prev,next ',
                center: 'title',
                right : 'today,month,agendaDay'
            },
            defaultDate: today,
            navLinks: true, 
            editable: true,
            eventLimit: true,
        });
        $('#calendar').fullCalendar('gotoDate', today);
    });
</script>

<script>
   // Mengatur ukuran canvas dengan JavaScript
const grafikGajiCanvas = document.getElementById('grafikGaji');
grafikGajiCanvas.width = 800; // Lebar sesuai dengan kontainer, dikurangi 20px untuk padding
grafikGajiCanvas.height = 400; // Tinggi yang diinginkan

// Inisialisasi Chart.js setelah mengatur ukuran
const ctx = grafikGajiCanvas.getContext('2d');
const grafikGaji = new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($gajiPerBulan->pluck('bulan')),
        datasets: [{
            label: 'Total Gaji',
            data: @json($gajiPerBulan->pluck('total')),
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif

@endsection
