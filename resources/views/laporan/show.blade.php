@extends('layouts.app')

@section('title', 'Detail Laporan #' . $id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Back Navigation -->
    <div>
        <a href="{{ route('laporan.index') }}" 
           class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-800 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Laporan
        </a>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-slate-900 to-blue-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <span class="text-xs font-mono uppercase tracking-wider text-blue-200">Informasi Objek Laporan</span>
                <h1 class="text-xl font-bold mt-0.5 flex items-center gap-2">
                    <i class="fa-solid fa-file-lines text-amber-400"></i>
                    Detail Laporan: {{ $id }}
                </h1>
            </div>
            <div>
                @if ($laporan instanceof \App\Models\LaporanKehilangan)
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow-sm inline-flex items-center">
                        <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Laporan Kehilangan
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white shadow-sm inline-flex items-center">
                        <i class="fa-solid fa-box-open mr-1.5"></i> Laporan Temuan
                    </span>
                @endif
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-6 space-y-6">

            <!-- Ringkasan Polimorfik (Abstract Class Method) -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg">
                <p class="text-xs uppercase font-bold text-slate-500 tracking-wider">Output Polymorphic Method ringkas():</p>
                <p class="text-sm font-mono text-slate-800 mt-1.5 bg-white p-3 rounded border border-slate-200 shadow-inner">
                    {{ $laporan->ringkas() }}
                </p>
            </div>

            <!-- Grid Detail Informasi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Informasi Barang (Composition has-a) -->
                <div class="border border-slate-200 rounded-lg p-5 bg-white shadow-sm space-y-3">
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i class="fa-solid fa-box text-blue-600"></i>
                        Data Komponen Barang (Objek Barang)
                    </h3>
                    <div class="text-sm space-y-2">
                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold">Nama Barang</span>
                            <p class="font-medium text-slate-800">{{ $laporan->getBarang()->getNama() }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold">Ciri-Ciri Fisik</span>
                            <p class="text-slate-600">{{ $laporan->getBarang()->getCiri() }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold">Kunci Pencocokan (Interface)</span>
                            <p class="font-mono text-xs bg-slate-100 inline-block px-2 py-1 rounded text-blue-700">
                                "{{ $laporan->kunciPencocokan() }}"
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pelapor / Penemu & Lokasi -->
                <div class="border border-slate-200 rounded-lg p-5 bg-white shadow-sm space-y-3">
                    <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2 border-b border-slate-100 pb-2">
                        <i class="fa-solid fa-location-dot text-red-500"></i>
                        Pihak Pelapor & Tempat Kejadian
                    </h3>
                    <div class="text-sm space-y-2">
                        @if ($laporan instanceof \App\Models\LaporanKehilangan)
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold">Nama Pelapor</span>
                                <p class="font-medium text-slate-800">{{ $laporan->getNamaPelapor() }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold">Lokasi Terakhir</span>
                                <p class="text-slate-600">{{ $laporan->getLokasi() }}</p>
                            </div>
                        @else
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold">Nama Penemu</span>
                                <p class="font-medium text-slate-800">{{ $laporan->getNamaPenemu() }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold">Lokasi Ditemukan</span>
                                <p class="text-slate-600">{{ $laporan->getLokasi() }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold">Tempat Simpan Barang</span>
                                <p class="text-emerald-700 font-medium">{{ $laporan->getTempatSimpan() }}</p>
                            </div>
                        @endif

                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold">Masa Berlaku Simpan</span>
                            <p class="font-semibold text-slate-700">
                                {{ $laporan->masaBerlaku() }} Hari
                                @if ($laporan->masaBerlaku() === 90)
                                    <span class="text-xs text-emerald-600 font-normal">(Aturan Khusus Overriding Subclass Temuan)</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Status Laporan -->
            <div class="border-t border-slate-200 pt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-slate-700">Status Laporan Saat Ini:</span>
                    @if ($laporan->getStatus() === 'dilaporkan')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                            Dilaporkan
                        </span>
                    @elseif ($laporan->getStatus() === 'cocok')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                            Cocok (Klaim Terverifikasi)
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            Selesai (Barang Diserahkan)
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('laporan.klaim') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-medium rounded-lg transition">
                        Periksa di Simulasi Klaim
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
