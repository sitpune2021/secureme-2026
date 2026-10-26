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

<!-- Responder / Police Status style -->
<style>
    .report-responder-cell {
    min-width: 270px;
    max-width: 360px;
    white-space: normal !important;
    vertical-align: top !important;
}

.report-responder-card {
    width: 100%;
    min-width: 240px;
    padding: 12px;
    margin-bottom: 10px;
    background: #ffffff;
    border: 1px solid #e5eaf1;
    border-radius: 10px;
    overflow-wrap: anywhere;
}

.report-responder-card:last-child {
    margin-bottom: 0;
}

.report-responder-name {
    color: #1e293b;
    font-size: 13px;
    font-weight: 700;
    margin-bottom: 8px;
}

.report-responder-name i {
    color: #2563eb;
    margin-right: 5px;
}

.report-responder-info {
    color: #475569;
    font-size: 12px;
    line-height: 1.7;
    margin-top: 4px;
}

.report-responder-progress {
    display: flex;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 8px;
    color: #475569;
    font-size: 12px;
}

.report-status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    line-height: 1.5;
}

.report-status-accepted {
    background: #dbeafe;
    color: #1d4ed8;
}

.report-status-progress {
    background: #fef3c7;
    color: #92400e;
}

.report-status-arrived {
    background: #ede9fe;
    color: #6d28d9;
}

.report-status-completed {
    background: #dcfce7;
    color: #166534;
}

.report-status-declined {
    background: #fee2e2;
    color: #b91c1c;
}

.report-status-pending {
    background: #f1f5f9;
    color: #475569;
}

.report-responder-notes {
    margin-top: 8px;
    padding: 8px;
    background: #f8fafc;
    border-left: 3px solid #cbd5e1;
    border-radius: 4px;
    color: #475569;
    font-size: 11px;
    line-height: 1.6;
}

.report-responder-updated {
    margin-top: 8px;
    padding-top: 7px;
    border-top: 1px solid #edf0f4;
    color: #64748b;
    font-size: 10px;
}

.report-responder-updated i {
    margin-right: 4px;
}

.report-no-responder {
    min-width: 180px;
    padding: 12px;
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 8px;
    color: #64748b;
    font-size: 12px;
}

@media (max-width: 768px) {
    .report-responder-cell {
        min-width: 250px;
        max-width: 300px;
    }

    .report-responder-card {
        min-width: 220px;
    }
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
                                <th>SOS Status</th>
                                <th>Responder / Police Status</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Date & Time</th>
                            </tr>
                        </thead>

                        <tbody id="responseTable">

                            @forelse($alerts as $alert)

                                <tr>
                                    {{-- Serial Number --}}
                                    <td>
                                        {{ ($alerts->currentPage() - 1) * $alerts->perPage() + $loop->iteration }}
                                    </td>

                                    {{-- Signal ID --}}
                                    <td>
                                        <span class="signal-id">
                                            {{ $alert->signal_id }}
                                        </span>
                                    </td>

                                    {{-- SOS User --}}
                                    <td>
                                        {{ $alert->name }}
                                    </td>

                                    {{-- SOS User Phone --}}
                                    <td>
                                        {{ $alert->phone_no ?? 'N/A' }}
                                    </td>

                                    {{-- SOS Status --}}
                                    <td>
                                        @if($alert->signal_status == 'Active')
                                            <span class="badge-active">Active</span>
                                        @else
                                            <span class="badge-resolved">Resolved</span>
                                        @endif
                                    </td>

                                    {{-- Responder / Police Details --}}
                                    <td class="report-responder-cell">

                                        @forelse($alert->responders as $responder)

                                            @php
                                                $action = strtolower($responder->response_action ?? '');

                                                $actionLabels = [
                                                    'accept' => 'Accepted SOS',
                                                    'accepted' => 'Accepted SOS',
                                                    'decline' => 'Declined SOS',
                                                    'declined' => 'Declined SOS',
                                                    'on_the_way' => 'On The Way',
                                                    'arrived' => 'Arrived at Location',
                                                    'help_completed' => 'Help Completed',
                                                    'unable_to_help' => 'Unable To Help',
                                                ];

                                                $actionClasses = [
                                                    'accept' => 'report-status-accepted',
                                                    'accepted' => 'report-status-accepted',
                                                    'decline' => 'report-status-declined',
                                                    'declined' => 'report-status-declined',
                                                    'on_the_way' => 'report-status-progress',
                                                    'arrived' => 'report-status-arrived',
                                                    'help_completed' => 'report-status-completed',
                                                    'unable_to_help' => 'report-status-declined',
                                                ];

                                                $responseStatus = strtolower($responder->response_status ?? 'pending');
                                            @endphp

                                            <div class="report-responder-card">

                                                <div class="report-responder-name">
                                                    <i class="fas fa-user-shield"></i>
                                                    {{ $responder->responder_name ?? 'Unknown Responder' }}
                                                </div>

                                                <div class="report-responder-info">
                                                    <strong>Role:</strong>
                                                    {{ $responder->responder_role ?? $responder->responder_type ?? 'Responder' }}
                                                </div>

                                                <div class="report-responder-info">
                                                    <strong>Phone:</strong>
                                                    {{ $responder->responder_phone ?? 'N/A' }}
                                                </div>

                                                <div class="report-responder-progress">
                                                    <strong>Progress:</strong>

                                                    <span class="report-status-badge {{ $actionClasses[$action] ?? 'report-status-pending' }}">
                                                        {{ $actionLabels[$action] ?? ($action !== '' ? ucwords(str_replace('_', ' ', $action)) : 'No Response Yet') }}
                                                    </span>
                                                </div>

                                                <div class="report-responder-info">
                                                    <strong>Response Status:</strong>

                                                    @if($responseStatus == 'in_progress')
                                                        <span class="report-status-badge report-status-progress">
                                                            In Progress
                                                        </span>
                                                    @elseif($responseStatus == 'completed')
                                                        <span class="report-status-badge report-status-completed">
                                                            Completed
                                                        </span>
                                                    @elseif($responseStatus == 'pending')
                                                        <span class="report-status-badge report-status-pending">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span class="report-status-badge report-status-pending">
                                                            {{ ucwords(str_replace('_', ' ', $responseStatus)) }}
                                                        </span>
                                                    @endif
                                                </div>

                                                @if(!empty($responder->response_notes))
                                                    <div class="report-responder-notes">
                                                        <strong>Note:</strong>
                                                        {{ $responder->response_notes }}
                                                    </div>
                                                @endif

                                                @if($responder->response_updated_at)
                                                    <div class="report-responder-updated">
                                                        <i class="far fa-clock"></i>
                                                        {{ \Carbon\Carbon::parse($responder->response_updated_at)->format('d M Y, h:i A') }}
                                                    </div>
                                                @endif

                                            </div>

                                        @empty

                                            <div class="report-no-responder">
                                                <i class="fas fa-user-clock"></i>
                                                No Responder Yet
                                            </div>

                                        @endforelse

                                    </td>

                                    {{-- Location --}}
                                    <td>{{ $alert->latitude }}</td>
                                    <td>{{ $alert->longitude }}</td>

                                    {{-- Date & Time --}}
                                    <td>
                                        {{ \Carbon\Carbon::parse($alert->created_at)->format('d M Y h:i A') }}
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="9" class="text-center py-5">
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