@include('admin.includes.header')

<style>

    .report-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
    }

    .top-header{
        padding:24px;
        border-bottom:1px solid #eef2ff;
        background:linear-gradient(135deg,#ffffff,#f8fbff);
    }

    .page-title{
        font-size:26px;
        font-weight:700;
        color:#1e293b;
    }

    .sub-title{
        color:#64748b;
        font-size:14px;
    }

    .stats-box{
        padding:20px;
        border-radius:20px;
        color:#fff;
    }

    .bg-total{
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
    }

    .bg-accepted{
        background:linear-gradient(135deg,#16a34a,#4ade80);
    }

    .bg-pending{
        background:linear-gradient(135deg,#f59e0b,#fbbf24);
    }

    .stats-number{
        font-size:30px;
        font-weight:700;
    }

    .search-box{
        position:relative;
        max-width:320px;
        width:100%;
    }

    .search-box input{
        width:100%;
        height:50px;
        border:none;
        border-radius:14px;
        padding-left:45px;
        background:#f8fafc;
        box-shadow:inset 0 0 0 1px #e2e8f0;
    }

    .search-icon{
        position:absolute;
        left:16px;
        top:50%;
        transform:translateY(-50%);
        color:#6777ef;
    }

    .custom-table{
        min-width:1100px;
    }

    .custom-table thead{
        background:#f8fafc;
    }

    .custom-table thead th{
        border:none;
        padding:18px;
        font-size:12px;
        text-transform:uppercase;
        color:#64748b;
    }

    .custom-table tbody td{
        padding:18px;
        border-top:1px solid #f1f5f9;
        white-space:nowrap;
    }

    .signal-id{
        background:#6777ef;
        color:#fff;
        padding:8px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .accepted-badge{
        background:#dcfce7;
        color:#16a34a;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .pending-badge{
        background:#fef3c7;
        color:#d97706;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

</style>

<div class="main-content">

    <section class="section">

        <div class="section-body">

            <!-- TOP CARDS -->

            <div class="row">

                <div class="col-lg-4 mb-4">

                    <div class="stats-box bg-total">

                        <div>Total Responses</div>

                        <div class="stats-number">

                            {{ $totalResponses }}

                        </div>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="stats-box bg-accepted">

                        <div>Accepted Responses</div>

                        <div class="stats-number">

                            {{ $acceptedResponses }}

                        </div>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="stats-box bg-pending">

                        <div>Pending Responses</div>

                        <div class="stats-number">

                            {{ $pendingResponses }}

                        </div>

                    </div>

                </div>

            </div>

            <!-- TABLE CARD -->

            <div class="report-card">

                <div class="top-header">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div>

                            <div class="page-title">

                                🤝 Emergency Responses Report

                            </div>

                            <div class="sub-title">

                                Monitor police helpers and emergency response logs

                            </div>

                        </div>

                        <form method="GET">

                            <div class="search-box">

                                <i class="fas fa-search search-icon"></i>

                                <input
                                    type="text"
                                    id="searchInput"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search responses..."
                                >

                            </div>

                        </form>

                    </div>

                </div>

                <div class="table-responsive">

                    <table class="table custom-table">

                        <thead>

                            <tr>

                                <th>#</th>
                                <th>Signal ID</th>
                                <th>Responder</th>
                                <th>Role</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Date & Time</th>

                            </tr>

                        </thead>

                        <tbody id="responseTable">

                            @forelse($responses as $response)

                                <tr>

                                    <td>

                                        {{ ($responses->currentPage() - 1) * $responses->perPage() + $loop->iteration }}

                                    </td>

                                    <td>

                                        <span class="signal-id">

                                            {{ $response->emergency_signal_code }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ $response->name }}

                                    </td>

                                    <td>

                                        {{ $response->user_role }}

                                    </td>

                                    <td>

                                        {{ $response->phone_no ?? 'N/A' }}

                                    </td>

                                    <td>

                                        @if($response->response_action == 'accepted')

                                            <span class="accepted-badge">

                                                Accepted

                                            </span>

                                        @else

                                            <span class="pending-badge">

                                                Pending

                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($response->created_at)->format('d M Y h:i A') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        No Emergency Responses Found

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="p-4">

                    <div class="d-flex justify-content-between align-items-center flex-wrap">

                        <div class="text-muted mb-2">

                            Showing
                            {{ $responses->firstItem() ?? 0 }}
                            to
                            {{ $responses->lastItem() ?? 0 }}
                            of
                            {{ $responses->total() ?? 0 }}
                            entries

                        </div>

                        <div>

                            @if(method_exists($responses, 'links'))

                                {!! $responses->links('pagination::bootstrap-5') !!}

                            @endif

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

        let rows = document.querySelectorAll("#responseTable tr");

        rows.forEach(row => {

            row.style.display =
                row.innerText.toLowerCase().includes(value)
                    ? ""
                    : "none";

        });

    });

</script>

@include('admin.includes.footer')