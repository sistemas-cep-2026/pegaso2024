<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_usuarios extends Parse
{
    private $cc_usuario;
    private $cc_persona;
    private $cc_perfil;
    private $cc_local;
    private $c_area;
    private $tp_user;
    private $usuario;
    private $clave;
    private $tiempo_sesion;
    private $foto;
    private $obs;
    private $user_crea;
    private $fech_crea;
    private $user_mod;
    private $fech_mod;
    private $flag;
    private $fech_bloquea;

    private $nombre;
    private $opc;


    function __construct()
    {

        $this->cc_usuario= '';
        $this->cc_persona= '';
        $this->cc_perfil= '';
        $this->cc_local= '';
        $this->c_area= '';
        $this->tp_user= '';
        $this->usuario= '';
        $this->clave= '';
        $this->tiempo_sesion= '';
        $this->foto= '';
        $this->obs= '';
        $this->user_crea= '';
        $this->fech_crea= '';
        $this->user_mod= '';
        $this->fech_mod= '';
        $this->flag= '';
        $this->fech_bloquea= '';

        $this->nombre='';
        $this->opc='';
    }

    public function setCc_usuario($cc_usuario)
    {
        if(empty($cc_usuario)) return;
        $this->cc_usuario = self::Clean($cc_usuario);
    }

    public function getCc_usuario()
    {
        return $this->cc_usuario;
    }

    public function setCc_persona($cc_persona)
    {
        if(empty($cc_persona)) return;
        $this->cc_persona = self::Clean($cc_persona);
    }

    public function getCc_persona()
    {
        return $this->cc_persona;
    }

    public function setCc_perfil($cc_perfil)
    {
        if(empty($cc_perfil)) return;
        $this->cc_perfil = self::Clean($cc_perfil);
    }

    public function getCc_perfil()
    {
        return $this->cc_perfil;
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

    public function setC_area($c_area)
    {
        if (empty($c_area)) return;
        $this->c_area = self::Clean($c_area);
    }

    public function getC_area()
    {
        return $this->c_area;
    }

    public function setTp_user($tp_user)
    {
        if(empty($tp_user)) return;
        $this->tp_user = self::Clean($tp_user);
    }

    public function getTp_user()
    {
        return $this->tp_user;
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

    public function setClave($clave)
    {
        if(empty($clave)) return;
        $this->clave = self::Clean($clave);
    }

    public function getClave()
    {
        return $this->clave;
    }

    public function setTiempo_sesion($tiempo_sesion)
    {
        if(empty($tiempo_sesion)) return;
        $this->tiempo_sesion = self::Clean($tiempo_sesion);
    }

    public function getTiempo_sesion()
    {
        return $this->tiempo_sesion;
    }

    public function setFoto($foto)
    {
        if(empty($foto)) return;
        $this->foto = self::Clean($foto);
    }

    public function getFoto()
    {
        return $this->foto;
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

    public function setUser_crea($user_crea)
    {
        if(empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setFech_crea($fech_crea)
    {
        if(empty($fech_crea)) return;
        $this->fech_crea = self::Clean($fech_crea);
    }

    public function getFech_crea()
    {
        return $this->fech_crea;
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

    public function setFech_mod($fech_mod)
    {
        if(empty($fech_mod)) return;
        $this->fech_mod = self::Clean($fech_mod);
    }

    public function getFech_mod()
    {
        return $this->fech_mod;
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

    public function setFecha_bloqueo($fecha_bloqueo)
    {
        if(empty($fecha_bloqueo)) return;
        $this->fecha_bloqueo = self::Clean($fecha_bloqueo);
    }

    public function getFecha_bloqueo()
    {
        return $this->fecha_bloqueo;
    }

    public function setNombre($nombre)
    {
        if(empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
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