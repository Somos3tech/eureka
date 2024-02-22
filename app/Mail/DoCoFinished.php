<?php

namespace App\Mail;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * ! Jorge Thomas
 * * Envio de Correo para avisar conciliación de Domiciliación Terminada
 */
class DoCoFinished extends Mailable
{
    use Queueable, Batchable, SerializesModels;

    public $data;

    public $procesados;

    public $noProcesados;

    public $totales;

    public function __construct($data, $procesados, $noProcesados, $totales)
    {
        $this->data = $data;
        $this->procesados = $procesados;
        $this->noProcesados = $noProcesados;
        $this->totales = $totales;
    }

    public function build()
    {
        return $this->view('mails.docofinished')->subject('Proceso de Domiciliación Finalizado - '.$this->data);
    }
}
