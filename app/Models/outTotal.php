<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outTotal extends Model
{
    use HasFactory;


    protected $fillable = [
     'idPart',
        'idColor',
        'idItemDefact',
        'itemDefact',
        'idShift',
        'keterangan_defact',
        "idLine",
        'idNPKQ2',


    ];
}