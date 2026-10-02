<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_perfil extends Parse
{
    private $cc_perfil;
    private $ct_perfil;
    private $mod_defecto;
    private $flag;

    function __construct()
    {
        $this->cc_perfil = 0;
        $this->ct_perfil = '';
        $this->mod_defecto = '';
        $this->flag = '';
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

    public function setCt_perfil($ct_perfil)
    {
        if(empty($ct_perfil)) return;
        $this->ct_perfil = self::Clean($ct_perfil);
    }

    public function getCt_perfil()
    {
        return $this->ct_perfil;
    }

    public function setMod_defecto($mod_defecto)
    {
        if(empty($mod_defecto)) return;
        $this->mod_defecto = self::Clean($mod_defecto);
    }

    public function getMod_defecto()
    {
        return $this->mod_defecto;
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