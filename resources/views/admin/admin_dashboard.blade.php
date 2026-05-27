@include('admin.includes.header');
<style>

/* =========================
   PREMIUM DASHBOARD
========================= */

.section{
    padding:10px 5px 40px;
}

/* DASHBOARD HEADER */

.dashboard-top{

    margin-bottom:28px;

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
}

.dashboard-title h2{

    font-size:30px;
    font-weight:800;
    margin-bottom:6px;

    color:#0f172a;
}

.dashboard-title p{

    margin:0;

    color:#64748b;
    font-size:14px;
}

/* =========================
   PREMIUM CARDS
========================= */

.premium-card{

    position:relative;

    overflow:hidden;

    border:none !important;

    border-radius:26px !important;

    background:
        rgba(255,255,255,0.92);

    backdrop-filter:blur(14px);

    box-shadow:
        0 10px 35px rgba(15,23,42,0.08);

    transition:0.35s ease;
}

.premium-card:hover{

    transform:translateY(-6px);

    box-shadow:
        0 18px 45px rgba(14,165,233,0.16);
}

/* GLOW */

.premium-card::before{

    content:"";

    position:absolute;

    top:-80px;
    right:-80px;

    width:180px;
    height:180px;

    border-radius:50%;

    background:
        radial-gradient(rgba(56,189,248,0.22),transparent);

}

/* CARD BODY */

.stats-card{

    padding:24px;
}

/* ICON */

.stats-icon{

    width:68px;
    height:68px;

    border-radius:22px;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:30px;

    color:#fff;

    margin-bottom:22px;

    box-shadow:
        0 10px 25px rgba(0,0,0,0.10);
}

