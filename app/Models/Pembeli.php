<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembeli';
    protected $primaryKey = 'id_pembeli';

    protected $fillable = [
        'nama',
        'nomor_hp',
        'alamat',
    ];

    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_pembeli');
    }
}
