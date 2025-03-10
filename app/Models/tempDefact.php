<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tempDefact extends Model
{
    use HasFactory;

    protected $table = 'temp_defacts';
    protected $fillable = [
        'idPart',
        'idColor',
        'typeDefact',
        'role',
        'idShift',
        "idLine",
        'idNPK',
        'role',
        'keterangan',
         'created_at',
        'updated_at',

    ];






    public function part()
    {
        return $this->belongsTo(Parts::class, 'idPart');
    }
    // public function line()
    // {
    //     return $this->belongsTo(line::class, 'idLine');
    // }

    public function typePart()
    {
        return $this->belongsTo(typeParts::class, 'idType', 'id');
    }
    public function color()
    {
        return $this->belongsTo(Colors::class, 'idColor');
    }

    public function type()
    {
        return $this->belongsTo(typeDefect::class, 'idTypeDefact');
    }

    public function shift()
    {
        return $this->belongsTo(shift::class, 'idShift');
    }

    public function itemDefact()
    {
        return $this->belongsTo(itemDefects::class, 'idItemDefact');
    }

}