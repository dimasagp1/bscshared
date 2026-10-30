<div class="space-y-6">

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/50 p-4 text-xs text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 text-sm"></i>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
            <button type="button" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-200" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- TOP BANNER: WIRING DIAGRAM BSC -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 shadow-xs flex flex-wrap items-center justify-between gap-4 transition-colors duration-200">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/60 flex items-center justify-center text-[#166534] dark:text-emerald-400 shadow-xs">
                <i class="fas fa-network-wired text-lg"></i>
            </div>
            <div>
                <h1 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span>Wiring Diagram Hubungan BSC</span>
                    <span class="text-xs text-gray-400 dark:text-slate-500 font-normal">&middot;</span>
                    <span class="text-xs font-semibold text-gray-600 dark:text-slate-300">35 sasaran</span>
                    <span class="text-xs text-gray-400 dark:text-slate-500 font-normal">&middot;</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $totalShiftedCount > 0 ? 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-700' : 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700' }}">
                        {{ $totalShiftedCount }} bergeser
                    </span>
                </h1>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">
                    @if($activeTab === 'macro')
                        Peta transmisi makro 3-tier: Target Revenue &mdash; Kelompok Rasio Driver &mdash; Unit Kerja Departemen
                    @else
                        Kaskade mikro: Enam rel turun dari target revenue menyadap 35 sasaran mutu HRIS per departemen
                    @endif
                </p>
            </div>
        </div>

        <!-- Mode Switcher Tabs -->
        <div class="flex items-center bg-gray-100 dark:bg-slate-800/90 p-1 rounded-2xl border border-gray-200 dark:border-slate-700/80 text-xs font-semibold">
            <button type="button" 
                    wire:click="switchTab('macro')"
                    class="px-4 py-2 rounded-xl transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'macro' ? 'bg-[#15803D] text-white shadow-xs' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200' }}">
                <i class="fas fa-diagram-project text-[11px]"></i>
                <span>Wiring Rasio (Makro)</span>
            </button>
            <button type="button" 
                    wire:click="switchTab('kpi35')"
                    class="px-4 py-2 rounded-xl transition-all duration-200 flex items-center gap-2 {{ $activeTab === 'kpi35' ? 'bg-[#15803D] text-white shadow-xs' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200' }}">
                <i class="fas fa-list-check text-[11px]"></i>
                <span>Wiring Sasaran Mutu (35 KPI)</span>
            </button>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- MODE 1: WIRING RASIO (MAKRO)                                              -->
    <!-- ========================================================================= -->
    @if($activeTab === 'macro')

        <!-- Top Simulator Row: Target Revenue Slider + 5 Driver Stepper Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3.5">
            
            <!-- Card 1: Target Revenue Box with Slider -->
            <div class="bg-white dark:bg-[#0F172A] rounded-2xl border border-emerald-200 dark:border-emerald-800/60 p-4 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[11px] font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">TARGET REVENUE</span>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-300 font-mono font-bold text-[11px]">
                        Rp {{ number_format($simulatedRevenueValue / 1000, 3, '.', '') }} jt
                    </span>
                </div>
                <div class="my-2">
                    <input type="range" 
                           wire:model.live.debounce.100ms="revenueSliderPercent" 
                           min="-50" 
                           max="50" 
                           step="1"
                           class="w-full h-1.5 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#15803D]">
                    <div class="flex items-center justify-between text-[10px] font-mono text-gray-400 dark:text-slate-500 mt-1">
                        <span>-50%</span>
                        <span class="font-bold text-[#15803D] dark:text-emerald-400">k {{ $kRevenueFormatted }}</span>
                        <span>+50%</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Profitabilitas Stepper -->
            <div class="bg-white dark:bg-[#0F172A] rounded-2xl border border-[#10B981]/50 dark:border-[#10B981]/40 p-4 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white block">Profitabilitas</span>
                    <span class="text-[10px] font-mono text-gray-400 dark:text-slate-400">
                        k {{ $drivers['profitabilitas']['k_formatted'] }} &middot; e 0,78
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 bg-gray-50 dark:bg-slate-800/80 rounded-xl p-1 border border-gray-100 dark:border-slate-700/60">
                    <button type="button" 
                            wire:click="adjustDriver('profitabilitas', -1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        &minus;
                    </button>
                    <span class="font-mono font-bold text-xs text-gray-800 dark:text-slate-200">
                        {{ $stepperAdjustments['profitabilitas'] >= 0 ? '+' : '' }}{{ $stepperAdjustments['profitabilitas'] }}%
                    </span>
                    <button type="button" 
                            wire:click="adjustDriver('profitabilitas', 1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        +
                    </button>
                </div>
            </div>

            <!-- Card 3: Aktivitas Stepper -->
            <div class="bg-white dark:bg-[#0F172A] rounded-2xl border border-[#F59E0B]/50 dark:border-[#F59E0B]/40 p-4 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white block">Aktivitas</span>
                    <span class="text-[10px] font-mono text-gray-400 dark:text-slate-400">
                        k {{ $drivers['aktivitas']['k_formatted'] }} &middot; e 0,88
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 bg-gray-50 dark:bg-slate-800/80 rounded-xl p-1 border border-gray-100 dark:border-slate-700/60">
                    <button type="button" 
                            wire:click="adjustDriver('aktivitas', -1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        &minus;
                    </button>
                    <span class="font-mono font-bold text-xs text-gray-800 dark:text-slate-200">
                        {{ $stepperAdjustments['aktivitas'] >= 0 ? '+' : '' }}{{ $stepperAdjustments['aktivitas'] }}%
                    </span>
                    <button type="button" 
                            wire:click="adjustDriver('aktivitas', 1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        +
                    </button>
                </div>
            </div>

            <!-- Card 4: Produktivitas Stepper -->
            <div class="bg-white dark:bg-[#0F172A] rounded-2xl border border-[#0284C7]/50 dark:border-[#0284C7]/40 p-4 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white block">Produktivitas</span>
                    <span class="text-[10px] font-mono text-gray-400 dark:text-slate-400">
                        k {{ $drivers['produktivitas']['k_formatted'] }} &middot; e 0,93
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 bg-gray-50 dark:bg-slate-800/80 rounded-xl p-1 border border-gray-100 dark:border-slate-700/60">
                    <button type="button" 
                            wire:click="adjustDriver('produktivitas', -1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        &minus;
                    </button>
                    <span class="font-mono font-bold text-xs text-gray-800 dark:text-slate-200">
                        {{ $stepperAdjustments['produktivitas'] >= 0 ? '+' : '' }}{{ $stepperAdjustments['produktivitas'] }}%
                    </span>
                    <button type="button" 
                            wire:click="adjustDriver('produktivitas', 1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        +
                    </button>
                </div>
            </div>

            <!-- Card 5: Likuiditas Stepper -->
            <div class="bg-white dark:bg-[#0F172A] rounded-2xl border border-[#0D9488]/50 dark:border-[#0D9488]/40 p-4 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white block">Likuiditas</span>
                    <span class="text-[10px] font-mono text-gray-400 dark:text-slate-400">
                        k {{ $drivers['likuiditas']['k_formatted'] }} &middot; e 0,50
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 bg-gray-50 dark:bg-slate-800/80 rounded-xl p-1 border border-gray-100 dark:border-slate-700/60">
                    <button type="button" 
                            wire:click="adjustDriver('likuiditas', -1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        &minus;
                    </button>
                    <span class="font-mono font-bold text-xs text-gray-800 dark:text-slate-200">
                        {{ $stepperAdjustments['likuiditas'] >= 0 ? '+' : '' }}{{ $stepperAdjustments['likuiditas'] }}%
                    </span>
                    <button type="button" 
                            wire:click="adjustDriver('likuiditas', 1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        +
                    </button>
                </div>
            </div>

            <!-- Card 6: Solvabilitas Stepper -->
            <div class="bg-white dark:bg-[#0F172A] rounded-2xl border border-[#8B5CF6]/50 dark:border-[#8B5CF6]/40 p-4 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <span class="text-xs font-bold text-gray-900 dark:text-white block">Solvabilitas</span>
                    <span class="text-[10px] font-mono text-gray-400 dark:text-slate-400">
                        k {{ $drivers['solvabilitas']['k_formatted'] }} &middot; e 0,20
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 bg-gray-50 dark:bg-slate-800/80 rounded-xl p-1 border border-gray-100 dark:border-slate-700/60">
                    <button type="button" 
                            wire:click="adjustDriver('solvabilitas', -1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        &minus;
                    </button>
                    <span class="font-mono font-bold text-xs text-gray-800 dark:text-slate-200">
                        {{ $stepperAdjustments['solvabilitas'] >= 0 ? '+' : '' }}{{ $stepperAdjustments['solvabilitas'] }}%
                    </span>
                    <button type="button" 
                            wire:click="adjustDriver('solvabilitas', 1)"
                            class="w-7 h-7 rounded-lg bg-white dark:bg-slate-700 border border-gray-200 dark:border-slate-600 text-gray-700 dark:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-600 flex items-center justify-center font-bold text-xs transition-colors">
                        +
                    </button>
                </div>
            </div>

        </div>

        <!-- MAIN 3-TIER BEZIER CANVAS -->
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-6 shadow-xs relative transition-colors duration-200">
            
            <div class="w-full overflow-x-auto">
                <svg viewBox="0 0 960 620" class="w-full h-auto select-none font-sans" style="min-width: 800px;">
                    <defs>
                        <!-- Drop Shadow Filter for active highlighted nodes -->
                        <filter id="nodeGlow" x="-20%" y="-20%" width="140%" height="140%">
                            <feDropShadow dx="0" dy="2" stdDeviation="4" flood-color="#10B981" flood-opacity="0.35"/>
                        </filter>
                    </defs>

                    <!-- ============================================================= -->
                    <!-- SVG BEZIER CURVES LAYER                                       -->
                    <!-- ============================================================= -->

                    @php
                        // Coordinates map
                        // Tier 1 Port (Target Revenue right center)
                        $t1_x = 175;
                        $t1_y = 300;

                        // Tier 2 Ports (6 Drivers)
                        $t2_nodes = [
                            'profitabilitas' => ['in_x' => 320, 'out_x' => 480, 'y' => 78,  'color' => '#10B981', 'stroke' => '#10B981'],
                            'revenue'        => ['in_x' => 320, 'out_x' => 480, 'y' => 168, 'color' => '#166534', 'stroke' => '#166534'],
                            'aktivitas'      => ['in_x' => 320, 'out_x' => 480, 'y' => 258, 'color' => '#F59E0B', 'stroke' => '#F59E0B'],
                            'produktivitas'  => ['in_x' => 320, 'out_x' => 480, 'y' => 348, 'color' => '#0284C7', 'stroke' => '#0284C7'],
                            'likuiditas'     => ['in_x' => 320, 'out_x' => 480, 'y' => 438, 'color' => '#0D9488', 'stroke' => '#0D9488'],
                            'solvabilitas'   => ['in_x' => 320, 'out_x' => 480, 'y' => 528, 'color' => '#8B5CF6', 'stroke' => '#8B5CF6'],
                        ];

                        // Tier 3 Ports (9 Departments)
                        $t3_nodes = [
                            'FAT' => ['in_x' => 640, 'y' => 54],
                            'GA'  => ['in_x' => 640, 'y' => 116],
                            'HC'  => ['in_x' => 640, 'y' => 178],
                            'OPS' => ['in_x' => 640, 'y' => 240],
                            'PRC' => ['in_x' => 640, 'y' => 302],
                            'PRD' => ['in_x' => 640, 'y' => 364],
                            'QLT' => ['in_x' => 640, 'y' => 426],
                            'RND' => ['in_x' => 640, 'y' => 488],
                            'SCM' => ['in_x' => 640, 'y' => 550],
                        ];
                    @endphp

                    <!-- 1. Curves: Tier 1 -> Tier 2 (Target Revenue to 6 Drivers) -->
                    @foreach($t2_nodes as $dKey => $dCoord)
                        @php
                            $dx = $dCoord['in_x'] - $t1_x;
                            $cx1 = $t1_x + ($dx * 0.5);
                            $cx2 = $dCoord['in_x'] - ($dx * 0.5);
                            $pathD = "M {$t1_x} {$t1_y} C {$cx1} {$t1_y}, {$cx2} {$dCoord['y']}, {$dCoord['in_x']} {$dCoord['y']}";

                            // Highlighting condition
                            $isActive = (
                                $selectedNode === null || 
                                $selectedNode === 'target_revenue' || 
                                $selectedNode === $dKey ||
                                (isset($departments[$selectedNode]) && in_array($dKey, $departments[$selectedNode]['drivers']))
                            );
                            $strokeOpacity = $isActive ? 0.95 : 0.08;
                            $strokeWidth = $isActive ? (2.2 + min(2.5, abs($drivers[$dKey]['k'] - 1.0) * 8)) : 1.2;
                        @endphp
                        <path d="{{ $pathD }}" 
                              fill="none" 
                              stroke="{{ $dCoord['stroke'] }}" 
                              stroke-width="{{ $strokeWidth }}" 
                              stroke-opacity="{{ $strokeOpacity }}"
                              class="transition-all duration-300 pointer-events-none" />
                    @endforeach

                    <!-- 2. Curves: Tier 2 -> Tier 3 (Drivers to 9 Departments) -->
                    @foreach($departments as $deptCode => $dept)
                        @foreach($dept['drivers'] as $pDriver)
                            @if(isset($t2_nodes[$pDriver]) && isset($t3_nodes[$deptCode]))
                                @php
                                    $pCoord = $t2_nodes[$pDriver];
                                    $deptCoord = $t3_nodes[$deptCode];
                                    $dx2 = $deptCoord['in_x'] - $pCoord['out_x'];
                                    $cx1_2 = $pCoord['out_x'] + ($dx2 * 0.5);
                                    $cx2_2 = $deptCoord['in_x'] - ($dx2 * 0.5);
                                    $pathD2 = "M {$pCoord['out_x']} {$pCoord['y']} C {$cx1_2} {$pCoord['y']}, {$cx2_2} {$deptCoord['y']}, {$deptCoord['in_x']} {$deptCoord['y']}";

                                    // Highlighting condition
                                    $isLineActive = (
                                        $selectedNode === null ||
                                        $selectedNode === 'target_revenue' ||
                                        $selectedNode === $pDriver ||
                                        $selectedNode === $deptCode
                                    );
                                    $lineOpacity = $isLineActive ? 0.85 : 0.07;
                                    $lineWidth = $isLineActive ? 2.0 : 1.0;
                                @endphp
                                <path d="{{ $pathD2 }}" 
                                      fill="none" 
                                      stroke="{{ $pCoord['stroke'] }}" 
                                      stroke-width="{{ $lineWidth }}" 
                                      stroke-opacity="{{ $lineOpacity }}"
                                      class="transition-all duration-300 pointer-events-none" />
                            @endif
                        @endforeach
                    @endforeach

                    <!-- ============================================================= -->
                    <!-- SVG NODES LAYER                                               -->
                    <!-- ============================================================= -->

                    <!-- TIER 1: TARGET REVENUE NODE -->
                    @php
                        $isT1Active = ($selectedNode === null || $selectedNode === 'target_revenue');
                        $t1Opacity = $isT1Active ? 1.0 : 0.45;
                    @endphp
                    <g wire:click="selectNode('target_revenue')" 
                       class="cursor-pointer transition-all duration-200" 
                       opacity="{{ $t1Opacity }}">
                        <rect x="35" y="248" width="140" height="104" rx="16" 
                              fill="#F0FDF4" 
                              stroke="#10B981" 
                              stroke-width="{{ $selectedNode === 'target_revenue' ? '3' : '1.8' }}"
                              filter="{{ $selectedNode === 'target_revenue' ? 'url(#nodeGlow)' : 'none' }}" />
                        <text x="50" y="274" fill="#047857" font-size="11" font-weight="700">Target revenue</text>
                        <text x="50" y="308" fill="#065F46" font-size="24" font-weight="800" font-family="monospace">
                            {{ number_format($simulatedRevenueValue / 1000, 3, '.', '') }}
                        </text>
                        <text x="50" y="334" fill="#6B7280" font-size="10" font-family="monospace">
                            k {{ $kRevenueFormatted }} &middot; {{ $deltaRPercent >= 0 ? '+' : '' }}{{ $deltaRPercent }}%
                        </text>
                    </g>

                    <!-- TIER 2: 6 DRIVER NODES -->
                    @php
                        $driverOffsets = [
                            'profitabilitas' => 45,
                            'revenue'        => 135,
                            'aktivitas'      => 225,
                            'produktivitas'  => 315,
                            'likuiditas'     => 405,
                            'solvabilitas'   => 495,
                        ];
                    @endphp

                    @foreach($driverOffsets as $dKey => $yOffset)
                        @php
                            $dInfo = $drivers[$dKey];
                            $isDActive = (
                                $selectedNode === null || 
                                $selectedNode === 'target_revenue' || 
                                $selectedNode === $dKey ||
                                (isset($departments[$selectedNode]) && in_array($dKey, $departments[$selectedNode]['drivers']))
                            );
                            $dOpacity = $isDActive ? 1.0 : 0.35;
                            $isSelected = ($selectedNode === $dKey);
                        @endphp
                        <g wire:click="selectNode('{{ $dKey }}')" 
                           class="cursor-pointer transition-all duration-200" 
                           opacity="{{ $dOpacity }}">
                            <!-- Node Outer Pill -->
                            <rect x="320" y="{{ $yOffset }}" width="160" height="66" rx="14" 
                                  fill="{{ $dInfo['bg'] }}" 
                                  stroke="{{ $dInfo['color'] }}" 
                                  stroke-width="{{ $isSelected ? '2.8' : '1.5' }}"
                                  filter="{{ $isSelected ? 'url(#nodeGlow)' : 'none' }}" />
                            
                            <!-- Node Title -->
                            <text x="336" y="{{ $yOffset + 24 }}" fill="#111827" font-size="13" font-weight="700">
                                {{ $dInfo['name'] }}
                            </text>
                            
                            <!-- Subtitle: e and units -->
                            <text x="336" y="{{ $yOffset + 48 }}" fill="#4B5563" font-size="10" font-mono>
                                e {{ number_format($dInfo['elasticity'], 2, ',', '.') }} &middot; {{ $dInfo['connected_units_count'] }} unit
                            </text>
                            
                            <!-- Right multiplier value (1,000) -->
                            <text x="464" y="{{ $yOffset + 38 }}" fill="#111827" font-size="13" font-weight="800" font-family="monospace" text-anchor="end">
                                {{ $dInfo['k_formatted'] }}
                            </text>
                        </g>
                    @endforeach

                    <!-- TIER 3: 9 DEPARTMENT NODES -->
                    @php
                        $deptOffsets = [
                            'FAT' => 30,
                            'GA'  => 92,
                            'HC'  => 154,
                            'OPS' => 216,
                            'PRC' => 278,
                            'PRD' => 340,
                            'QLT' => 402,
                            'RND' => 464,
                            'SCM' => 526,
                        ];
                    @endphp

                    @foreach($deptOffsets as $deptCode => $deptY)
                        @php
                            $deptData = $departments[$deptCode];
                            $isDeptActive = (
                                $selectedNode === null || 
                                $selectedNode === 'target_revenue' || 
                                $selectedNode === $deptCode ||
                                (isset($drivers[$selectedNode]) && in_array($deptCode, $drivers[$selectedNode]['connected_depts']))
                            );
                            $deptOpacity = $isDeptActive ? 1.0 : 0.35;
                            $isDeptSelected = ($selectedNode === $deptCode);
                        @endphp
                        <g wire:click="selectNode('{{ $deptCode }}')" 
                           class="cursor-pointer transition-all duration-200" 
                           opacity="{{ $deptOpacity }}">
                            <!-- Box Rect -->
                            <rect x="640" y="{{ $deptY }}" width="285" height="48" rx="12" 
                                  fill="#FFFFFF" 
                                  stroke="{{ $isDeptSelected ? '#10B981' : '#E5E7EB' }}" 
                                  stroke-width="{{ $isDeptSelected ? '2.5' : '1.2' }}"
                                  filter="{{ $isDeptSelected ? 'url(#nodeGlow)' : 'none' }}" />
                            
                            <!-- Department Name -->
                            <text x="656" y="{{ $deptY + 20 }}" fill="#111827" font-size="12" font-weight="700">
                                {{ $deptData['name'] }}
                            </text>
                            
                            <!-- Subtitle: Sasaran & Bergeser status -->
                            <text x="656" y="{{ $deptY + 36 }}" fill="{{ $deptData['shifted_sasaran'] > 0 ? '#D97706' : '#6B7280' }}" font-size="10">
                                {{ $deptData['total_sasaran'] }} sasaran &middot; {{ $deptData['shifted_sasaran'] }} bergeser
                            </text>
                            
                            <!-- Connected driver color dots on right side -->
                            @php
                                $dotStartX = 905;
                            @endphp
                            @foreach(array_reverse($deptData['dots']) as $dotIndex => $dotColor)
                                <circle cx="{{ $dotStartX - ($dotIndex * 12) }}" cy="{{ $deptY + 24 }}" r="4" fill="{{ $dotColor }}" />
                            @endforeach
                        </g>
                    @endforeach

                </svg>
            </div>

            <!-- Canvas Footnote / Legend -->
            <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-800 text-center">
                <span class="text-[11px] text-gray-400 dark:text-slate-500">
                    Tebal kabel kiri ~ seberapa jauh faktor simpul bergeser dari 1,000 &middot; tebal kabel kanan ~ jumlah sasaran pada sambungan
                </span>
            </div>

        </div>

        <!-- BOTTOM TWO CARDS: TARGET YANG BERGESER & SIMPUL YANG DISOROT -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Left Card (col-span-8): TARGET YANG BERGESER -->
            <div class="lg:col-span-8 bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-6 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm">🎯</span>
                            <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                                TARGET YANG BERGESER
                            </h3>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold font-mono {{ $totalShiftedCount > 0 ? 'bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300' : 'bg-gray-100 dark:bg-slate-800 text-gray-600 dark:text-slate-400' }}">
                            {{ $totalShiftedCount }} sasaran terdampak
                        </span>
                    </div>

                    @if($totalShiftedCount === 0)
                        <div class="py-12 px-6 rounded-2xl bg-gray-50/70 dark:bg-slate-800/40 border border-dashed border-gray-200 dark:border-slate-700/60 text-center text-xs text-gray-400 dark:text-slate-500">
                            Tidak ada target yang bergeser pada kondisi saat ini. Geser target revenue atau salah satu kelompok rasio.
                        </div>
                    @else
                        <div class="space-y-2 max-h-72 overflow-y-auto pr-1">
                            @foreach($shiftedKpisList as $sKpi)
                                <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/80 flex items-center justify-between text-xs gap-3">
                                    <div class="flex items-center gap-2.5">
                                        <span class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 font-mono font-bold text-[10px]">
                                            {{ $sKpi['code'] }}
                                        </span>
                                        <span class="font-medium text-gray-800 dark:text-slate-200">
                                            {{ $sKpi['name'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3 font-mono">
                                        <span class="text-gray-400 dark:text-slate-500 line-through">
                                            {{ $sKpi['baseline_target'] }}{{ $sKpi['unit'] }}
                                        </span>
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400">
                                            {{ $sKpi['sim_target'] }}{{ $sKpi['unit'] }}
                                        </span>
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $sKpi['delta_kpi_pct'] >= 0 ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300' : 'bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-300' }}">
                                            {{ $sKpi['delta_kpi_pct'] >= 0 ? '+' : '' }}{{ $sKpi['delta_kpi_pct'] }}%
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                @if($totalShiftedCount > 0)
                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-800 flex items-center justify-between text-xs">
                        <span class="text-gray-500 dark:text-slate-400">Transmisi kaskade aktif terhitung secara real-time.</span>
                        <button type="button" 
                                wire:click="resetSimulation" 
                                class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline">
                            Reset Simulasi
                        </button>
                    </div>
                @endif
            </div>

            <!-- Right Card (col-span-4): SIMPUL YANG DISOROT -->
            <div class="lg:col-span-4 bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-6 shadow-xs flex flex-col justify-between transition-colors duration-200">
                <div>
                    <h3 class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-4">
                        SIMPUL YANG DISOROT
                    </h3>

                    @if(!$selectedNodeDetail)
                        <div class="py-12 px-6 rounded-2xl bg-gray-50/70 dark:bg-slate-800/40 border border-dashed border-gray-200 dark:border-slate-700/60 text-center text-xs">
                            <span class="font-bold text-gray-700 dark:text-slate-300 block mb-1">Belum ada yang disorot</span>
                            <span class="text-gray-400 dark:text-slate-500 leading-relaxed block">
                                Klik salah satu simpul di tengah untuk melihat unit kerja mana yang digerakkannya, atau klik unit kerja di kanan untuk melihat simpul mana yang menggerakkannya.
                            </span>
                        </div>
                    @else
                        <div class="space-y-4 text-xs">
                            <div class="p-4 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-800/50">
                                <span class="text-[10px] font-bold text-emerald-800 dark:text-emerald-300 uppercase tracking-wider block mb-1">
                                    {{ $selectedNodeDetail['subtitle'] }}
                                </span>
                                <h4 class="text-base font-bold text-gray-900 dark:text-white">
                                    {{ $selectedNodeDetail['title'] }}
                                </h4>
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-xs font-mono">
                                <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700/60">
                                    <span class="text-[10px] text-gray-400 dark:text-slate-500 block">NILAI PENGALI (k):</span>
                                    <span class="font-extrabold text-sm text-gray-900 dark:text-slate-100">
                                        {{ $selectedNodeDetail['k_val'] }}
                                    </span>
                                </div>
                                <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700/60">
                                    <span class="text-[10px] text-gray-400 dark:text-slate-500 block">ELASTISITAS (e):</span>
                                    <span class="font-extrabold text-sm text-emerald-600 dark:text-emerald-400">
                                        {{ $selectedNodeDetail['elasticity'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-3 rounded-xl bg-gray-50 dark:bg-slate-800/60 border border-gray-100 dark:border-slate-700/60 text-xs text-gray-600 dark:text-slate-300 leading-relaxed">
                                {{ $selectedNodeDetail['description'] }}
                            </div>

                            @if(isset($selectedNodeDetail['connected_units_names']))
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider block mb-1.5">
                                        UNIT KERJA TERHUBUNG ({{ count($selectedNodeDetail['connected_units_names']) }}):
                                    </span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($selectedNodeDetail['connected_units_names'] as $uName)
                                            <span class="px-2 py-0.5 rounded-md bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 text-[10px] font-semibold">
                                                {{ $uName }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if(isset($selectedNodeDetail['feeding_drivers']))
                                <div>
                                    <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider block mb-1.5">
                                        DRIVER PENGGERAK:
                                    </span>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($selectedNodeDetail['feeding_drivers'] as $fDriver)
                                            <span class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 text-[10px] font-bold">
                                                {{ $fDriver }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if($selectedNodeDetail)
                    <div class="mt-4 pt-3 border-t border-gray-100 dark:border-slate-800">
                        <button type="button" 
                                wire:click="resetHighlight" 
                                class="w-full py-2 rounded-xl border border-gray-200 dark:border-slate-700 text-xs font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                            Reset Sorotan
                        </button>
                    </div>
                @endif
            </div>

        </div>

    <!-- ========================================================================= -->
    <!-- MODE 2: WIRING SASARAN MUTU (35 KPI CIRCUIT BUS RAIL)                     -->
    <!-- ========================================================================= -->
    @else

        <!-- Top Simulator Sub-Bar: 6 Bus Indicators & Right Filters -->
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-5 shadow-xs space-y-4 transition-colors duration-200">
            
            <div class="flex flex-wrap items-center justify-between gap-4">
                <!-- 6 Driver Bus Indicators with colored dots -->
                <div class="flex flex-wrap items-center gap-3 text-xs font-semibold">
                    <span class="inline-flex items-center gap-1.5 text-gray-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>
                        <span>Profitabilitas</span>
                        <span class="font-mono text-gray-400 dark:text-slate-500 text-[11px]">{{ $drivers['profitabilitas']['k_formatted'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#166534]"></span>
                        <span>Revenue</span>
                        <span class="font-mono text-gray-400 dark:text-slate-500 text-[11px]">{{ $drivers['revenue']['k_formatted'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#F59E0B]"></span>
                        <span>Aktivitas</span>
                        <span class="font-mono text-gray-400 dark:text-slate-500 text-[11px]">{{ $drivers['aktivitas']['k_formatted'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#0284C7]"></span>
                        <span>Produktivitas</span>
                        <span class="font-mono text-gray-400 dark:text-slate-500 text-[11px]">{{ $drivers['produktivitas']['k_formatted'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#0D9488]"></span>
                        <span>Likuiditas</span>
                        <span class="font-mono text-gray-400 dark:text-slate-500 text-[11px]">{{ $drivers['likuiditas']['k_formatted'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#8B5CF6]"></span>
                        <span>Solvabilitas</span>
                        <span class="font-mono text-gray-400 dark:text-slate-500 text-[11px]">{{ $drivers['solvabilitas']['k_formatted'] }}</span>
                    </span>
                </div>

                <!-- Right Filters: Unit Kerja & Checkbox -->
                <div class="flex items-center gap-3.5 text-xs">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] uppercase font-bold text-gray-400 dark:text-slate-500">UNIT KERJA:</span>
                        <select wire:model.live="selectedUnit" 
                                class="px-3 py-1.5 rounded-xl border border-gray-200 dark:border-slate-700 text-xs font-semibold text-gray-800 dark:text-slate-200 bg-white dark:bg-slate-800 focus:outline-none focus:ring-1 focus:ring-emerald-600">
                            <option value="all">Semua unit</option>
                            @foreach($departments as $d)
                                <option value="{{ $d['code'] }}">{{ $d['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" 
                               wire:model.live="hanyaBergeser"
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-[#166534] focus:ring-emerald-600">
                        <span class="text-xs text-gray-600 dark:text-slate-300 font-medium">hanya yang bergeser</span>
                    </label>
                </div>
            </div>

            <!-- Simulator Slider Row (Matching Image 5) -->
            <div class="pt-3 border-t border-gray-100 dark:border-slate-800 grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                
                <!-- Target Revenue Node Box (md:col-span-4) -->
                <div class="md:col-span-4 p-3.5 rounded-2xl bg-emerald-50/60 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/60 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-emerald-700 dark:text-emerald-400 block mb-0.5">Target revenue</span>
                        <span class="text-[10px] font-mono text-gray-500 dark:text-slate-400 block">
                            k {{ $kRevenueFormatted }} &middot; {{ $deltaRPercent >= 0 ? '+' : '' }}{{ $deltaRPercent }}%
                        </span>
                    </div>
                    <span class="text-base font-extrabold text-emerald-600 dark:text-emerald-300 font-mono tracking-tight">
                        Rp {{ number_format($simulatedRevenueValue, 0, ',', '.') }} JT
                    </span>
                </div>

                <!-- Uji Kaskade Revenue Slider (md:col-span-8) -->
                <div class="md:col-span-8 p-3.5 rounded-2xl bg-gray-50 dark:bg-slate-800/60 border border-gray-200 dark:border-slate-700/60 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs font-bold text-gray-700 dark:text-slate-300 flex items-center gap-1.5">
                            <i class="fas fa-sliders text-[#10B981]"></i>
                            <span>Uji Kaskade Revenue:</span>
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full bg-white dark:bg-slate-700 text-[#166534] dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 font-mono font-bold text-xs shadow-xs">
                            Rp {{ number_format($simulatedRevenueValue, 0, ',', '.') }} JT
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-[10px] font-mono text-gray-400 dark:text-slate-500">-50%</span>
                        <input type="range" 
                               wire:model.live.debounce.100ms="revenueSliderPercent" 
                               min="-50" 
                               max="50" 
                               step="1"
                               class="w-full h-2 bg-gray-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer accent-[#15803D]">
                        <span class="text-[10px] font-mono text-gray-400 dark:text-slate-500">+50%</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- CIRCUIT BUS RAIL SCHEMATIC & 9 DEPARTMENT CARDS -->
        <div class="bg-white dark:bg-[#0F172A] rounded-3xl border border-gray-200 dark:border-slate-800 p-6 shadow-xs space-y-6 transition-colors duration-200">
            
            @php
                // Driver rail configuration for bus tracks
                $driverTracks = [
                    'profitabilitas' => ['color' => '#10B981', 'name' => 'Profitabilitas'],
                    'revenue'        => ['color' => '#166534', 'name' => 'Revenue'],
                    'aktivitas'      => ['color' => '#F59E0B', 'name' => 'Aktivitas'],
                    'produktivitas'  => ['color' => '#0284C7', 'name' => 'Produktivitas'],
                    'likuiditas'     => ['color' => '#0D9488', 'name' => 'Likuiditas'],
                    'solvabilitas'   => ['color' => '#8B5CF6', 'name' => 'Solvabilitas'],
                ];
                $trackKeys = array_keys($driverTracks);
            @endphp

            @foreach($filteredDepartments as $dept)
                <div class="rounded-2xl border border-gray-200 dark:border-slate-800 overflow-hidden shadow-xs">
                    
                    <!-- Department Header Banner -->
                    <div class="bg-gray-50/90 dark:bg-slate-800/90 px-5 py-3 border-b border-gray-200 dark:border-slate-700/80 flex items-center justify-between">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h4 class="text-xs font-bold text-gray-900 dark:text-white">
                                {{ $dept['name'] }}
                            </h4>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($dept['shifted_sasaran'] > 0)
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950/60 text-amber-800 dark:text-amber-300 text-[10px] font-bold">
                                    {{ $dept['shifted_sasaran'] }} bergeser
                                </span>
                            @endif
                            <span class="text-xs font-mono text-gray-500 dark:text-slate-400">
                                {{ $dept['total_sasaran'] }} sasaran
                            </span>
                        </div>
                    </div>

                    <!-- 35 KPI Rows with Left Bus Rail Connector -->
                    <div class="divide-y divide-gray-100 dark:divide-slate-800/80">
                        @foreach($dept['kpis'] as $kpi)
                            <div class="flex items-center hover:bg-gray-50/70 dark:hover:bg-slate-800/40 transition-colors py-2 px-3 text-xs">
                                
                                <!-- LEFT: 6 Vertical Circuit Bus Tracks & Taps (Matching Image 5) -->
                                <div class="w-32 flex-shrink-0 flex items-center justify-between pr-3 relative h-7">
                                    @php
                                        // Find which of the 6 tracks connect to this KPI
                                        $connectedTrackIndexes = [];
                                        foreach ($kpi['drivers'] as $pD) {
                                            $idx = array_search($pD, $trackKeys);
                                            if ($idx !== false) {
                                                $connectedTrackIndexes[] = $idx;
                                            }
                                        }
                                        $minTrack = count($connectedTrackIndexes) > 0 ? min($connectedTrackIndexes) : null;
                                    @endphp

                                    @foreach($trackKeys as $tIndex => $tKey)
                                        @php
                                            $tColor = $driverTracks[$tKey]['color'];
                                            $isTapped = in_array($tIndex, $connectedTrackIndexes);
                                        @endphp
                                        <div class="w-4 h-full relative flex items-center justify-center">
                                            <!-- Vertical Rail Line Segment -->
                                            <div class="w-0.5 h-full opacity-70" style="background-color: {{ $tColor }};"></div>
                                            
                                            <!-- Tapped Connection Junction Dot -->
                                            @if($isTapped)
                                                <div class="absolute w-2 h-2 rounded-full ring-2 ring-white dark:ring-slate-900 z-10" 
                                                     style="background-color: {{ $tColor }};"></div>
                                            @endif
                                        </div>
                                    @endforeach

                                    <!-- Horizontal Tap Line extending to the right card -->
                                    @if($minTrack !== null)
                                        @php
                                            $leadColor = $driverTracks[$trackKeys[$minTrack]]['color'];
                                            // Calculate left offset from minimum track
                                            $leftPercent = ($minTrack * 16.66) + 8.33;
                                        @endphp
                                        <div class="absolute h-0.5 z-0" 
                                             style="left: {{ $leftPercent }}%; right: 0; background-color: {{ $leadColor }}; opacity: 0.85;"></div>
                                    @endif
                                </div>

                                <!-- MIDDLE: KPI Code & Name -->
                                <div class="flex-1 flex flex-wrap items-center gap-2 pl-2">
                                    <span class="font-mono font-bold text-gray-900 dark:text-slate-100 text-xs w-16">
                                        {{ $kpi['code'] }}
                                    </span>
                                    <span class="font-medium text-gray-800 dark:text-slate-200 mr-2">
                                        {{ $kpi['name'] }}
                                    </span>

                                    <!-- Driver Tags -->
                                    <div class="flex items-center gap-1">
                                        @foreach($kpi['drivers'] as $dTag)
                                            @if(isset($driverTracks[$dTag]))
                                                <span class="px-1.5 py-0.2 rounded text-[9px] font-semibold text-white" 
                                                      style="background-color: {{ $driverTracks[$dTag]['color'] }};">
                                                    {{ $driverTracks[$dTag]['name'] }}
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- ELASTICITY BADGE -->
                                <div class="w-24 text-center">
                                    @if($kpi['is_locked'])
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-slate-400 border border-gray-200 dark:border-slate-700">
                                            dikunci
                                        </span>
                                    @else
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            e {{ number_format($kpi['elasticity'], 2, ',', '.') }}
                                        </span>
                                    @endif
                                </div>

                                <!-- SIMULATED TARGET VALUE -->
                                <div class="w-24 text-right font-mono font-bold text-xs text-gray-900 dark:text-slate-100">
                                    @if($kpi['is_shifted'])
                                        <span class="text-emerald-600 dark:text-emerald-400">
                                            {{ $kpi['sim_target'] }} {{ $kpi['unit'] }}
                                        </span>
                                    @else
                                        <span>
                                            {{ $kpi['baseline_target'] }} {{ $kpi['unit'] }}
                                        </span>
                                    @endif
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

        </div>

    @endif

</div>
