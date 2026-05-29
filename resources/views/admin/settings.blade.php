@include('admin.includes.header')

<style>

    .settings-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 35px rgba(0,0,0,.08);
    }

    .settings-header{
        padding:24px;
        border-bottom:1px solid #eef2ff;
        background:linear-gradient(135deg,#ffffff,#f8fbff);
    }

    .settings-title{
        font-size:26px;
        font-weight:700;
        color:#1e293b;
    }

    .settings-subtitle{
        color:#64748b;
        font-size:14px;
        margin-top:4px;
    }

    .nav-tabs{
        border:none;
        gap:12px;
        flex-wrap:wrap;
    }

    .nav-tabs .nav-link{
        border:none;
        background:#f8fafc;
        color:#64748b;
        font-weight:600;
        border-radius:14px;
        padding:12px 22px;
        transition:.3s;
    }

    .nav-tabs .nav-link.active{
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff;
        box-shadow:0 8px 20px rgba(103,119,239,.25);
    }

    .profile-box{
        background:#f8fafc;
        border-radius:24px;
        padding:35px;
    }

    /* PROFILE TOP */

    .profile-top-section{
        display:flex;
        align-items:center;
        gap:35px;
        flex-wrap:wrap;
        padding-bottom:30px;
        border-bottom:1px solid #e2e8f0;
    }

    .profile-image-wrapper{
        position:relative;
    }

    .profile-image{
        width:130px;
        height:130px;
        border-radius:50%;
        object-fit:cover;
        border:5px solid #fff;
        box-shadow:0 10px 25px rgba(0,0,0,.12);
        background:#fff;
    }

    .upload-photo-box{
        flex:1;
        min-width:250px;
    }

    .upload-btn{
        height:52px;
        padding:0 26px;
        border:none;
        border-radius:16px;
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff;
        font-weight:600;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
        box-shadow:0 10px 25px rgba(103,119,239,.20);
        transition:.3s;
        margin-bottom:10px;
    }

    .upload-btn:hover{
        transform:translateY(-2px);
    }

    .upload-text{
        font-size:13px;
        color:#64748b;
    }

    /* FORM */

    .custom-label{
        font-size:14px;
        font-weight:600;
        color:#1e293b;
        margin-bottom:10px;
    }

    .custom-input{
        height:56px;
        border:none;
        border-radius:16px;
        background:#fff;
        padding:0 18px;
        box-shadow:inset 0 0 0 1px #e2e8f0;
        transition:.3s;
    }

    .custom-input:focus{
        outline:none;
        box-shadow:
            0 0 0 4px rgba(103,119,239,.10),
            inset 0 0 0 1px #6777ef;
    }

    .update-btn{
        height:56px;
        border:none;
        border-radius:16px;
        padding:0 35px;
        font-weight:700;
        color:#fff;
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        box-shadow:0 10px 25px rgba(103,119,239,.25);
        transition:.3s;
    }

    .update-btn:hover{
        transform:translateY(-2px);
    }

    .security-btn{
        background:linear-gradient(135deg,#f59e0b,#fbbf24);
        box-shadow:0 10px 25px rgba(245,158,11,.25);
    }

    .alert-success{
        border:none;
        border-radius:16px;
        background:#dcfce7;
        color:#166534;
        font-weight:600;
    }

    .alert-danger{
        border:none;
        border-radius:16px;
    }

    .text-danger{
        font-size:13px;
        margin-top:5px;
        display:block;
    }

    /* MOBILE */

    @media(max-width:768px){

        .profile-box{
            padding:20px;
        }

        .settings-title{
            font-size:22px;
        }

        .profile-top-section{
            flex-direction:column;
            text-align:center;
            justify-content:center;
        }

        .upload-photo-box{
            width:100%;
        }

        .upload-btn{
            width:100%;
        }

        .profile-image{
            width:110px;
            height:110px;
        }

        .update-btn{
            width:100%;
        }

    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body">

            <div class="row">

                <div class="col-12">

                    <div class="settings-card">

                        <!-- HEADER -->

                        <div class="settings-header">

                            <div class="settings-title">

                                ⚙️ Settings

                            </div>

                            <div class="settings-subtitle">

                                Manage your profile and security settings

                            </div>

                        </div>

                        <div class="card-body p-4">

                            <!-- SUCCESS MESSAGE -->

                            @if(session('success'))

                                <div class="alert alert-success">

                                    <i class="fas fa-check-circle mr-2"></i>

                                    {{ session('success') }}

                                </div>

                            @endif

                            <!-- ERROR MESSAGE -->

                            @if ($errors->any())

                                <div class="alert alert-danger">

                                    <ul class="mb-0 pl-3">

                                        @foreach ($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                        @endforeach

                                    </ul>

                                </div>

                            @endif

                            @if(session('error'))

                                <div class="alert alert-danger">

                                    <i class="fas fa-times-circle mr-2"></i>

                                    {{ session('error') }}

                                </div>

                            @endif

                            <!-- TABS -->

                            <ul
                                class="nav nav-tabs mb-4"
                                id="settingsTabs"
                                role="tablist"
                            >

                                <li class="nav-item">

                                    <a
                                        class="nav-link active"
                                        id="profile-tab"
                                        data-toggle="tab"
                                        href="#profile"
                                        role="tab"
                                    >

                                        <i class="fas fa-user mr-2"></i>

                                        Profile

                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a
                                        class="nav-link"
                                        id="security-tab"
                                        data-toggle="tab"
                                        href="#security"
                                        role="tab"
                                    >

                                        <i class="fas fa-lock mr-2"></i>

                                        Security

                                    </a>

                                </li>

                            </ul>

                            <!-- TAB CONTENT -->

                            <div class="tab-content">

                                <!-- PROFILE TAB -->

                                <div
                                    class="tab-pane fade show active"
                                    id="profile"
                                    role="tabpanel"
                                >

                                    <div class="profile-box">

                                        <form
                                            action="{{ route('admin.profile.update') }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                        >

                                            @csrf

                                            <!-- PROFILE TOP -->

                                            <div class="profile-top-section">

                                                <!-- PROFILE IMAGE -->

                                                <div class="profile-image-wrapper">

                                                    @if(!empty($admin->profile_image))

                                                        <img
                                                            src="{{ asset('admin_profile/' . $admin->profile_image) }}"
                                                            class="profile-image"
                                                        >

                                                    @else

                                                        <img
                                                            src="https://ui-avatars.com/api/?name={{ urlencode($admin->name ?? 'Admin') }}&background=6777ef&color=fff"
                                                            class="profile-image"
                                                        >

                                                    @endif

                                                </div>

                                                <!-- FILE UPLOAD -->

                                                <div class="upload-photo-box">

                                                    <label class="upload-btn">

                                                        <i class="fas fa-camera mr-2"></i>

                                                        Change Profile Photo

                                                        <input
                                                            type="file"
                                                            name="profile_photo"
                                                            hidden
                                                        >

                                                    </label>

                                                    <div class="upload-text">

                                                        JPG, JPEG, PNG allowed • Max 2MB

                                                    </div>

                                                </div>

                                            </div>

                                            <!-- FORM FIELDS -->

                                            <div class="row mt-4">

                                                <!-- NAME -->

                                                <div class="col-lg-6 col-md-6">

                                                    <div class="form-group">

                                                        <label class="custom-label">

                                                            Admin Name

                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control custom-input"
                                                            value="{{ old('name', $admin->name ?? '') }}"
                                                            placeholder="Enter admin name"
                                                        >

                                                    </div>

                                                </div>

                                                <!-- EMAIL -->

                                                <div class="col-lg-6 col-md-6">

                                                    <div class="form-group">

                                                        <label class="custom-label">

                                                            Email Address

                                                        </label>

                                                        <input
                                                            type="email"
                                                            name="email"
                                                            class="form-control custom-input"
                                                            value="{{ old('email', $admin->email ?? '') }}"
                                                            placeholder="Enter email address"
                                                        >

                                                    </div>

                                                </div>

                                                <!-- PHONE -->

                                                <div class="col-lg-6 col-md-6">

                                                    <div class="form-group">

                                                        <label class="custom-label">

                                                            Phone Number

                                                        </label>

                                                        <input
                                                            type="text"
                                                            name="phone_no"
                                                            class="form-control custom-input"
                                                            value="{{ old('phone_no', $admin->phone_no ?? '') }}"
                                                            placeholder="Enter phone number"
                                                        >

                                                    </div>

                                                </div>

                                            </div>

                                            <!-- BUTTON -->

                                            <div class="mt-3">

                                                <button
                                                    type="submit"
                                                    class="update-btn"
                                                >

                                                    <i class="fas fa-save mr-2"></i>

                                                    Update Profile

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                                <!-- SECURITY TAB -->

                               <div
                                    class="tab-pane fade"
                                    id="security"
                                    role="tabpanel"
                                >

                                    <div class="profile-box">

                                        <form
                                            action="{{ route('admin.change.password') }}"
                                            method="POST"
                                        >

                                            @csrf

                                            <div class="row">

                                                <!-- CURRENT PASSWORD -->

                                                <div class="col-lg-6 col-md-6">

                                                    <div class="form-group">

                                                        <label class="custom-label">

                                                            Current Password

                                                        </label>

                                                        <input
                                                            type="password"
                                                            name="current_password"
                                                            class="form-control custom-input"
                                                            placeholder="Enter current password"
                                                        >

                                                        @error('current_password')

                                                            <small class="text-danger">

                                                                {{ $message }}

                                                            </small>

                                                        @enderror

                                                    </div>

                                                </div>

                                                <!-- NEW PASSWORD -->

                                                <div class="col-lg-6 col-md-6">

                                                    <div class="form-group">

                                                        <label class="custom-label">

                                                            New Password

                                                        </label>

                                                        <input
                                                            type="password"
                                                            name="new_password"
                                                            class="form-control custom-input"
                                                            placeholder="Enter new password"
                                                        >

                                                        @error('new_password')

                                                            <small class="text-danger">

                                                                {{ $message }}

                                                            </small>

                                                        @enderror

                                                    </div>

                                                </div>

                                                <!-- CONFIRM PASSWORD -->

                                                <div class="col-lg-6 col-md-6">

                                                    <div class="form-group">

                                                        <label class="custom-label">

                                                            Confirm Password

                                                        </label>

                                                        <input
                                                            type="password"
                                                            name="confirm_password"
                                                            class="form-control custom-input"
                                                            placeholder="Confirm new password"
                                                        >

                                                        @error('confirm_password')

                                                            <small class="text-danger">

                                                                {{ $message }}

                                                            </small>

                                                        @enderror

                                                    </div>

                                                </div>

                                            </div>

                                            <!-- BUTTON -->

                                            <div class="mt-3">

                                                <button
                                                    type="submit"
                                                    class="update-btn security-btn"
                                                >

                                                    <i class="fas fa-lock mr-2"></i>

                                                    Change Password

                                                </button>

                                            </div>

                                        </form>

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