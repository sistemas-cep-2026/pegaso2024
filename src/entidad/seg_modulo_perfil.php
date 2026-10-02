<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_modulo_perfil extends Parse
{
    private $cc_modrol;
    private $cc_modulo;
    private $cc_perfil;

    function __construct()
    {
        $this->cc_modrol = 0;
        $this->cc_modulo = 0;
        $this->cc_perfil = 0;
    }

    public function setCc_modrol($cc_modrol)
    {
        if(empty($cc_modrol)) return;
        $this->cc_modrol = self::Clean($cc_modrol);
    }

    public function getCc_modrol()
    {
        return $this->cc_modrol;
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

    public function setCc_perfil($cc_perfil)
    {
        if(empty($cc_perfil)) return;
        $this->cc_perfil = self::Clean($cc_perfil);
    }

    public function getCc_perfil()
    {
        return $this->cc_perfil;
    }

}