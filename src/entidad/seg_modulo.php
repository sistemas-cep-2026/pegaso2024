<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_modulo extends Parse
{
    private $cc_modulo;
    private $mod_nombre;
    private $mod_nivel;
    private $mod_carpeta;
    private $mod_url;
    private $mod_js;
    private $mod_estado;
    private $mod_orden;
    private $mod_ico;
    private $mod_vista;

    function __construct()
    {
        $this->cc_modulo = 0;
        $this->mod_nombre = '';
        $this->mod_nivel = '';
        $this->mod_carpeta = '';
        $this->mod_url = '';
        $this->mod_js = '';
        $this->mod_estado = '';
        $this->mod_orden = 0;
        $this->mod_ico = '';
        $this->mod_vista = '';
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

    public function setMod_nombre($mod_nombre)
    {
        if(empty($mod_nombre)) return;
        $this->mod_nombre = self::Clean($mod_nombre);
    }

    public function getMod_nombre()
    {
        return $this->mod_nombre;
    }

    public function setMod_nivel($mod_nivel)
    {
        if(empty($mod_nivel)) return;
        $this->mod_nivel = self::Clean($mod_nivel);
    }

    public function getMod_nivel()
    {
        return $this->mod_nivel;
    }

    public function setMod_carpeta($mod_carpeta)
    {
        if(empty($mod_carpeta)) return;
        $this->mod_carpeta = self::Clean($mod_carpeta);
    }

    public function getMod_carpeta()
    {
        return $this->mod_carpeta;
    }

    public function setMod_url($mod_url)
    {
        if(empty($mod_url)) return;
        $this->mod_url = self::Clean($mod_url);
    }

    public function getMod_url()
    {
        return $this->mod_url;
    }

    public function setMod_js($mod_js)
    {
        if(empty($mod_js)) return;
        $this->mod_js = self::Clean($mod_js);
    }

    public function getMod_js()
    {
        return $this->mod_js;
    }

    public function setMod_estado($mod_estado)
    {
        if(empty($mod_estado)) return;
        $this->mod_estado = self::Clean($mod_estado);
    }

    public function getMod_estado()
    {
        return $this->mod_estado;
    }

    public function setMod_orden($mod_orden)
    {
        if(empty($mod_orden)) return;
        $this->mod_orden = self::Clean($mod_orden);
    }

    public function getMod_orden()
    {
        return $this->mod_orden;
    }

    public function setMod_ico($mod_ico)
    {
        if(empty($mod_ico)) return;
        $this->mod_ico = self::Clean($mod_ico);
    }

    public function getMod_ico()
    {
        return $this->mod_ico;
    }

    public function setMod_vista($mod_vista)
    {
        if(empty($mod_vista)) return;
        $this->mod_vista = self::Clean($mod_vista);
    }

    public function getMod_vista()
    {
        return $this->mod_vista;
    }

}