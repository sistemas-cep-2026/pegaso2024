<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class nps_cabecera extends Parse
{
    private $cc_cabecera;
    private $fecha_registro;
    private $c_local;
    private $c_persona;

    function __construct()
    {
        $this->cc_cabecera = 0;
        $this->fecha_registro = '';
        $this->c_local = '';
        $this->c_persona = '';
    }

    public function setCc_cabecera($cc_cabecera)
    {
        if(empty($cc_cabecera)) return;
        $this->cc_cabecera = self::Clean($cc_cabecera);
    }

    public function getCc_cabecera()
    {
        return $this->cc_cabecera;
    }

    public function setFecha_registro($fecha_registro)
    {
        if(empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    public function setC_local($c_local)
    {
        if(empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setC_persona($c_persona)
    {
        if(empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

}