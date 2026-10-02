<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class recaud_excelbcp extends Parse
{
    private $codigo_depositante;
    private $dato_adicional;
    private $fecha;
    private $fecha_vencimiento;
    private $monto;
    private $mora;
    private $total;
    private $sucursal;
    private $numero_operacion;
    private $referencia;
    private $terminal;
    private $medio;
    private $hora;
    private $cheque;
    private $codigo_banco;
    private $cargo;
    private $extorno;
    private $documento_pago;
    private $operacion_db;
    private $operacion_canal;

    function __construct()
    {
        $this->codigo_depositante = '';
        $this->dato_adicional = '';
        $this->fecha = '';
        $this->fecha_vencimiento = '';
        $this->monto = '';
        $this->mora = '';
        $this->total = '';
        $this->sucursal = '';
        $this->numero_operacion = '';
        $this->referencia = '';
        $this->terminal = '';
        $this->medio = '';
        $this->hora = '';
        $this->cheque = '';
        $this->codigo_banco = '';
        $this->cargo = '';
        $this->extorno = '';
        $this->documento_pago = '';
        $this->operacion_db = '';
        $this->operacion_canal = '';
    }

    public function setCodigo_depositante($codigo_depositante)
    {
        if(empty($codigo_depositante)) return;
        $this->codigo_depositante = self::Clean($codigo_depositante);
    }

    public function getCodigo_depositante()
    {
        return $this->codigo_depositante;
    }

    public function setDato_adicional($dato_adicional)
    {
        if(empty($dato_adicional)) return;
        $this->dato_adicional = self::Clean($dato_adicional);
    }

    public function getDato_adicional()
    {
        return $this->dato_adicional;
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

    public function setFecha_vencimiento($fecha_vencimiento)
    {
        if(empty($fecha_vencimiento)) return;
        $this->fecha_vencimiento = self::Clean($fecha_vencimiento);
    }

    public function getFecha_vencimiento()
    {
        return $this->fecha_vencimiento;
    }

    public function setMonto($monto)
    {
        if(empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setMora($mora)
    {
        if(empty($mora)) return;
        $this->mora = self::Clean($mora);
    }

    public function getMora()
    {
        return $this->mora;
    }

    public function setTotal($total)
    {
        if(empty($total)) return;
        $this->total = self::Clean($total);
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setSucursal($sucursal)
    {
        if(empty($sucursal)) return;
        $this->sucursal = self::Clean($sucursal);
    }

    public function getSucursal()
    {
        return $this->sucursal;
    }

    public function setNumero_operacion($numero_operacion)
    {
        if(empty($numero_operacion)) return;
        $this->numero_operacion = self::Clean($numero_operacion);
    }

    public function getNumero_operacion()
    {
        return $this->numero_operacion;
    }

    public function setReferencia($referencia)
    {
        if(empty($referencia)) return;
        $this->referencia = self::Clean($referencia);
    }

    public function getReferencia()
    {
        return $this->referencia;
    }

    public function setTerminal($terminal)
    {
        if(empty($terminal)) return;
        $this->terminal = self::Clean($terminal);
    }

    public function getTerminal()
    {
        return $this->terminal;
    }

    public function setMedio($medio)
    {
        if(empty($medio)) return;
        $this->medio = self::Clean($medio);
    }

    public function getMedio()
    {
        return $this->medio;
    }

    public function setHora($hora)
    {
        if(empty($hora)) return;
        $this->hora = self::Clean($hora);
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setCheque($cheque)
    {
        if(empty($cheque)) return;
        $this->cheque = self::Clean($cheque);
    }

    public function getCheque()
    {
        return $this->cheque;
    }

    public function setCodigo_banco($codigo_banco)
    {
        if(empty($codigo_banco)) return;
        $this->codigo_banco = self::Clean($codigo_banco);
    }

    public function getCodigo_banco()
    {
        return $this->codigo_banco;
    }

    public function setCargo($cargo)
    {
        if(empty($cargo)) return;
        $this->cargo = self::Clean($cargo);
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setExtorno($extorno)
    {
        if(empty($extorno)) return;
        $this->extorno = self::Clean($extorno);
    }

    public function getExtorno()
    {
        return $this->extorno;
    }

    public function setDocumento_pago($documento_pago)
    {
        if(empty($documento_pago)) return;
        $this->documento_pago = self::Clean($documento_pago);
    }

    public function getDocumento_pago()
    {
        return $this->documento_pago;
    }

    public function setOperacion_db($operacion_db)
    {
        if(empty($operacion_db)) return;
        $this->operacion_db = self::Clean($operacion_db);
    }

    public function getOperacion_db()
    {
        return $this->operacion_db;
    }

    public function setOperacion_canal($operacion_canal)
    {
        if(empty($operacion_canal)) return;
        $this->operacion_canal = self::Clean($operacion_canal);
    }

    public function getOperacion_canal()
    {
        return $this->operacion_canal;
    }

}