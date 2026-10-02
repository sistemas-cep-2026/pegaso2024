<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class alm_items_requisicion extends Parse
{
    private $c_articulo;
    private $cantidad;
    
    private $cc_requisicion_det;
    private $cc_requisicion;

    

    function __construct()
    {
        $this->c_articulo = '';
        $this->cantidad = '';
        
        $this->cc_requisicion_det = 0;
        $this->cc_requisicion = 0;
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

    
    public function setCc_requisicion_det($cc_requisicion_det)
    {
        if (empty($cc_requisicion_det)) return;
        $this->cc_requisicion_det = self::Clean($cc_requisicion_det);
    }
    public function getCc_requisicion_det()
    {
        return $this->cc_requisicion_det;
    }

    
    public function setCc_requisicion($cc_requisicion)
    {
        if (empty($cc_requisicion)) return;
        $this->cc_requisicion = self::Clean($cc_requisicion);
    }
    public function getCc_requisicion()
    {
        return $this->cc_requisicion;
    }

    
    
}