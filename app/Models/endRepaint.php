<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class endRepaint extends Model
{
    use HasFactory;


    protected $fillable = [
        'idTempDefact',
        'idShift',
        'idTypeDefact',
        'itemDefact',
        'created_at',
        'updated_at'



    ];
}