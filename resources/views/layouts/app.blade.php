<!DOCTYPE html>
<html lang="id" 
      x-data="{ 
          sidebarCollapsed: false, 
          darkTheme: localStorage.getItem('bsc_dark_mode') === 'true' || (!('bsc_dark_mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches), 
          logoutModalOpen: false,
          toggleDark() {
              this.darkTheme = !this.darkTheme;
              localStorage.setItem('bsc_dark_mode', this.darkTheme);
              if (this.darkTheme) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }" 
      :class="{ 'dark': darkTheme }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">
    <title>{{ $pageTitle ?? ($title ?? 'Super Apps BSC') }} - PT Herbatech Innopharma</title>

    <!-- Dark Mode FOUC Prevention Script -->
    <script>
        if (localStorage.getItem('bsc_dark_mode') === 'true' || (!('bsc_dark_mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

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
<body class="bg-[#F8FAFC] dark:bg-[#0B1120] text-slate-800 dark:text-slate-100 antialiased min-h-screen flex selection:bg-green-100 selection:text-green-900 transition-colors duration-200">

    <!-- SIDEBAR KIRI (13 MENU UTAMA DOKUMENTASI DESIGN & LOGIC) -->
    <aside :class="sidebarCollapsed ? 'w-20' : 'w-64'" 
           class="fixed inset-y-0 left-0 bg-white dark:bg-[#0F172A] border-r border-gray-200 dark:border-slate-800 z-30 transition-all duration-200 flex flex-col justify-between select-none">
        
        <!-- Sidebar Top Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Brand Header -->
            <div class="h-16 px-4 flex items-center gap-3 border-b border-gray-100 dark:border-slate-800/80">
                <!-- Squircle Logo Mark Herbatech -->
                <div class="w-10 h-10 shrink-0 bg-[#E8F5E9] dark:bg-emerald-950/60 rounded-xl flex items-center justify-center text-[#166534] dark:text-emerald-400 border border-transparent dark:border-emerald-800/50 shadow-xs">
                    <svg class="w-6 h-6 text-[#166534] dark:text-emerald-400" viewBox="0 0 36 36" fill="currentColor">
                        <rect x="6" y="10" width="4.5" height="16" rx="2.25" fill="currentColor"/>
                        <rect x="13.5" y="6" width="4.5" height="24" rx="2.25" fill="currentColor"/>
                        <rect x="21" y="6" width="4.5" height="24" rx="2.25" fill="currentColor"/>
                        <rect x="28.5" y="10" width="4.5" height="16" rx="2.25" fill="currentColor"/>
                    </svg>
                </div>
                <!-- Brand Title & Year Pill Badge -->
                <div x-show="!sidebarCollapsed" class="overflow-hidden transition-opacity duration-150">
                    <div class="flex items-center gap-1.5">
                        <span class="font-extrabold text-gray-900 dark:text-white text-sm tracking-tight">Super Apps</span>
                        <span class="bg-[#DCFCE7] dark:bg-emerald-900/40 text-[#166534] dark:text-emerald-300 border border-transparent dark:border-emerald-700/50 text-[10px] font-bold px-1.5 py-0.5 rounded-full">2026</span>
                    </div>
                    <p class="text-[11px] font-medium text-gray-500 dark:text-slate-400 truncate">PT Herbatech Innopharma</p>
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
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-150 {{ $isActive ? 'bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-transparent dark:border-emerald-800/60 font-semibold shadow-xs' : 'text-gray-600 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/60 hover:text-gray-900 dark:hover:text-slate-200' }}">
                        <div class="w-5 flex items-center justify-center shrink-0">
                            <i class="{{ $m['icon'] }} {{ $isActive ? 'text-[#166534] dark:text-emerald-400' : 'text-gray-400 dark:text-slate-500 group-hover:text-gray-600 dark:group-hover:text-slate-300' }}"></i>
                        </div>
                        <span x-show="!sidebarCollapsed" class="truncate">{{ $m['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Sidebar Footer Area -->
        <div class="p-3 border-t border-gray-100 dark:border-slate-800/80 flex flex-col gap-2">
            <!-- Collapse Button: < Kecilkan Menu -->
            <button type="button" 
                    @click="sidebarCollapsed = !sidebarCollapsed" 
                    class="w-full flex items-center justify-center gap-2 py-1.5 px-2 rounded-lg text-xs font-medium text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fas" :class="sidebarCollapsed ? 'fa-chevron-right' : 'fa-chevron-left'"></i>
                <span x-show="!sidebarCollapsed" class="text-[11px]">Kecilkan Menu</span>
            </button>

            <!-- User Profile Card -->
            <div class="p-2 rounded-xl bg-gray-50/80 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700/60 flex items-center justify-between">
                <div class="flex items-center gap-2.5 overflow-hidden">
                    <!-- Avatar circle 'S' -->
                    <div class="w-8 h-8 rounded-full bg-[#166534] text-white flex items-center justify-center text-xs font-bold shrink-0">
                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : 'S' }}
                    </div>
                    <!-- Name & Role -->
                    <div x-show="!sidebarCollapsed" class="overflow-hidden">
                        <p class="text-xs font-bold text-gray-900 dark:text-slate-100 truncate">
                            {{ auth()->check() ? Str::limit(auth()->user()->name, 16) : 'Super Admin BSC' }}
                        </p>
                        <span class="inline-block bg-purple-50 dark:bg-purple-950/40 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800/60 text-[9px] font-mono font-bold px-1 py-0.2 rounded">
                            SUPER_ADMIN
                        </span>
                    </div>
                </div>

                <!-- Logout Trigger Icon -->
                <button type="button" 
                        @click="logoutModalOpen = true" 
                        title="Keluar dari sesi"
                        class="text-gray-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 p-1 rounded-md transition-colors">
                    <i class="fas fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- MAIN WRAPPER KANAN (CONTENT CANVAS) -->
    <div :class="sidebarCollapsed ? 'ml-20' : 'ml-64'" class="flex-1 flex flex-col min-h-screen transition-all duration-200">
        
        <!-- TOPBAR HEADER (Piramida Pengukuran BSC + Sync + Badges) -->
        <header class="h-16 bg-white dark:bg-[#0F172A] border-b border-gray-200 dark:border-slate-800 px-6 flex items-center justify-between sticky top-0 z-20">
            <!-- Left: Dot Indicator + Title -->
            <div class="flex items-center gap-2.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#10B981] animate-pulse"></span>
                <h1 class="text-base font-bold text-gray-900 dark:text-white">
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
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FEF9C3] dark:bg-amber-950/40 text-[#854D0E] dark:text-amber-300 border border-yellow-200/80 dark:border-amber-800/50 text-xs font-semibold">
                    <i class="fas fa-bolt text-yellow-600 dark:text-amber-400 text-[11px]"></i>
                    <span>HRIS: 35 KPI</span>
                </div>

                <!-- Chip 2: Finance 9 CoA -->
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#EEF2FF] dark:bg-indigo-950/40 text-[#4338CA] dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-800/50 text-xs font-semibold">
                    <i class="fas fa-bolt text-indigo-600 dark:text-indigo-400 text-[11px]"></i>
                    <span>Finance: 9 CoA</span>
                </div>

                <!-- Chip 3: Real-Time Sync Timestamp -->
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-300 border border-gray-200 dark:border-slate-700 text-xs font-medium font-mono">
                    <i class="fas fa-arrows-rotate text-gray-400 dark:text-slate-500 text-[11px]"></i>
                    <span>Real-Time Sync: 05.52.28</span>
                </div>

                <!-- Dark Mode Toggle Button -->
                <button type="button" 
                        @click="toggleDark()" 
                        class="w-8 h-8 rounded-full border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 flex items-center justify-center text-gray-500 dark:text-amber-400 hover:text-gray-900 dark:hover:text-amber-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors shadow-xs" 
                        title="Toggle Tema Gelap/Terang">
                    <i x-show="!darkTheme" class="far fa-moon text-xs"></i>
                    <i x-show="darkTheme" x-cloak class="fas fa-sun text-xs text-amber-400"></i>
                </button>
            </div>
        </header>

        <!-- SUBBAR PERIOD FILTER & TIMELINE MONTHS (SHARED LIVEWIRE HORIZONTAL CONTROL) -->
        <livewire:periodic-monitor />

        <!-- MAIN PAGE SLOT CONTENT (DASHBOARD, OBJECTIVES, WIRING, ETC) -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>

        <!-- FOOTER WATERMARK -->
        <footer class="px-6 py-3 border-t border-gray-200 dark:border-slate-800 bg-white dark:bg-[#0F172A] text-center text-xs text-gray-400 dark:text-slate-500">
            Balanced Scorecard 2026 &copy; PT Herbatech Innopharma Industry. Single Source of Truth (SSOT).
        </footer>
    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div x-show="logoutModalOpen" 
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="logoutModalOpen = false" 
             class="bg-white dark:bg-[#0F172A] rounded-2xl max-w-sm w-full p-6 shadow-xl border border-gray-100 dark:border-slate-800 text-center animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 flex items-center justify-center mx-auto mb-3 text-lg">
                <i class="fas fa-arrow-right-from-bracket"></i>
            </div>
            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-1">Konfirmasi Logout</h3>
            <p class="text-xs text-gray-500 dark:text-slate-400 mb-5">Apakah Anda yakin ingin mengakhiri sesi kerja pada Super Apps BSC?</p>
            <div class="flex items-center justify-center gap-2">
                <button type="button" 
                        @click="logoutModalOpen = false" 
                        class="px-4 py-2 rounded-lg border border-gray-200 dark:border-slate-700 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800">
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

    @livewireScripts
</body>
</html>
