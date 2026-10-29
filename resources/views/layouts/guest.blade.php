<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#166534">
    <title>{{ $title ?? 'Login' }} - Super Apps PT Herbatech Innopharma</title>

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

    <!-- Tailwind CSS CDN with Custom Theme Configuration -->
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
        h1, h2, h3, h4 {
            font-family: 'Manrope', system-ui, sans-serif;
        }
    </style>
</head>
<body class="bg-[#F8FAFC] dark:bg-[#0B1120] flex items-center justify-center p-4 min-h-screen text-slate-800 dark:text-slate-100 antialiased selection:bg-green-100 selection:text-green-900 transition-colors duration-200">
    <main class="w-full flex items-center justify-center">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
