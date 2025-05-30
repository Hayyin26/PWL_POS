<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KategoriModel extends Model
{
    use HasFactory;

    protected $table = 'm_kategori';
    protected $primaryKey = 'kategori_id';


    
    protected $fillable = ['kategori_id', 'kategori_nama', 'kategori_kode'];

    public function kategori(): BelongsTo 
    {
        return $this->belongsTo(KategoriModel::class);
    }

    public function barang(): BelongsTo 
    {
        return $this->belongsTo(BarangModel::class);
    }
}

