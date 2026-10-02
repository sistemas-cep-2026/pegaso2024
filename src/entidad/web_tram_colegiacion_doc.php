<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class web_tram_colegiacion_doc extends Parse
{
    private $id;
    private $fecha;
    private $c_persona;
    private $tipo;
    private $archivo;
    private $detalle;

    function __construct()
    {
        $this->id = 0;
        $this->fecha = '';
        $this->c_persona = '';
        $this->tipo = '';
        $this->archivo = '';
        $this->detalle = '';
    }

    public function setId($id)
    {
        if(empty($id)) return;
        $this->id = self::Clean($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
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

    public function setTipo($tipo)
    {
        if(empty($tipo)) return;
        $this->tipo = self::Clean($tipo);
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setArchivo($archivo)
    {
        if(empty($archivo)) return;
        $this->archivo = self::Clean($archivo);
    }

    public function getArchivo()
    {
        return $this->archivo;
    }

    public function setDetalle($detalle)
    {
        if(empty($detalle)) return;
        $this->detalle = self::Clean($detalle);
    }

    public function getDetalle()
    {
        return $this->detalle;
    }

}