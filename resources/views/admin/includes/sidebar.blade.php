<!-- =========================
     PREMIUM SIDEBAR
========================= -->

<div class="main-sidebar sidebar-style-2">

    <aside id="sidebar-wrapper">

        <!-- LOGO -->
        <div class="sidebar-brand">

            <a href="{{ url('admin/admin-dashboard') }}">

                <div class="logo-box">

                    <img src="{{ asset('admin-assets/img/logo.png') }}"
                         class="header-logo">

                </div>

                <div class="logo-content">

                    <h5>Secure Me</h5>

                </div>

            </a>

        </div>

        <!-- MENU -->
        <ul class="sidebar-menu">

            <li class="menu-header">
                
            </li>

            <!-- Dashboard -->
            <li class="{{ Request::is('admin/admin-dashboard') ? 'active' : '' }}">

                <a href="{{ url('admin/admin-dashboard') }}"
                   class="nav-link">

                    <i data-feather="home"></i>
                    <span>Dashboard</span>

                </a>

            </li>

            <!-- Users -->
            <li class="{{ Request::is('admin/users-list*') ? 'active' : '' }}">

                <a href="{{ url('admin/users-list') }}"
                   class="nav-link">

                    <i data-feather="users"></i>
                    <span>Manage Users</span>

                </a>

            </li>

            <!-- Emergency Signals -->
            <!-- <li class="{{ Request::is('/send-emergency') ? 'active' : '' }}">

                <a href="{{ url('/send-emergency') }}"
                   class="nav-link">

                    <i data-feather="alert-triangle"></i>
                    <span>Send Emergency Alerts</span>

                </a>

            </li> -->

            <!-- Emergency Signals -->
            <li class="{{ Request::is('admin/emergency-alerts') ? 'active' : '' }}">

                <a href="{{ url('admin/all-emergency-signals') }}" class="nav-link">
                <!-- <a href="{{ url('admin/emergency-alerts') }}"
                   class="nav-link"> -->

                    <i data-feather="alert-triangle"></i>
                    <span>Emergency Alerts</span>

                </a>

            </li>

            <!-- Emergency Responses -->
            <li class="{{ Request::is('admin/all-emergency-responses') ? 'active' : '' }}">

                <a href="{{ url('admin/all-emergency-responses') }}"
                   class="nav-link">

                    <i data-feather="activity"></i>
                    <span>Emergency Responses</span>

                </a>

            </li>

            <!-- Groups -->
            <li class="{{ Request::is('admin/instant-emergency-groups') ? 'active' : '' }}">

                <a href="{{ url('admin/instant-emergency-groups') }}"
                   class="nav-link">

                    <i data-feather="shield"></i>
                    <span>Emergency Groups</span>

                </a>

            </li>

            <!-- Reports -->
            <li class="{{ Request::is('admin/reports-and-logs') ? 'active' : '' }}">

                <a href="{{ url('admin/reports-and-logs') }}"
                   class="nav-link">

                    <i data-feather="file-text"></i>
                    <span>Reports & Logs</span>

                </a>

            </li>

            <!-- Settings -->
            <li class="{{ Request::is('admin/settings') ? 'active' : '' }}">

                <a href="{{ url('admin/settings') }}"
                   class="nav-link">

                    <i data-feather="settings"></i>
                    <span>Settings</span>

                </a>

            </li>

        </ul>

    </aside>

</div>

<style>

/* =========================
   SIDEBAR
========================= */

.main-sidebar{

    width:280px !important;

    background:
        linear-gradient(180deg,#0f172a,#111827);

    box-shadow:
        5px 0 30px rgba(0,0,0,0.15);

    overflow:hidden;

    z-index:999;
}

/* SIDEBAR FIX */

.main-sidebar{
    top:0;
    left:0;
    height:100vh;
    position:fixed;
}

/* REMOVE GAP */

body.sidebar-gone .main-sidebar{
    left:-280px;
}

@media(max-width:991px){

    body.sidebar-show .main-sidebar{
        left:0 !important;
    }
}

/* WRAPPER */

.sidebar-style-2 #sidebar-wrapper{

    height:100vh;

    overflow-y:auto;

    overflow-x:hidden;

    padding-bottom:30px;

    background:transparent !important;
}

