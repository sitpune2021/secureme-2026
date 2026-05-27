<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Reset Password</title>

    <link rel="stylesheet"
        href="{{ asset('admin-assets/css/app.min.css') }}">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;

            font-family:'Poppins',sans-serif;

            background:
            linear-gradient(rgba(8,15,40,0.80),
            rgba(8,15,40,0.90)),
            url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=2070&auto=format&fit=crop')
            center/cover no-repeat;

            overflow:hidden;
        }

        .reset-card{
            width:100%;
            max-width:450px;

            background:rgba(255,255,255,0.10);
            backdrop-filter:blur(18px);

            border:1px solid rgba(255,255,255,0.12);

            border-radius:28px;

            padding:32px 28px;

            box-shadow:
            0 10px 40px rgba(0,0,0,0.35);

            animation:fadeIn 0.7s ease;
        }

        @keyframes fadeIn{
            from{
                opacity:0;
                transform:translateY(20px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        .logo-box{
            width:75px;
            height:75px;

            margin:auto;
            margin-bottom:18px;

            border-radius:50%;

            background:linear-gradient(135deg,#00c6ff,#0072ff);

            display:flex;
            align-items:center;
            justify-content:center;

            box-shadow:
            0 0 25px rgba(0,114,255,0.45);
        }

        .logo-box i{
            color:#fff;
            font-size:30px;
        }

        .title{
            text-align:center;
            color:#fff;
            font-size:28px;
            font-weight:700;

            margin-bottom:6px;
        }

        .subtitle{
            text-align:center;
            color:rgba(255,255,255,0.7);

            font-size:14px;

            margin-bottom:24px;
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-label{
            color:#fff;
            font-size:14px;
            margin-bottom:8px;
            display:block;
        }

        .input-group{
            position:relative;
        }

        .input-group i{
            position:absolute;
            left:15px;
            top:16px;

            color:rgba(255,255,255,0.6);
        }

        .form-control{
            width:100%;
            height:52px;

            border:none;
            outline:none;

            border-radius:14px;

            padding-left:45px;

            background:rgba(255,255,255,0.12);

            color:#fff;

            font-size:14px;

            transition:0.3s ease;
        }

        .form-control::placeholder{
            color:rgba(255,255,255,0.5);
        }

        .form-control:focus{
            background:rgba(255,255,255,0.18);

            box-shadow:
            0 0 0 3px rgba(0,153,255,0.25);
        }

        .reset-btn{
            width:100%;
            height:52px;

            border:none;

            border-radius:14px;

            background:linear-gradient(135deg,#00c6ff,#0072ff);

            color:#fff;

            font-size:15px;
            font-weight:600;

            cursor:pointer;

            transition:0.3s ease;
        }

        .reset-btn:hover{
            transform:translateY(-2px);

            box-shadow:
            0 8px 25px rgba(0,114,255,0.35);
        }

        @media(max-width:576px){

            body{
                padding:15px;
                overflow-y:auto;
            }

            .reset-card{
                padding:26px 20px;
                border-radius:22px;
            }

            .title{
                font-size:24px;
            }

            .logo-box{
                width:65px;
                height:65px;
            }

            .logo-box i{
                font-size:26px;
            }

            .form-control{
                height:48px;
                font-size:13px;
            }

            .reset-btn{
                height:48px;
                font-size:14px;
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

    <div class="reset-card">

        <div class="logo-box">
            <i class="fas fa-key"></i>
        </div>

        <h2 class="title">
            Reset Password
        </h2>

        <p class="subtitle">
            Create your new secure password
        </p>

        <form method="POST"
            action="{{ route('password.update') }}">

            @csrf

            <input type="hidden"
                name="token"
                value="{{ $token }}">

            <div class="form-group">

                <label class="form-label">
                    Email Address
                </label>

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

                <label class="form-label">
                    New Password
                </label>

                <div class="input-group">

                    <i class="fas fa-lock"></i>

                    <input type="password"
                        name="password"
                        class="form-control"
                        placeholder="Enter new password"
                        required>
                </div>
            </div>

            <div class="form-group">

                <label class="form-label">
                    Confirm Password
                </label>

                <div class="input-group">

                    <i class="fas fa-shield-halved"></i>

                    <input type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm password"
                        required>
                </div>
            </div>

            <button type="submit"
                class="reset-btn">

                Reset Password
            </button>

        </form>

    </div>

</body>

</html>