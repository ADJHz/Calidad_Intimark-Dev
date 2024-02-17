<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScreenPrint extends Model
{
    use HasFactory;
    protected $table = 'screen_print';
    protected $fillable = [
                'Auditor',
                'Status',
                'Cliente',
                'Estilo' ,
                'OP_Defec',
                'Tecnico',
                'Color',
                'Num_Grafico',
                'Tecnica' ,
                'Fibras',
                'Porcen_Fibra',
                'Tipo_Problema',
                'Ac_Correctiva'
            ];
}
