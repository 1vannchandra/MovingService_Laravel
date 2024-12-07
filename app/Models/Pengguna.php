<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;

    protected $table = 'pengguna';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'nama',
        'password',
        'email',
        'no_telepon',
        'alamat'
    ];

    // Hide sensitive data such as password
    protected $hidden = [
        'password'
    ];

    // Define relationships
    public function inputPelayanans()
    {
        return $this->hasMany(InputPelayanan::class, 'pengguna_id');
    }
}
