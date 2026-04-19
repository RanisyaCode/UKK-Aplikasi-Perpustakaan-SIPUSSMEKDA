<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta name="description" content="SIPUS SMEKDA Digital Library" />
    <meta name="keyword" content="perpustakaan, smekda, digital library" />
    <meta name="author" content="flexilecode" />

    <title>SIPUS SMEKDA || {{ $title1 ?? 'Dashboard' }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('duralux/assets/images/logo/logo open book perpus.png') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/vendors/css/vendors.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/vendors/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('duralux/assets/css/theme.min.css') }}" />

    <script>
        (function() {
            const savedTheme = "@auth{{ auth()->user()->theme }}@else" + (localStorage.getItem('sipus-theme') || 'dark') + "@endauth";
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <style>
        :root {
            --bg-main: #020617;
            --bg-soft: #0f172a;
            --border-color: rgba(255, 255, 255, 0.08);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --emerald: #10b981;
        }

        [data-theme="light"] {
            --bg-main: #f8fafc;
            --bg-soft: #ffffff;
            --border-color: rgba(15, 23, 42, 0.08);
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body, .nxl-container, .nxl-content {
            background-color: var(--bg-main) !important;
            color: var(--text-main) !important;
            transition: background 0.3s ease, color 0.3s ease;
            min-height: 100vh;
        }

        .nxl-header, .nxl-header .header-wrapper {
            background-color: var(--bg-main) !important;
            border-bottom: 1px solid var(--border-color) !important;
            max-width: 100%;
        }

        .nxl-header .nxl-head-link i, 
        .nxl-header .nxl-nav-toggle i {
            color: var(--text-muted) !important;
        }

        .nxl-header .nxl-head-link:hover i {
            color: var(--emerald) !important;
        }

        .card, .nxl-header .dropdown-menu, .nxl-user-dropdown {
            background-color: var(--bg-soft) !important;
            border: 1px solid var(--border-color) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .dropdown-item {
            color: var(--text-muted) !important;
            padding: 10px 15px;
        }

        .dropdown-item:hover {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: var(--emerald) !important;
        }

        .nxl-header .nxl-search-form input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
        }

        .table-responsive {
            border: none !important;
        }
        
        .table { color: var(--text-main) !important; }
        .table thead th {
            background-color: rgba(255, 255, 255, 0.02) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            white-space: nowrap;
        }
        .table td { border-top: 1px solid var(--border-color) !important; }

        .page-header {
            background-color: var(--bg-main) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 1.5rem 1rem;
        }

        footer.footer {
            background-color: var(--bg-main) !important;
            border-top: 1px solid var(--border-color) !important;
            color: var(--text-muted) !important;
            padding: 20px;
        }

        .logo-title { 
            font-weight: 800; 
            background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%); 
            -webkit-background-clip: text;
            background-clip: text; 
            -webkit-text-fill-color: transparent; 
        }

        @media (max-width: 991.98px) {
            .nxl-header .header-wrapper {
                padding: 0 15px;
            }
            .nxl-header .nxl-search-form {
                display: none; 
            }
        }

        @media (max-width: 767.98px) {
            .page-header {
                padding: 1rem;
                flex-direction: column;
                align-items: flex-start !important;
            }
            .page-header .breadcrumb {
                margin-top: 10px;
                padding-left: 0;
            }
            .nxl-container {
                margin-left: 0 !important;
                padding: 0;
            }
            /* Menyesuaikan dropdown agar tidak keluar layar */
            .dropdown-menu-end {
                right: 0 !important;
                left: auto !important;
            }
        }

        @media (max-width: 480px) {
            .logo-title {
                font-size: 1.2rem;
            }
            .footer .footer-content {
                text-align: center;
                flex-direction: column;
            }
        }
    </style>
</head>

<body class="dark-layout">
    </body>

</html>