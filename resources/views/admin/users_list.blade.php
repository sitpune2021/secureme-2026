@include('admin.includes.header')

<style>

    .users-card{
        border:none;
        border-radius:26px;
        overflow:hidden;
        background:#fff;
        box-shadow:
            0 12px 40px rgba(15,23,42,.08),
            0 2px 8px rgba(15,23,42,.04);
    }

    .users-header{
        padding:24px;
        background:
            linear-gradient(135deg,#ffffff 0%,#f8faff 100%);
        border-bottom:1px solid #eef2ff;
    }

    .title-text{
        font-size:24px;
        font-weight:700;
        color:#1e293b;
        margin-bottom:4px;
    }

    .sub-text{
        color:#64748b;
        font-size:14px;
    }

    /* SEARCH */

    .search-wrapper{
        display:flex;
        justify-content:flex-end;
    }

    .search-box{
        position:relative;
        width:100%;
        max-width:360px;
    }

    .search-box input{
        width:100%;
        height:52px;
        border:none;
        outline:none !important;
        border-radius:16px;
        padding-left:52px;
        padding-right:16px;
        background:#f8fafc;
        font-size:14px;
        font-weight:500;
        color:#0f172a;
        transition:.3s ease;
        box-shadow:
            inset 0 0 0 1px #e2e8f0;
    }

    .search-box input:focus{
        background:#fff;
        box-shadow:
            0 0 0 4px rgba(103,119,239,.10),
            inset 0 0 0 1px #6777ef;
    }

    .search-box input::placeholder{
        color:#94a3b8;
        font-weight:500;
    }

    .search-box .search-icon{
        position:absolute;
        left:18px;
        top:50%;
        transform:translateY(-50%);
        color:#6777ef;
        font-size:16px;
        z-index:10;
        pointer-events:none;
    }

    /* TABLE */

    .table-responsive{
        overflow-x:auto;
    }

    .custom-table{
        margin:0;
        min-width:950px;
    }

    .custom-table thead{
        background:#f8fafc;
    }

    .custom-table thead th{
        border:none;
        padding:18px 16px;
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:.5px;
        color:#64748b;
        font-weight:700;
        white-space:nowrap;
    }

    .custom-table tbody td{
        padding:18px 16px;
        vertical-align:middle;
        border-top:1px solid #f1f5f9;
        white-space:nowrap;
    }

    .custom-table tbody tr{
        transition:.25s ease;
    }

    .custom-table tbody tr:hover{
        background:#f8fbff;
    }

    /* USER */

    .user-flex{
        display:flex;
        align-items:center;
    }

    .user-avatar{
        width:48px;
        height:48px;
        border-radius:16px;
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
        font-size:18px;
        margin-right:14px;
        box-shadow:0 8px 18px rgba(103,119,239,.22);
        flex-shrink:0;
    }

    .user-name{
        font-weight:700;
        color:#0f172a;
        font-size:15px;
    }

    .user-id{
        font-size:12px;
        color:#94a3b8;
    }

    /* BADGES */

    .role-badge{
        padding:8px 15px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
        display:inline-block;
    }

    .role-police{
        background:#dbeafe;
        color:#2563eb;
    }

    .role-manager{
        background:#dcfce7;
        color:#16a34a;
    }

    .role-gym{
        background:#fef3c7;
        color:#d97706;
    }

    .role-defense{
        background:#fee2e2;
        color:#dc2626;
    }

    /* ACTION BUTTON */

    .view-btn{
        width:42px;
        height:42px;
        border:none;
        border-radius:14px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff !important;
        transition:.3s ease;
        box-shadow:0 8px 20px rgba(103,119,239,.22);
    }

    .view-btn:hover{
        transform:translateY(-3px);
        box-shadow:0 12px 28px rgba(103,119,239,.30);
    }

    /* PAGINATION */

    .pagination{
        gap:8px;
    }

    .pagination .page-link{
        border:none;
        width:42px;
        height:42px;
        border-radius:14px !important;
        display:flex;
        align-items:center;
        justify-content:center;
        color:#6777ef;
        font-weight:700;
        background:#fff;
        box-shadow:0 5px 14px rgba(0,0,0,.06);
    }

    .pagination .active .page-link{
        background:#6777ef;
        color:#fff;
    }

    /* EMPTY */

    .empty-box{
        padding:60px 20px;
        text-align:center;
    }

    .empty-box img{
        width:120px;
        margin-bottom:16px;
    }

    /* MOBILE */

    @media(max-width:768px){

        .users-header{
            padding:18px;
        }

        .title-text{
            font-size:20px;
        }

        .search-wrapper{
            margin-top:18px;
        }

        .search-box{
            max-width:100%;
        }

        .custom-table{
            min-width:800px;
        }

    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body">

            <div class="row">

                <div class="col-12">

                    <div class="users-card">

                        <!-- HEADER -->

                        <div class="users-header">

                            <div class="row align-items-center">

                                <div class="col-lg-6">

                                    <div class="title-text">
                                        👥 Emergency Helpers
                                    </div>

                                    <div class="sub-text">
                                        Police, Manager, Gym Person & Defense Members
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="search-wrapper">

                                        <div class="search-box">

                                            <i class="fas fa-search search-icon"></i>

                                            <input
                                                type="text"
                                                id="searchInput"
                                                placeholder="Search helper by name, email, role..."
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- TABLE -->

                        <div class="table-responsive">

                            <table class="table custom-table" id="usersTable">

                                <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Joined</th>
                                        <th class="text-center">Action</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($users as $user)

                                        <tr>

                                            <td>
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </td>

                                            <td>

                                                <div class="user-flex">

                                                    <div class="user-avatar">
                                                        {{ strtoupper(substr($user->name,0,1)) }}
                                                    </div>

                                                    <div>

                                                        <div class="user-name">
                                                            {{ $user->name }}
                                                        </div>

                                                        <div class="user-id">
                                                            ID #{{ $user->id }}
                                                        </div>

                                                    </div>

                                                </div>

                                            </td>

                                            <td>

                                                @php

                                                    $roleClass = '';

                                                    if($user->user_role == 'police'){
                                                        $roleClass = 'role-police';
                                                    }
                                                    elseif($user->user_role == 'Manager'){
                                                        $roleClass = 'role-manager';
                                                    }
                                                    elseif($user->user_role == 'Gym_Person'){
                                                        $roleClass = 'role-gym';
                                                    }
                                                    else{
                                                        $roleClass = 'role-defense';
                                                    }

                                                @endphp

                                                <span class="role-badge {{ $roleClass }}">
                                                    {{ $user->user_role }}
                                                </span>

                                            </td>

                                            <td>{{ $user->email }}</td>

                                            <td>{{ $user->phone_no ?? 'N/A' }}</td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}
                                            </td>

                                            <td class="text-center">

                                                <a href="{{ url('admin/users-details/'.$user->id) }}"
                                                    class="view-btn">

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="7">

                                                <div class="empty-box">

                                                    <img src="{{ asset('admin-assets/img/no-data.svg') }}">

                                                    <h5>No Helpers Found</h5>

                                                    <p class="text-muted mb-0">
                                                        No emergency helpers available.
                                                    </p>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <!-- PAGINATION -->

                        <div class="p-4 bg-white">

                            <div class="d-flex justify-content-center">

                                {!! $users->links('pagination::bootstrap-5') !!}

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<script>

    document.getElementById("searchInput").addEventListener("keyup", function () {

        let value = this.value.toLowerCase();

        let rows = document.querySelectorAll("#usersTable tbody tr");

        rows.forEach(row => {

            row.style.display =
                row.innerText.toLowerCase().includes(value)
                    ? ""
                    : "none";

        });

    });

</script>

@include('admin.includes.footer')