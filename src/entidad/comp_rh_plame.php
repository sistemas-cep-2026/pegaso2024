<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class comp_rh_plame extends Parse
{
    private $cc_id;
    private $c_local;
    private $cod_anho;
    private $cod_mes;
    private $c_usuario;
    private $fecha_registro;
    private $c_persona;
    private $cod_documento;
    private $num_documento;
    private $monto;
    private $fecha_documento;
    private $fecha_pago;
    private $cuarta;

    private $razon_social;
    private $opc;


    function __construct()
    {
        $this->cc_id = 0;
        $this->c_local = '';
        $this->cod_anho = '';
        $this->cod_mes = '';
        $this->c_usuario = '';
        $this->fecha_registro = '';
        $this->c_persona = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->monto = 0;
        $this->fecha_documento = '';
        $this->fecha_pago = '';
        $this->cuarta = '';

        $this->razon_social = '';
        $this->opc = '';
    }

    public function setRazon_social($razon_social)
    {
        if (empty($razon_social)) return;
        $this->razon_social = self::Clean($razon_social);
    }

    public function getRazon_social()
    {
        return $this->razon_social;
    }

    public function setOpc($opc)
    {
        if (empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }


    public function setCc_id($cc_id)
    {
        if (empty($cc_id)) return;
        $this->cc_id = self::Clean($cc_id);
    }

    public function getCc_id()
    {
        return $this->cc_id;
    }

    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setCod_anho($cod_anho)
    {
        if (empty($cod_anho)) return;
        $this->cod_anho = self::Clean($cod_anho);
    }

    public function getCod_anho()
    {
        return $this->cod_anho;
    }

    public function setCod_mes($cod_mes)
    {
        if (empty($cod_mes)) return;
        $this->cod_mes = self::Clean($cod_mes);
    }

    public function getCod_mes()
    {
        return $this->cod_mes;
    }

    public function setC_usuario($c_usuario)
    {
        if (empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
    }

    public function setFecha_registro($fecha_registro)
    {
        if (empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    public function setC_persona($c_persona)
    {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

    public function setCod_documento($cod_documento)
    {
        if (empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento()
    {
        return $this->cod_documento;
    }

    public function setNum_documento($num_documento)
    {
        if (empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
    }

    public function setMonto($monto)
    {
        if (empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setFecha_documento($fecha_documento)
    {
        if (empty($fecha_documento)) return;
        $this->fecha_documento = self::Clean($fecha_documento);
    }

    public function getFecha_documento()
    {
        return $this->fecha_documento;
    }

    public function setFecha_pago($fecha_pago)
    {
        if (empty($fecha_pago)) return;
        $this->fecha_pago = self::Clean($fecha_pago);
    }

    public function getFecha_pago()
    {
        return $this->fecha_pago;
    }

    public function setCuarta($cuarta)
    {
        if (empty($cuarta)) return;
        $this->cuarta = self::Clean($cuarta);
    }

    public function getCuarta()
    {
        return $this->cuarta;
    }
}
