<div class="w-full max-w-[420px] mx-auto py-6" x-data="{ showPassword: false }">
    <!-- Floating White Card -->
    <div class="bg-white dark:bg-[#0F172A] rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/50 dark:shadow-none border border-gray-100 dark:border-slate-800 transition-colors duration-200">
        
        <!-- Logo Mark Squircle Badge -->
        <div class="w-16 h-16 bg-[#E8F5E9] dark:bg-emerald-950/60 rounded-2xl mx-auto flex items-center justify-center mb-4 shadow-xs border border-transparent dark:border-emerald-800/50">
            <!-- Herbatech 4 Vertical Pills Logo -->
            <svg class="w-9 h-9 text-[#166534] dark:text-emerald-400" viewBox="0 0 36 36" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <!-- 4 vertical rounded capsules forming Herbatech logo -->
                <rect x="6" y="10" width="4.5" height="16" rx="2.25" fill="currentColor"/>
                <rect x="13.5" y="6" width="4.5" height="24" rx="2.25" fill="currentColor"/>
                <rect x="21" y="6" width="4.5" height="24" rx="2.25" fill="currentColor"/>
                <rect x="28.5" y="10" width="4.5" height="16" rx="2.25" fill="currentColor"/>
            </svg>
        </div>

        <!-- Header Titles -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Super Apps</h1>
            <p class="text-sm font-medium text-gray-500 dark:text-slate-400 mt-1">PT Herbatech Innopharma</p>
        </div>

        <!-- Flash Status & Alerts -->
        @if(session()->has('status'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 dark:bg-emerald-950/40 border border-green-200 dark:border-emerald-800/50 text-xs text-green-800 dark:text-emerald-300 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600 dark:text-emerald-400"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-50 dark:bg-rose-950/40 border border-red-200 dark:border-rose-800/50 text-xs text-red-800 dark:text-rose-300 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-600 dark:text-rose-400"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form wire:submit.prevent="login" novalidate class="space-y-4">
            <!-- Field: Email Akun -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1.5">Email Akun</label>
                <div class="relative">
                    <input type="email" 
                           id="email" 
                           wire:model="email" 
                           placeholder="Masukkan Email Terdaftar" 
                           autocomplete="email"
                           autofocus
                           class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 dark:border-slate-700 text-sm font-mono text-gray-900 dark:text-slate-100 placeholder:text-gray-400 dark:placeholder:text-slate-500 placeholder:font-mono focus:outline-none focus:ring-2 focus:ring-[#166534]/20 focus:border-[#166534] bg-white dark:bg-slate-800 transition-all duration-150 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                </div>
                @error('email')
                    <span class="text-xs text-red-600 dark:text-rose-400 mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Field: Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 dark:text-slate-300 mb-1.5">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           wire:model="password" 
                           placeholder="••••••••" 
                           autocomplete="current-password"
                           class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 dark:border-slate-700 text-sm font-sans text-gray-900 dark:text-slate-100 placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-[#166534]/20 focus:border-[#166534] bg-white dark:bg-slate-800 transition-all duration-150 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    
                    <!-- Interactive Eye Toggle -->
                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 dark:text-slate-500 hover:text-gray-600 dark:hover:text-slate-300 focus:outline-none"
                            tabindex="-1"
                            title="Toggle tampilkan password">
                        <i class="far" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-xs text-red-600 dark:text-rose-400 mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Option: Ingat saya -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" 
                           wire:model="remember" 
                           class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-[#166534] focus:ring-[#166534]/20 focus:ring-offset-0 transition-colors">
                    <span class="text-xs text-gray-600 dark:text-slate-400">Ingat saya</span>
                </label>
            </div>

            <!-- Submit Button: Masuk ke Dashboard BSC -->
            <div class="pt-2">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full py-3 px-4 rounded-lg bg-[#166534] hover:bg-[#14532D] active:bg-[#0F3F22] text-white text-sm font-bold flex items-center justify-center gap-2 shadow-sm transition-all duration-150 cursor-pointer disabled:opacity-75 disabled:cursor-wait">
                    
                    <span wire:loading.remove class="flex items-center gap-2">
                        <i class="fas fa-arrow-right-to-bracket text-xs"></i>
                        <span>Masuk ke Dashboard BSC</span>
                    </span>

                    <span wire:loading class="flex items-center gap-2">
                        <i class="fas fa-circle-notch fa-spin text-sm"></i>
                        <span>Memproses Autentikasi...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Footer Help -->
        <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-800 text-center">
            <span class="text-xs text-gray-400 dark:text-slate-500">
                Single Source of Truth (SSOT) Hub v2.0
            </span>
        </div>
    </div>
</div>
