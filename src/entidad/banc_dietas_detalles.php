<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class banc_dietas_detalles extends Parse
{
    private $cc_dietas_detalles;
    private $cc_dietas;
    private $concepto;
    private $renta_bruta;
    private $retencion;
    private $neto;

    private $opcd;

    function __construct()
    {
        $this->cc_dietas_detalles = 0;
        $this->cc_dietas = 0;
        $this->concepto = '';
        $this->renta_bruta = 0;
        $this->retencion = 0;
        $this->neto = 0;
           $this->opcd = 0;
    }

    public function setCc_dietas_detalles($cc_dietas_detalles)
    {
        if(empty($cc_dietas_detalles)) return;
        $this->cc_dietas_detalles = self::Clean($cc_dietas_detalles);
    }

    public function getCc_dietas_detalles()
    {
        return $this->cc_dietas_detalles;
    }

    public function setCc_dietas($cc_dietas)
    {
        if(empty($cc_dietas)) return;
        $this->cc_dietas = self::Clean($cc_dietas);
    }

    public function getCc_dietas()
    {
        return $this->cc_dietas;
    }

    public function setConcepto($concepto)
    {
        if(empty($concepto)) return;
        $this->concepto = self::Clean($concepto);
    }

    public function getConcepto()
    {
        return $this->concepto;
    }

    public function setRenta_bruta($renta_bruta)
    {
        if(empty($renta_bruta)) return;
        $this->renta_bruta = self::Clean($renta_bruta);
    }

    public function getRenta_bruta()
    {
        return $this->renta_bruta;
    }

    public function setRetencion($retencion)
    {
        if(empty($retencion)) return;
        $this->retencion = self::Clean($retencion);
    }

    public function getRetencion()
    {
        return $this->retencion;
    }

    public function setNeto($neto)
    {
        if(empty($neto)) return;
        $this->neto = self::Clean($neto);
    }

    public function getNeto()
    {
        return $this->neto;
    }

    public function setOpcd($opcd)
    {
        if(empty($opcd)) return;
        $this->opcd = self::Clean($opcd);
    }

    public function getOpcd()
    {
        return $this->opcd;
    }
}