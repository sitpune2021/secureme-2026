@include('admin.includes.header')

<style>

    .responses-card{
        border:none;
        border-radius:26px;
        overflow:hidden;
        background:#fff;
        box-shadow:
            0 12px 40px rgba(15,23,42,.08),
            0 2px 8px rgba(15,23,42,.04);
    }

    .responses-header{
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
        min-width:1000px;
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
        flex-shrink:0;
        box-shadow:0 8px 18px rgba(103,119,239,.22);
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

    .badge-custom{
        padding:8px 16px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
        display:inline-block;
    }

    .badge-helper{
        background:#dbeafe;
        color:#2563eb;
    }

    .badge-police{
        background:#fee2e2;
        color:#dc2626;
    }

    .badge-success{
        background:#dcfce7;
        color:#16a34a;
    }

    .badge-danger{
        background:#fee2e2;
        color:#dc2626;
    }

    .badge-warning{
        background:#fef3c7;
        color:#d97706;
    }

    .badge-info{
        background:#cffafe;
        color:#0891b2;
    }

    .badge-primary{
        background:#e0e7ff;
        color:#4338ca;
    }

    .badge-secondary{
        background:#f1f5f9;
        color:#475569;
    }

    /* DATE */

    .date-text{
        font-weight:600;
        color:#0f172a;
    }

    .time-text{
        font-size:12px;
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

        .responses-header{
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
            min-width:900px;
        }

    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body">

            <div class="row">

                <div class="col-12">

                    <div class="responses-card">

                        <!-- HEADER -->

                        <div class="responses-header">

                            <div class="row align-items-center">

                                <div class="col-lg-6">

                                    <div class="title-text">
                                        🚨 Emergency Responses
                                    </div>

                                    <div class="sub-text">
                                        Track all helper & police emergency responses
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="search-wrapper">

                                        <div class="search-box">

                                            <i class="fas fa-search search-icon"></i>

                                            <input
                                                type="text"
                                                id="searchInput"
                                                placeholder="Search response..."
                                            >

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- TABLE -->

                        <div class="table-responsive">

                            <table class="table custom-table" id="responsesTable">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Signal ID</th>
                                        <th>Responder</th>
                                        <th>SOS User Helped</th>
                                        <th>Responder Type</th>
                                        <th>Action / Progress</th>
                                        <th>Help Status</th>
                                        <th>SOS Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                              
                                <tbody>
                                    @forelse($responses as $index => $response)
                                        <tr>
                                            {{-- Number --}}
                                            <td>{{ $responses->firstItem() + $index }}</td>

                                            {{-- Signal ID --}}
                                            <td>
                                                <span class="badge-custom badge-primary">
                                                    {{ $response->public_signal_id ?? ('#' . $response->signal_id) }}
                                                </span>
                                            </td>

                                            {{-- Responder --}}
                                            <td>
                                                <div class="user-flex">
                                                    <div class="user-avatar">
                                                        {{ strtoupper(substr($response->responder_name ?? 'N', 0, 1)) }}
                                                    </div>

                                                    <div>
                                                        <div class="user-name">
                                                            {{ $response->responder_name ?? 'N/A' }}
                                                        </div>

                                                        <div class="user-id">
                                                            {{ $response->responder_phone ?? 'No phone' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- SOS User Helped --}}
                                            <td>
                                                <div class="user-flex">
                                                    <div class="user-avatar">
                                                        {{ strtoupper(substr($response->sos_user_name ?? 'U', 0, 1)) }}
                                                    </div>

                                                    <div>
                                                        <div class="user-name">
                                                            {{ $response->sos_user_name ?? 'Unknown User' }}
                                                        </div>

                                                        <div class="user-id">
                                                            {{ $response->sos_user_phone ?? 'No phone' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Responder Type --}}
                                            <td>
                                                @if(strtolower($response->responder_type) === 'helper')
                                                    <span class="badge-custom badge-helper">Helper</span>
                                                @else
                                                    <span class="badge-custom badge-police">
                                                        {{ ucfirst($response->responder_type) }}
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Action / Progress --}}
                                            <td>
                                                @php
                                                    $action = strtolower($response->response_action ?? 'pending');

                                                    $actionClass = [
                                                        'accept'          => 'badge-success',
                                                        'accepted'        => 'badge-success',
                                                        'decline'         => 'badge-danger',
                                                        'declined'        => 'badge-danger',
                                                        'rejected'        => 'badge-danger',
                                                        'on_the_way'      => 'badge-info',
                                                        'arrived'          => 'badge-info',
                                                        'help_completed'  => 'badge-success',
                                                        'unable_to_help'  => 'badge-danger',
                                                        'pending'          => 'badge-warning',
                                                    ];
                                                @endphp

                                                <span class="badge-custom {{ $actionClass[$action] ?? 'badge-secondary' }}">
                                                    {{ ucwords(str_replace('_', ' ', $action)) }}
                                                </span>
                                            </td>

                                            {{-- Help Status --}}
                                            <td>
                                                @php
                                                    $helpStatus = strtolower($response->response_status ?? 'pending');

                                                    $statusClass = [
                                                        'in_progress' => 'badge-info',
                                                        'completed'   => 'badge-success',
                                                        'pending'     => 'badge-warning',
                                                    ];
                                                @endphp

                                                <span class="badge-custom {{ $statusClass[$helpStatus] ?? 'badge-secondary' }}">
                                                    {{ ucwords(str_replace('_', ' ', $helpStatus)) }}
                                                </span>
                                            </td>

                                            {{-- SOS Status --}}
                                            <td>
                                                @php
                                                    $signalStatus = strtolower($response->signal_status ?? 'active');
                                                @endphp

                                                <span class="badge-custom {{ $signalStatus === 'resolved' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ ucfirst($signalStatus) }}
                                                </span>
                                            </td>

                                            {{-- Date --}}
                                            <td>
                                                <div class="date-text">
                                                    {{ \Carbon\Carbon::parse($response->response_created_at ?? $response->created_at)->format('d M Y') }}
                                                </div>

                                                <div class="time-text">
                                                    {{ \Carbon\Carbon::parse($response->response_created_at ?? $response->created_at)->format('h:i A') }}
                                                </div>
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <div class="empty-box">
                                                    <img src="{{ asset('admin-assets/img/no-data.svg') }}">

                                                    <h5>No Emergency Responses</h5>

                                                    <p class="text-muted mb-0">
                                                        No response records available.
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

                                {!! $responses->links('pagination::bootstrap-5') !!}

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

        let rows = document.querySelectorAll("#responsesTable tbody tr");

        rows.forEach(row => {

            row.style.display =
                row.innerText.toLowerCase().includes(value)
                    ? ""
                    : "none";

        });

    });

</script>

@include('admin.includes.footer')