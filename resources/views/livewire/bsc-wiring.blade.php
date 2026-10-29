<div class="space-y-5">
    
    <!-- ALERT BANNER: SIMULASI KASKADE REVENUE -->
    <div class="rounded-xl bg-[#FFFBEB] border border-[#FDE68A] p-3.5 flex flex-wrap items-center justify-between gap-3 text-xs shadow-xs text-amber-900">
        <div class="flex items-center gap-2.5">
            <i class="fas fa-triangle-exclamation text-amber-600 text-sm"></i>
            <span>
                <strong>Mode Tampilan:</strong> Simulasi Kaskade Revenue &amp; Transmisi Kausalitas 64 Sasaran Mutu Departemen. Geser slider untuk menguji pergeseran nilai.
            </span>
        </div>
        <button type="button" 
                wire:click="simulateCascade"
                class="px-3.5 py-1.5 rounded-full bg-[#166534] hover:bg-[#14532D] text-white font-bold text-xs shadow-xs transition-colors">
            Simulasikan Kaskade
        </button>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session()->has('message'))
        <div class="rounded-xl bg-green-50 border border-green-200 p-3.5 text-xs text-green-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" class="text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- SIMULATOR CONTROLS HEADER (WHITE ELEVATED CARD) -->
    <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs space-y-4">
        
        <!-- Top Row: Target Revenue Box & Interactive Slider -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            
            <!-- Target Revenue Node Box (col-span-4) -->
            <div class="md:col-span-4 p-4 rounded-2xl bg-gray-50/70 border border-gray-100 flex flex-col justify-between">
                <div>
                    <span class="text-xs font-bold text-emerald-700 block mb-0.5">Target revenue</span>
                    <h2 class="text-2xl font-extrabold text-emerald-600 font-mono tracking-tight leading-tight">
                        Rp {{ number_format($cascadeValue * 1000, 0, ',', '.') }} JT
                    </h2>
                </div>
                <span class="text-[10px] font-mono text-gray-400 mt-1 block">k 1,000 &middot; +0.0%</span>
            </div>

            <!-- Uji Kaskade Revenue Slider (col-span-8) -->
            <div class="md:col-span-8 p-4 rounded-2xl bg-green-50/40 border border-green-100 flex flex-col justify-between">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-[#166534] flex items-center gap-1.5">
                        <i class="fas fa-sliders text-[#10B981]"></i>
                        <span>Uji Kaskade Revenue:</span>
                    </span>
                    <span class="px-3 py-1 rounded-full bg-white text-[#166534] border border-green-200 font-mono font-bold text-xs shadow-xs">
                        Rp {{ number_format($cascadeValue * 1000, 0, ',', '.') }} JT
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-[10px] font-mono text-gray-400">Rp 500M</span>
                    <input type="range" 
                           wire:model.live.debounce.150ms="cascadeValue" 
                           min="50" 
                           max="150" 
                           step="1"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-[#166534]">
                    <span class="text-[10px] font-mono text-gray-400">Rp 1.500M</span>
                </div>
            </div>

        </div>

        <!-- Middle Row: 6 Perspective Category Badges -->
        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100">
            @foreach($perspectives as $p)
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border transition-all"
                     style="background-color: {{ $p['bg'] }}; border-color: {{ $p['border'] }}; color: {{ $p['color'] }};">
                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $p['color'] }};"></span>
                    <span>{{ $p['name'] }}</span>
                    <span class="text-[10px] opacity-75 font-mono ml-1">{{ $p['score'] }}</span>
                </div>
            @endforeach
        </div>

        <!-- Bottom Row: Unit Filters & Tab Switcher -->
        <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-gray-100 text-xs">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5 font-semibold text-gray-700">
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">UNIT KERJA:</span>
                    <select wire:model.live="selectedUnit" 
                            class="px-2.5 py-1 rounded-lg border border-gray-200 text-xs font-semibold text-gray-800 focus:outline-none focus:ring-1 focus:ring-green-600">
                        <option value="all">Semua unit</option>
                        @foreach($departments as $d)
                            <option value="{{ $d['code'] }}">{{ $d['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="flex items-center gap-1.5 cursor-pointer select-none">
                    <input type="checkbox" 
                           wire:model.live="hanyaBergeser"
                           class="w-4 h-4 rounded border-gray-300 text-[#166534] focus:ring-green-600">
                    <span class="text-xs text-gray-600 font-medium">hanya yang bergeser</span>
                </label>
            </div>

            <!-- Tab Switching Buttons -->
            <div class="flex items-center bg-gray-100 p-0.5 rounded-lg border border-gray-200 text-xs font-semibold">
                <button type="button" 
                        wire:click="switchTab('flow')"
                        class="px-3 py-1 rounded-md transition-all flex items-center gap-1.5 {{ $activeTab === 'flow' ? 'bg-[#DCFCE7] text-[#166534] shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <i class="fas fa-layer-group text-[11px]"></i>
                    <span>Wiring Rasio (Makro)</span>
                </button>
                <button type="button" 
                        wire:click="switchTab('cascade')"
                        class="px-3 py-1 rounded-md transition-all flex items-center gap-1.5 {{ $activeTab === 'cascade' ? 'bg-[#DCFCE7] text-[#166534] shadow-xs' : 'text-gray-600 hover:text-gray-900' }}">
                    <i class="fas fa-list-check text-[11px]"></i>
                    <span>Wiring Sasaran Mutu (64 KPI)</span>
                </button>
            </div>
        </div>

    </div>

    <!-- TAB 1: CURVED BEZIER FLOW DIAGRAM (ALUR 3 KOLOM) -->
    @if($activeTab === 'flow')
        <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs">
            <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-diagram-project text-[#10B981]"></i>
                <span>Diagram Alur Transmisi Kausalitas Makro (Target &rarr; 6 Perspektif &rarr; Departemen)</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <!-- Col 1: Target Revenue -->
                <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-center">
                    <span class="text-xs font-bold text-emerald-800 uppercase block mb-1">Target Revenue Konsolidasi</span>
                    <span class="text-2xl font-extrabold text-emerald-700 font-mono">Rp {{ number_format($cascadeValue * 1000, 0, ',', '.') }} JT</span>
                    <span class="text-xs text-gray-500 block mt-2">Sumber Kausalitas Apex Utama</span>
                </div>

                <!-- Col 2: Perspectives -->
                <div class="space-y-2">
                    @foreach($perspectives as $p)
                        <div class="p-2.5 rounded-xl border flex items-center justify-between text-xs"
                             style="background-color: {{ $p['bg'] }}; border-color: {{ $p['border'] }}; color: {{ $p['color'] }};">
                            <span class="font-bold">{{ $p['name'] }}</span>
                            <span class="font-mono font-extrabold">{{ $p['score'] }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Col 3: Departments Summary -->
                <div class="space-y-2">
                    @foreach(array_slice($filteredDepartments, 0, 6) as $d)
                        <div class="p-2.5 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-between text-xs">
                            <span class="font-semibold text-gray-800">{{ $d['name'] }}</span>
                            <span class="text-[10px] text-gray-500 font-mono">{{ $d['sasaran'] }} sasaran</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    <!-- TAB 2: INTERACTIVE CASCADE TESTING & DEPARTMENT KPI CARDS (MATCHING USER SCREENSHOT) -->
    @else
        <div class="space-y-4">
            @foreach($filteredDeptCards as $card)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="px-5 py-3.5 flex items-center justify-between text-white" 
                         style="background-color: {{ $card['header_bg'] }};">
                        <h4 class="text-sm font-bold tracking-tight">{{ $card['title'] }}</h4>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold font-mono"
                              style="background-color: {{ $card['badge_bg'] }}; color: {{ $card['badge_color'] }};">
                            {{ $card['sasaran_count'] }}
                        </span>
                    </div>

                    <!-- KPI Cascade Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <tbody class="divide-y divide-gray-100">
                                @foreach($card['kpis'] as $kpi)
                                    <tr class="hover:bg-gray-50/70 transition-colors">
                                        <!-- Left Color Bar Accent & Code -->
                                        <td class="py-3 px-4 w-28">
                                            <div class="flex items-center gap-2">
                                                <span class="w-1.5 h-6 rounded-full" style="background-color: {{ $kpi['left_accent'] }};"></span>
                                                <span class="font-mono font-bold text-xs text-gray-900">{{ $kpi['code'] }}</span>
                                            </div>
                                        </td>

                                        <!-- KPI Name -->
                                        <td class="py-3 px-4 font-semibold text-gray-800">
                                            {{ $kpi['name'] }}
                                        </td>

                                        <!-- Elasticity Badge -->
                                        <td class="py-3 px-4 text-center w-36">
                                            @if($kpi['elasticity_type'] === 'green')
                                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#DCFCE7] text-[#166534] border border-green-200">
                                                    {{ $kpi['elasticity'] }}
                                                </span>
                                            @elseif($kpi['elasticity_type'] === 'yellow')
                                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                    {{ $kpi['elasticity'] }}
                                                </span>
                                            @else
                                                <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                    {{ $kpi['elasticity'] }}
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Simulated Value / Result -->
                                        <td class="py-3 px-4 text-right font-mono font-bold text-sm w-36 text-gray-900">
                                            {{ $kpi['result'] }}
                                        </td>

                                        <!-- Trace Action -->
                                        <td class="py-3 px-4 text-right w-24">
                                            <button type="button" 
                                                    class="px-2 py-1 rounded-md border border-gray-200 text-xs font-bold text-[#166534] hover:bg-green-50 transition-colors">
                                                <i class="fas fa-bolt text-[9px] mr-1"></i>Trace
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

    <!-- BOTTOM SUMMARY CARD: RINGKASAN TRANSMISI KAUSALITAS -->
    <div class="rounded-2xl bg-white border border-gray-200 p-5 flex flex-wrap items-center justify-between gap-4 text-xs shadow-xs">
        <div>
            <h4 class="text-xs font-bold text-[#166534] uppercase tracking-wider mb-1">
                RINGKASAN TRANSMISI KAUSALITAS REVENUE
            </h4>
            <p class="text-gray-500 text-[11px]">
                64 Sasaran Mutu terkalibrasi secara matematis dengan Matriks Transmisi Kaskade &amp; Jurnal SSOT Odoo ERP.
            </p>
        </div>

        <div class="flex items-center gap-4 text-xs font-mono">
            <div>
                <span class="text-gray-400 block text-[10px]">TOTAL SASARAN:</span>
                <span class="font-bold text-gray-900">64 KPI</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px]">ELASTISITAS DOMINAN:</span>
                <span class="font-bold text-emerald-700">+1.000 ▲</span>
            </div>
            <div>
                <span class="text-gray-400 block text-[10px]">DAMPAK APEX:</span>
                <span class="font-bold text-emerald-700">+0.0% (Stabil)</span>
            </div>
        </div>
    </div>

</div>
