@include('admin.includes.header')

<style>

    .profile-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,0.08);
        background:#fff;
    }

    .profile-top{
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        padding:40px 20px 90px;
        position:relative;
        text-align:center;
    }

    .profile-avatar{
        width:120px;
        height:120px;
        border-radius:50%;
        background:#fff;
        position:absolute;
        bottom:-60px;
        left:50%;
        transform:translateX(-50%);
        display:flex;
        align-items:center;
        justify-content:center;
        box-shadow:0 10px 25px rgba(0,0,0,0.15);
    }

    .profile-avatar i{
        font-size:50px;
        color:#6777ef;
    }

    .profile-body{
        padding:80px 25px 30px;
    }

    .info-box{
        background:#f8f9fc;
        border-radius:16px;
        padding:18px;
        margin-bottom:18px;
    }

    .info-title{
        font-size:12px;
        color:#98a6ad;
        font-weight:700;
        text-transform:uppercase;
        margin-bottom:6px;
    }

    .info-value{
        font-size:16px;
        font-weight:600;
        color:#34395e;
        word-break:break-word;
    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body">

            <div class="row justify-content-center">

                <div class="col-lg-12 col-xl-11">

                    <div class="profile-card">

                        <div class="profile-top">

                            <div class="profile-avatar">

                                <i class="fas fa-user"></i>

                            </div>

                        </div>

                        <div class="profile-body text-center">

                            <h3 class="mb-1">
                                {{ $UsersDetails->name }}
                            </h3>

                            <span class="badge badge-primary px-3 py-2 mb-4">
                                {{ $UsersDetails->user_role }}
                            </span>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Email
                                        </div>

                                        <div class="info-value">
                                            {{ $UsersDetails->email }}
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Phone Number
                                        </div>

                                        <div class="info-value">
                                            {{ $UsersDetails->phone_no ?? 'N/A' }}
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Availability
                                        </div>

                                        <div class="info-value">

                                            @if($UsersDetails->is_available == 1)

                                                <span class="badge badge-success">
                                                    Available
                                                </span>

                                            @else

                                                <span class="badge badge-danger">
                                                    Not Available
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Account Status
                                        </div>

                                        <div class="info-value">

                                            @if($UsersDetails->is_active == 1)

                                                <span class="badge badge-success">
                                                    Active
                                                </span>

                                            @else

                                                <span class="badge badge-danger">
                                                    Inactive
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Latitude
                                        </div>

                                        <div class="info-value">
                                            {{ $UsersDetails->latitude ?? 'N/A' }}
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Longitude
                                        </div>

                                        <div class="info-value">
                                            {{ $UsersDetails->longitude ?? 'N/A' }}
                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-12">

                                    <div class="info-box text-left">

                                        <div class="info-title">
                                            Created At
                                        </div>

                                        <div class="info-value">
                                            {{ \Carbon\Carbon::parse($UsersDetails->created_at)->format('d M Y h:i A') }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <a href="{{ url('admin/users-list') }}"
                                class="btn btn-primary btn-lg rounded-pill px-5 mt-3">

                                <i class="fas fa-arrow-left"></i>
                                Back

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

@include('admin.includes.footer')