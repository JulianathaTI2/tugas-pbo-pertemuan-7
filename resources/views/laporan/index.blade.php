@extends('layouts.app')

@section('title', 'Daftar Laporan Kehilangan & Temuan (OOP Polymorphism)')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked text-blue-600"></i>
                Daftar Laporan Kehilangan & Temuan
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Implementasi konsep <strong>OOP Polymorphism & Abstraction</strong> dari Pertemuan 5 ke dalam Laravel MVC & Blade.
            </p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('laporan.klaim') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition">
                <i class="fa-solid fa-arrows-split-up-and-left mr-2"></i> Simulasi Klaim Barang
            </a>
        </div>
    </div>

    <!-- Statistik Ringkas (Blade Directives & OOP Data) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-slate-500">Total Semua Laporan</p>
                <p class="text-2xl font-black text-slate-800 mt-1">{{ $totalLaporan }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-xl">
                <i class="fa-solid fa-folder-open"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-red-500">Laporan Kehilangan</p>
                <p class="text-2xl font-black text-red-600 mt-1">{{ $totalKehilangan }}</p>
            </div>
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-wider font-semibold text-emerald-500">Laporan Temuan</p>
                <p class="text-2xl font-black text-emerald-600 mt-1">{{ $totalTemuan }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-xl">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Daftar Laporan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800 text-sm flex items-center gap-2">
                <i class="fa-solid fa-table-list text-slate-500"></i>
                Data Objek Laporan (Looping via Blade Foreach)
            </h2>
            <span class="text-xs text-slate-500 font-mono">Route: /laporan (laporan.index)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-100 text-slate-700 text-xs uppercase font-semibold border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3.5">ID Laporan</th>
                        <th class="px-6 py-3.5">Jenis & Sumber</th>
                        <th class="px-6 py-3.5">Nama Barang</th>
                        <th class="px-6 py-3.5">Lokasi</th>
                        <th class="px-6 py-3.5">Masa Simpan (Override)</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    {{-- Menggunakan Blade Directive @foreach --}}
                    @foreach ($daftarLaporan as $item)
                    <tr class="hover:bg-slate-50 transition">
                        <!-- ID Laporan -->
                        <td class="px-6 py-4 font-mono font-bold text-blue-700">
                            {{ $item->getIdLaporan() }}
                        </td>

                        <!-- Jenis Laporan (Directive if untuk membedakan badge) -->
                        <td class="px-6 py-4">
                            @if ($item instanceof \App\Models\LaporanKehilangan)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    <i class="fa-solid fa-circle-exclamation mr-1 text-[10px]"></i> Kehilangan
                                </span>
                                <div class="text-xs text-slate-500 mt-1">
                                    Pelapor: <strong>{{ $item->getNamaPelapor() }}</strong>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    <i class="fa-solid fa-box-open mr-1 text-[10px]"></i> Temuan
                                </span>
                                <div class="text-xs text-slate-500 mt-1">
                                    Penemu: <strong>{{ $item->getNamaPenemu() }}</strong>
                                </div>
                            @endif
                        </td>

                        <!-- Nama Barang & Ciri (Komposisi Barang) -->
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-800">{{ $item->getBarang()->getNama() }}</span>
                            <p class="text-xs text-slate-500 truncate max-w-xs">{{ $item->getBarang()->getCiri() }}</p>
                        </td>

                        <!-- Lokasi -->
                        <td class="px-6 py-4">
                            <span class="text-slate-700">{{ $item->getLokasi() }}</span>
                        </td>

                        <!-- Masa Simpan (Membuktikan Overriding masaBerlaku) -->
                        <td class="px-6 py-4 font-semibold">
                            @if ($item->masaBerlaku() > 30)
                                <span class="text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-md text-xs font-bold inline-flex items-center">
                                    <i class="fa-solid fa-shield-halved mr-1 text-[10px]"></i> {{ $item->masaBerlaku() }} Hari (Override)
                                </span>
                            @else
                                <span class="text-slate-600 bg-slate-100 px-2.5 py-1 rounded-md text-xs font-medium">
                                    {{ $item->masaBerlaku() }} Hari (Default)
                                </span>
                            @endif
                        </td>

                        <!-- Status Laporan -->
                        <td class="px-6 py-4">
                            @if ($item->getStatus() === 'dilaporkan')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    Dilaporkan
                                </span>
                            @elseif ($item->getStatus() === 'cocok')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                    Cocok
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    Selesai
                                </span>
                            @endif
                        </td>

                        <!-- Aksi: Link ke detail dengan named route & parameter -->
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('laporan.show', $item->getIdLaporan()) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-medium shadow-sm transition">
                                <i class="fa-solid fa-circle-info mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Keterangan OOP Polymorphism -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 text-sm text-blue-900 space-y-2">
        <div class="flex items-center gap-2 font-bold text-blue-800">
            <i class="fa-solid fa-circle-question"></i>
            Konsep OOP yang Bekerja pada Halaman Ini:
        </div>
        <ul class="list-disc list-inside space-y-1 text-blue-800/90 text-xs sm:text-sm pl-2">
            <li><strong>Polymorphism:</strong> Daftar di atas memuat objek <code>LaporanKehilangan</code> dan <code>LaporanTemuan</code> dalam satu perulangan tunggal (<code>$daftarLaporan</code>) tanpa merusak tipe data parent <code>Laporan</code>.</li>
            <li><strong>Method Overriding:</strong> Method <code>masaBerlaku()</code> pada <code>LaporanTemuan</code> menghasilkan <strong>90 hari</strong>, sedangkan pada <code>LaporanKehilangan</code> default <strong>30 hari</strong>.</li>
            <li><strong>Composition:</strong> Setiap objek laporan memiliki referensi objek <code>Barang</code> tersendiri melalui relasi <em>has-a</em>.</li>
        </ul>
    </div>

</div>
@endsection
