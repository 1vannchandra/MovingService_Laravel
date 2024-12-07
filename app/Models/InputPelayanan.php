<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputPelayanan extends Model
{
    use HasFactory;

    protected $table = 'input_pelayanan';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'pengguna_id',
        'layanan_id',
        'tanggal_permintaan',
        'status'
    ];

    // Define relationships
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }
}
