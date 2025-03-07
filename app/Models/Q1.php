<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Q1 extends Model
{
    use HasFactory;
    protected $table = 'q1_s';
    protected $fillable = [
        'idPart',
        'idColor',
        'typeDefact',
        'role',
        'idShift',
        "idLine",
        'idNPK',
        'role',
         'created_at',
        'updated_at',

    ];
}
