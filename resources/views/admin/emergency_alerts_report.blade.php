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
        position:relative;
        overflow:hidden;
    }

    .bg-total{
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
    }

    .bg-active{
        background:linear-gradient(135deg,#16a34a,#4ade80);
    }

    .bg-resolved{
        background:linear-gradient(135deg,#dc2626,#fb7185);
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
        min-width:1000px;
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

    .badge-active{
        background:#dcfce7;
        color:#16a34a;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .badge-resolved{
        background:#fee2e2;
        color:#dc2626;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .signal-id{
        background:#6777ef;
        color:#fff;
        padding:8px 14px;
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

                        <div>Total Alerts</div>

                        <div class="stats-number">
                            {{ $totalAlerts }}
                        </div>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="stats-box bg-active">

                        <div>Active Alerts</div>

                        <div class="stats-number">
                            {{ $activeAlerts }}
                        </div>

                    </div>

                </div>

                <div class="col-lg-4 mb-4">

                    <div class="stats-box bg-resolved">

                        <div>Resolved Alerts</div>

                        <div class="stats-number">
                            {{ $resolvedAlerts }}
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
                                🚨 Emergency Alerts Report
                            </div>

                            <div class="sub-title">
                                Monitor all emergency alerts raised by users
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
                                    placeholder="Search alert..."
                                    autocomplete="off"
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
                                <th>User Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Date & Time</th>

                            </tr>

                        </thead>

                        <tbody id="responseTable">

                            @forelse($alerts as $alert)

                                <tr>

                                    <td>
                                        {{ ($alerts->currentPage() - 1) * $alerts->perPage() + $loop->iteration }}
                                    </td>

                                    <td>

                                        <span class="signal-id">

                                            {{ $alert->signal_id }}

                                        </span>

                                    </td>

                                    <td>

                                        {{ $alert->name }}

                                    </td>

                                    <td>

                                        {{ $alert->phone_no ?? 'N/A' }}

                                    </td>

                                    <td>

                                        @if($alert->signal_status == 'Active')

                                            <span class="badge-active">

                                                Active

                                            </span>

                                        @else

                                            <span class="badge-resolved">

                                                Resolved

                                            </span>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $alert->latitude }}
                                    </td>

                                    <td>
                                        {{ $alert->longitude }}
                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($alert->created_at)->format('d M Y h:i A') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center py-5">

                                        No Emergency Alerts Found

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
                            {{ $alerts->firstItem() ?? 0 }}
                            to
                            {{ $alerts->lastItem() ?? 0 }}
                            of
                            {{ $alerts->total() }}
                            entries

                        </div>

                        <div>

                            {!! $alerts->links('pagination::bootstrap-5') !!}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<script>

    const searchInput = document.getElementById('searchInput');

    searchInput.addEventListener('keyup', function () {

        let value = this.value.toLowerCase();

        let rows = document.querySelectorAll('#responseTable tr');

        rows.forEach((row) => {

            let text = row.innerText.toLowerCase();

            if (text.includes(value)) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    });

</script>

@include('admin.includes.footer')