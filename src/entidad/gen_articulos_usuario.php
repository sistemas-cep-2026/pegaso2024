<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_articulos_usuario extends Parse
{
    private $c_usuario;
    private $c_articulo;
    private $flag;

    function __construct()
    {
        $this->c_usuario = '';
        $this->c_articulo = '';
        $this->flag = '';
    }

    public function setC_usuario($c_usuario)
    {
        if(empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
    }

    public function setC_articulo($c_articulo)
    {
        if(empty($c_articulo)) return;
        $this->c_articulo = self::Clean($c_articulo);
    }

    public function getC_articulo()
    {
        return $this->c_articulo;
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