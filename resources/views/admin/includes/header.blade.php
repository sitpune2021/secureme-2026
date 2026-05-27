<!DOCTYPE html>
<html lang="en">
@include('admin.includes.sidebar');
<head>

    <meta charset="UTF-8">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no"
          name="viewport">

    <title>Secure Me Admin Panel</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}">

    <!-- FEATHER -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>

/* =========================
   BODY
========================= */

body{
    background:#f4f7fb;
    overflow-x:hidden;
}

/* =========================
   HEADER
========================= */
/* REMOVE WHITE GAP */

.navbar-bg{
    width:100% !important;
    left:0 !important;
}

/* HEADER FIX */

.main-navbar{
    left:280px;
    width:calc(100% - 280px);
}

/* CONTENT FIX */

.main-content{
    padding-top:90px !important;
    padding-left:300px !important;
}

/* TABLET */

@media(max-width:991px){

    .main-navbar{
        left:0;
        width:100%;
    }

    .main-content{
        padding-left:30px !important;
    }
}

.main-navbar{

    height:72px;

    background:
        rgba(255,255,255,0.92) !important;

    backdrop-filter:blur(14px);

    border-bottom:
        1px solid rgba(0,0,0,0.05);

    box-shadow:
        0 4px 18px rgba(15,23,42,0.05);

    padding:0 20px;

    display:flex;
    align-items:center;
    justify-content:space-between;
}

.navbar-bg{
    background:transparent !important;
}
/* =========================
   NAVBAR ALIGN FIX
========================= */

.main-navbar{
    display:flex;
    align-items:center;
    justify-content:flex-end; /* PROFILE RIGHT */
}

/* MOBILE/TABLET */

@media(max-width:991px){

    .main-navbar{
        justify-content:space-between; /* MENU LEFT + PROFILE RIGHT */
    }
}

/* HIDE MENU BUTTON DESKTOP */

@media(min-width:992px){

    .header-left{
        display:none !important;
    }

    .navbar-right{
        margin-left:auto !important;
    }
}

/* SHOW MENU BUTTON MOBILE */

@media(max-width:991px){

    .header-left{
        display:flex !important;
        align-items:center;
    }

    .navbar-right{
        margin-left:auto !important;
    }
}

/* LEFT */

.header-left{

    display:flex;

    align-items:center;

    gap:12px;
}

/* ICON BUTTON */

.header-btn{

    width:42px;
    height:42px;

    border-radius:14px;

    background:#f1f5f9;

    display:flex !important;
    align-items:center;
    justify-content:center;

    color:#0f172a !important;

    transition:0.3s ease;
}

.header-btn:hover{

    background:
        linear-gradient(135deg,#0284c7,#0ea5e9);

    color:#fff !important;

    transform:translateY(-2px);

    box-shadow:
        0 0 18px rgba(14,165,233,0.35);
}

/* RIGHT */

.navbar-right{

    display:flex;

    align-items:center;

    gap:14px;
}

/* PROFILE */

.profile-btn{

    display:flex !important;

    align-items:center;

    gap:12px;

    background:#fff;

    border-radius:18px;

    padding:8px 12px !important;

    border:
        1px solid rgba(0,0,0,0.05);

    transition:0.3s ease;
}

.profile-btn:hover{

    box-shadow:
        0 8px 25px rgba(0,0,0,0.08);
}

/* IMAGE */

.user-img-radious-style{

    width:44px;
    height:44px;

    border-radius:50%;

    object-fit:cover;

    border:2px solid #38bdf8;
}

/* TEXT */

.profile-content h6{

    margin:0;

    font-size:14px;
    font-weight:600;

    color:#0f172a;
}

.profile-content span{

    font-size:12px;

    color:#64748b;
}

/* DROPDOWN */

.dropdown-menu{

    border:none;

    border-radius:18px;

    overflow:hidden;

    margin-top:12px;

    box-shadow:
        0 12px 30px rgba(0,0,0,0.08);
}

.dropdown-title{

    padding:14px 18px;

    background:#f8fafc;

    font-size:13px;
    font-weight:600;
}

.dropdown-item{

    padding:12px 18px;

    transition:0.3s ease;
}

.dropdown-item:hover{

    background:#eff6ff;
}

/* =========================
   MOBILE
========================= */

@media(max-width:768px){

    .main-navbar{
        height:66px;
        padding:0 12px;
    }

    .profile-content{
        display:none;
    }

    .profile-btn{
        padding:6px !important;
    }

    .user-img-radious-style{
        width:40px;
        height:40px;
    }

    .header-btn{
        width:38px;
        height:38px;
    }
}
/* HIDE TOGGLE BUTTON ON DESKTOP */

@media(min-width:992px){

    .header-left{
        display:none !important;
    }
}

/* SHOW ON MOBILE/TABLET */

@media(max-width:991px){

    .header-left{
        display:flex !important;
        align-items:center;
    }
}

    </style>

</head>

<body>

<div class="loader"></div>

<div id="app">

<div class="main-wrapper main-wrapper-1">

<div class="navbar-bg"></div>

<!-- HEADER -->
<nav class="navbar navbar-expand-lg main-navbar sticky">

    <!-- LEFT -->
    <!-- LEFT -->
    <div class="header-left">

        <!-- TOGGLE -->
        <a href="#"
        data-toggle="sidebar"
        class="nav-link header-btn">

            <i data-feather="menu"></i>

        </a>

    </div>

    <!-- RIGHT -->
    <ul class="navbar-nav navbar-right">

        <!-- PROFILE -->
        <li class="dropdown">

            <a href="#"
               data-toggle="dropdown"
               class="nav-link dropdown-toggle profile-btn">

                <img src="{{ asset('admin-assets/img/users/user-3.png') }}"
                     class="user-img-radious-style">

                <div class="profile-content">

                    <h6>
                        Admin
                    </h6>

                    <span>
                        Super Admin
                    </span>

                </div>

            </a>

            <!-- DROPDOWN -->
            <div class="dropdown-menu dropdown-menu-right pullDown">

                <div class="dropdown-title">
                    {{ session('admin_email', 'Guest') }}
                </div>

                <a href="{{ url('admin/profile') }}"
                   class="dropdown-item has-icon">

                    <i class="far fa-user"></i>
                    Profile

                </a>

                <a href="{{ url('admin/settings') }}"
                   class="dropdown-item has-icon">

                    <i class="fas fa-cog"></i>
                    Settings

                </a>

                <div class="dropdown-divider"></div>

                <a href="{{ url('admin/logout') }}"
                   class="dropdown-item has-icon text-danger">

                    <i class="fas fa-sign-out-alt"></i>
                    Logout

                </a>

            </div>

        </li>

    </ul>

</nav>

<script>
    feather.replace();
</script>
