<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class web_tram_colegiacion_control extends Parse
{
    private $id;
    private $cc_usuario;
    private $fecha;
    private $c_persona;
    private $codigo;
    private $estado;
    private $detalle;

    function __construct()
    {
        $this->id = 0;
        $this->cc_usuario = '';
        $this->fecha = '';
        $this->c_persona = '';
        $this->codigo = '';
        $this->estado = '';
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

    public function setCc_usuario($cc_usuario)
    {
        if(empty($cc_usuario)) return;
        $this->cc_usuario = self::Clean($cc_usuario);
    }

    public function getCc_usuario()
    {
        return $this->cc_usuario;
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

    public function setCodigo($codigo)
    {
        if(empty($codigo)) return;
        $this->codigo = self::Clean($codigo);
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setEstado($estado)
    {
        if(empty($estado)) return;
        $this->estado = self::Clean($estado);
    }

    public function getEstado()
    {
        return $this->estado;
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