<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_modulo_pagina extends Parse
{
    private $mod_id;
    private $pag_id;

    function __construct()
    {
        $this->mod_id = 0;
        $this->pag_id = 0;
    }

    public function setMod_id($mod_id)
    {
        if(empty($mod_id)) return;
        $this->mod_id = self::Clean($mod_id);
    }

    public function getMod_id()
    {
        return $this->mod_id;
    }

    public function setPag_id($pag_id)
    {
        if(empty($pag_id)) return;
        $this->pag_id = self::Clean($pag_id);
    }

    public function getPag_id()
    {
        return $this->pag_id;
    }

}