<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeDefect extends Model
{
    use HasFactory;

    protected $table = 'type_defects';
    public $timestamps = false;
    protected $fillable = [
        'type'
    ];


}