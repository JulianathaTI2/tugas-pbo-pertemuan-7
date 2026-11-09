<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Kehilangan & Temuan Barang') - UCIC</title>
    <!-- Tailwind CSS CDN for modern and clean styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between text-slate-800">

    <!-- Top Navigation Bar -->
    <header class="bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-900 text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center text-amber-300 font-bold text-xl border border-white/20">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <a href="{{ route('laporan.index') }}" class="font-bold text-lg tracking-wide hover:text-blue-200 transition">
                            Sistem Kehilangan & Temuan Kampus
                        </a>
                        <p class="text-xs text-blue-200">Universitas Catur Insan Cendekia &bull; TI033015 PBO</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center space-x-2">
                    <a href="{{ route('laporan.index') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('laporan.index') || request()->routeIs('laporan.show') ? 'bg-white/20 text-white shadow' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-list-check mr-1.5"></i> Daftar Laporan
                    </a>
                    <a href="{{ route('laporan.klaim') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('laporan.klaim') ? 'bg-white/20 text-white shadow' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
                        <i class="fa-solid fa-handshake-angle mr-1.5"></i> Simulasi Klaim
                    </a>
                    <div class="h-6 w-px bg-blue-700 mx-2"></div>
                    <span class="text-xs bg-amber-400 text-slate-900 font-semibold px-2.5 py-1 rounded-full">
                        Pertemuan 7
                    </span>
                </nav>
            </div>
        </div>
    </header>

    <!-- Student Info Subheader -->
    <section class="bg-white border-b border-slate-200 shadow-sm py-2.5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between text-xs text-slate-600 gap-2">
            <div class="flex items-center space-x-4">
                <span><i class="fa-solid fa-user text-blue-600 mr-1"></i> <strong>Mahasiswa:</strong> Julian Atha Maulana</span>
                <span><i class="fa-solid fa-id-card text-blue-600 mr-1"></i> <strong>NIM:</strong> 20251020052</span>
                <span><i class="fa-solid fa-book-bookmark text-blue-600 mr-1"></i> <strong>Mata Kuliah:</strong> Pemrograman Berorientasi Objek</span>
            </div>
            <div class="flex items-center space-x-2 text-slate-500">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800">
                    <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> Laravel 13 MVC + Blade
                </span>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-6 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <p class="font-semibold text-slate-300">Tugas Pertemuan 7: Routing, Controller & Blade Template Engine</p>
                <p class="text-xs text-slate-500">Pemrograman Berorientasi Objek (TI033015) &bull; Dosen Pengampu: Hilman Lesmana, S.T., M.S.F.</p>
            </div>
            <div class="text-xs text-slate-500 text-center md:text-right">
                <p>&copy; 2026 Julian Atha Maulana (20251020052)</p>
                <p>Program Studi Teknik Informatika &bull; Universitas Catur Insan Cendekia</p>
            </div>
        </div>
    </footer>

</body>
</html>
