@include('admin.includes.header')

<style>

    body{
        background:#f4f7fb;
    }

    .reports-wrapper{
        padding:10px 0;
    }

    .reports-main-card{
        border:none;
        border-radius:28px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 35px rgba(0,0,0,.08);
    }

    .reports-header{
        padding:28px;
        background:linear-gradient(135deg,#ffffff,#f6f9ff);
        border-bottom:1px solid #eef2ff;
    }

    .reports-title{
        font-size:28px;
        font-weight:800;
        color:#1e293b;
        margin-bottom:6px;
    }

    .reports-subtitle{
        font-size:14px;
        color:#64748b;
    }

    .report-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        background:#fff;
        position:relative;
        transition:.35s ease;
        box-shadow:
            0 10px 25px rgba(0,0,0,.06),
            inset 0 0 0 1px #eef2ff;
    }

    .report-card:hover{
        transform:translateY(-8px);
        box-shadow:
            0 20px 40px rgba(103,119,239,.16),
            inset 0 0 0 1px rgba(103,119,239,.10);
    }

    .report-card-body{
        padding:30px 24px;
        text-align:center;
    }

    .report-icon-box{
        width:85px;
        height:85px;
        margin:auto;
        border-radius:24px;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:34px;
        margin-bottom:20px;
        position:relative;
        overflow:hidden;
    }

    .report-icon-box::before{
        content:'';
        position:absolute;
        width:140%;
        height:140%;
        background:rgba(255,255,255,.20);
        transform:rotate(45deg);
        left:-120%;
        top:-120%;
        transition:.5s;
    }

    .report-card:hover .report-icon-box::before{
        left:120%;
        top:120%;
    }

    .icon-primary{
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff;
    }

    .icon-success{
        background:linear-gradient(135deg,#22c55e,#4ade80);
        color:#fff;
    }

    .icon-danger{
        background:linear-gradient(135deg,#ef4444,#fb7185);
        color:#fff;
    }

    .icon-warning{
        background:linear-gradient(135deg,#f59e0b,#fbbf24);
        color:#fff;
    }

    .icon-info{
        background:linear-gradient(135deg,#06b6d4,#67e8f9);
        color:#fff;
    }

    .icon-secondary{
        background:linear-gradient(135deg,#64748b,#94a3b8);
        color:#fff;
    }

    .report-card h5{
        font-size:20px;
        font-weight:700;
        color:#1e293b;
        margin-bottom:12px;
    }

    .report-card p{
        font-size:14px;
        color:#64748b;
        line-height:1.7;
        min-height:70px;
    }

    .report-btn{
        border:none;
        border-radius:14px;
        padding:12px 20px;
        font-size:14px;
        font-weight:700;
        display:inline-flex;
        align-items:center;
        gap:10px;
        transition:.3s ease;
        text-decoration:none !important;
    }

    .btn-primary-custom{
        background:#eef2ff;
        color:#6777ef;
    }

    .btn-primary-custom:hover{
        background:#6777ef;
        color:#fff;
    }

    .btn-success-custom{
        background:#ecfdf5;
        color:#16a34a;
    }

    .btn-success-custom:hover{
        background:#16a34a;
        color:#fff;
    }

    .btn-danger-custom{
        background:#fef2f2;
        color:#dc2626;
    }

    .btn-danger-custom:hover{
        background:#dc2626;
        color:#fff;
    }

    .btn-warning-custom{
        background:#fffbeb;
        color:#d97706;
    }

    .btn-warning-custom:hover{
        background:#d97706;
        color:#fff;
    }

    .btn-info-custom{
        background:#ecfeff;
        color:#0891b2;
    }

    .btn-info-custom:hover{
        background:#0891b2;
        color:#fff;
    }

    .btn-secondary-custom{
        background:#f1f5f9;
        color:#475569;
    }

    .btn-secondary-custom:hover{
        background:#475569;
        color:#fff;
    }

    .report-top-badge{
        position:absolute;
        top:18px;
        right:18px;
        padding:7px 14px;
        border-radius:30px;
        font-size:11px;
        font-weight:700;
        background:#f8fafc;
        color:#64748b;
        box-shadow:0 4px 10px rgba(0,0,0,.05);
    }

    @media(max-width:768px){

        .reports-header{
            padding:20px;
        }

        .reports-title{
            font-size:22px;
        }

        .report-card-body{
            padding:24px 18px;
        }

        .report-card p{
            min-height:auto;
        }

    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body reports-wrapper">

            <div class="row">

                <div class="col-12">

                    <div class="reports-main-card">

                        <!-- HEADER -->

                        <div class="reports-header">

                            <div class="d-flex justify-content-between align-items-center flex-wrap">

                                <div>

                                    <div class="reports-title">
                                        📝 Reports & Logs Dashboard
                                    </div>

                                    <div class="reports-subtitle">
                                        Analyze emergency system reports, logs, users and response activities
                                    </div>

                                </div>

                                <div class="mt-3 mt-md-0">

                                    <span class="badge badge-primary p-3 shadow-sm">

                                        Total Modules : 6

                                    </span>

                                </div>

                            </div>

                        </div>

                        <!-- BODY -->

                        <div class="card-body p-4">

                            <div class="row">

                                <!-- USER REPORT -->

                                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                                    <div class="report-card h-100">

                                        <div class="report-top-badge">
                                            Active
                                        </div>

                                        <div class="report-card-body">

                                            <div class="report-icon-box icon-primary">

                                                <i class="fas fa-user"></i>

                                            </div>

                                            <h5>
                                                User Reports
                                            </h5>

                                            <p>
                                                Track user registrations, profile details, account activities and emergency participation records.
                                            </p>

                                            <a
                                                href="{{ url('reports/users') }}"
                                                class="report-btn btn-primary-custom"
                                            >

                                                View Report
                                                <i class="fas fa-arrow-right"></i>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- EMERGENCY ALERT -->

                                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                                    <div class="report-card h-100">

                                        <div class="report-top-badge">
                                            Live Alerts
                                        </div>

                                        <div class="report-card-body">

                                            <div class="report-icon-box icon-danger">

                                                <i class="fas fa-exclamation-triangle"></i>

                                            </div>

                                            <h5>
                                                Emergency Alerts
                                            </h5>

                                            <p>
                                                Analyze instant emergency alerts raised by users with date, time and status tracking.
                                            </p>

                                            <a
                                                href="{{ url('reports/emergency-alerts') }}"
                                                class="report-btn btn-danger-custom" target="_blank"
                                            >

                                                View Report
                                                <i class="fas fa-arrow-right"></i>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- EMERGENCY RESPONSE -->

                                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                                    <div class="report-card h-100">

                                        <div class="report-top-badge">
                                            Response Logs
                                        </div>

                                        <div class="report-card-body">

                                            <div class="report-icon-box icon-warning">

                                                <i class="fas fa-hands-helping"></i>

                                            </div>

                                            <h5>
                                                Emergency Responses
                                            </h5>

                                            <p>
                                                Monitor police helpers, response activities, acceptance status and emergency support logs.
                                            </p>

                                            <a
                                                href="{{ url('reports/emergency-responses') }}"
                                                class="report-btn btn-warning-custom" target="_blank"
                                            >

                                                View Report
                                                <i class="fas fa-arrow-right"></i>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- EMERGENCY GROUP -->

                                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                                    <div class="report-card h-100">

                                        <div class="report-top-badge">
                                            Dynamic Groups
                                        </div>

                                        <div class="report-card-body">

                                            <div class="report-icon-box icon-info">

                                                <i class="fas fa-layer-group"></i>

                                            </div>

                                            <h5>
                                                Instant Emergency Groups
                                            </h5>

                                            <p>
                                                View dynamic emergency rescue groups created during active emergency incidents.
                                            </p>

                                            <a
                                                href="{{ url('reports/emergency-groups') }}"
                                                class="report-btn btn-info-custom"
                                            >

                                                View Report
                                                <i class="fas fa-arrow-right"></i>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                                <!-- SYSTEM LOG -->

                                <div class="col-xl-4 col-lg-6 col-md-6 mb-4">

                                    <div class="report-card h-100">

                                        <div class="report-top-badge">
                                            Secure Logs
                                        </div>

                                        <div class="report-card-body">

                                            <div class="report-icon-box icon-secondary">

                                                <i class="fas fa-database"></i>

                                            </div>

                                            <h5>
                                                System Logs
                                            </h5>

                                            <p>
                                                Monitor admin activities, login attempts, API logs, errors and security event history.
                                            </p>

                                            <a
                                                href="{{ url('reports/system-logs') }}"
                                                class="report-btn btn-secondary-custom"
                                            >

                                                View Report
                                                <i class="fas fa-arrow-right"></i>

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@include('admin.includes.footer')