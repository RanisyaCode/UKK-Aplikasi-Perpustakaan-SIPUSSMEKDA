<nav class="nxl-navigation">
    <div class="navbar-wrapper">
        <div class="m-header">
            <style>
                :root {
                    --side-bg: #020617;
                    --side-border: rgba(255, 255, 255, 0.08);
                    --side-item-hover: rgba(255, 255, 255, 0.05);
                    --side-text: #94a3b8;
                    --side-text-active: #ffffff;
                    --primary-emerald: #10b981;
                    --gradasi: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
                }

                [data-theme="light"] {
                    --side-bg: #ffffff;
                    --side-border: rgba(15, 23, 42, 0.08);
                    --side-item-hover: rgba(15, 23, 42, 0.05);
                    --side-text: #64748b;
                    --side-text-active: #0f172a;
                }

                .nxl-navigation {
                    background-color: var(--side-bg) !important;
                    border-right: 1px solid var(--side-border) !important;
                    transition: all 0.2s ease-in-out;
                }

                .nxl-navigation .navbar-wrapper, 
                .nxl-navigation .navbar-content,
                .nxl-navigation .m-header {
                    background-color: var(--side-bg) !important;
                }

                .nxl-navigation .m-header {
                    border-bottom: 1px solid var(--side-border) !important;
                    height: 75px;
                    display: flex;
                    align-items: center;
                    padding: 0 15px;
                }

                .b-brand {
                    display: flex !important;
                    align-items: center !important;
                    gap: 12px;
                    text-decoration: none;
                }

                .logo-title { 
                    font-weight: 800; 
                    font-size: 15px; 
                    background: var(--gradasi); 
                    background-clip: text; 
                    -webkit-background-clip: text; 
                    -webkit-text-fill-color: transparent;
                }

                .nxl-navigation .nxl-navbar .nxl-item .nxl-link {
                    color: var(--side-text) !important;
                }

                .nxl-navigation .nxl-navbar > .nxl-item.active > .nxl-link {
                    background-color: rgba(16, 185, 129, 0.12) !important;
                    color: var(--primary-emerald) !important;
                    box-shadow: inset 4px 0 0 0 var(--primary-emerald);
                }

                .nxl-navigation .nxl-navbar .nxl-submenu .nxl-item.active > .nxl-link {
                    color: var(--primary-emerald) !important;
                    background: transparent !important; 
                    font-weight: 700;
                }

                @media (max-width: 1024px) {
                    .nxl-navigation {
                        left: -280px !important;
                        visibility: hidden;
                    }
                    .nxl-mobile-menu-opened .nxl-navigation {
                        left: 0 !important;
                        visibility: visible;
                        z-index: 2000;
                    }
                    .nxl-container, .nxl-header {
                        margin-left: 0 !important;
                        width: 100% !important;
                        left: 0 !important;
                    }
                }

                .nxl-navigation .nxl-navbar .nxl-item.active > .nxl-link .nxl-micon i {
                    color: var(--primary-emerald) !important;
                }

                .nxl-navigation .nxl-navbar .nxl-submenu {
                    background-color: transparent !important;
                }
            </style>

            <a href="{{ route('dashboardadmin') }}" class="b-brand">
                <img src="{{ asset('duralux/assets/images/logo/logo open book perpus.png') }}" alt="Logo" style="height: 35px; width: auto; min-width: 35px;" />
                <div class="logo-text nxl-mtext">
                    <span class="logo-title">SIPUS SMEKDA</span>
                </div>
            </a>
        </div>
    </div>

    <div class="navbar-content">
        <ul class="nxl-navbar">
            <li class="nxl-item {{ request()->routeIs('dashboardadmin*') ? 'active' : '' }}">
                <a href="{{ route('dashboardadmin') }}" class="nxl-link">
                    <span class="nxl-micon"><i class="feather-airplay"></i></span>
                    <span class="nxl-mtext">Dashboard Overview</span>
                </a>
            </li>   

            @if (auth()->user()->role == 'Admin')
                <li class="nxl-item nxl-caption"><label>Data Master</label></li>     

                <li class="nxl-item {{ request()->routeIs('databuku*') || request()->is('admin/buku*') || request()->is('databuku*') ? 'active' : '' }}">
                    <a href="{{ route('databuku') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-book"></i></span>
                        <span class="nxl-mtext">Kelola Data Buku</span>
                    </a>
                </li>

                <li class="nxl-item {{ request()->routeIs('anggota*') || request()->is('admin/anggota*') ? 'active' : '' }}">
                    <a href="{{ route('anggota') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-users"></i></span>
                        <span class="nxl-mtext">Data Anggota</span>
                    </a>
                </li>

                <li class="nxl-item nxl-caption"><label>Operation</label></li>

                <li class="nxl-item nxl-hasmenu {{ request()->is('admin/transaksi*') ? 'active nxl-trigger' : '' }}">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-activity"></i></span>
                        <span class="nxl-mtext">Transaksi</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ (request()->routeIs('admin.transaksi.peminjaman*') || request()->routeIs('admin.transaksi.create') || request()->routeIs('admin.transaksi.edit')) ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('admin.transaksi.peminjaman') }}">Peminjaman</a>
                        </li>
                        <li class="nxl-item {{ (request()->routeIs('admin.transaksi.pengembalian*') || request()->routeIs('admin.transaksi.edit_pengembalian*')) ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('admin.transaksi.pengembalian') }}">Pengembalian</a>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nxl-item nxl-caption"><label>Siswa Area</label></li>
                <li class="nxl-item {{ request()->routeIs('katalog*') ? 'active' : '' }}">
                    <a href="{{ route('katalog') }}" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-grid"></i></span>
                        <span class="nxl-mtext">E-Katalog</span>
                    </a>
                </li>
                <li class="nxl-item nxl-hasmenu {{ request()->is('transaksi*') || request()->routeIs('pinjam*') || request()->routeIs('pengembalian.index*') ? 'active nxl-trigger' : '' }}">
                    <a href="javascript:void(0);" class="nxl-link">
                        <span class="nxl-micon"><i class="feather-refresh-cw"></i></span>
                        <span class="nxl-mtext">Transaksi Saya</span>
                        <span class="nxl-arrow"><i class="feather-chevron-right"></i></span>
                    </a>
                    <ul class="nxl-submenu">
                        <li class="nxl-item {{ request()->routeIs('pinjam*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('pinjam') }}">Ajukan Pinjam</a>
                        </li>
                        <li class="nxl-item {{ request()->routeIs('pengembalian.index*') ? 'active' : '' }}">
                            <a class="nxl-link" href="{{ route('pengembalian.index') }}">Status Buku</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</nav>