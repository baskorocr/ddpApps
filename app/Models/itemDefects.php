<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\typeDefect;

class itemDefects extends Model
{
    use HasFactory;
    protected $table = 'item_defects';
    public $timestamps = false;
    protected $fillable = [
        'idTypeDefact',
        'itemDefact'
    ];

    public function typeDefact()
    {
        return $this->belongsTo(TypeDefect::class, 'idTypeDefact');
    }
}