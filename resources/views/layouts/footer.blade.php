<style>
        .nxl-content {
        min-height: calc(100vh - 150px); 
        display: flex;
        flex-direction: column;
    }
 </style>
<footer class="footer">
    <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <div class="copyright-text">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
                <span class="ms-1">SIPUS SMEKDA</span>
            </p>
        </div>

        <div class="footer-credit d-none d-md-block">
            <p class="fs-11 text-muted mb-0">
                Built with <i class="feather-heart text-danger"></i> for Smekda Library
            </p>
        </div>

        <div class="footer-links d-flex align-items-center gap-4">
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase text-muted">Help</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase text-muted">Terms</a>
            <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase text-muted">Privacy</a>
        </div>
    </div>
</footer>

<script src="{{ asset('duralux/assets/vendors/js/vendors.min.js') }}"></script>

<script src="{{ asset('duralux/assets/vendors/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('duralux/assets/vendors/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('duralux/assets/vendors/js/circle-progress.min.js') }}"></script>

<script src="{{ asset('duralux/assets/js/common-init.min.js') }}"></script>
<script src="{{ asset('duralux/assets/js/dashboard-init.min.js') }}"></script>

<script src="{{ asset('duralux/assets/js/theme-customizer-init.min.js') }}"></script>

<script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>