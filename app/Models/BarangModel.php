<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';


    
    protected $fillable = ['barang_id', 'barang_nama', 'barang_kode', 'kategori_id', 'harga_beli', 'harga_jual'];

    public function barang(): BelongsTo 
    {
        return $this->belongsTo(BarangModel::class);    
    }

    public function kategori(): BelongsTo 
    {
        return $this->belongsTo(KategoriModel::class);    
    }
}
