<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_actividad_sustento extends Parse
{
    private $numero;
    private $usuario;
    private $fecha;
    private $obs;
    private $flag;
    private $cc_local;
    private $dia;
    private $fecha_registro;
    private $activo;
    private $cc_sustento;
    private $cc_area_adm;
    private $anho;
    private $periodo;

    function __construct()
    {
        $this->numero = '';
        $this->usuario = '';
        $this->fecha = '';
        $this->obs = '';
        $this->flag = '';
        $this->cc_local = '';
        $this->dia='';
        $this->fecha_registro = '';
        $this->activo = '';
        $this->cc_sustento = 0;
        $this->cc_area_adm='';
        $this->anho='';
        $this->periodo='';
    }

    public function setNumero($numero)
    {
        if(empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
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

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
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

    public function setCc_local($cc_local)
    {
        if(empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }

    public function getCc_local()
    {
        return $this->cc_local;
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

    public function setActivo($activo)
    {
        if(empty($activo)) return;
        $this->activo = self::Clean($activo);
    }

    public function getActivo()
    {
        return $this->activo;
    }

    public function setCc_sustento($cc_sustento)
    {
        if(empty($cc_sustento)) return;
        $this->cc_sustento = self::Clean($cc_sustento);
    }

    public function getCc_sustento()
    {
        return $this->cc_sustento;
    }

    public function setCc_area_adm($cc_area_adm)
    {
        if(empty($cc_area_adm)) return;
        $this->cc_area_adm = self::Clean($cc_area_adm);
    }

    public function getCc_area_adm()
    {
        return $this->cc_area_adm;
    }
    public function setDia($dia)
    {
        if(empty($dia)) return;
        $this->dia = self::Clean($dia);
    }
    public function getDia()
    {
        return $this->dia;
    }

    public function setAnho($anho)
    {
        if(empty($anho)) return;
        $this->anho = self::Clean($anho);
    }
    public function getAnho()
    {
        return $this->anho;
    }
    public function setPeriodo($periodo)
    {
        if(empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }
    public function getPeriodo()
    {
        return $this->periodo;
    }

}