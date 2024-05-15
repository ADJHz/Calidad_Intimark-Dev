<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\AseguramientoCalidad;

class NotificacionParo extends Mailable
{
    use Queueable, SerializesModels;

    public $registro;

    public function __construct(AseguramientoCalidad $registro)
    {
        $this->registro = $registro;
    }

    public function build()
    {
        return $this->view('emails.notificacion_paro')
                    ->subject('Inicio de paro')
                    ->with([
                        'area' => $this->registro->area,
                        'fecha' => $this->registro->inicio_paro,
                        // Otros datos que quieras incluir en el correo...
                    ]);
    }
}
