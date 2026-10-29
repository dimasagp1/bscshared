<div class="w-full max-w-[420px] mx-auto py-6" x-data="{ showPassword: false }">
    <!-- Floating White Card -->
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl shadow-slate-200/50 border border-gray-100">
        
        <!-- Logo Mark Squircle Badge -->
        <div class="w-16 h-16 bg-[#E8F5E9] rounded-2xl mx-auto flex items-center justify-center mb-4 shadow-xs">
            <!-- Herbatech 4 Vertical Pills Logo -->
            <svg class="w-9 h-9 text-[#166534]" viewBox="0 0 36 36" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <!-- 4 vertical rounded capsules forming Herbatech logo -->
                <rect x="6" y="10" width="4.5" height="16" rx="2.25" fill="#166534"/>
                <rect x="13.5" y="6" width="4.5" height="24" rx="2.25" fill="#166534"/>
                <rect x="21" y="6" width="4.5" height="24" rx="2.25" fill="#166534"/>
                <rect x="28.5" y="10" width="4.5" height="16" rx="2.25" fill="#166534"/>
            </svg>
        </div>

        <!-- Header Titles -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Super Apps</h1>
            <p class="text-sm font-medium text-gray-500 mt-1">PT Herbatech Innopharma</p>
        </div>

        <!-- Flash Status & Alerts -->
        @if(session()->has('status'))
            <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-xs text-green-800 flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-xs text-red-800 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Form -->
        <form wire:submit.prevent="login" novalidate class="space-y-4">
            <!-- Field: Email Akun -->
            <div>
                <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email Akun</label>
                <div class="relative">
                    <input type="email" 
                           id="email" 
                           wire:model="email" 
                           placeholder="Masukkan Email Terdaftar" 
                           autocomplete="email"
                           autofocus
                           class="w-full px-3.5 py-2.5 rounded-lg border border-gray-200 text-sm font-mono text-gray-900 placeholder:text-gray-400 placeholder:font-mono focus:outline-none focus:ring-2 focus:ring-[#166534]/20 focus:border-[#166534] transition-all duration-150 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                </div>
                @error('email')
                    <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Field: Password -->
            <div>
                <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" 
                           id="password" 
                           wire:model="password" 
                           placeholder="••••••••" 
                           autocomplete="current-password"
                           class="w-full px-3.5 py-2.5 pr-10 rounded-lg border border-gray-200 text-sm font-sans text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#166534]/20 focus:border-[#166534] transition-all duration-150 @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror">
                    
                    <!-- Interactive Eye Toggle -->
                    <button type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                            tabindex="-1"
                            title="Toggle tampilkan password">
                        <i class="far" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-xs text-red-600 mt-1 block font-medium">{{ $message }}</span>
                @enderror
            </div>

            <!-- Option: Ingat saya -->
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" 
                           wire:model="remember" 
                           class="w-4 h-4 rounded border-gray-300 text-[#166534] focus:ring-[#166534]/20 focus:ring-offset-0 transition-colors">
                    <span class="text-xs text-gray-600">Ingat saya</span>
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
                        <i class="fas fa-spinner fa-spin text-xs"></i>
                        <span>Memproses Autentikasi...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Subdued Footer Caption -->
        <p class="text-center text-xs text-gray-400 mt-6 tracking-normal">
            Balanced Scorecard 2026 · PT Herbatech Innopharma Industry
        </p>
    </div>
</div>
