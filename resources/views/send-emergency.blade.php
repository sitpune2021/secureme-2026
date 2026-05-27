<!DOCTYPE html>
<html lang="en">

@include('admin.includes.header')

<head>

    <title>Emergency Alert</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

        body{
            margin:0;
            padding:0;
            background:#f1f5f9;
            min-height:100vh;
            font-family:'Poppins',sans-serif;
            overflow-x:hidden;
        }

        /* MAIN CONTENT */

        .main-content{

            padding-top:120px !important;

            padding-left:300px !important;

            padding-right:30px !important;

            min-height:100vh;

            box-sizing:border-box;
        }

        /* WRAPPER */

        .emergency-wrapper{

            width:100%;

            min-height:calc(100vh - 120px);

            display:flex;

            justify-content:center;

            align-items:center;

            padding:20px;
        }

        /* CARD */

        .emergency-card{

            width:100%;

            max-width:520px;

            background:#ffffff;

            border-radius:28px;

            padding:35px;

            border:1px solid #e2e8f0;

            box-shadow:
                0 10px 40px rgba(15,23,42,0.08);

            position:relative;

            overflow:hidden;

            margin:auto;
        }

        /* TOP GLOW */

        .emergency-card::before{

            content:'';

            position:absolute;

            top:0;
            left:0;

            width:100%;
            height:5px;

            background:
                linear-gradient(90deg,#ef4444,#f97316,#dc2626);
        }

        /* ICON */

        .alert-icon{

            width:80px;
            height:80px;

            margin:auto;

            border-radius:50%;

            display:flex;
            align-items:center;
            justify-content:center;

            font-size:34px;

            background:
                linear-gradient(135deg,#ef4444,#dc2626);

            color:#fff;

            box-shadow:
                0 12px 30px rgba(239,68,68,0.25);

            animation:pulse 2s infinite;
        }

        @keyframes pulse{

            0%{
                transform:scale(1);
            }

            50%{
                transform:scale(1.05);
            }

            100%{
                transform:scale(1);
            }
        }

        /* TITLE */

        .main-title{

            text-align:center;

            font-size:30px;

            font-weight:800;

            color:#0f172a;

            margin-top:22px;
            margin-bottom:8px;
        }

        .sub-title{

            text-align:center;

            color:#64748b;

            font-size:14px;

            margin-bottom:28px;
        }

        /* INPUT GROUP */

        .input-group{

            margin-bottom:18px;
        }

        .input-label{

            display:block;

            margin-bottom:8px;

            font-size:14px;

            font-weight:600;

            color:#0f172a;
        }

        /* INPUT */

        .custom-input{

            width:100%;

            height:54px;

            border-radius:16px;

            border:1px solid #dbeafe;

            background:#f8fafc;

            padding:0 18px;

            font-size:14px;

            color:#0f172a;

            outline:none;

            transition:0.3s ease;
        }

        /* TEXTAREA */

        .custom-textarea{

            width:100%;

            min-height:130px;

            border-radius:16px;

            border:1px solid #dbeafe;

            background:#f8fafc;

            padding:18px;

            font-size:14px;

            color:#0f172a;

            resize:none;

            outline:none;

            transition:0.3s ease;
        }

        /* PLACEHOLDER */

        .custom-input::placeholder,
        .custom-textarea::placeholder{

            color:#94a3b8;
        }

        /* FOCUS */

        .custom-input:focus,
        .custom-textarea:focus{

            background:#fff;

            border-color:#38bdf8;

            box-shadow:
                0 0 0 4px rgba(56,189,248,0.15);
        }

        /* BUTTON */

        .sos-btn{

            width:100%;

            height:58px;

            border:none;

            border-radius:18px;

            background:
                linear-gradient(135deg,#ef4444,#dc2626);

            color:#fff;

            font-size:17px;

            font-weight:700;

            margin-top:12px;

            cursor:pointer;

            transition:0.3s ease;
        }

        .sos-btn:hover{

            transform:translateY(-2px);

            box-shadow:
                0 15px 30px rgba(239,68,68,0.25);
        }

        /* LIVE STATUS */

        .live-status{

            margin-top:20px;

            display:flex;

            justify-content:center;

            align-items:center;

            gap:8px;

            color:#dc2626;

            font-size:13px;

            font-weight:600;
        }

        .live-dot{

            width:10px;
            height:10px;

            border-radius:50%;

            background:#ef4444;

            animation:blink 1s infinite;
        }

        @keyframes blink{

            0%{
                opacity:1;
            }

            50%{
                opacity:0.3;
            }

            100%{
                opacity:1;
            }
        }

        /* TABLET */

        @media(max-width:991px){

            .main-content{

                padding-left:20px !important;

                padding-right:20px !important;
            }
        }

        /* MOBILE */

        @media(max-width:768px){

            .main-content{

                padding-top:90px !important;

                padding-left:12px !important;

                padding-right:12px !important;
            }

            .emergency-wrapper{

                padding:10px;
            }

            .emergency-card{

                padding:24px;

                border-radius:22px;
            }

            .main-title{

                font-size:24px;
            }

            .alert-icon{

                width:70px;
                height:70px;

                font-size:30px;
            }

            .custom-input{

                height:50px;
            }

            .sos-btn{

                height:54px;

                font-size:15px;
            }
        }

    </style>

</head>

<body>

<div class="main-content">

    <div class="emergency-wrapper">

        <div class="emergency-card">

            <!-- ICON -->

            <div class="alert-icon">

                🚨

            </div>

            <!-- TITLE -->

            <h1 class="main-title">

                Emergency Alert

            </h1>

            <p class="sub-title">

                Send instant SOS alert with live GPS tracking

            </p>

            <!-- FORM -->

            <form method="POST"
                  action="{{ url('/store-emergency') }}">

                @csrf

                <!-- NAME -->

                <div class="input-group">

                    <label class="input-label">

                        Full Name

                    </label>

                    <input type="text"
                           name="user_name"
                           class="custom-input"
                           placeholder="Enter your full name"
                           required>

                </div>

                <!-- MOBILE -->

                <div class="input-group">

                    <label class="input-label">

                        Mobile Number

                    </label>

                    <input type="text"
                           name="mobile"
                           class="custom-input"
                           placeholder="Enter mobile number"
                           required>

                </div>

                <!-- MESSAGE -->

                <div class="input-group">

                    <label class="input-label">

                        Emergency Message

                    </label>

                    <textarea name="message"
                              class="custom-textarea"
                              placeholder="Describe your emergency..."
                              required></textarea>

                </div>

                <!-- LOCATION -->

                <input type="hidden"
                       name="latitude"
                       id="latitude">

                <input type="hidden"
                       name="longitude"
                       id="longitude">

                <!-- BUTTON -->

                <button class="sos-btn">

                    🚨 SEND SOS ALERT

                </button>

            </form>

            <!-- LIVE STATUS -->

            <div class="live-status">

                <div class="live-dot"></div>

                Live GPS Tracking Enabled

            </div>

        </div>

    </div>

</div>

<script>

navigator.geolocation.getCurrentPosition(

    function(position){

        document.getElementById('latitude').value =
            position.coords.latitude;

        document.getElementById('longitude').value =
            position.coords.longitude;
    }
);

</script>

</body>

</html>

@include('admin.includes.footer')