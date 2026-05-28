@include('admin.includes.header')

<style>

    .signals-card{
        border:none;
        border-radius:26px;
        overflow:hidden;
        background:#fff;
        box-shadow:
            0 12px 40px rgba(15,23,42,.08),
            0 2px 8px rgba(15,23,42,.04);
    }

    .signals-header{
        padding:24px;
        background:linear-gradient(135deg,#ffffff 0%,#f8faff 100%);
        border-bottom:1px solid #eef2ff;
    }

    .title-text{
        font-size:24px;
        font-weight:700;
        color:#0f172a;
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
        border-radius:16px;
        padding-left:52px;
        padding-right:16px;
        background:#f8fafc;
        font-size:14px;
        font-weight:500;
        color:#0f172a;
        box-shadow:inset 0 0 0 1px #e2e8f0;
        transition:.3s ease;
    }

    .search-box input:focus{
        outline:none;
        background:#fff;
        box-shadow:
            0 0 0 4px rgba(103,119,239,.10),
            inset 0 0 0 1px #6777ef;
    }

    .search-box input::placeholder{
        color:#94a3b8;
    }

    .search-icon{
        position:absolute;
        left:18px;
        top:50%;
        transform:translateY(-50%);
        color:#6777ef;
        font-size:16px;
        pointer-events:none;
    }

    /* TABLE */

    .table-responsive{
        overflow-x:auto;
    }

    .custom-table{
        margin:0;
        min-width:1050px;
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
        background:linear-gradient(135deg,#ef4444,#f87171);
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
        font-size:18px;
        margin-right:14px;
        flex-shrink:0;
        box-shadow:0 8px 18px rgba(239,68,68,.25);
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

    /* STATUS */

    .status-badge{
        padding:8px 16px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
        display:inline-block;
    }

    .status-active{
        background:#fee2e2;
        color:#dc2626;
    }

    .status-resolved{
        background:#dcfce7;
        color:#16a34a;
    }

    /* BUTTONS */

    .map-btn{
        border:none;
        border-radius:12px;
        padding:10px 16px;
        font-size:13px;
        font-weight:600;
        background:#eef2ff;
        color:#6777ef;
        transition:.3s ease;
    }

    .map-btn:hover{
        background:#6777ef;
        color:#fff;
        text-decoration:none;
    }

    .close-btn{
        border:none;
        border-radius:12px;
        padding:10px 18px;
        font-size:13px;
        font-weight:700;
        background:linear-gradient(135deg,#f59e0b,#fbbf24);
        color:#fff;
        transition:.3s ease;
        box-shadow:0 8px 18px rgba(245,158,11,.20);
    }

    .close-btn:hover{
        transform:translateY(-2px);
        box-shadow:0 12px 24px rgba(245,158,11,.28);
    }

    .closed-text{
        font-weight:700;
        color:#94a3b8;
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

        .signals-header{
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
            min-width:950px;
        }

    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body">

            <div class="row">

                <div class="col-12">

                    <div class="signals-card">

                        <!-- HEADER -->

                        <div class="signals-header">

                            <div class="row align-items-center">

                                <div class="col-lg-6">

                                    <div class="title-text">
                                        🚨 Emergency Signals
                                    </div>

                                    <div class="sub-text">
                                        Live emergency alerts generated by users
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="search-wrapper">

                                        <div class="search-box">

                                            <i class="fas fa-search search-icon"></i>

                                            <input
                                                type="text"
                                                id="searchInput"
                                                placeholder="Search by user, phone, status..."
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- TABLE -->

                        <div class="table-responsive">

                            <table class="table custom-table" id="signalsTable">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>User</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Location</th>
                                        <th>Date & Time</th>
                                        <th class="text-center">Action</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($signals as $signal)

                                        <tr>

                                            <td>
                                                {{ $signal->id }}
                                            </td>

                                            <td>

                                                <div class="user-flex">

                                                    <div class="user-avatar">

                                                        {{ strtoupper(substr($signal->user_name,0,1)) }}

                                                    </div>

                                                    <div>

                                                        <div class="user-name">
                                                            {{ $signal->user_name }}
                                                        </div>

                                                        <div class="user-id">
                                                            Signal ID #{{ $signal->id }}
                                                        </div>

                                                    </div>

                                                </div>

                                            </td>

                                            <td>
                                                {{ $signal->user_phone ?? 'N/A' }}
                                            </td>

                                            <td>

                                                <span class="status-badge 
                                                    {{ $signal->signal_status == 'Active' ? 'status-active' : 'status-resolved' }}">

                                                    {{ $signal->signal_status }}

                                                </span>

                                            </td>

                                            <td>

                                                @if($signal->latitude && $signal->longitude)

                                                    <a href="https://maps.google.com/?q={{ $signal->latitude }},{{ $signal->longitude }}"
                                                        target="_blank"
                                                        class="map-btn">

                                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                                        View Map

                                                    </a>

                                                @else

                                                    <span class="text-muted">
                                                        N/A
                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                {{ \Carbon\Carbon::parse($signal->created_at)->format('d M Y') }}

                                                <br>

                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($signal->created_at)->format('h:i A') }}
                                                </small>

                                            </td>

                                            <td class="text-center">

                                                @if($signal->signal_status == 'Active')

                                                    <form action="{{ url('admin/emergency-signal/close/'.$signal->id) }}"
                                                        method="POST">

                                                        @csrf

                                                        <button class="close-btn">

                                                            <i class="fas fa-times-circle mr-1"></i>
                                                            Close

                                                        </button>

                                                    </form>

                                                @else

                                                    <span class="closed-text">

                                                        <i class="fas fa-check-circle"></i>
                                                        Closed

                                                    </span>

                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="7">

                                                <div class="empty-box">

                                                    <img src="{{ asset('admin-assets/img/no-data.svg') }}">

                                                    <h5>No Emergency Signals</h5>

                                                    <p class="text-muted mb-0">
                                                        No emergency alerts available.
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

                                {!! $signals->links('pagination::bootstrap-5') !!}

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

        let rows = document.querySelectorAll("#signalsTable tbody tr");

        rows.forEach(row => {

            row.style.display =
                row.innerText.toLowerCase().includes(value)
                    ? ""
                    : "none";

        });

    });

</script>

@include('admin.includes.footer')