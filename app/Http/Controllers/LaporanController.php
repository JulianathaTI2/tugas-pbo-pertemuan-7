<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Laporan;
use App\Models\LaporanKehilangan;
use App\Models\LaporanTemuan;
use App\Models\Klaim;

class LaporanController extends Controller
{
    /**
     * Data mock / contoh objek OOP (karena materi database setelah UTS)
     * @return array<string, Laporan>
     */
    private function getSampleLaporan(): array
    {
        // 1. Objek Barang (Komposisi)
        $dompet = new Barang("Dompet hitam", "Kulit sintetis, terdapat Kartu Tanda Mahasiswa (KTM)");
        $botol  = new Barang("Botol minum biru", "Merek Tupperware 750ml, tutup warna putih");
        $kunci  = new Barang("Kunci Motor Honda", "Gantungan pita merah bertuliskan 'One Heart'");
        $jaket  = new Barang("Jaket Hoodie Abu-abu", "Ukuran XL, logo UCIC di bagian dada kiri");
        $payung = new Barang("Payung Lipat Hitam", "Otomatis, pegangan kayu");

        // 2. Objek Subclass Laporan (Inheritance & Polymorphism)
        $lk1 = new LaporanKehilangan("LK-001", "Budi Santoso", $dompet, "Perpustakaan Lantai 1");
        $lt1 = new LaporanTemuan("LT-001", "Rina Marlina", $dompet, "Perpustakaan Lantai 2", "Pos Satpam Gedung B");

        $lk2 = new LaporanKehilangan("LK-002", "Sari Indah", $botol, "Kantin Belakang");
        $lt2 = new LaporanTemuan("LT-002", "Dani Hermawan", $kunci, "Parkiran Motor Depan", "Pos Satpam Utama");

        $lk3 = new LaporanKehilangan("LK-003", "Maya Anggraini", $jaket, "Ruang Kuliah B.203");
        $lt3 = new LaporanTemuan("LT-003", "Tono Sutrisno", $payung, "Lobi Utama Gedung A", "Ruang Customer Service");

        return [
            "LK-001" => $lk1,
            "LT-001" => $lt1,
            "LK-002" => $lk2,
            "LT-002" => $lt2,
            "LK-003" => $lk3,
            "LT-003" => $lt3,
        ];
    }

    /**
     * Data mock transaksi Klaim (Composition & Interface BisaDicocokkan)
     * @return array<Klaim>
     */
    private function getSampleKlaim(): array
    {
        $laporanList = $this->getSampleLaporan();

        // Klaim 1: Cocok dan diserahkan (LK-001 & LT-001: Dompet hitam)
        $klaim1 = new Klaim("KL-001", $laporanList["LK-001"], $laporanList["LT-001"]);
        $klaim1->verifikasi();
        $klaim1->serahkan();

        // Klaim 2: Tidak cocok / ditolak (LK-002: Botol minum vs LT-001: Dompet)
        $klaim2 = new Klaim("KL-002", $laporanList["LK-002"], $laporanList["LT-001"]);
        $klaim2->verifikasi();

        // Klaim 3: Tidak cocok / ditolak (LK-003: Jaket vs LT-003: Payung)
        $klaim3 = new Klaim("KL-003", $laporanList["LK-003"], $laporanList["LT-003"]);
        $klaim3->verifikasi();

        return [$klaim1, $klaim2, $klaim3];
    }

    /**
     * 1. Halaman Daftar Semua Laporan (GET /laporan)
     * Target Praktikum: Menampilkan daftar laporan menggunakan @foreach dan @if
     */
    public function index()
    {
        $daftarLaporan = $this->getSampleLaporan();
        $totalKehilangan = 0;
        $totalTemuan = 0;

        foreach ($daftarLaporan as $item) {
            if ($item instanceof LaporanKehilangan) {
                $totalKehilangan++;
            } else {
                $totalTemuan++;
            }
        }

        return view('laporan.index', [
            'daftarLaporan'   => $daftarLaporan,
            'totalLaporan'    => count($daftarLaporan),
            'totalKehilangan' => $totalKehilangan,
            'totalTemuan'     => $totalTemuan,
            'judulHalaman'    => 'Daftar Laporan Kehilangan & Temuan Kampus'
        ]);
    }

    /**
     * 2. Halaman Detail Laporan dengan Parameter Wajib (GET /laporan/{id})
     * Target Praktikum: Mengambil parameter URL $id dan merender detail objek
     */
    public function show(string $id)
    {
        $daftarLaporan = $this->getSampleLaporan();

        if (!isset($daftarLaporan[$id])) {
            abort(404, "Laporan dengan ID {$id} tidak ditemukan.");
        }

        $laporan = $daftarLaporan[$id];

        return view('laporan.show', [
            'laporan'      => $laporan,
            'id'           => $id,
            'judulHalaman' => "Detail Laporan #{$id}"
        ]);
    }

    /**
     * 3. Halaman Tugas Rumah: Verifikasi Klaim & Filter Parameter Opsional (GET /klaim/{status?})
     * Target Tugas Rumah: Route parameter opsional, penggunaan Controller data, Blade @if dan @foreach
     */
    public function klaim(?string $status = null)
    {
        $semuaKlaim = $this->getSampleKlaim();
        $statusFilter = $status ? strtolower($status) : 'semua';

        if ($statusFilter !== 'semua') {
            $daftarKlaim = array_filter($semuaKlaim, function (Klaim $k) use ($statusFilter) {
                return strtolower($k->getStatusKlaim()) === $statusFilter;
            });
        } else {
            $daftarKlaim = $semuaKlaim;
        }

        return view('laporan.klaim', [
            'daftarKlaim'  => $daftarKlaim,
            'statusFilter' => $statusFilter,
            'judulHalaman' => 'Simulasi & Verifikasi Klaim Barang (Loose Coupling)'
        ]);
    }
}
