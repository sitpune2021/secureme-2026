<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Me - Admin Login</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/app.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            overflow: hidden; /* <-- add this */
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(rgba(8, 15, 40, 0.75),
                    rgba(8, 15, 40, 0.88)),
                url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        body::before{
            content:'';
            position:fixed;
            width:500px;
            height:500px;
            background:radial-gradient(circle,#00c6ff55,transparent 70%);
            top:-120px;
            left:-120px;
            animation:floatOrb 8s ease-in-out infinite;
            z-index:0;
        }

        body::after{
            content:'';
            position:fixed;
            width:450px;
            height:450px;
            background:radial-gradient(circle,#0072ff44,transparent 70%);
            bottom:-120px;
            right:-120px;
            animation:floatOrb2 10s ease-in-out infinite;
            z-index:0;
        }

        @keyframes floatOrb{
            0%,100%{
                transform:translateY(0px);
            }
            50%{
                transform:translateY(40px);
            }
        }

        @keyframes floatOrb2{
            0%,100%{
                transform:translateY(0px);
            }
            50%{
                transform:translateY(-40px);
            }
        }
        .login-card::before{
            content:'';
            position:absolute;
            width:180px;
            height:200%;
            background:rgba(255,255,255,0.08);
            top:-50%;
            left:-120%;
            transform:rotate(25deg);
            animation:shine 7s linear infinite;
        }

        @keyframes shine{
            100%{
                left:140%;
            }
        }
        @keyframes floatingCard{
            0%,100%{
                transform:translateY(0px);
            }
            50%{
                transform:translateY(-8px);
            }
        }
        .login-card{
            width:100%;
            max-width:520px;
            position:relative;
            z-index:2;
            overflow:hidden;
            animation:
            fadeIn 0.8s ease,
            floatingCard 5s ease-in-out infinite;

            background:rgba(255,255,255,0.10);
            backdrop-filter:blur(16px);

            border:1px solid rgba(255,255,255,0.12);
            border-radius:26px;

            padding:22px 30px;
        }

        .brand-logo{
            width:62px;
            height:62px;
            margin:auto;
            margin-bottom:10px;

            border-radius:50%;
            background:linear-gradient(135deg,#00c6ff,#0072ff);

            display:flex;
            align-items:center;
            justify-content:center;

            box-shadow:
                0 0 15px rgba(0,198,255,0.5),
                0 0 35px rgba(0,114,255,0.4);

            animation:pulseGlow 2.5s infinite;
        }
        @keyframes pulseGlow{
            0%,100%{
                transform:scale(1);
                box-shadow:
                    0 0 15px rgba(0,198,255,0.5),
                    0 0 35px rgba(0,114,255,0.4);
            }

            50%{
                transform:scale(1.08);
                box-shadow:
                    0 0 25px rgba(0,198,255,0.8),
                    0 0 50px rgba(0,114,255,0.6);
            }
        }
        .form-control:hover{
            background:rgba(255,255,255,0.18);
            transform:translateY(-1px);
        }

        .brand-logo i{
            font-size:26px;
        }

        .login-title{
            text-align:center;
            color:#fff;
            font-size:24px;
            font-weight:700;
            margin-bottom:2px;
        }

        .login-subtitle{
            text-align:center;
            color:rgba(255,255,255,0.7);
            font-size:13px;
            margin-bottom:16px;
        }

        .form-group{
            margin-bottom:12px;
        }

        .form-label{
            margin-bottom:5px;
            font-size:13px;
        }

        .form-control{
            height:46px;
            font-size:14px;
        }

        .input-group i{
            top:14px;
        }

        .remember-wrap{
            margin-bottom:14px;
            font-size:13px;
        }

        .login-btn{
            height:48px;
            font-size:15px;
        }

        .footer-text{
            margin-top:14px;
            font-size:12px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .brand-logo {
            width: 85px;
            height: 85px;
            margin: auto;
            border-radius: 50%;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 25px rgba(0, 114, 255, 0.45);
            margin-bottom: 20px;
        }

        .brand-logo i {
            color: white;
            font-size: 34px;
        }

        .login-title {
            text-align: center;
            color: #fff;
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-subtitle {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            color: #fff;
            margin-bottom: 8px;
            font-size: 14px;
            display: block;
            font-weight: 500;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            top: 16px;
            left: 15px;
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control {
            width: 100%;
            height: 52px;
            border-radius: 14px;
            border: none;
            outline: none;
            padding-left: 45px;
            background: rgba(255, 255, 255, 0.12);
            color: white;
            font-size: 15px;
            transition: 0.3s ease;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 0 0 3px rgba(0, 153, 255, 0.25);
        }

        .remember-wrap {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .login-btn{
            width:100%;
            height:48px;
            border:none;
            border-radius:14px;

            background:linear-gradient(135deg,#00c6ff,#0072ff);

            color:white;
            font-size:15px;
            font-weight:600;

            cursor:pointer;
            transition:0.3s ease;

            position:relative;
            overflow:hidden;

            box-shadow:
                0 0 15px rgba(0,114,255,0.4);
        }
        .login-btn::before{
            content:'';
            position:absolute;
            width:120px;
            height:120%;
            background:rgba(255,255,255,0.25);
            top:-10%;
            left:-120%;
            transform:skewX(25deg);
            transition:0.5s;
        }

        .login-btn:hover::before{
            left:130%;
        }

        .login-btn:hover{
            transform:translateY(-2px);
            box-shadow:
                0 0 25px rgba(0,114,255,0.7);
        }


        .footer-text {
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 25px;
            font-size: 13px;
        }

        .alert {
            border-radius: 12px;
            font-size: 14px;
        }

       @media(max-width:576px) {

        body{
            overflow-y:auto;
        }

        .login-wrapper{
            padding:20px 14px;
        }

        .login-card {
            max-width: 100%;
            padding: 30px 20px;
            border-radius: 24px;
        }

        .login-title {
            font-size: 24px;
        }

        .brand-logo {
            width: 70px;
            height: 70px;
        }

        .brand-logo i {
            font-size: 28px;
        }
    }
    .form-control,
    .form-control:focus,
    .form-control:active{
        color: #fff !important;
        caret-color: #fff;
    }

    /* Chrome Autofill Fix */
    .form-control:-webkit-autofill,
    .form-control:-webkit-autofill:hover,
    .form-control:-webkit-autofill:focus,
    .form-control:-webkit-autofill:active{
        -webkit-text-fill-color: #fff !important;
        transition: background-color 5000s ease-in-out 0s;
        box-shadow: 0 0 0px 1000px rgba(255,255,255,0.12) inset;
    }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <div class="login-card">

            <div class="brand-logo">
                <i class="fas fa-shield-halved"></i>
            </div>

            <h2 class="login-title">Secure Me</h2>

            <p class="login-subtitle">
                Smart Emergency Security Dashboard
            </p>

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            {{-- Success --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.save-login') }}" method="POST" id="loginForm">

                @csrf

                <div class="form-group">
                    <label class="form-label">Email Address</label>

                    <div class="input-group">
                        <i class="fas fa-envelope"></i>

                        <input type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>

                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required>
                    </div>
                </div>

                <div class="remember-wrap">
                    <div>
                        <input type="checkbox" name="remember">
                        Remember Me
                    </div>

                    <a href="#"
                        data-toggle="modal"
                        data-target="#forgotModal"
                        style="color:#7dd3fc;text-decoration:none;">
                        Forgot?
                    </a>
                </div>

                <button type="submit"
                    class="login-btn"
                    id="loginBtn">

                    Login Securely
                </button>

            </form>

            <div class="footer-text">
                Secure Me © 2026 <br>
                Your Safety. Our Technology.
            </div>

        </div>

    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {

            let btn = document.getElementById('loginBtn');

            btn.disabled = true;

            btn.innerHTML =
                '<i class="fas fa-spinner fa-spin"></i> Logging in...';
        });
    </script>


    <!-- Forgot Password Modal -->
<div class="modal fade"
    id="forgotModal"
    tabindex="-1"
    role="dialog">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content"
            style="background:#10182f;
                   border-radius:20px;
                   border:1px solid rgba(255,255,255,0.1);">

            <div class="modal-header border-0">

                <h5 style="color:white;">
                    Reset Password
                </h5>

                <button type="button"
                    class="close text-white"
                    data-dismiss="modal">

                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <form action="{{ route('password.email') }}"
                    method="POST">

                    @csrf

                    <div class="form-group">

                        <label style="color:white;">
                            Registered Email
                        </label>

                        <input type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required>
                    </div>

                    <button type="submit"
                        class="login-btn">

                        Send Reset Link
                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>