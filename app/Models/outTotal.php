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
        'idShift',
        'idNPK',
        'created_at',
        'updated_at',


    ];
}