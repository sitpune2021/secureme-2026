@include('admin.includes.header')

<style>

    .groups-card{
        border:none;
        border-radius:24px;
        overflow:hidden;
        background:#fff;
        box-shadow:0 10px 35px rgba(0,0,0,.08);
    }

    .groups-header{
        padding:24px;
        border-bottom:1px solid #eef2ff;
        background:linear-gradient(135deg,#ffffff,#f8fbff);
    }

    .title-text{
        font-size:24px;
        font-weight:700;
        color:#1e293b;
    }

    .sub-text{
        color:#64748b;
        font-size:14px;
    }

    .search-box{
        position:relative;
        width:100%;
        max-width:340px;
    }

    .search-box input{
        width:100%;
        height:52px;
        border:none;
        border-radius:16px;
        background:#f8fafc;
        padding-left:52px;
        padding-right:15px;
        font-size:14px;
        box-shadow:inset 0 0 0 1px #e2e8f0;
    }

    .search-box input:focus{
        outline:none;
        background:#fff;
        box-shadow:
            0 0 0 4px rgba(103,119,239,.10),
            inset 0 0 0 1px #6777ef;
    }

    .search-icon{
        position:absolute;
        left:18px;
        top:50%;
        transform:translateY(-50%);
        color:#6777ef;
        font-size:16px;
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

    .custom-table tbody tr:hover{
        background:#f8fbff;
    }

    .group-badge{
        background:#6777ef;
        color:#fff;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .status-active{
        background:#dcfce7;
        color:#16a34a;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .status-resolved{
        background:#fee2e2;
        color:#dc2626;
        padding:7px 14px;
        border-radius:30px;
        font-size:12px;
        font-weight:700;
    }

    .view-member-btn{
        border:none;
        border-radius:12px;
        padding:9px 14px;
        background:#eef2ff;
        color:#6777ef;
        font-weight:600;
    }

    .view-member-btn:hover{
        background:#6777ef;
        color:#fff;
    }

    .view-btn{
        width:42px;
        height:42px;
        border:none;
        border-radius:14px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff;
    }

    .member-box{
        background:#f8fafc;
        border-radius:18px;
        padding:18px;
    }

    .member-item{
        display:flex;
        justify-content:space-between;
        align-items:center;
        background:#fff;
        padding:14px;
        border-radius:14px;
        margin-bottom:12px;
        border:1px solid #eef2ff;
        flex-wrap:wrap;
        gap:12px;
    }

    .member-left{
        display:flex;
        align-items:center;
    }

    .member-avatar{
        width:45px;
        height:45px;
        border-radius:14px;
        background:linear-gradient(135deg,#6777ef,#8ea6ff);
        color:#fff;
        display:flex;
        align-items:center;
        justify-content:center;
        font-weight:700;
        margin-right:14px;
    }

    .member-name{
        font-weight:700;
        color:#1e293b;
    }

    .member-role{
        font-size:12px;
        color:#64748b;
    }

    .member-status{
        padding:6px 12px;
        border-radius:20px;
        font-size:12px;
        font-weight:700;
    }

    .pending-status{
        background:#fef3c7;
        color:#d97706;
    }

    .accepted-status{
        background:#dcfce7;
        color:#16a34a;
    }

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
        box-shadow:0 5px 14px rgba(0,0,0,.06);
    }

    .pagination .active .page-link{
        background:#6777ef;
        color:#fff;
    }

    @media(max-width:768px){

        .groups-header{
            padding:18px;
        }

        .title-text{
            font-size:20px;
        }

        .search-box{
            margin-top:15px;
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

                    <div class="groups-card">

                        <!-- HEADER -->

                        <div class="groups-header">

                            <div class="row align-items-center">

                                <div class="col-lg-6">

                                    <div class="title-text">
                                        🚨 Instant Emergency Groups
                                    </div>

                                    <div class="sub-text">
                                        Manage all emergency rescue groups
                                    </div>

                                </div>

                                <div class="col-lg-6">

                                    <div class="search-box ml-lg-auto">

                                        <i class="fas fa-search search-icon"></i>

                                        <input
                                            type="text"
                                            id="searchInput"
                                            placeholder="Search group, signal, user..."
                                            autocomplete="off"
                                        >

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- TABLE -->

                        <div class="table-responsive">

                            <table class="table custom-table" id="groupsTable">

                                <thead>

                                    <tr>

                                        <th>#</th>
                                        <th>Group Name</th>
                                        <th>Signal ID</th>
                                        <th>Emergency User</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Members</th>
                                        <!-- <th>Action</th> -->

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($groups as $group)

                                        <tr>

                                            <td>
                                                {{ ($groups->currentPage() - 1) * $groups->perPage() + $loop->iteration }}
                                            </td>

                                            <td>

                                                <span class="group-badge">

                                                    {{ $group->group_name }}

                                                </span>

                                            </td>

                                            <td>

                                                {{ $group->emergency_signal_id }}

                                            </td>

                                            <td>

                                                {{ $group->emergency_user_name }}

                                            </td>

                                            <td>

                                                @if($group->signal_status == 'Active')

                                                    <span class="status-active">

                                                        Active

                                                    </span>

                                                @else

                                                    <span class="status-resolved">

                                                        Resolved

                                                    </span>

                                                @endif

                                            </td>

                                            <td>

                                                {{ \Carbon\Carbon::parse($group->created_at)->format('d M Y h:i A') }}

                                            </td>

                                            <td>

                                                <button
                                                    class="view-member-btn"
                                                    data-toggle="collapse"
                                                    data-target="#members{{ $group->id }}"
                                                >

                                                    View Members
                                                    ({{ count($group->members) }})

                                                </button>

                                            </td>

                                            <!-- <td>

                                                <button class="view-btn">

                                                    <i class="fas fa-eye"></i>

                                                </button>

                                            </td> -->

                                        </tr>

                                        <!-- MEMBERS -->

                                        <tr
                                            id="members{{ $group->id }}"
                                            class="collapse"
                                        >

                                            <td colspan="8">

                                                <div class="member-box">

                                                    @forelse($group->members as $member)

                                                        <div class="member-item">

                                                            <div class="member-left">

                                                                <div class="member-avatar">

                                                                    {{ strtoupper(substr($member->name,0,1)) }}

                                                                </div>

                                                                <div>

                                                                    <div class="member-name">

                                                                        {{ $member->name }}

                                                                    </div>

                                                                    <div class="member-role">

                                                                        {{ $member->user_role }}

                                                                        •

                                                                        {{ $member->phone_no ?? 'N/A' }}

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div>

                                                                @if($member->status == 'accepted')

                                                                    <span class="member-status accepted-status">

                                                                        Accepted

                                                                    </span>

                                                                @else

                                                                    <span class="member-status pending-status">

                                                                        Pending

                                                                    </span>

                                                                @endif

                                                            </div>

                                                        </div>

                                                    @empty

                                                        <div class="text-center text-muted">

                                                            No Members Found

                                                        </div>

                                                    @endforelse

                                                </div>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="8" class="text-center py-5">

                                                <h5>No Emergency Groups Found</h5>

                                            </td>

                                        </tr>

                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <!-- PAGINATION -->

                        <div class="p-4 bg-white">

                            <div class="d-flex justify-content-between align-items-center flex-wrap">

                                <div class="text-muted mb-2">

                                    Showing
                                    {{ $groups->firstItem() ?? 0 }}
                                    to
                                    {{ $groups->lastItem() ?? 0 }}
                                    of
                                    {{ $groups->total() }}
                                    entries

                                </div>

                                <div>

                                    {!! $groups->links('pagination::bootstrap-5') !!}

                                </div>

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

        let rows = document.querySelectorAll("#groupsTable tbody tr");

        rows.forEach((row) => {

            // collapse member row skip
            if(row.classList.contains('collapse')){
                return;
            }

            let text = row.innerText.toLowerCase();

            if(text.includes(value)){

                row.style.display = "";

                // member row show
                let nextRow = row.nextElementSibling;

                if(nextRow && nextRow.classList.contains('collapse')){
                    nextRow.style.display = "";
                }

            }else{

                row.style.display = "none";

                // member row hide
                let nextRow = row.nextElementSibling;

                if(nextRow && nextRow.classList.contains('collapse')){
                    nextRow.style.display = "none";
                }

            }

        });

    });

</script>

@include('admin.includes.footer')