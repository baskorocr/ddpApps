<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\typeParts;
use App\Models\Colors;



class Parts extends Model
{
    use HasFactory;
    protected $table = 'parts';


    public $timestamps = false;
    protected $fillable = [
        'item',
        'idType'

    ];



    public function typePart()
    {
        return $this->belongsTo(typeParts::class, 'idType');
    }


}