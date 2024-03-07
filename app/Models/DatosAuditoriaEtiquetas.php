<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAuditoriaEtiquetas extends Model
{
    use HasFactory;
    protected $table = 'auditoria_etiquetas';
    protected $fillable = [
    'id',
    'purchid',
    'purchname',
    'itemid',
    'qty',
    'inventdimid',
    'inventsizeid',
    'inventcolorid',
    'year',
    'status',
    ];
}
