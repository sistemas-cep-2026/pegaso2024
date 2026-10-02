<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class comp_items_documentos_de_compra_cue extends Parse
{
    private $cc_compra_det;
    private $cc_compra;
    private $c_cuenta;
    private $debe;
    private $haber;
    private $opcd;


    function __construct()
    {
        $this->cc_compra_det=0;
        $this->cc_compra=0;
        $this->c_cuenta=0;
        $this->debe=0;
        $this->haber=0;
        $this->opcd='';

    }

    public function setCc_compra_det($cc_compra_det)
    {
        if (empty($cc_compra_det)) return;
        $this->cc_compra_det = self::Clean($cc_compra_det);
    }

    public function getCc_compra_det()
    {
        return $this->cc_compra_det;
    }

    public function setCc_compra($cc_compra)
    {
        if (empty($cc_compra)) return;
        $this->cc_compra = self::Clean($cc_compra);
    }

    public function getCc_compra()
    {
        return $this->cc_compra;
    }

    public function setC_cuenta($c_cuenta)
    {
        if (empty($c_cuenta)) return;
        $this->c_cuenta = self::Clean($c_cuenta);
    }

    public function getC_cuenta()
    {
        return $this->c_cuenta;
    }

    public function setDebe($debe)
    {
        if (empty($debe)) return;
        $this->debe = self::Clean($debe);
    }

    public function getDebe()
    {
        return $this->debe;
    }

    public function setHaber($haber)
    {
        if (empty($haber)) return;
        $this->haber = self::Clean($haber);
    }

    public function getHaber()
    {
        return $this->haber;
    }
    public function setOpcd($opcd)
    {
        if (empty($opcd)) return;
        $this->opcd = self::Clean($opcd);
    }

    public function getOpcd()
    {
        return $this->opcd;
    }

}