/* =========================
   LOGO
========================= */

.sidebar-brand{

    padding:22px 18px;

    border-bottom:
        1px solid rgba(255,255,255,0.06);

    margin-bottom:20px;
}

.sidebar-brand a{

    display:flex;

    align-items:center;

    gap:14px;

    text-decoration:none;
}

/* LOGO BOX */

.logo-box{

    width:55px;
    height:47px;

    border-radius:10px;

    background:
        linear-gradient(135deg,#0284c7,#38bdf8);

    display:flex;
    align-items:center;
    justify-content:center;

    box-shadow:
        0 0 20px rgba(56,189,248,0.35);
}

/* IMAGE */

.header-logo{

    width:34px;
    height:34px;

    object-fit:contain;
}

/* TEXT */

.logo-content h5{

    margin:0;

    color:#fff;

    font-size:22px;
    font-weight:700;
}

.logo-content span{

    color:#94a3b8;

    font-size:12px;
}

/* =========================
   MENU
========================= */

.sidebar-menu{

    padding:0 12px !important;
}

/* HEADER */

.menu-header{

    color:#64748b !important;

    font-size:11px;

    letter-spacing:1px;

    margin:10px 10px 14px;
}

/* MENU ITEM */

.sidebar-style-2 .sidebar-menu li{

    margin-bottom:10px;
}

/* MENU LINK */

.sidebar-style-2 .sidebar-menu li a{

    height:54px;

    border-radius:16px;

    padding:0 18px;

    display:flex;
    align-items:center;

    color:rgba(255,255,255,0.82) !important;

    transition:0.3s ease;
}

/* ICON */

.sidebar-style-2 .sidebar-menu li a i{

    width:20px;

    min-width:20px;

    margin-right:14px;
}

/* TEXT */

.sidebar-style-2 .sidebar-menu li a span{

    font-size:14px;
    font-weight:500;
}

/* HOVER */

.sidebar-style-2 .sidebar-menu li a:hover{

    background:
        linear-gradient(135deg,#0284c7,#0ea5e9);

    transform:translateX(4px);

    color:#fff !important;

    box-shadow:
        0 0 18px rgba(14,165,233,0.35);
}

/* ACTIVE */

.sidebar-style-2 .sidebar-menu li.active a{

    background:
        linear-gradient(135deg,#0284c7,#38bdf8);

    color:#fff !important;

    box-shadow:
        0 0 18px rgba(56,189,248,0.35);
}

/* SCROLLBAR */

#sidebar-wrapper::-webkit-scrollbar{
    width:5px;
}

#sidebar-wrapper::-webkit-scrollbar-thumb{

    background:#38bdf8;

    border-radius:20px;
}

/* =========================
   TABLET
========================= */

@media(max-width:991px){

    .main-sidebar{
        width:260px !important;
    }

    .sidebar-brand{
        padding:20px 14px;
    }

    .logo-box{
        width:52px;
        height:52px;
    }

    .logo-content h5{
        font-size:20px;
    }

    .sidebar-style-2 .sidebar-menu li a{
        height:50px;
    }
}

/* =========================
   MOBILE
========================= */

@media(max-width:576px){

    .main-sidebar{
        width:240px !important;
    }

    .sidebar-brand{
        padding:18px 12px;
    }

    .logo-box{
        width:46px;
        height:46px;

        border-radius:14px;
    }

    .header-logo{
        width:28px;
        height:28px;
    }

    .logo-content h5{
        font-size:17px;
    }

    .logo-content span{
        font-size:11px;
    }

    .sidebar-style-2 .sidebar-menu li a{

        height:46px;

        padding:0 14px;

        border-radius:14px;
    }

    .sidebar-style-2 .sidebar-menu li a span{
        font-size:13px;
    }
}

</style>

<script src="https://unpkg.com/feather-icons"></script>

<script>
    feather.replace();
</script>
