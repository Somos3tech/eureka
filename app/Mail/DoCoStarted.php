<?php

namespace App\Mail;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * ! Jorge Thomas
 * * Envio de Correo para avisar conciliación de Domiciliación en Proceso
 */
class DoCoStarted extends Mailable
{
    use Queueable, Batchable, SerializesModels;

    public $data;

    public $procesados;

    public $noProcesados;

    public $totales;

    public $batchid;

    public function __construct($data, $procesados, $noProcesados, $totales, $batchid)
    {
        $this->data = $data;
        $this->procesados = $procesados;
        $this->noProcesados = $noProcesados;
        $this->totales = $totales;
        $this->batchid = $batchid;
    }

    public function build()
    {
        return $this->view('mails.docostarted')->subject('Proceso de Domiciliación Iniciado - '.$this->data);
    }
}
