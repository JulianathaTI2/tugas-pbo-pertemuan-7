@extends('layouts.app')

@section('title', 'Simulasi & Verifikasi Klaim Barang (Tugas Rumah Individu)')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200 mb-2">
                <i class="fa-solid fa-house-laptop"></i> Halaman Tambahan Tugas Rumah Individu
            </div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-handshake-angle text-indigo-600"></i>
                Simulasi Klaim & Pencocokan Barang
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Penerapan <strong>Composition (has-a)</strong> dan kontrak <strong>Interface BisaDicocokkan</strong> untuk memverifikasi kecocokan barang antara laporan kehilangan dan temuan.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('laporan.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Laporan
            </a>
        </div>
    </div>

    <!-- Filter Buttons (Route dengan Parameter Opsional: /klaim/{status?}) -->
    <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider mr-1">
                <i class="fa-solid fa-filter text-slate-400 mr-1"></i> Filter Status:
            </span>
            <a href="{{ route('laporan.klaim') }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusFilter === 'semua' ? 'bg-indigo-600 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua Status
            </a>
            <a href="{{ route('laporan.klaim', 'cocok') }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusFilter === 'cocok' ? 'bg-blue-600 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Cocok
            </a>
            <a href="{{ route('laporan.klaim', 'ditolak') }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusFilter === 'ditolak' ? 'bg-red-600 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Ditolak
            </a>
            <a href="{{ route('laporan.klaim', 'selesai') }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $statusFilter === 'selesai' ? 'bg-emerald-600 text-white shadow' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Selesai (Diserahkan)
            </a>
        </div>

        <div class="text-xs text-slate-500 font-mono">
            URL Route: <span class="bg-slate-100 px-2 py-1 rounded text-slate-700">/klaim/{{ $statusFilter !== 'semua' ? $statusFilter : '{status?}' }}</span>
        </div>
    </div>

    <!-- Daftar Kartu Klaim (Looping Blade Forelse / Empty) -->
    <div class="grid grid-cols-1 gap-5">
        @forelse ($daftarKlaim as $klaim)
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">
                <!-- Klaim Header -->
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="font-mono font-bold text-base text-indigo-700">
                            {{ $klaim->getIdKlaim() }}
                        </span>
                        <span class="text-xs text-slate-400">|</span>
                        <span class="text-xs font-medium text-slate-600">
                            Klaim Transaksi Kampus
                        </span>
                    </div>

                    <!-- Badge Status Klaim (Directive if) -->
                    <div>
                        @if ($klaim->getStatusKlaim() === 'Selesai')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <i class="fa-solid fa-check-double mr-1"></i> Selesai (Barang Diserahkan)
                            </span>
                        @elseif ($klaim->getStatusKlaim() === 'Cocok')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">
                                <i class="fa-solid fa-check mr-1"></i> Cocok (Terverifikasi)
                            </span>
                        @elseif ($klaim->getStatusKlaim() === 'Ditolak')
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                <i class="fa-solid fa-xmark mr-1"></i> Ditolak (Barang Beda)
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                Diajukan
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Klaim Content: Perbandingan 2 Laporan (Composition Klaim has-a 2 Laporan) -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Sisi Laporan Kehilangan -->
                    <div class="p-4 rounded-lg bg-red-50/60 border border-red-100 space-y-2">
                        <div class="flex items-center justify-between border-b border-red-200 pb-2">
                            <span class="text-xs uppercase font-bold text-red-700">
                                <i class="fa-solid fa-user mr-1"></i> Laporan Kehilangan (has-a)
                            </span>
                            <span class="font-mono text-xs font-bold text-red-800">
                                {{ $klaim->getKehilangan()->getIdLaporan() }}
                            </span>
                        </div>
                        <div class="text-xs space-y-1 text-slate-700 pt-1">
                            <p><strong>Pelapor:</strong> {{ $klaim->getKehilangan()->getNamaPelapor() }}</p>
                            <p><strong>Barang:</strong> {{ $klaim->getKehilangan()->getBarang()->getNama() }}</p>
                            <p><strong>Ciri:</strong> {{ $klaim->getKehilangan()->getBarang()->getCiri() }}</p>
                            <p><strong>Lokasi Hilang:</strong> {{ $klaim->getKehilangan()->getLokasi() }}</p>
                            <p class="font-mono text-[11px] text-red-900 bg-red-100/80 p-1.5 rounded mt-2">
                                Kunci Pencocokan: "{{ $klaim->getKehilangan()->kunciPencocokan() }}"
                            </p>
                        </div>
                    </div>

                    <!-- Sisi Laporan Temuan -->
                    <div class="p-4 rounded-lg bg-emerald-50/60 border border-emerald-100 space-y-2">
                        <div class="flex items-center justify-between border-b border-emerald-200 pb-2">
                            <span class="text-xs uppercase font-bold text-emerald-700">
                                <i class="fa-solid fa-hand-holding-heart mr-1"></i> Laporan Temuan (has-a)
                            </span>
                            <span class="font-mono text-xs font-bold text-emerald-800">
                                {{ $klaim->getTemuan()->getIdLaporan() }}
                            </span>
                        </div>
                        <div class="text-xs space-y-1 text-slate-700 pt-1">
                            <p><strong>Penemu:</strong> {{ $klaim->getTemuan()->getNamaPenemu() }}</p>
                            <p><strong>Barang:</strong> {{ $klaim->getTemuan()->getBarang()->getNama() }}</p>
                            <p><strong>Ciri:</strong> {{ $klaim->getTemuan()->getBarang()->getCiri() }}</p>
                            <p><strong>Tempat Simpan:</strong> {{ $klaim->getTemuan()->getTempatSimpan() }}</p>
                            <p class="font-mono text-[11px] text-emerald-900 bg-emerald-100/80 p-1.5 rounded mt-2">
                                Kunci Pencocokan: "{{ $klaim->getTemuan()->kunciPencocokan() }}"
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Footer Hasil Verifikasi Interface -->
                <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div class="text-slate-600">
                        <i class="fa-solid fa-code-compare text-blue-600 mr-1"></i>
                        Evaluasi Interface <code>BisaDicocokkan::kunciPencocokan()</code>:
                        @if ($klaim->getKehilangan()->kunciPencocokan() === $klaim->getTemuan()->kunciPencocokan())
                            <span class="text-emerald-700 font-bold ml-1">KUNCI IDENTIK (MATCH)</span>
                        @else
                            <span class="text-red-700 font-bold ml-1">KUNCI TIDAK SESUAI (MISMATCH)</span>
                        @endif
                    </div>
                    <div>
                        <span class="text-slate-500">Status Objek Kehilangan:</span>
                        <strong class="font-mono text-slate-700 uppercase">{{ $klaim->getKehilangan()->getStatus() }}</strong>
                    </div>
                </div>

            </div>
        @empty
            <div class="bg-white p-12 text-center rounded-xl border border-slate-200">
                <i class="fa-solid fa-inbox text-4xl text-slate-300 mb-3"></i>
                <p class="text-base font-semibold text-slate-700">Tidak ada data klaim dengan status "{{ $statusFilter }}"</p>
                <p class="text-xs text-slate-400 mt-1">Coba gunakan tombol filter lain atau pilih Semua Status.</p>
                <a href="{{ route('laporan.klaim') }}" class="inline-block mt-4 px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold">
                    Reset Filter
                </a>
            </div>
        @endforelse
    </div>

</div>
@endsection
