<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dept extends Model
{
    use HasFactory;

    protected $table = 'depts'; // Specify the table name if not pluralized

    protected $fillable = [
        'nama_dept',
    ];
}