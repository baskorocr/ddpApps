<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class line extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'lines';
    protected $fillable = [
        'nameLine'
    ];
}