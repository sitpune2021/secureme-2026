<div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <style>
        /* =========================================
   PREMIUM FOOTER
========================================= */

.premium-footer{

    position:relative;

    margin-left:280px;

    width:calc(100% - 280px);

    min-height:78px;

    background:
        rgba(255,255,255,0.88);

    backdrop-filter:blur(18px);

    border-top:
        1px solid rgba(255,255,255,0.4);

    display:flex;

    align-items:center;

    justify-content:space-between;

    padding:16px 24px;

    overflow:hidden;

    z-index:10;

    box-shadow:
        0 -5px 25px rgba(15,23,42,0.04);
}

/* TOP GLOW */

.premium-footer::before{

    content:"";

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:2px;

    background:
        linear-gradient(
            90deg,
            #0284c7,
            #38bdf8,
            #0ea5e9,
            #0284c7
        );

    background-size:300% 100%;

    animation:footerGlow 6s linear infinite;
}

/* ANIMATION */

@keyframes footerGlow{

    0%{
        background-position:0% 50%;
    }

    100%{
        background-position:100% 50%;
    }
}

/* =========================================
   LEFT
========================================= */

.footer-brand{

    display:flex;

    align-items:center;

    gap:14px;
}

/* LOGO */

.footer-logo{

    width:46px;
    height:46px;

    border-radius:14px;

    background:
        linear-gradient(135deg,#0284c7,#38bdf8);

    display:flex;

    align-items:center;

    justify-content:center;

    box-shadow:
        0 0 18px rgba(14,165,233,0.35);
}

.footer-logo img{

    width:28px;
    height:28px;

    object-fit:contain;
}

/* TEXT */

.footer-text h6{

    margin:0;

    font-size:15px;

    font-weight:700;

    color:#0f172a;
}

.footer-text span{

    font-size:12px;

    color:#64748b;
}

/* =========================================
   CENTER
========================================= */

.footer-center{

    font-size:13px;

    font-weight:500;

    color:#475569;

    text-align:center;
}

/* =========================================
   RIGHT
========================================= */

.footer-link{

    display:flex;

    align-items:center;

    gap:8px;

    padding:10px 16px;

    border-radius:14px;

    text-decoration:none !important;

    background:
        linear-gradient(135deg,#0284c7,#0ea5e9);

    color:#fff !important;

    font-size:13px;

    font-weight:600;

    transition:0.3s ease;

    box-shadow:
        0 6px 18px rgba(14,165,233,0.25);
}

.footer-link:hover{

    transform:translateY(-3px);

    box-shadow:
        0 10px 25px rgba(14,165,233,0.35);
}

/* =========================================
   TABLET
========================================= */

@media(max-width:991px){

    .premium-footer{

        margin-left:0;

        width:100%;

        flex-direction:column;

        gap:18px;

        padding:20px;
    }
}

/* =========================================
   MOBILE
========================================= */

@media(max-width:576px){

    .premium-footer{

        padding:18px 14px;
    }

    .footer-brand{

        gap:10px;
    }

    .footer-logo{

        width:40px;
        height:40px;
    }

    .footer-logo img{

        width:24px;
        height:24px;
    }

    .footer-text h6{

        font-size:14px;
    }

    .footer-text span{

        font-size:11px;
    }

    .footer-center{

        font-size:12px;
    }

    .footer-link{

        width:100%;

        justify-content:center;
    }
}
        </style>
      <footer class="main-footer premium-footer">

    <!-- LEFT -->
    <div class="footer-left">

        <div class="footer-brand">

            <div class="footer-logo">

                <img src="{{ asset('admin-assets/img/logo1.png') }}"
                     alt="Secure Me">

            </div>

            <div class="footer-text">

                <h6>
                    Secure Me
                </h6>

                <span>
                    Advanced Security Dashboard
                </span>

            </div>

        </div>

    </div>

    <!-- CENTER -->
    <div class="footer-center">

        <span>
            © 2025 S-IT Solutions PVT LTD
        </span>

    </div>

    <!-- RIGHT -->
    <div class="footer-right">

        <a href="https://sitsolutions.co.in/"
           target="_blank"
           class="footer-link">

            Visit Website

            <i class="fas fa-arrow-up-right-from-square"></i>

        </a>

    </div>

</footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="{{ asset('admin-assets/js/app.min.js') }}"></script>

  <!-- JS Libraries -->
  <script src="{{ asset('admin-assets/bundles/apexcharts/apexcharts.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('admin-assets/js/page/index.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('admin-assets/js/scripts.js') }}"></script>

  <!-- Custom JS File -->
  <script src="{{ asset('admin-assets/js/custom.js') }}"></script>

</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>