<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pendidik Pay</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{asset('bs/css/bootstrap.css')}}">
    <link rel="shortcut icon" href="gambar/icon_app.png">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="{{asset('bs/js/jquery.js')}}"></script>
    <script src="{{asset('bs/js/bootstrap.js')}}"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        
        body {
            background-color: #290849;
            color: white;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            max-width: 1200px;
            padding: 20px;
        }

        .col-lg-6 {
            padding: 20px;
        }

        h1 {
            font-size: 70px;
            font-weight: bold;
            text-align: left;
            margin-bottom: 20px;
            font-family: 'Righteous', sans-serif;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 10px;
            text-align: left;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d9534f;
            padding: 10px 30px;
            font-size: 1.2rem;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }

        .col-lg-6 img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Align items to the left */
            text-align: left;
        }

        @media (max-width: 768px) {
            .col-lg-6 {
                text-align: center;
            }

            .col-lg-6 img {
                margin-left: auto;
                margin-right: auto;
            }

            p {
                font-size: 1rem;
            }

            .btn-danger {
                padding: 8px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 animate__animated animate__fadeIn" style="animation-duration: 2s;">
                <img src="{{asset('gambar/Header_web.png')}}" class="img-fluid rounded">
            </div>
            <div class="col-12 col-lg-6 content">
                <div style="text-align: left;">
                    <h1>Welcome</h1>
                    <p>Pendidik Pay adalah platform inovatif untuk penggajian guru yang menawarkan pengalaman pembayaran yang mudah dan adil. Fokus pada gaji tepat waktu, transparansi, dan perhitungan otomatis berdasarkan kinerja, Pendidik Pay bertujuan meningkatkan kesejahteraan guru dan mendukung kualitas pendidikan yang lebih baik.</p>
                    <p>Email    : jatibintang16@gmail.com</p>
                    <p>Phone    : +62-821-2034-4425</p>
                </div>
                <div class="d-flex mt-3">
                    <a href="login" class="btn btn-danger btn-lg">Get Started As Admin</a>
                    <div class="ms-5">
                        <img src="{{asset('gambar/icon_rplsmk.png')}}" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Set the body opacity to 1 after the document is fully loaded
        $(document).ready(function(){
            $("body").css("opacity", "1");
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
</body>
</html>
