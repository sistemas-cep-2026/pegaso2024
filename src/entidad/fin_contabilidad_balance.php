<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_contabilidad_balance extends Parse
{
    private $cc_local;
    private $anho;
    private $desde;
    private $hasta;
    private $version;
    private $digitos;
    
    function __construct()
    {
        $this->cc_local='';
        $this->anho='';
        $this->desde='';
        $this->hasta='';
        $this->version='';
        $this->digitos='';
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

    public function setAnho($anho)
    {
        if (empty($anho)) return;
        $this->anho = self::Clean($anho);
    }

    public function getAnho() 
    {
        return $this->anho;
    }
    public function setDesde($desde)
    {
        if (empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde() 
    {
        return $this->desde;
    }
    public function setHasta($hasta)
    {
        if (empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta() 
    {
        return $this->hasta;
    }
    public function setVersion($version)
    {
        if (empty($version)) return;
        $this->version = self::Clean($version);
    }

    public function getVersion() 
    {
        return $this->version;
    }
    public function setDigitos($digitos)
    {
        if (empty($digitos)) return;
        $this->digitos = self::Clean($digitos);
    }

    public function getDigitos() 
    {
        return $this->digitos;
    }

}