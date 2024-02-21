<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoAX extends Model
{
    use HasFactory;
    protected $table = 'datos_auditorias';

    public function auditoriasMarcadas()
    {
        return $this->hasMany(AuditoriaMarcada::class, 'orden_id', 'op');
    }
    
}
