<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'nama_layanan',
        'deskripsi'
    ];

    // Define relationships
    public function inputPelayanans()
    {
        return $this->hasMany(InputPelayanan::class, 'layanan_id');
    }
}
