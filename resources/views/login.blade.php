<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tutorial Login Laravel</title>
    <link rel="shortcut icon" href="gambar/icon_app.png">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Righteous&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        html, body {
            height: 100%;
            margin: 0;
        }
        body {
            display: flex;
            align-items: center; /* Aligns vertically center */
            justify-content: center; /* Aligns horizontally center */
            background-color: #220B44; /* Optional: adds background color */
        }
        h1 {
            color: #ffff;
            font-family: 'Righteous', sans-serif;
        }
        label {
            color: #ffff;
            font-family: 'Poppins', sans-serif;
        }
        input[type="text"], input[type="password"] {
            transition: all 0.3s ease-in-out;
            border-radius: 5px;
            border: 2px solid #ccc;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            box-shadow: 0 0 15px rgba(34, 11, 68, 0.8);
            border: 2px solid #220B44;
            transform: scale(1.05);
        }
        .btn-danger {
            margin-top: 25px;
            background-color: #d9534f;
            border-color: #d9534f;
            padding: 10px 30px;
            font-weight: 600;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }
    </style>
</head>
<body>
    <div class="container"><br>
        <div class="col-md-4 col-md-offset-4">
            <h1 class="text-center">PendidikPay</h1>
            <hr>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('loginaksi') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="usernameadmin" class="form-control" placeholder="Username" required="">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" name="passwordadmin" class="form-control" placeholder="Password" required="" id="passwordInput">
                        <span class="input-group-addon">
                            <i id="togglePassword" class="fas fa-eye" onclick="togglePasswordVisibility()"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger btn-block">Log In</button>
                <hr>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('passwordInput');
            var toggleIcon = document.getElementById('togglePassword');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

    <!-- Menampilkan Notifikasi -->
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</body>
</html>
