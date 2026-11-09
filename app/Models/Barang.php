<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * Class Barang
 * Komponen objek fisik barang yang dilaporkan hilang atau ditemukan
 */
class Barang implements BisaDicocokkan
{
    private string $nama;
    private string $ciri;

    public function __construct(string $nama, string $ciri)
    {
        if (trim($nama) === "") {
            throw new InvalidArgumentException("Nama barang tidak boleh kosong");
        }
        $this->nama = trim($nama);
        $this->ciri = trim($ciri);
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getCiri(): string
    {
        return $this->ciri;
    }

    /**
     * Memenuhi kontrak BisaDicocokkan
     */
    public function kunciPencocokan(): string
    {
        return strtolower($this->nama);
    }
}
