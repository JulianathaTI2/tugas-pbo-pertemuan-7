<?php

namespace App\Models;

/**
 * Interface BisaDicocokkan
 * Kontrak kemampuan pencocokan barang (can-do relationship)
 */
interface BisaDicocokkan
{
    /**
     * Menghasilkan string kunci pencocokan
     */
    public function kunciPencocokan(): string;
}
