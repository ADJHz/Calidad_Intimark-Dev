<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteAuditoriaEtiqueta extends Model
{
    use HasFactory;
    protected $table = 'reporte_auditoria_etiquetas';

    public function categoriaCliente()
    {
        return $this->belongsTo(CategoriaCliente::class, 'cliente_id');
    }
    public function categoriaEstilo()
    {
        return $this->belongsTo(CategoriaEstilo::class, 'estilo_id');
    }
    public function categoriaNoRecibo()
    {
        return $this->belongsTo(CategoriaNoRecibo::class, 'no_recibo_id');
    }
    public function categoriaTallaCantidad()
    {
        return $this->belongsTo(CategoriaTallaCantidad::class, 'talla_cantidad_id');
    }
    public function categoriaTamañoMuestra()
    {
        return $this->belongsTo(CategoriaTamañoMuestra::class, 'tamaño_muestra_id');
    }
    public function categoriaDefecto()
    {
        return $this->belongsTo(CategoriaDefecto::class, 'defecto_id');
    }
    public function categoriaTipoDefecto()
    {
        return $this->belongsTo(CategoriaTipoDefecto::class, 'tipo_defecto_id');
    }
    public function categoriaAuditor()
    {
        return $this->belongsTo(CategoriaTipoDefecto::class, 'auditor_id');
    }


}
