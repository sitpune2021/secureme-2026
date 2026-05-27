@include('admin.includes.header');

<style>

/* =========================
   PAGE
========================= */

.emergency-page{

    padding:25px;
}

/* TOP BAR */

.page-top{

    display:flex;
    align-items:center;
    justify-content:space-between;

    margin-bottom:28px;

    flex-wrap:wrap;
    gap:15px;
}

.page-title{

    font-size:28px;
    font-weight:700;

    color:#0f172a;

    margin:0;
}

.page-subtitle{

    color:#64748b;

    margin-top:5px;

    font-size:14px;
}

/* LIVE BADGE */

.live-badge{

    background:linear-gradient(135deg,#ef4444,#dc2626);

    color:#fff;

    padding:12px 18px;

    border-radius:16px;

    font-weight:600;

    box-shadow:
        0 10px 25px rgba(239,68,68,0.25);
}

/* CARD */

.alert-card{

    border:none !important;

    border-radius:24px;

    overflow:hidden;

    background:
        linear-gradient(145deg,#ffffff,#f8fafc);

    transition:0.35s ease;

    position:relative;
}

/* GLOW */

.alert-card::before{

    content:'';

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:5px;

    background:
        linear-gradient(90deg,#ef4444,#f97316);
}

.alert-card:hover{

    transform:translateY(-6px);

    box-shadow:
        0 20px 45px rgba(15,23,42,0.12);
}

/* HEADER */

.alert-header{

    display:flex;
    align-items:center;
    justify-content:space-between;

    margin-bottom:20px;
}

.alert-title{

    font-size:20px;
    font-weight:700;

    color:#dc2626;
}

/* STATUS */

.status-badge{

    padding:8px 14px;

    border-radius:12px;

    font-size:12px;
    font-weight:600;

    color:#fff;

    background:
        linear-gradient(135deg,#ef4444,#dc2626);
}

/* INFO */

.info-box{

    background:#f8fafc;

    border-radius:16px;

    padding:14px;

    margin-bottom:16px;
}

.info-item{

    display:flex;

    justify-content:space-between;

    gap:10px;

    margin-bottom:10px;

    font-size:14px;
}

.info-item:last-child{
    margin-bottom:0;
}

.info-label{

    font-weight:600;

    color:#0f172a;

    min-width:90px;
}

.info-value{

    color:#475569;

    text-align:right;

    word-break:break-word;
}

/* MAP BUTTON */

.map-btn{

    height:48px;

    border-radius:14px !important;

    font-weight:600 !important;

    display:flex !important;
    align-items:center;
    justify-content:center;

    margin-bottom:16px;
}

/* SELECT */

.custom-select{

    height:50px !important;

    border-radius:14px !important;

    border:1px solid #dbeafe !important;

    box-shadow:none !important;
}

/* UPDATE BUTTON */

.update-btn{

    height:50px;

    border:none !important;

    border-radius:14px !important;

    font-weight:600 !important;

    background:
        linear-gradient(135deg,#0284c7,#0ea5e9) !important;

    transition:0.3s ease;
}

.update-btn:hover{

    transform:translateY(-2px);

    box-shadow:
        0 10px 25px rgba(14,165,233,0.35);
}

/* EMPTY */

.empty-box{

    background:#fff;

    border-radius:24px;

    padding:60px 20px;

    text-align:center;

    box-shadow:
        0 10px 30px rgba(15,23,42,0.06);
}

/* MOBILE */

@media(max-width:768px){

    .emergency-page{
        padding:15px;
    }

    .page-title{
        font-size:22px;
    }

    .alert-card{
        border-radius:18px;
    }

    .card-body{
        padding:18px;
    }

    .info-item{
        flex-direction:column;
    }

    .info-value{
        text-align:left;
    }
}

</style>

<div class="main-content">

    <section class="section emergency-page">

        <!-- TOP -->
        <div class="page-top">

            <div>

                <h2 class="page-title">
                    🚨 Live Emergency Alerts
                </h2>

                <p class="page-subtitle">
                    Real-time emergency monitoring dashboard
                </p>

            </div>

            <div class="live-badge">

                Total Alerts :
                {{ $alerts->count() }}

            </div>

        </div>

        <!-- ROW -->
        <div class="row">

            @forelse($alerts as $alert)

            <div class="col-xl-4 col-lg-6 col-md-6">

                <div class="card alert-card shadow-lg mb-4">

                    <div class="card-body">

                        <!-- HEADER -->
                        <div class="alert-header">

                            <div class="alert-title">
                                🚨 Emergency
                            </div>

                            <div class="status-badge">

                                {{ $alert->status }}

                            </div>

                        </div>

                        <!-- INFO -->
                        <div class="info-box">

                            <div class="info-item">

                                <div class="info-label">
                                    👤 Name
                                </div>

                                <div class="info-value">
                                    {{ $alert->user_name }}
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-label">
                                    📱 Mobile
                                </div>

                                <div class="info-value">
                                    {{ $alert->mobile }}
                                </div>

                            </div>

                            <div class="info-item">

                                <div class="info-label">
                                    💬 Message
                                </div>

                                <div class="info-value">
                                    {{ $alert->message }}
                                </div>

                            </div>

                        </div>

                        <!-- MAP -->
                        <a href="https://maps.google.com/?q={{ $alert->latitude }},{{ $alert->longitude }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-block map-btn">

                            📍 Open Live Location

                        </a>

                        <!-- FORM -->
                        <form method="POST"
                              action="{{ url('/update-alert-status/'.$alert->id) }}">

                            @csrf

                            <select name="status"
                                    class="form-control custom-select mb-3">

                                <option value="Pending">
                                    Pending
                                </option>

                                <option value="Accepted">
                                    Accepted
                                </option>

                                <option value="Resolved">
                                    Resolved
                                </option>

                            </select>

                            <button class="btn btn-primary btn-block update-btn">

                                Update Emergency Status

                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @empty

            <div class="col-12">

                <div class="empty-box">

                    <h3 class="mb-2">
                        🚫 No Emergency Alerts Found
                    </h3>

                    <p class="text-muted mb-0">
                        Live alerts will appear here automatically.
                    </p>

                </div>

            </div>

            @endforelse

        </div>

    </section>

</div>

@include('admin.includes.footer');