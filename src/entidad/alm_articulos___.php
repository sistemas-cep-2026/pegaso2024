<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class alm_articulos extends Parse
{
private $c_articulo; 
private $cantidad;
private $stock_actual;
private $c_local;

private $nombre;
    

    function __construct()
    {
        $this->c_articulo=0;
        $this->cantidad='';
        $this->stock_actual='';
        $this->c_local='';

        $this->nombre='';
    }

    public function setC_articulo($c_articulo)
    {
        if (empty($c_articulo)) return;
        $this->c_articulo = self::Clean($c_articulo);
    }

    public function getC_articulo() 
    {
        return $this->c_articulo;
    }

    public function setC_local($c_local) 
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local() 
    {
        return $this->c_local;
    }

    public function setCantidad($cantidad) 
    {
        if (empty($cantidad)) return;
        $this->cantidad = self::Clean($cantidad);
    }

    public function getCantidad() 
    {
        return $this->cantidad;
    }

    public function setStock_actual($stock_actual) 
    {
        if (empty($stock_actual)) return;
        $this->stock_actual = self::Clean($stock_actual);
    }

    public function getStock_actual() 
    {
        return $this->stock_actual;
    }

    public function setNombre($nombre) 
    {
        if (empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre() 
    {
        return $this->nombre;
    }

}