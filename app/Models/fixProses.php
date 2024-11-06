<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fixProses extends Model
{
    use HasFactory;

    protected $fillable = [
        'idPart',
        'idColor',
        'idStatusOK',
        'idShift',
        'idNPK',
        'keterangan_OK',
        "idLine",
        'created_at',
        'updated_at',
        'role'
    ];
}