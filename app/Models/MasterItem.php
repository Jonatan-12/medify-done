<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class MasterItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_items';

    protected $fillable = [
        'kode',
        'nama',
        'harga_beli',
        'laba',
        'supplier',
        'jenis',
        'foto',
    ];

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'category_master_item', 
            'master_item_id',
            'category_id'
        );
    }

    public function getHargaJualAttribute()
    {
        return $this->harga_beli + ($this->harga_beli * $this->laba / 100);
    }
}
