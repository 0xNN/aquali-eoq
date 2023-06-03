<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function pembelianDetail()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    public function permintaanDetail()
    {
        return $this->hasMany(PermintaanDetail::class);
    }

    public function distribusi()
    {
        return $this->hasMany(Distribusi::class);
    }
}
