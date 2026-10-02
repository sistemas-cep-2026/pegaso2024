<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class recaud_excelbbva extends Parse
{
    private $nombre;
    private $codigo;
    private $obs;
    private $imp1;
    private $imp2;
    private $oficina;
    private $mov;
    private $fecha_pago;
    private $fecha_proceso;
    private $forma_pago;
    private $canal;

    function __construct()
    {
        $this->nombre = '';
        $this->codigo = '';
        $this->obs = '';
        $this->imp1 = '';
        $this->imp2 = '';
        $this->oficina = '';
        $this->mov = '';
        $this->fecha_pago = 0;
        $this->fecha_proceso = 0;
        $this->forma_pago = '';
        $this->canal = '';
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

    public function setCodigo($codigo)
    {
        if(empty($codigo)) return;
        $this->codigo = self::Clean($codigo);
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setObs($obs)
    {
        if(empty($obs)) return;
        $this->obs = self::Clean($obs);
    }

    public function getObs()
    {
        return $this->obs;
    }

    public function setImp1($imp1)
    {
        if(empty($imp1)) return;
        $this->imp1 = self::Clean($imp1);
    }

    public function getImp1()
    {
        return $this->imp1;
    }

    public function setImp2($imp2)
    {
        if(empty($imp2)) return;
        $this->imp2 = self::Clean($imp2);
    }

    public function getImp2()
    {
        return $this->imp2;
    }

    public function setOficina($oficina)
    {
        if(empty($oficina)) return;
        $this->oficina = self::Clean($oficina);
    }

    public function getOficina()
    {
        return $this->oficina;
    }

    public function setMov($mov)
    {
        if(empty($mov)) return;
        $this->mov = self::Clean($mov);
    }

    public function getMov()
    {
        return $this->mov;
    }

    public function setFecha_pago($fecha_pago)
    {
        if(empty($fecha_pago)) return;
        $this->fecha_pago = self::Clean($fecha_pago);
    }

    public function getFecha_pago()
    {
        return $this->fecha_pago;
    }

    public function setFecha_proceso($fecha_proceso)
    {
        if(empty($fecha_proceso)) return;
        $this->fecha_proceso = self::Clean($fecha_proceso);
    }

    public function getFecha_proceso()
    {
        return $this->fecha_proceso;
    }

    public function setForma_pago($forma_pago)
    {
        if(empty($forma_pago)) return;
        $this->forma_pago = self::Clean($forma_pago);
    }

    public function getForma_pago()
    {
        return $this->forma_pago;
    }

    public function setCanal($canal)
    {
        if(empty($canal)) return;
        $this->canal = self::Clean($canal);
    }

    public function getCanal()
    {
        return $this->canal;
    }

}