<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan - @yield('title')</title>

    @vite(['resources/css/app.css'])
</head>
<body>
    <header class="sticky top-0 z-50 border-b border-white/60 bg-white/75 shadow-sm backdrop-blur-xl">
        <div class="mx-auto flex min-h-20 max-w-7xl items-center gap-2 px-3 sm:gap-6 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" aria-label="Perpus Kampus, beranda" class="flex shrink-0 items-center gap-2">
                <span class="flex size-9 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm sm:size-10">
                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" class="size-5">
                        <path d="M4 5.75A1.75 1.75 0 0 1 5.75 4H20v14H6a2 2 0 0 0-2 2V5.75Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                        <path d="M4 18a2 2 0 0 1 2-2h14M8 8h8M8 11h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                </span>
                <span class="whitespace-nowrap text-sm font-bold tracking-tight text-slate-900 sm:text-lg">
                    Perpus <span class="text-blue-700">Kampus</span>
                </span>
            </a>

            <nav aria-label="Navigasi utama" tabindex="0" class="min-w-0 flex-1 overflow-x-auto overscroll-x-contain scroll-smooth">
                <div class="flex w-max min-w-full items-center justify-center gap-5 px-1 sm:gap-8">
                    <a href="{{ route('home') }}" @class(['group relative inline-flex shrink-0 items-center py-3 text-sm font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:text-blue-700', 'text-blue-700' => request()->routeIs('home'), 'text-slate-600 hover:text-blue-700' => ! request()->routeIs('home')]) @if(request()->routeIs('home')) aria-current="page" @endif>
                        Beranda
                        <span aria-hidden="true" class="absolute inset-x-0 bottom-1 h-0.5 origin-left scale-x-0 rounded-full bg-blue-600 transition-transform duration-300 group-hover:scale-x-100 group-focus-visible:scale-x-100"></span>
                    </a>
                    <a href="{{ route('buku.index') }}" @class(['group relative inline-flex shrink-0 items-center py-3 text-sm font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:text-blue-700', 'text-blue-700' => request()->routeIs('buku.*'), 'text-slate-600 hover:text-blue-700' => ! request()->routeIs('buku.*')]) @if(request()->routeIs('buku.*')) aria-current="page" @endif>
                        Daftar Buku
                        <span aria-hidden="true" class="absolute inset-x-0 bottom-1 h-0.5 origin-left scale-x-0 rounded-full bg-blue-600 transition-transform duration-300 group-hover:scale-x-100 group-focus-visible:scale-x-100"></span>
                    </a>
                </div>
            </nav>

            <a href="{{ route('buku.index') }}" class="inline-flex shrink-0 items-center gap-2 rounded-md bg-blue-600 px-2.5 py-2 text-xs font-semibold text-white transition-colors duration-200 hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 sm:px-4 sm:py-2.5 sm:text-sm">
                <span class="sm:hidden">Lihat Buku</span>
                <span class="hidden sm:inline">Jelajahi Buku</span>
                <svg aria-hidden="true" viewBox="0 0 20 20" fill="none" class="hidden size-4 sm:block">
                    <path d="M4.167 10h11.666M10 4.167 15.833 10 10 15.833" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 Perpustakaan Kampus. All rights reserved.</p>
    </footer>
</body>
</html>