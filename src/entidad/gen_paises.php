<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_paises extends Parse
{
    private $c_pais;
    private $nombre;
    private $dias_estimados;

    function __construct()
    {
        $this->c_pais = '';
        $this->nombre = '';
        $this->dias_estimados = '';
    }

    public function setC_pais($c_pais)
    {
        if(empty($c_pais)) return;
        $this->c_pais = self::Clean($c_pais);
    }

    public function getC_pais()
    {
        return $this->c_pais;
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

    public function setDias_estimados($dias_estimados)
    {
        if(empty($dias_estimados)) return;
        $this->dias_estimados = self::Clean($dias_estimados);
    }

    public function getDias_estimados()
    {
        return $this->dias_estimados;
    }

}