<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class teso_conciliacion_mensual_transferencia extends Parse
{
    private $cc_transferencia;
    private $cc_local;
    private $cod_anho;
    private $cod_mes;
    private $fecha;
    private $banco_cuenta;
    private $vnop;
    private $vfecha;
    private $vmonto;
    private $user_crea;
    private $obs;
    private $flag;

    function __construct()
    {
        $this->cc_transferencia = 0;
        $this->cc_local = '';
        $this->cod_anho = '';
        $this->cod_mes = '';
        $this->fecha = '';
        $this->banco_cuenta = '';
        $this->vnop = '';
        $this->vfecha = '';
        $this->vmonto = 0;
        $this->user_crea = '';
        $this->obs = '';
        $this->flag = '';
    }

    public function setCc_transferencia($cc_transferencia)
    {
        if(empty($cc_transferencia)) return;
        $this->cc_transferencia = self::Clean($cc_transferencia);
    }

    public function getCc_transferencia()
    {
        return $this->cc_transferencia;
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

    public function setCod_anho($cod_anho)
    {
        if(empty($cod_anho)) return;
        $this->cod_anho = self::Clean($cod_anho);
    }

    public function getCod_anho()
    {
        return $this->cod_anho;
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

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setBanco_cuenta($banco_cuenta)
    {
        if(empty($banco_cuenta)) return;
        $this->banco_cuenta = self::Clean($banco_cuenta);
    }

    public function getBanco_cuenta()
    {
        return $this->banco_cuenta;
    }

    public function setVnop($vnop)
    {
        if(empty($vnop)) return;
        $this->vnop = self::Clean($vnop);
    }

    public function getVnop()
    {
        return $this->vnop;
    }

    public function setVfecha($vfecha)
    {
        if(empty($vfecha)) return;
        $this->vfecha = self::Clean($vfecha);
    }

    public function getVfecha()
    {
        return $this->vfecha;
    }

    public function setVmonto($vmonto)
    {
        if(empty($vmonto)) return;
        $this->vmonto = self::Clean($vmonto);
    }

    public function getVmonto()
    {
        return $this->vmonto;
    }

    public function setUser_crea($user_crea)
    {
        if(empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setObs($obs)
    {
        if(empty($obs)) return;
        $this->obs = self::Clean($obs);
    }

    public function getObs()
    {
        return $this->obs;
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

}