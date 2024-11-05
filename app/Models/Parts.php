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
        'idCustomer',
        'item'

    ];



    public function type()
    {
        return $this->belongsTo(TypeParts::class, 'idType');
    }

    public function color()
    {
        return $this->belongsTo(Colors::class, 'idColor');
    }
    public function line()
    {
        return $this->belongsTo(line::class, 'idLine');
    }

}