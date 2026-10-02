<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_permiso extends Parse
{
    private $cc_modulo;
    private $cc_permiso;
    private $cc_usuario;
    private $permiso_descripcion;
    private $flag;

    function __construct()
    {
        $this->cc_modulo = '';
        $this->cc_permiso = 0;
        $this->cc_usuario = '';
        $this->permiso_descripcion = '';
        $this->flag = 0;
    }

    public function setCc_modulo($cc_modulo)
    {
        if(empty($cc_modulo)) return;
        $this->cc_modulo = self::Clean($cc_modulo);
    }

    public function getCc_modulo()
    {
        return $this->cc_modulo;
    }

    public function setCc_permiso($cc_permiso)
    {
        if(empty($cc_permiso)) return;
        $this->cc_permiso = self::Clean($cc_permiso);
    }

    public function getCc_permiso()
    {
        return $this->cc_permiso;
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

    public function setPermiso_descripcion($permiso_descripcion)
    {
        if(empty($permiso_descripcion)) return;
        $this->permiso_descripcion = self::Clean($permiso_descripcion);
    }

    public function getPermiso_descripcion()
    {
        return $this->permiso_descripcion;
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