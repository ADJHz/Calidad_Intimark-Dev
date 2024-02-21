<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAX extends Model
{
    use HasFactory;
    protected $table = 'datos_ax';
    protected $fillable = [
        'id',
        'cliente',
    'estilo'
    ];


}
