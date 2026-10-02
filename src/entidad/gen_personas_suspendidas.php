<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_personas_suspendidas extends Parse
{
    private $cc_psuspendidas;
    private $c_persona;
    private $sancion;
    private $resol1;
    private $resol2;
    private $desde;
    private $hasta;
    private $url;
    private $flag;
    private $flag_activo;
    private $fecha_crea;
    private $fecha_mod;
    private $user_crea;
    private $user_mod;
    private $obs;

    private $opc;

    function __construct()
    {
        $this->cc_psuspendidas = 0;
        $this->c_persona = '';
        $this->sancion = '';
        $this->resol1 = '';
        $this->resol2 = '';
        $this->desde = '';
        $this->hasta = '';
        $this->url = '';
        $this->flag = '';
        $this->flag_activo = '';
        $this->fecha_crea = '';
        $this->fecha_mod = '';
        $this->user_crea = '';
        $this->user_mod = '';
        $this->obs = '';

        $this->opc = '';
    }

    public function setCc_psuspendidas($cc_psuspendidas)
    {
        if(empty($cc_psuspendidas)) return;
        $this->cc_psuspendidas = self::Clean($cc_psuspendidas);
    }

    public function getCc_psuspendidas()
    {
        return $this->cc_psuspendidas;
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

    public function setSancion($sancion)
    {
        if(empty($sancion)) return;
        $this->sancion = self::Clean($sancion);
    }

    public function getSancion()
    {
        return $this->sancion;
    }

    public function setResol1($resol1)
    {
        if(empty($resol1)) return;
        $this->resol1 = self::Clean($resol1);
    }

    public function getResol1()
    {
        return $this->resol1;
    }

    public function setResol2($resol2)
    {
        if(empty($resol2)) return;
        $this->resol2 = self::Clean($resol2);
    }

    public function getResol2()
    {
        return $this->resol2;
    }

    public function setDesde($desde)
    {
        if(empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function setHasta($hasta)
    {
        if(empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta()
    {
        return $this->hasta;
    }

    public function setUrl($url)
    {
        if(empty($url)) return;
        $this->url = self::Clean($url);
    }

    public function getUrl()
    {
        return $this->url;
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

    public function setFlag_activo($flag_activo)
    {
        if(empty($flag_activo)) return;
        $this->flag_activo = self::Clean($flag_activo);
    }

    public function getFlag_activo()
    {
        return $this->flag_activo;
    }

    public function setFecha_crea($fecha_crea)
    {
        if(empty($fecha_crea)) return;
        $this->fecha_crea = self::Clean($fecha_crea);
    }

    public function getFecha_crea()
    {
        return $this->fecha_crea;
    }

    public function setFecha_mod($fecha_mod)
    {
        if(empty($fecha_mod)) return;
        $this->fecha_mod = self::Clean($fecha_mod);
    }

    public function getFecha_mod()
    {
        return $this->fecha_mod;
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

    public function setUser_mod($user_mod)
    {
        if(empty($user_mod)) return;
        $this->user_mod = self::Clean($user_mod);
    }

    public function getUser_mod()
    {
        return $this->user_mod;
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

    public function setOpc($opc)
    {
        if(empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }

}