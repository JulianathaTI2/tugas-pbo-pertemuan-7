<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * Class LaporanTemuan
 * Subclass dari Laporan (Inheritance is-a) dengan Overriding masaBerlaku()
 */
class LaporanTemuan extends Laporan
{
    private string $namaPenemu;
    private string $tempatSimpan;

    public function __construct(
        string $idLaporan,
        string $namaPenemu,
        Barang $barang,
        string $lokasiDitemukan,
        string $tempatSimpan
    ) {
        parent::__construct($idLaporan, $barang, $lokasiDitemukan);
        if (mb_strlen(trim($namaPenemu)) < 3) {
            throw new InvalidArgumentException("Nama penemu minimal 3 karakter");
        }
        $this->namaPenemu   = trim($namaPenemu);
        $this->tempatSimpan = trim($tempatSimpan);
    }

    public function getNamaPenemu(): string
    {
        return $this->namaPenemu;
    }

    public function getTempatSimpan(): string
    {
        return $this->tempatSimpan;
    }

    public function getJenis(): string
    {
        return "Temuan";
    }

    public function deskripsi(): string
    {
        return "TEMUAN: {$this->namaPenemu} menemukan {$this->barang->getNama()} di {$this->lokasi} (Disimpan di: {$this->tempatSimpan})";
    }

    /**
     * OVERRIDING: Barang temuan disimpan 90 hari di kampus (menggantikan default 30 hari)
     */
    public function masaBerlaku(): int
    {
        return 90; // 90 hari
    }
}
