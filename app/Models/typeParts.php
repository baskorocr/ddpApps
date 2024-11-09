<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeParts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'type_parts';

    protected $fillable = [
        'type',
        'idCustomer'
    ];

    public function customer()
    {
        return $this->belongsTo(customer::class, 'idCustomer');
    }
}