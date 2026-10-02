<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_personas_discapacidad extends Parse
{
    private $cc_discapac;
    private $cc_persona;
    private $cod_tipo;
    private $obs;
    private $reg_conadis;
    private $fecha_registro;
    private $flag;
    private $user_crea;
    private $fecha_crea;

    private $nombre;
    private $anho;
    private $c_local;

    function __construct()
    {
        $this->cc_discapac = 0;
        $this->cc_persona = '';
        $this->cod_tipo = '';
        $this->obs = '';
        $this->reg_conadis = '';
        $this->fecha_registro = '';
        $this->flag = '';
        $this->user_crea = '';
        $this->fecha_crea = '';

        $this->nombre = '';
        $this->anho = '';
        $this->c_local = '';
    }

    public function setCc_discapac($cc_discapac)
    {
        if (empty($cc_discapac)) return;
        $this->cc_discapac = self::Clean($cc_discapac);
    }

    public function getCc_discapac()
    {
        return $this->cc_discapac;
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

    public function setCod_tipo($cod_tipo)
    {
        if (empty($cod_tipo)) return;
        $this->cod_tipo = self::Clean($cod_tipo);
    }

    public function getCod_tipo()
    {
        return $this->cod_tipo;
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

    public function setReg_conadis($reg_conadis)
    {
        if (empty($reg_conadis)) return;
        $this->reg_conadis = self::Clean($reg_conadis);
    }

    public function getReg_conadis()
    {
        return $this->reg_conadis;
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

    public function setFlag($flag)
    {
        if (empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
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

    public function setNombre($nombre)
    {
        if (empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
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
    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }
}