.icon-blue{
    background:linear-gradient(135deg,#0284c7,#38bdf8);
}

.icon-green{
    background:linear-gradient(135deg,#059669,#34d399);
}

.icon-orange{
    background:linear-gradient(135deg,#ea580c,#fb923c);
}

.icon-red{
    background:linear-gradient(135deg,#dc2626,#f87171);
}

.icon-purple{
    background:linear-gradient(135deg,#7c3aed,#a78bfa);
}

/* CARD TEXT */

.stats-title{

    font-size:15px;
    font-weight:600;

    color:#64748b;

    margin-bottom:10px;
}

.stats-number{

    font-size:34px;
    font-weight:800;

    color:#0f172a;

    line-height:1;
}

.stats-bottom{

    margin-top:16px;

    display:flex;
    align-items:center;
    justify-content:space-between;
}

.stats-badge{

    padding:6px 12px;

    border-radius:50px;

    font-size:12px;
    font-weight:600;

    background:#eff6ff;

    color:#0284c7;
}

/* =========================
   CHART CARD
========================= */

.chart-card{

    border:none !important;

    border-radius:28px !important;

    overflow:hidden;

    background:#fff;

    box-shadow:
        0 12px 35px rgba(15,23,42,0.08);
}

.chart-header{

    padding:24px 28px;

    border-bottom:
        1px solid rgba(15,23,42,0.06);

    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
}

.chart-header h4{

    margin:0;

    font-size:22px;
    font-weight:700;

    color:#0f172a;
}

.chart-sub{

    color:#64748b;
    font-size:13px;
}

/* CHART BODY */

.chart-body{

    padding:25px;
}

/* =========================
   TABLE CARD
========================= */

.table-card{

    border:none !important;

    border-radius:28px !important;

    overflow:hidden;

    background:#fff;

    box-shadow:
        0 10px 35px rgba(15,23,42,0.07);
}

.table-card .card-header{

    background:transparent;

    border:none;

    padding:22px 26px 10px;
}

.table-card .card-header h4{

    margin:0;

    font-size:22px;
    font-weight:700;

    color:#0f172a;
}

/* TABLE */

.table{

    margin-bottom:0;
}

.table thead th{

    border:none !important;

    background:#f8fafc;

    color:#475569;

    font-size:13px;
    font-weight:700;

    padding:18px;
}

.table tbody td{

    padding:18px;

    vertical-align:middle;

    border-top:
        1px solid rgba(15,23,42,0.05);
}

/* BUTTON */

.btn-premium{

    border:none;

    border-radius:14px;

    padding:10px 18px;

    background:
        linear-gradient(135deg,#0284c7,#38bdf8);

    color:#fff !important;

    font-weight:600;

    transition:0.3s ease;
}

.btn-premium:hover{

    transform:translateY(-2px);

    box-shadow:
        0 12px 22px rgba(56,189,248,0.28);
}

/* SEARCH */

.premium-search{

    height:46px;

    border:none;

    border-radius:14px;

    background:#f1f5f9;

    padding:0 16px;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:1199px){

    .stats-number{
        font-size:28px;
    }
}

@media(max-width:991px){

    .main-content{
        padding-left:20px !important;
        padding-right:20px !important;
    }

    .dashboard-title h2{
        font-size:24px;
    }

    .stats-card{
        padding:22px;
    }

    .chart-header{
        padding:20px;
    }
}

@media(max-width:768px){

    .section{
        padding:5px 0 30px;
    }

    .dashboard-title h2{
        font-size:22px;
    }

    .stats-number{
        font-size:26px;
    }

    .stats-icon{

        width:58px;
        height:58px;

        border-radius:18px;

        font-size:24px;
    }

    .chart-header h4{
        font-size:18px;
    }

    .table thead{
        display:none;
    }

    .table,
    .table tbody,
    .table tr,
    .table td{
        display:block;
        width:100%;
    }

    .table tr{

        margin-bottom:14px;

        border-radius:18px;

        overflow:hidden;

        background:#fff;

        box-shadow:
            0 6px 18px rgba(0,0,0,0.05);
    }

    .table td{

        border:none !important;

        position:relative;

        padding-left:45%;
    }

    .table td::before{

        content:attr(data-label);

        position:absolute;

        left:18px;

        top:18px;

        font-weight:700;

        color:#0f172a;
    }
}

@media(max-width:576px){

    .main-content{
        padding-left:12px !important;
        padding-right:12px !important;
    }

    .stats-card{
        padding:18px;
    }

    .stats-title{
        font-size:14px;
    }

    .stats-number{
        font-size:24px;
    }

    .chart-body{
        padding:15px;
    }
}

</style>

 <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <!-- =========================
     DASHBOARD TOP
========================= -->

<div class="dashboard-top">

    <div class="dashboard-title">

        <h2>
            Dashboard Overview
        </h2>

        <p>
            Real-time analytics & emergency monitoring system
        </p>

    </div>

</div>

<!-- =========================
     STATS CARDS
========================= -->

<div class="row">

    <!-- USERS -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">

        <div class="card premium-card">

            <div class="stats-card">

                <div class="stats-icon icon-blue">
                    👥
                </div>

                <div class="stats-title">
                    Total Users
                </div>

                <div class="stats-number">
                    {{ $users }}
                </div>

                <div class="stats-bottom">

                    <span class="stats-badge">
                        Active Members
                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- HELPERS -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">

        <div class="card premium-card">

            <div class="stats-card">

                <div class="stats-icon icon-green">
                    🤝
                </div>

                <div class="stats-title">
                    Total Helpers
                </div>

                <div class="stats-number">
                    {{ $total_helpers }}
                </div>

                <div class="stats-bottom">

                    <span class="stats-badge">
                        Support Team
                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- POLICE -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">

        <div class="card premium-card">

            <div class="stats-card">

                <div class="stats-icon icon-orange">
                    👮
                </div>

                <div class="stats-title">
                    Total Police
                </div>

                <div class="stats-number">
                    {{ $TotalPolices }}
                </div>

                <div class="stats-bottom">

                    <span class="stats-badge">
                        Security Staff
                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- ACTIVE -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">

        <div class="card premium-card">

            <div class="stats-card">

                <div class="stats-icon icon-red">
                    🚨
                </div>

                <div class="stats-title">
                    Active Emergency
                </div>

                <div class="stats-number text-danger">
                    {{ $active_emergency_signals ?? '0' }}
                </div>

                <div class="stats-bottom">

                    <span class="stats-badge">
                        Live Alerts
                    </span>

                </div>

            </div>

        </div>

    </div>

    <!-- RESOLVED -->
    <div class="col-xl-3 col-lg-6 col-md-6 mb-4">

        <div class="card premium-card">

            <div class="stats-card">

                <div class="stats-icon icon-purple">
                    ✅
                </div>

                <div class="stats-title">
                    Resolved Signals
                </div>

                <div class="stats-number text-success">
                    {{ $resolved_emergency_signals ?? '0' }}
                </div>

                <div class="stats-bottom">

                    <span class="stats-badge">
                        Completed Cases
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>
          
            
          <!-- =========================
     PREMIUM CHART CARD
========================= -->

<div class="row">

    <div class="col-12 mb-4">

        <div class="card chart-card">

            <div class="chart-header">

                <div>

                    <h4>
                        Emergency Analytics
                    </h4>

                    <div class="chart-sub">
                        Monitor all emergency activities in real-time
                    </div>

                </div>

                <a href="#"
                   class="btn btn-premium">

                    View Reports

                </a>

            </div>

            <div class="chart-body">

                <div id="chart1"></div>

            </div>

        </div>

    </div>

</div> 
            
         
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h4>Assign Task Table</h4>
                  <div class="card-header-form">
                    <form>
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-btn">
                          <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th class="text-center">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                              class="custom-control-input" id="checkbox-all">
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                        </th>
                        <th>Task Name</th>
                        <th>Members</th>
                        <th>Task Status</th>
                        <th>Assigh Date</th>
                        <th>Due Date</th>
                        <th>Priority</th>
                        <th>Action</th>
                      </tr>
                      <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-1">
                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        <td>Create a mobile app</td>
                        <td class="text-truncate">
                          <ul class="list-unstyled order-list m-b-0 m-b-0">
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Wildan Ahdian"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="John Deo"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Sarah Smith"></li>
                            <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                          </ul>
                        </td>
                        <td class="align-middle">
                          <div class="progress-text">50%</div>
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-success" data-width="50%"></div>
                          </div>
                        </td>
                        <td>2018-01-20</td>
                        <td>2019-05-28</td>
                        <td>
                          <div class="badge badge-success">Low</div>
                        </td>
                        <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                      </tr>
                      <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-2">
                            <label for="checkbox-2" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        <td>Redesign homepage</td>
                        <td class="text-truncate">
                          <ul class="list-unstyled order-list m-b-0 m-b-0">
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-1.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Wildan Ahdian"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-2.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="John Deo"></li>
                            <li class="avatar avatar-sm"><span class="badge badge-primary">+2</span></li>
                          </ul>
                        </td>
                        <td class="align-middle">
                          <div class="progress-text">40%</div>
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-danger" data-width="40%"></div>
                          </div>
                        </td>
                        <td>2017-07-14</td>
                        <td>2018-07-21</td>
                        <td>
                          <div class="badge badge-danger">High</div>
                        </td>
                        <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                      </tr>
                      <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-3">
                            <label for="checkbox-3" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        <td>Backup database</td>
                        <td class="text-truncate">
                          <ul class="list-unstyled order-list m-b-0 m-b-0">
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-3.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Wildan Ahdian"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-4.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="John Deo"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-5.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Sarah Smith"></li>
                            <li class="avatar avatar-sm"><span class="badge badge-primary">+3</span></li>
                          </ul>
                        </td>
                        <td class="align-middle">
                          <div class="progress-text">55%</div>
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-purple" data-width="55%"></div>
                          </div>
                        </td>
                        <td>2019-07-25</td>
                        <td>2019-08-17</td>
                        <td>
                          <div class="badge badge-info">Average</div>
                        </td>
                        <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                      </tr>
                      <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-4">
                            <label for="checkbox-4" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        <td>Android App</td>
                        <td class="text-truncate">
                          <ul class="list-unstyled order-list m-b-0 m-b-0">
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-7.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="John Deo"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Sarah Smith"></li>
                            <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                          </ul>
                        </td>
                        <td class="align-middle">
                          <div class="progress-text">70%</div>
                          <div class="progress" data-height="6">
                            <div class="progress-bar" data-width="70%"></div>
                          </div>
                        </td>
                        <td>2018-04-15</td>
                        <td>2019-07-19</td>
                        <td>
                          <div class="badge badge-success">Low</div>
                        </td>
                        <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                      </tr>
                      <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-5">
                            <label for="checkbox-5" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        <td>Logo Design</td>
                        <td class="text-truncate">
                          <ul class="list-unstyled order-list m-b-0 m-b-0">
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Wildan Ahdian"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="John Deo"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-2.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Sarah Smith"></li>
                            <li class="avatar avatar-sm"><span class="badge badge-primary">+2</span></li>
                          </ul>
                        </td>
                        <td class="align-middle">
                          <div class="progress-text">45%</div>
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-cyan" data-width="45%"></div>
                          </div>
                        </td>
                        <td>2017-02-24</td>
                        <td>2018-09-06</td>
                        <td>
                          <div class="badge badge-danger">High</div>
                        </td>
                        <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                      </tr>
                      <tr>
                        <td class="p-0 text-center">
                          <div class="custom-checkbox custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                              id="checkbox-6">
                            <label for="checkbox-6" class="custom-control-label">&nbsp;</label>
                          </div>
                        </td>
                        <td>Ecommerce website</td>
                        <td class="text-truncate">
                          <ul class="list-unstyled order-list m-b-0 m-b-0">
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Wildan Ahdian"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="John Deo"></li>
                            <li class="team-member team-member-sm"><img class="rounded-circle"
                                src="assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                data-original-title="Sarah Smith"></li>
                            <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                          </ul>
                        </td>
                        <td class="align-middle">
                          <div class="progress-text">30%</div>
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-orange" data-width="30%"></div>
                          </div>
                        </td>
                        <td>2018-01-20</td>
                        <td>2019-05-28</td>
                        <td>
                          <div class="badge badge-info">Average</div>
                        </td>
                        <td><a href="#" class="btn btn-outline-primary">Detail</a></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </section>

        
@include('admin.includes.footer');
