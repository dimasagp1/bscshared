<!DOCTYPE html>
<html lang="id" x-data="{ sidebarCollapsed: false, darkTheme: false, logoutModalOpen: false }" :class="{ 'dark': darkTheme }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">
    <title>{{ $pageTitle ?? ($title ?? 'Super Apps BSC') }} - PT Herbatech Innopharma</title>

    <!-- Google Fonts: Manrope, Inter, JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        forest: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Manrope', 'system-ui', 'sans-serif'],
                        mono: ['JetBrains Mono', 'ui-monospace', 'monospace'],
                    }
                }
            }
        }
    </script>

    @livewireStyles
    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Manrope', system-ui, sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 antialiased min-h-screen flex selection:bg-green-100 selection:text-green-900">

    <!-- SIDEBAR KIRI (13 MENU UTAMA DOKUMENTASI DESIGN & LOGIC) -->
    <aside :class="sidebarCollapsed ? 'w-20' : 'w-64'" 
           class="fixed inset-y-0 left-0 bg-white border-r border-gray-200 z-30 transition-all duration-200 flex flex-col justify-between select-none">
        
        <!-- Sidebar Top Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Brand Header -->
            <div class="h-16 px-4 flex items-center gap-3 border-b border-gray-100">
                <!-- Squircle Logo Mark Herbatech -->
                <div class="w-10 h-10 shrink-0 bg-[#E8F5E9] rounded-xl flex items-center justify-center text-[#166534] shadow-xs">
                    <svg class="w-6 h-6 text-[#166534]" viewBox="0 0 36 36" fill="currentColor">
                        <rect x="6" y="10" width="4.5" height="16" rx="2.25" fill="#166534"/>
                        <rect x="13.5" y="6" width="4.5" height="24" rx="2.25" fill="#166534"/>
                        <rect x="21" y="6" width="4.5" height="24" rx="2.25" fill="#166534"/>
                        <rect x="28.5" y="10" width="4.5" height="16" rx="2.25" fill="#166534"/>
                    </svg>
                </div>
                <!-- Brand Title & Year Pill Badge -->
                <div x-show="!sidebarCollapsed" class="overflow-hidden transition-opacity duration-150">
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-gray-900 text-sm tracking-tight">Super Apps</span>
                        <span class="bg-[#DCFCE7] text-[#166534] text-[10px] font-bold px-1.5 py-0.5 rounded-full">2026</span>
                    </div>
                    <p class="text-[11px] font-medium text-gray-500 truncate">PT Herbatech Innopharma</p>
                </div>
            </div>

            <!-- 13 Navigasi Menu Sesuai Spesifikasi -->
            <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-1">
                @php
                    $menuItems = [
                        [
                            'label' => 'Piramida BSC',
                            'route' => 'dashboard',
                            'icon'  => 'fas fa-cubes',
                            'active'=> 'dashboard'
                        ],
                        [
                            'label' => 'Rasio Keuangan',
                            'route' => 'financial-ratios',
                            'icon'  => 'fas fa-arrow-trend-up',
                            'active'=> 'financial-ratios'
                        ],
                        [
                            'label' => 'Objective Dept.',
                            'route' => 'department-objectives',
                            'icon'  => 'fas fa-bullseye',
                            'active'=> 'department-objectives'
                        ],
                        [
                            'label' => 'Wiring Peta',
                            'route' => 'bsc-wiring',
                            'icon'  => 'fas fa-diagram-project',
                            'active'=> 'bsc-wiring'
                        ],
                        [
                            'label' => 'Uji Dampak',
                            'route' => 'dampak',
                            'icon'  => 'fas fa-bolt',
                            'active'=> 'dampak'
                        ],
                        [
                            'label' => 'Simulasi CoA',
                            'route' => 'coa',
                            'icon'  => 'fas fa-chart-simple',
                            'active'=> 'coa'
                        ],
                        [
                            'label' => 'Action Plan',
                            'route' => 'action-plans',
                            'icon'  => 'fas fa-clipboard-list',
                            'active'=> 'action-plans'
                        ],
                        [
                            'label' => 'Konsensus IBP',
                            'route' => 'ibp',
                            'icon'  => 'fas fa-users-line',
                            'active'=> 'ibp'
                        ],
                        [
                            'label' => 'Sensitivitas',
                            'route' => 'sensitivity',
                            'icon'  => 'fas fa-wave-square',
                            'active'=> 'sensitivity'
                        ],
                        [
                            'label' => 'Skenario History',
                            'route' => 'skenario',
                            'icon'  => 'fas fa-clock-rotate-left',
                            'active'=> 'skenario'
                        ],
                        [
                            'label' => 'Dokumentasi Metode',
                            'route' => 'dokumentasi',
                            'icon'  => 'fas fa-book-open',
                            'active'=> 'dokumentasi'
                        ],
                        [
                            'label' => 'Gateway & Audit',
                            'route' => 'system-integration',
                            'icon'  => 'fas fa-shield-halved',
                            'active'=> 'system-integration'
                        ],
                        [
                            'label' => 'Super Admin & Config',
                            'route' => 'manage-users',
                            'icon'  => 'fas fa-gear',
                            'active'=> 'manage-users'
                        ],
                    ];
                @endphp

                @foreach($menuItems as $m)
                    @php
                        $isActive = request()->routeIs($m['active']);
                    @endphp
                    <a href="{{ route($m['route']) }}" 
                       title="{{ $m['label'] }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-150 {{ $isActive ? 'bg-[#DCFCE7] text-[#166534]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <div class="w-5 flex items-center justify-center shrink-0">
                            <i class="{{ $m['icon'] }} {{ $isActive ? 'text-[#166534]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                        </div>
                        <span x-show="!sidebarCollapsed" class="truncate">{{ $m['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Sidebar Footer Area -->
        <div class="p-3 border-t border-gray-100 flex flex-col gap-2">
            <!-- Collapse Button: < Kecilkan Menu -->
            <button type="button" 
                    @click="sidebarCollapsed = !sidebarCollapsed" 
                    class="w-full flex items-center justify-center gap-2 py-1.5 px-2 rounded-lg text-xs font-medium text-gray-500 hover:bg-gray-100 transition-colors">
                <i class="fas" :class="sidebarCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
                <span x-show="!sidebarCollapsed" class="text-[11px]">Kecilkan Menu</span>
            </button>

            <!-- User Profile Card -->
            <div class="p-2 rounded-xl bg-gray-50/80 border border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <!-- Avatar circle 'S' -->
                    <div class="w-8 h-8 rounded-full bg-[#166534] text-white flex items-center justify-center text-xs font-bold shrink-0">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'S' }}
                    </div>
                    <!-- Name & Role -->
                    <div x-show="!sidebarCollapsed" class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 truncate">
                            {{ auth()->check() ? Str::limit(auth()->user()->name, 16) : 'Super Admin BSC' }}
                        </p>
                        <span class="inline-block bg-purple-50 text-purple-700 border border-purple-200 text-[9px] font-mono font-bold px-1 py-0.2 rounded">
                            SUPER_ADMIN
                        </span>
                    </div>
                </div>

                <!-- Logout Trigger Icon -->
                <button type="button" 
                        @click="logoutModalOpen = true" 
                        title="Keluar dari sesi"
                        class="text-gray-400 hover:text-red-600 p-1 rounded-md transition-colors">
                    <i class="fas fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- MAIN WRAPPER KANAN (CONTENT CANVAS) -->
    <div :class="sidebarCollapsed ? 'ml-20' : 'ml-64'" class="flex-1 flex flex-col min-h-screen transition-all duration-200">
        
        <!-- TOPBAR HEADER (Piramida Pengukuran BSC + Sync + Badges) -->
        <header class="h-16 bg-white border-b border-gray-200 px-6 flex items-center justify-between sticky top-0 z-20">
            <!-- Left: Dot Indicator + Title -->
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] animate-pulse"></span>
                <h1 class="text-base font-bold text-gray-900">
                    {{ $pageTitle ?? ($title ?? 'Piramida Pengukuran BSC (Dashboard Utama)') }}
                </h1>
            </div>

            <!-- Right: Action Badges & Sync Button -->
            <div class="flex items-center gap-2.5">
                <!-- Sync Button (Solid Green Pill) -->
                <button type="button" 
                        onclick="Livewire.dispatch('triggerSync')"
                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold shadow-xs transition-colors">
                    <i class="fas fa-arrows-rotate text-[11px]"></i>
                    <span>Sync</span>
                </button>

                <!-- Chip 1: HRIS 35 KPI -->
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FEF9C3] text-[#854D0E] border border-yellow-200/80 text-xs font-semibold">
                    <i class="fas fa-bolt text-yellow-600 text-[11px]"></i>
                    <span>HRIS: 35 KPI</span>
                </div>

                <!-- Chip 2: Finance 9 CoA -->
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EEF2FF] text-[#4338CA] border border-indigo-200/80 text-xs font-semibold">
                    <i class="fas fa-bolt text-indigo-600 text-[11px]"></i>
                    <span>Finance: 9 CoA</span>
                </div>

                <!-- Chip 3: Real-Time Sync Timestamp -->
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-gray-700 border border-gray-200 text-xs font-medium font-mono">
                    <i class="fas fa-arrows-rotate text-gray-400 text-[11px]"></i>
                    <span>Real-Time Sync: 05.52.28</span>
                </div>

                <!-- Dark Mode Toggle Button -->
                <button type="button" 
                        @click="darkTheme = !darkTheme" 
                        class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-colors" 
                        title="Toggle Tema">
                    <i class="far fa-moon text-xs"></i>
                </button>
            </div>
        </header>

        <!-- SUBBAR PERIOD FILTER & TIMELINE MONTHS (SHARED HORIZONTAL CONTROL) -->
        <div class="bg-white border-b border-gray-200 px-6 py-2.5 flex flex-wrap items-center justify-between gap-3 text-xs">
            <!-- Left Controls: Periodic Monitor & Month Dropdown & Month Quick-Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <span class="flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#DCFCE7] text-[#166534] font-bold text-[11px]">
                    <i class="far fa-calendar text-[11px]"></i>
                    <span>PERIODIC MONITOR</span>
                </span>

                <!-- Dropdown Tahun -->
                <div class="px-2.5 py-1 rounded-lg border border-gray-200 font-semibold text-gray-800 flex items-center gap-1 cursor-pointer">
                    <span>Tahun: <strong>2026</strong></span>
                    <i class="fas fa-chevron-down text-[9px] text-gray-400"></i>
                </div>

                <!-- Dropdown Bulan Aktif -->
                <div class="px-2.5 py-1 rounded-lg border border-gray-200 font-semibold text-gray-800 flex items-center gap-1.5 cursor-pointer">
                    <span>Bulan: <strong>Oktober (10)</strong></span>
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <i class="fas fa-chevron-down text-[9px] text-gray-400"></i>
                </div>

                <!-- Horizontal Months Timeline Pills -->
                <div class="flex items-center gap-1 ml-1 text-gray-600 font-medium">
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Jan •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Feb •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Mar •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Apr •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Mei •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Jun •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Jul •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Agu •</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Sep •</span>
                    <span class="px-2.5 py-0.5 rounded bg-[#166534] text-white font-bold shadow-xs cursor-pointer">Okt</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Nov</span>
                    <span class="px-1.5 py-0.5 rounded cursor-pointer hover:bg-gray-100">Des</span>
                </div>
            </div>

            <!-- Right Controls: View Switcher (Per Bulan vs YTD) -->
            <div class="flex items-center gap-3">
                <div class="flex items-center bg-gray-100 p-0.5 rounded-lg border border-gray-200 text-[11px] font-semibold">
                    <button type="button" class="px-2.5 py-1 rounded-md bg-white text-gray-900 shadow-xs flex items-center gap-1.5">
                        <i class="far fa-calendar"></i>
                        <span>Per Bulan</span>
                    </button>
                    <button type="button" class="px-2.5 py-1 rounded-md text-gray-600 hover:text-gray-900 flex items-center gap-1.5">
                        <i class="fas fa-chart-line"></i>
                        <span>Akumulatif (YTD)</span>
                    </button>
                </div>

                <div class="flex items-center gap-1 text-[11px]">
                    <span class="px-2 py-1 rounded border border-gray-200 bg-gray-50 text-gray-700 font-mono">
                        <i class="far fa-clock mr-1"></i> Tahun Lalu: <strong>2025-10</strong>
                    </span>
                    <button type="button" class="px-2 py-1 rounded border border-gray-200 bg-white hover:bg-gray-50" title="Bandingkan">
                        <i class="fas fa-arrow-right-arrow-left text-[10px]"></i>
                    </button>
                    <button type="button" class="px-2.5 py-1 rounded border border-gray-200 bg-white hover:bg-gray-50 font-bold" title="Kelola Periode">
                        + Kelola
                    </button>
                </div>
            </div>
        </div>

        <!-- MAIN PAGE SLOT CONTENT (DASHBOARD, OBJECTIVES, WIRING, ETC) -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

        <!-- FOOTER WATERMARK -->
        <footer class="px-6 py-3 border-t border-gray-200 bg-white text-center text-xs text-gray-400">
            Balanced Scorecard 2026 &copy; PT Herbatech Innopharma Industry. Single Source of Truth (SSOT).
        </footer>
    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div x-show="logoutModalOpen" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-xs">
        <div @click.away="logoutModalOpen = false" 
             class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-xl border border-gray-100 text-center animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-3 text-lg">
                <i class="fas fa-arrow-right-from-bracket"></i>
            </div>
            <h3 class="text-base font-bold text-gray-900 mb-1">Konfirmasi Logout</h3>
            <p class="text-xs text-gray-500 mb-5">Apakah Anda yakin ingin mengakhiri sesi kerja pada Super Apps BSC?</p>
            <div class="flex items-center justify-center gap-2">
                <button type="button" 
                        @click="logoutModalOpen = false" 
                        class="px-4 py-2 rounded-lg border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-xs font-bold shadow-xs">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
