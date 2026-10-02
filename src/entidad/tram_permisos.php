<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_permisos extends Parse
{
    private $cc_permisos;
    private $c_local;
    private $tipo_permisos;
    private $fecha;
    private $fecha_ida;
    private $fecha_retorno;
    private $cc_area_adm;
    private $cc_usuario_e;
    private $motivo;
    private $destinos;
    private $user_crea;
    private $fech_crea;
    private $fech_anula;
    private $user_anula;
    private $obs;
    private $flag;

    private $cod_anho;
    private $periodo;

    function __construct()
    {
        $this->cc_permisos = 0;
        $this->c_local = '';
        $this->tipo_permisos = '';
        $this->fecha = '';
        $this->fecha_ida = '';
        $this->fecha_retorno = '';
        $this->cc_area_adm = '';
        $this->cc_usuario_e = '';
        $this->motivo = '';
        $this->destinos = '';
        $this->user_crea = '';
        $this->fech_crea = '';
        $this->user_anula = '';
        $this->fech_anula = '';
        $this->obs = '';
        $this->flag = '';

        $this->cod_anho = '';
        $this->periodo = '';
    }

    public function setCc_permisos($cc_permisos)
    {
        if (empty($cc_permisos)) return;
        $this->cc_permisos = self::Clean($cc_permisos);
    }

    public function getCc_permisos()
    {
        return $this->cc_permisos;
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

    public function setTipo_permisos($tipo_permisos)
    {
        if (empty($tipo_permisos)) return;
        $this->tipo_permisos = self::Clean($tipo_permisos);
    }

    public function getTipo_permisos()
    {
        return $this->tipo_permisos;
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


    public function setFecha_ida($fecha_ida)
    {
        if (empty($fecha_ida)) return;
        $this->fecha_ida = self::Clean($fecha_ida);
    }

    public function getFecha_ida()
    {
        return $this->fecha_ida;
    }

    public function setFecha_retorno($fecha_retorno)
    {
        if (empty($fecha_retorno)) return;
        $this->fecha_retorno = self::Clean($fecha_retorno);
    }

    public function getFecha_retorno()
    {
        return $this->fecha_retorno;
    }

    public function setCc_area_adm($cc_area_adm)
    {
        if (empty($cc_area_adm)) return;
        $this->cc_area_adm = self::Clean($cc_area_adm);
    }

    public function getCc_area_adm()
    {
        return $this->cc_area_adm;
    }

    public function setCc_usuario_e($cc_usuario_e)
    {
        if (empty($cc_usuario_e)) return;
        $this->cc_usuario_e = self::Clean($cc_usuario_e);
    }

    public function getCc_usuario_e()
    {
        return $this->cc_usuario_e;
    }

    public function setMotivo($motivo)
    {
        if (empty($motivo)) return;
        $this->motivo = self::Clean($motivo);
    }

    public function getMotivo()
    {
        return $this->motivo;
    }

    public function setDestinos($destinos)
    {
        if (empty($destinos)) return;
        $this->destinos = self::Clean($destinos);
    }

    public function getDestinos()
    {
        return $this->destinos;
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

    public function setFech_crea($fech_crea)
    {
        if (empty($fech_crea)) return;
        $this->fech_crea = self::Clean($fech_crea);
    }

    public function getFech_crea()
    {
        return $this->fech_crea;
    }

    public function setUser_anula($user_anula)
    {
        if (empty($user_anula)) return;
        $this->user_anula = self::Clean($user_anula);
    }

    public function getUser_anula()
    {
        return $this->user_anula;
    }

    public function setFech_anula($fech_anula)
    {
        if (empty($fech_anula)) return;
        $this->fech_anula = self::Clean($fech_anula);
    }

    public function getFech_anula()
    {
        return $this->fech_anula;
    }
    public function setObs($obs)
    {
        if (empty($obs)) return;
        $this->obs = self::Clean($obs);
    }

    public function getObs()
    {
        return $this->obs;
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
    public function setPeriodo($periodo)
    {
        if (empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }
}
