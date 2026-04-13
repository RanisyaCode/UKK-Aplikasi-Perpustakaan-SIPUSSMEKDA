<!DOCTYPE html>
<html lang="id">
@include('layouts.header')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<script>
    /* Script IIFE untuk mencegah flash-of-white, prioritas data Database */
    (function() {
        const savedTheme = "@auth{{ auth()->user()->theme ?: 'dark' }}@else" + (localStorage.getItem('sipus-theme') || 'dark') + "@endauth";
        document.documentElement.setAttribute('data-theme', savedTheme);
    })();
</script>

<style>
    /* FIX FINAL: jangan override layout desktop bawaan template */
    :root {
        --dynamic-bg: #020617;
        --dynamic-card: #0f172a;
        --dynamic-text: #f1f5f9;
        --kaca-header: rgba(15, 23, 42, 0.8);
        --garis-halus: rgba(255, 255, 255, 0.08);
        --aksen-gradasi: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
    }

    [data-theme="light"] {
        --dynamic-bg: #ffffff;
        --dynamic-card: #ffffff;
        --dynamic-text: #0f172a;
        --kaca-header: rgba(255, 255, 255, 0.9);
        --garis-halus: rgba(15, 23, 42, 0.08);
    }

    * { box-sizing: border-box; }
    html, body { overflow-x: hidden; }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--dynamic-bg) !important;
        color: var(--dynamic-text) !important;
    }

    /* biarkan desktop ikut ukuran asli template */
    .nxl-navigation {
        background: var(--dynamic-card) !important;
    }

    .nxl-header {
        background: var(--kaca-header) !important;
        backdrop-filter: blur(15px) !important;
        border-bottom: 1px solid var(--garis-halus) !important;
    }

    .nxl-content,
    .nxl-container {
        background-color: var(--dynamic-bg) !important;
    }

    .nxl-content {
        overflow-x: auto;
    }

    .nxl-menu-overlay {
        display: none !important;
    }

    /* HANYA mobile yang dioverride */
    @media (max-width: 1024px) {
        .nxl-navigation {
            position: fixed !important;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 3000 !important;
            transform: translateX(-100%);
            transition: transform .3s ease;
        }

        body.nxl-mobile-menu-opened .nxl-navigation {
            transform: translateX(0);
        }
    }

    @media (max-width: 768px) {
        .nxl-content { padding: .75rem; }
    }

    @media (max-width: 576px) {
        .nxl-content { padding: .5rem; }
    }
</style>


<body>
    @include('layouts.sidebar')

    @php
        $avatarDefault = (auth()->user()->jenis_kelamin === 'Perempuan') 
                        ? 'duralux/assets/images/avatar/profilcewe.png' 
                        : 'duralux/assets/images/avatar/profilcowo.avif';

        $userProfile = \App\Models\Profile::where('user_id', auth()->id())->first();

        if ($userProfile && $userProfile->profile_photo && file_exists(public_path('storage/profile_photos/' . $userProfile->profile_photo))) {
            $finalPhoto = asset('storage/profile_photos/' . $userProfile->profile_photo) . '?v=' . time();
        } else {
            $finalPhoto = asset($avatarDefault);
        }
        
        $roleBorderClass = match(auth()->user()->role) {
            'Admin' => 'border-role-admin',
            'Siswa' => 'border-role-siswa',
            default => 'border-role-default', 
        };
    @endphp

    <header class="nxl-header">
        <div class="header-wrapper px-3">
            <div class="header-left d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                    <div class="hamburger hamburger--arrowturn">
                        <div class="hamburger-box"><div class="hamburger-inner"></div></div>
                    </div>
                </a>
                <div class="nxl-navigation-toggle">
                    <a href="javascript:void(0);" id="menu-mini-button"><i class="feather-align-left"></i></a>
                </div>
            </div>

            <div class="header-right ms-auto d-flex align-items-center gap-3">
                <div class="nxl-h-item">
                    <a href="javascript:void(0);" class="nxl-head-link me-0" id="theme-toggle">
                        <i id="theme-icon" class="bi bi-moon-stars-fill"></i>
                    </a>
                </div>

                <div class="nxl-h-item d-none d-sm-flex">
                    <a href="javascript:void(0);" class="nxl-head-link me-0" id="btn-fullscreen">
                        <i class="feather-maximize maximize"></i>
                        <i class="feather-minimize minimize" style="display:none;"></i>
                    </a>
                </div>

                <div class="dropdown nxl-h-item">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" role="button" aria-expanded="false" class="p-0 border-0 d-block" style="position: relative; z-index: 1060;">
                        <img src="{{ $finalPhoto }}" class="img-fluid user-avtar me-0 {{ $roleBorderClass }}" style="width: 38px; height: 38px; object-fit: cover; border-radius: 50%;" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end nxl-h-dropdown nxl-user-dropdown">
                        <div class="d-flex align-items-center mb-3 px-2">
                            <img src="{{ $finalPhoto }}" class="img-fluid rounded-circle me-3 {{ $roleBorderClass }}" style="width: 45px; height: 45px; object-fit: cover; padding: 2px;" />
                            <div class="d-flex flex-column align-items-start">
                                <span class="fw-bold" style="color: var(--dynamic-text); font-size: 0.95rem;">{{ auth()->user()->nama }}</span>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->role }}</small>
                            </div>
                        </div>
                        
                        <div class="dropdown-divider"></div>

                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="bi bi-person-circle"></i> 
                            <span>Profil Saya</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger w-100 border-0 bg-transparent text-start">
                                <i class="bi bi-box-arrow-right"></i> 
                                <span class="ms-1">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="nxl-container">
        <div class="nxl-content">
            <div class="page-header px-4 pt-4">
                <div class="page-header-left">
                    <h5 class="m-b-10">{{ $title1 }}</h5>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title2 }}</li>
                    </ul>
                </div>
            </div>
            @yield('content')
        </div>
        @include('layouts.footer')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const themeToggle = document.getElementById('theme-toggle');
            const htmlElement = document.documentElement;
            const themeIcon = document.getElementById('theme-icon');

            function updateThemeUI(theme) {
                if(themeIcon) {
                    themeIcon.className = ''; 
                    themeIcon.classList.add('bi'); 
                    
                    if (theme === 'light') {
                        themeIcon.classList.add('bi-sun-fill');
                        themeIcon.style.color = '#f59e0b';
                    } else {
                        themeIcon.classList.add('bi-moon-stars-fill');
                        themeIcon.style.color = '#10b981';
                    }
                }
            }

            updateThemeUI(htmlElement.getAttribute('data-theme'));

            if (themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const currentTheme = htmlElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    htmlElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('sipus-theme', newTheme);
                    updateThemeUI(newTheme);

                    if ("{{ Auth::check() }}") { 
                        fetch("{{ route('update.theme') }}", {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                            },
                            body: JSON.stringify({ theme: newTheme })
                        })
                        .then(response => response.json())
                        .catch(err => console.error('DB Error:', err));
                    }
                });
            }

            $('#btn-fullscreen').on('click', function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen();
                    $(this).find('.maximize').hide();
                    $(this).find('.minimize').show();
                } else {
                    document.exitFullscreen();
                    $(this).find('.maximize').show();
                    $(this).find('.minimize').hide();
                }
            });

            $('#mobile-collapse').on('click', function() {
                $('body').toggleClass('nxl-mobile-menu-opened');
            });

            document.querySelectorAll('.modal').forEach(modal => {
                if (modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
            });
        });
    </script>
</body>
</html>