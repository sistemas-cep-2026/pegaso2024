<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class banc_dietas extends Parse
{
    private $cc_dietas;
    private $fecha;
    private $cc_local;
    private $cc_persona;
    private $referencia;
    private $cc_usuario;
    private $fecha_registro;
    private $c_area_adm;
    private $id_bancos;
    private $flag;

    private $desde;
    private $hasta;

    private $cod_ano;
    private $cod_mes;
    private $nombre_persona;
    private $nombre_area;
    private $opc;

    function __construct()
    {
        $this->cc_dietas = 0;
        $this->fecha = '';
        $this->cc_local = '';
        $this->cc_persona = '';
        $this->referencia = '';
        $this->cc_usuario = '';
        $this->fecha_registro = '';
        $this->c_area_adm = '';
        $this->id_bancos = '';
        $this->flag = '';

        $this->desde = '';
        $this->hasta = '';

        $this->cod_ano = '';
        $this->cod_mes = '';
        $this->nombre_persona = '';
        $this->nombre_area = '';
        $this->opc = '';
    }

    public function setCc_dietas($cc_dietas)
    {
        if (empty($cc_dietas)) return;
        $this->cc_dietas = self::Clean($cc_dietas);
    }

    public function getCc_dietas()
    {
        return $this->cc_dietas;
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

    public function setCc_usuario($cc_usuario)
    {
        if (empty($cc_usuario)) return;
        $this->cc_usuario = self::Clean($cc_usuario);
    }

    public function getCc_usuario()
    {
        return $this->cc_usuario;
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

    public function setC_area_adm($c_area_adm)
    {
        if (empty($c_area_adm)) return;
        $this->c_area_adm = self::Clean($c_area_adm);
    }

    public function getC_area_adm()
    {
        return $this->c_area_adm;
    }

    public function setId_bancos($id_bancos)
    {
        if (empty($id_bancos)) return;
        $this->id_bancos = self::Clean($id_bancos);
    }

    public function getId_bancos()
    {
        return $this->id_bancos;
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


    public function setDesde($desde)
    {
        if (empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function setHasta($hasta)
    {
        if (empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta()
    {
        return $this->hasta;
    }

    public function setCod_ano($cod_ano)
    {
        if (empty($cod_ano)) return;
        $this->cod_ano = self::Clean($cod_ano);
    }

    public function getCod_ano()
    {
        return $this->cod_ano;
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


    public function setNombre_persona($nombre_persona)
    {
        if (empty($nombre_persona)) return;
        $this->nombre_persona = self::Clean($nombre_persona);
    }

    public function getNombre_persona()
    {
        return $this->nombre_persona;
    }
    public function setNombre_area($nombre_area)
    {
        if (empty($nombre_area)) return;
        $this->nombre_area = self::Clean($nombre_area);
    }

    public function getNombre_area()
    {
        return $this->nombre_area;
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
}
