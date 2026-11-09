<?php

namespace App\Models;

use InvalidArgumentException;
use LogicException;

/**
 * Abstract Class Laporan
 * Blueprint / konsep dasar untuk semua jenis laporan di kampus
 */
abstract class Laporan implements BisaDicocokkan
{
    private const STATUS_VALID = ["dilaporkan", "cocok", "selesai"];

    private string $status = "dilaporkan";
    protected string $idLaporan;
    protected Barang $barang; // COMPOSITION: Laporan memiliki (has-a) Barang
    protected string $lokasi;

    public function __construct(string $idLaporan, Barang $barang, string $lokasi)
    {
        if (trim($idLaporan) === "" || trim($lokasi) === "") {
            throw new InvalidArgumentException("ID laporan dan lokasi tidak boleh kosong");
        }
        $this->idLaporan = trim($idLaporan);
        $this->barang    = $barang;
        $this->lokasi    = trim($lokasi);
    }

    /**
     * Wajib diwujudkan setiap subclass (Abstraction)
     */
    abstract public function deskripsi(): string;

    /**
     * Label tipe laporan
     */
    abstract public function getJenis(): string;

    /**
     * Method yang dapat di-override oleh subclass
     */
    public function masaBerlaku(): int
    {
        return 30; // 30 hari standar
    }

    /**
     * Ringkasan informasi laporan untuk tampilan
     */
    public function ringkas(): string
    {
        return sprintf(
            "[%s] %s | Ciri: %s | Berlaku: %d hari | Status: %s",
            $this->idLaporan,
            $this->deskripsi(),
            $this->barang->getCiri(),
            $this->masaBerlaku(),
            $this->status
        );
    }

    public function getIdLaporan(): string
    {
        return $this->idLaporan;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getLokasi(): string
    {
        return $this->lokasi;
    }

    public function getBarang(): Barang
    {
        return $this->barang;
    }

    /**
     * Delegasi kontrak BisaDicocokkan ke objek Barang
     */
    public function kunciPencocokan(): string
    {
        return $this->barang->kunciPencocokan();
    }

    /**
     * Mengubah status secara berurutan: dilaporkan -> cocok -> selesai
     */
    public function ubahStatus(string $statusBaru): void
    {
        $urutLama = array_search($this->status, self::STATUS_VALID, true);
        $urutBaru = array_search($statusBaru, self::STATUS_VALID, true);

        if ($urutBaru === false || $urutBaru !== $urutLama + 1) {
            throw new LogicException(
                "Status '{$this->status}' tidak bisa menjadi '{$statusBaru}'"
            );
        }

        $this->status = $statusBaru;
    }
}
