<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class endRepaint extends Model
{
    use HasFactory;


    protected $fillable = [
        'idPart',
        'idColor',
        'idItemDefact',
        'idShift',
        'keterangan_defact',
        'idNPK',
        'idLine',
        'created_at',
        'updated_at',
        'role'



    ];
}