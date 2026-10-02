<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_honorabilidad extends Parse
{
    private $cc_honorab;
    private $cc_local;
    private $cc_persona;
    private $anho;
    private $numero;
    private $fecha_reg;
    private $fecha_text;
    private $img_fondo;
    private $autoridad;
    private $cargo;
    private $nombre_anho;
    private $user_crea;
    private $fecha_crea;
    private $user_mod;
    private $fecha_mod;
    private $flag;

    private $nombre;
    private $periodo;
    private $opc;
    private $recaudo_id;

    function __construct()
    {
        $this->cc_honorab = 0;
        $this->cc_local = '';
        $this->cc_persona = '';
        $this->anho = '';
        $this->numero = 0;
        $this->fecha_reg = '';
        $this->fecha_text = '';
        $this->img_fondo = '';
        $this->autoridad = '';
        $this->cargo = '';
        $this->nombre_anho = '';
        $this->user_crea = '';
        $this->fecha_crea = '';
        $this->user_mod = '';
        $this->fecha_mod = '';
        $this->flag = '';

        $this->nombre = '';
        $this->periodo = '';
        $this->opc = '';
        $this->recaudo_id = '';
    }

    public function setCc_honorab($cc_honorab)
    {
        if (empty($cc_honorab)) return;
        $this->cc_honorab = self::Clean($cc_honorab);
    }

    public function getCc_honorab()
    {
        return $this->cc_honorab;
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

    public function setAnho($anho)
    {
        if (empty($anho)) return;
        $this->anho = self::Clean($anho);
    }

    public function getAnho()
    {
        return $this->anho;
    }

    public function setNumero($numero)
    {
        if (empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setFecha_reg($fecha_reg)
    {
        if (empty($fecha_reg)) return;
        $this->fecha_reg = self::Clean($fecha_reg);
    }

    public function getFecha_reg()
    {
        return $this->fecha_reg;
    }

    public function setFecha_text($fecha_text)
    {
        if (empty($fecha_text)) return;
        $this->fecha_text = self::Clean($fecha_text);
    }

    public function getFecha_text()
    {
        return $this->fecha_text;
    }

    public function setImg_fondo($img_fondo)
    {
        if (empty($img_fondo)) return;
        $this->img_fondo = self::Clean($img_fondo);
    }

    public function getImg_fondo()
    {
        return $this->img_fondo;
    }

    public function setAutoridad($autoridad)
    {
        if (empty($autoridad)) return;
        $this->autoridad = self::Clean($autoridad);
    }

    public function getAutoridad()
    {
        return $this->autoridad;
    }


    public function setCargo($cargo)
    {
        if (empty($cargo)) return;
        $this->cargo = self::Clean($cargo);
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setNombre_anho($nombre_anho)
    {
        if (empty($nombre_anho)) return;
        $this->nombre_anho = self::Clean($nombre_anho);
    }

    public function getNombre_anho()
    {
        return $this->nombre_anho;
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

    public function setPeriodo($periodo)
    {
        if (empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }
    public function setNombre($nombre)
    {
        if (empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setRecaudo_id($recaudo_id)
    {
        if (empty($recaudo_id)) return;
        $this->recaudo_id = self::Clean($recaudo_id);
    }

    public function getRecaudo_id()
    {
        return $this->recaudo_id;
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
