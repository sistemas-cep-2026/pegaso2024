<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class alm_items_guias_de_salida extends Parse
{
    private $cc_guia_det;
    private $cc_guia;
    private $c_articulo;
    private $cantidad;
    private $stock_actual;

    function __construct()
    {
        $this->cc_guia_det = 0;
        $this->cc_guia = 0;
        $this->c_articulo = '';
        $this->cantidad = '';
        $this->stock_actual = '';
    }
    public function setCc_guia_det($cc_guia_det)
    {
        if (empty($cc_guia_det)) return;
        $this->cc_guia_det = self::Clean($cc_guia_det);
    }

    public function getCc_guia_det()
    {
        return $this->cc_guia_det;
    }

    public function setCc_guia($cc_guia)
    {
        if (empty($cc_guia)) return;
        $this->cc_guia = self::Clean($cc_guia);
    }

    public function getCc_guia()
    {
        return $this->cc_guia;
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

    public function setCantidad($cantidad)
    {
        if (empty($cantidad)) return;
        $this->cantidad = self::Clean($cantidad);
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setStockactual($stock_actual)
    {
     if (empty($stock_actual)) return;
     $this->stock_actual = self::Clean($stock_actual);
 }

 public function getStockactual()
 {
    return $this->stock_actual;
}
}