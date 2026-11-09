<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * Class LaporanKehilangan
 * Subclass dari Laporan (Inheritance is-a)
 */
class LaporanKehilangan extends Laporan
{
    private string $namaPelapor;

    public function __construct(
        string $idLaporan,
        string $namaPelapor,
        Barang $barang,
        string $lokasiTerakhir
    ) {
        parent::__construct($idLaporan, $barang, $lokasiTerakhir);
        if (mb_strlen(trim($namaPelapor)) < 3) {
            throw new InvalidArgumentException("Nama pelapor minimal 3 karakter");
        }
        $this->namaPelapor = trim($namaPelapor);
    }

    public function getNamaPelapor(): string
    {
        return $this->namaPelapor;
    }

    public function getJenis(): string
    {
        return "Kehilangan";
    }

    public function deskripsi(): string
    {
        return "KEHILANGAN: {$this->namaPelapor} melaporkan kehilangan {$this->barang->getNama()} di {$this->lokasi}";
    }
}
