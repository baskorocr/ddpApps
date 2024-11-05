<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itemDefects extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'idTypeDefact',
        'item_defects'
    ];
}