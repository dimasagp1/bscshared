<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white dark:bg-[#121214] rounded-3xl border border-gray-200 dark:border-[#1F2026] p-8 shadow-xs text-center flex flex-col items-center transition-colors duration-200">
        <!-- Squircle Icon Box -->
        <div class="w-16 h-16 rounded-2xl bg-[#DCFCE7] dark:bg-emerald-950/60 text-[#166534] dark:text-emerald-400 border border-transparent dark:border-emerald-800/50 flex items-center justify-center text-2xl shadow-xs mb-4">
            <i class="fas fa-hammer"></i>
        </div>

        <span class="text-[10px] font-mono font-bold px-2.5 py-1 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 uppercase tracking-wider mb-2">
            {{ $frCode }}
        </span>

        <h2 class="text-xl font-extrabold text-gray-900 dark:text-white mb-2">
            {{ $menuTitle }} — Tahap Pengembangan
        </h2>

        <p class="text-sm text-gray-600 dark:text-slate-400 max-w-lg mb-6 leading-relaxed">
            {{ $menuDesc }}
        </p>

        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#166534] hover:bg-[#14532D] text-white text-xs font-bold transition-all shadow-xs">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali ke Dashboard Utama</span>
            </a>
            <a href="{{ route('department-objectives') }}" 
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 text-gray-700 dark:text-slate-300 text-xs font-semibold transition-all">
                <i class="fas fa-bullseye text-xs text-[#166534] dark:text-emerald-400"></i>
                <span>Lihat Sasaran Mutu</span>
            </a>
        </div>

        @can('view dashboard')
            <div class="mt-8 pt-4 border-t border-gray-100 dark:border-slate-800 text-center">
                <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-gray-500 dark:text-slate-400">
                    <i class="fas fa-shield-check text-green-600 dark:text-emerald-400"></i>
                    Akses pengguna terverifikasi. Modul ini terhubung secara kaskade ke SSOT Engine Herbatech Innopharma.
                </span>
            </div>
        @endcan
    </div>
</div>
