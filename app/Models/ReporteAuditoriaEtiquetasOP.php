<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteAuditoriaEtiquetasOP extends Model
{
    use HasFactory;
    protected $table = 'reporte_auditoria_etiquetasop';

    protected $fillable = [
        'id',
        'Orden',
        'Estilos',
        'Cantidad',
        'Muestreo',
        'Defectos',
        'Tipo_Defectos',
        'Talla',
        'Color',
        'Status',
        ];
}
