<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class teso_conciliacion_mensual extends Parse
{
    private $cc_concimen;
    private $entidad;
    private $referencia;
    private $cc_local;
    private $cod_mes;
    private $cod_anho;
    private $usuario;
    private $regional;
    private $nacional;
    private $cantidad;
    private $porcentaje;
    private $fecha;
    private $usuario2;
    private $fecha2;
    private $flag;

    private $opc;
    private $monto;
    private $asiento_usuario;
    function __construct()
    {
        $this->cc_concimen = 0;
        $this->entidad = '';
        $this->referencia = '';
        $this->cc_local = '';
        $this->cod_mes = '';
        $this->cod_anho = '';
        $this->usuario = '';
        $this->regional = 0;
        $this->nacional = 0;
        $this->cantidad = 0;
        $this->porcentaje = 0;
        $this->fecha = '';
        $this->usuario2='';
        $this->fecha2= '';
        $this->flag = '';

        $this->opc = '';
        $this->monto= 0 ;
        $this->asiento_usuario= '' ;
    }

    public function setCc_concimen($cc_concimen)
    {
        if(empty($cc_concimen)) return;
        $this->cc_concimen = self::Clean($cc_concimen);
    }

    public function getCc_concimen()
    {
        return $this->cc_concimen;
    }

    public function setEntidad($entidad)
    {
        if(empty($entidad)) return;
        $this->entidad = self::Clean($entidad);
    }

    public function getEntidad()
    {
        return $this->entidad;
    }

    public function setReferencia($referencia)
    {
        if(empty($referencia)) return;
        $this->referencia = self::Clean($referencia);
    }

    public function getReferencia()
    {
        return $this->referencia;
    }

    public function setCc_local($cc_local)
    {
        if(empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }

    public function getCc_local()
    {
        return $this->cc_local;
    }

    public function setCod_mes($cod_mes)
    {
        if(empty($cod_mes)) return;
        $this->cod_mes = self::Clean($cod_mes);
    }

    public function getCod_mes()
    {
        return $this->cod_mes;
    }

    public function setCod_anho($cod_anho)
    {
        if(empty($cod_anho)) return;
        $this->cod_anho = self::Clean($cod_anho);
    }

    public function getCod_anho()
    {
        return $this->cod_anho;
    }

    public function setUsuario($usuario)
    {
        if(empty($usuario)) return;
        $this->usuario = self::Clean($usuario);
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setRegional($regional)
    {
        if(empty($regional)) return;
        $this->regional = self::Clean($regional);
    }

    public function getRegional()
    {
        return $this->regional;
    }

    public function setNacional($nacional)
    {
        if(empty($nacional)) return;
        $this->nacional = self::Clean($nacional);
    }

    public function getNacional()
    {
        return $this->nacional;
    }

    public function setCantidad($cantidad)
    {
        if(empty($cantidad)) return;
        $this->cantidad = self::Clean($cantidad);
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setPorcentaje($porcentaje)
    {
        if(empty($porcentaje)) return;
        $this->porcentaje = self::Clean($porcentaje);
    }

    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setUsuario2($usuario2)
    {
        if(empty($usuario2)) return;
        $this->usuario2 = self::Clean($usuario2);
    }

    public function getUsuario2()
    {
        return $this->usuario2;
    }
    public function setFecha2($fecha2)
    {
        if(empty($fecha2)) return;
        $this->fecha2 = self::Clean($fecha2);
    }

    public function getFecha2()
    {
        return $this->fecha2;
    }
    public function setFlag($flag)
    {
        if(empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function setMonto($monto)
    {
        if(empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }
     public function setOpc($opc)
    {
        if(empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }

    public function setAsiento_usuario($asiento_usuario)
    {
        if(empty($asiento_usuario)) return;
        $this->asiento_usuario = self::Clean($asiento_usuario);
    }

    public function getAsiento_usuario()
    {
        return $this->asiento_usuario;
    }
}