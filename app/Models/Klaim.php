<?php

namespace App\Models;

use LogicException;

/**
 * Class Klaim
 * Composition (has-a): Menghubungkan LaporanKehilangan dan LaporanTemuan
 */
class Klaim
{
    private string $idKlaim;
    private LaporanKehilangan $kehilangan;
    private LaporanTemuan $temuan;
    private bool $terverifikasi = false;
    private string $statusKlaim = "Diajukan"; // Diajukan, Cocok, Ditolak, Selesai

    public function __construct(
        string $idKlaim,
        LaporanKehilangan $kehilangan,
        LaporanTemuan $temuan
    ) {
        $this->idKlaim      = $idKlaim;
        $this->kehilangan   = $kehilangan;
        $this->temuan       = $temuan;
    }

    public function getIdKlaim(): string
    {
        return $this->idKlaim;
    }

    public function getKehilangan(): LaporanKehilangan
    {
        return $this->kehilangan;
    }

    public function getTemuan(): LaporanTemuan
    {
        return $this->temuan;
    }

    public function isTerverifikasi(): bool
    {
        return $this->terverifikasi;
    }

    public function getStatusKlaim(): string
    {
        return $this->statusKlaim;
    }

    /**
     * Memeriksa kesesuaian menggunakan kontrak BisaDicocokkan (Loose Coupling)
     */
    private function cocok(BisaDicocokkan $a, BisaDicocokkan $b): bool
    {
        return $a->kunciPencocokan() === $b->kunciPencocokan();
    }

    public function verifikasi(): bool
    {
        if (!$this->cocok($this->kehilangan, $this->temuan)) {
            $this->statusKlaim = "Ditolak";
            return false;
        }

        $this->kehilangan->ubahStatus("cocok");
        $this->temuan->ubahStatus("cocok");
        $this->terverifikasi = true;
        $this->statusKlaim   = "Cocok";
        return true;
    }

    public function serahkan(): void
    {
        if (!$this->terverifikasi) {
            throw new LogicException("Klaim {$this->idKlaim} belum terverifikasi");
        }

        $this->kehilangan->ubahStatus("selesai");
        $this->temuan->ubahStatus("selesai");
        $this->statusKlaim = "Selesai";
    }
}
