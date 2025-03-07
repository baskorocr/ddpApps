<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Q2 extends Model
{
    use HasFactory;
    protected $table = 'q2_s';
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
