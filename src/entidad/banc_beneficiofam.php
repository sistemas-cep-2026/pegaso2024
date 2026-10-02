<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class banc_beneficiofam extends Parse
{
    private $cc_beneficiofam;
    private $fecha;
    private $cc_local;
    private $cc_persona;
    private $referencia;
    private $fecha_registro;
    private $c_banco;
    private $fecha_operacion;
    private $monto;
    private $operacion;
    private $cod_tipo;
    private $user_crea;
    private $fecha_crea;
    private $user_mod;
    private $fecha_mod;
    private $flag;

    private $cod_anho;
    private $cod_mes;

    function __construct()
    {
        $this->cc_beneficiofam = 0;
        $this->fecha = '';
        $this->cc_local = '';
        $this->cc_persona = '';
        $this->referencia = '';
        $this->fecha_registro = '';
        $this->c_banco = '';
        $this->fecha_operacion = '';
        $this->monto = 0;
        $this->operacion = '';
        $this->cod_tipo = '';
        $this->user_crea = '';
        $this->fecha_crea = '';
        $this->user_mod = '';
        $this->fecha_mod = '';
        $this->flag = '';

        $this->cod_anho = '';
        $this->cod_mes = '';
    }

    public function setCc_beneficiofam($cc_beneficiofam)
    {
        if (empty($cc_beneficiofam)) return;
        $this->cc_beneficiofam = self::Clean($cc_beneficiofam);
    }

    public function getCc_beneficiofam()
    {
        return $this->cc_beneficiofam;
    }

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setCc_local($cc_local)
    {
        if (empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }

    public function getCc_local()
    {
        return $this->cc_local;
    }

    public function setCc_persona($cc_persona)
    {
        if (empty($cc_persona)) return;
        $this->cc_persona = self::Clean($cc_persona);
    }

    public function getCc_persona()
    {
        return $this->cc_persona;
    }

    public function setReferencia($referencia)
    {
        if (empty($referencia)) return;
        $this->referencia = self::Clean($referencia);
    }

    public function getReferencia()
    {
        return $this->referencia;
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

    public function setC_banco($c_banco)
    {
        if (empty($c_banco)) return;
        $this->c_banco = self::Clean($c_banco);
    }

    public function getC_banco()
    {
        return $this->c_banco;
    }

    public function setFecha_operacion($fecha_operacion)
    {
        if (empty($fecha_operacion)) return;
        $this->fecha_operacion = self::Clean($fecha_operacion);
    }

    public function getFecha_operacion()
    {
        return $this->fecha_operacion;
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

    public function setOperacion($operacion)
    {
        if (empty($operacion)) return;
        $this->operacion = self::Clean($operacion);
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

    public function setCod_tipo($cod_tipo)
    {
        if (empty($cod_tipo)) return;
        $this->cod_tipo = self::Clean($cod_tipo);
    }

    public function getCod_tipo()
    {
        return $this->cod_tipo;
    }

    public function setUser_crea($user_crea)
    {
        if (empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setFecha_crea($fecha_crea)
    {
        if (empty($fecha_crea)) return;
        $this->fecha_crea = self::Clean($fecha_crea);
    }

    public function getFecha_crea()
    {
        return $this->fecha_crea;
    }

    public function setUser_mod($user_mod)
    {
        if (empty($user_mod)) return;
        $this->user_mod = self::Clean($user_mod);
    }

    public function getUser_mod()
    {
        return $this->user_mod;
    }

    public function setFecha_mod($fecha_mod)
    {
        if (empty($fecha_mod)) return;
        $this->fecha_mod = self::Clean($fecha_mod);
    }

    public function getFecha_mod()
    {
        return $this->fecha_mod;
    }

    public function setFlag($flag)
    {
        if (empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
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
}
