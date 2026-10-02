<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_documentos_recaudo extends Parse
{
    private $c_doc;
    private $c_expediente;
    private $c_persona;
    private $fecha_registro;
    private $id_recaudo_bbva;
    private $banco;
    private $operacion;
    private $fecha_op;
    private $monto;
    private $banco2;
    private $operacion2;
    private $fecha_op2;
    private $monto2;
    private $cod_tram_recaudo;
    private $obs;
    private $c_usuario_ingreso;
    private $fecha_ingreso;

    private $desde;
    private $hasta;

    function __construct()
    {
        $this->c_doc = 0;
        $this->c_expediente = '';
        $this->c_persona = '';
        $this->fecha_registro = '';
        $this->id_recaudo_bbva = 0;
        $this->banco = '';
        $this->operacion = '';
        $this->fecha_op = '';
        $this->monto = 0;
        $this->banco2 = '';
        $this->operacion2 = '';
        $this->fecha_op2 = '';
        $this->monto2 = 0;
        $this->cod_tram_recaudo = '';
        $this->obs = '';
        $this->c_usuario_ingreso = '';
        $this->fecha_ingreso = '';

        $this->desde = '';
        $this->hasta = '';
    }

    public function setC_doc($c_doc)
    {
        if(empty($c_doc)) return;
        $this->c_doc = self::Clean($c_doc);
    }

    public function getC_doc()
    {
        return $this->c_doc;
    }

    public function setC_expediente($c_expediente)
    {
        if(empty($c_expediente)) return;
        $this->c_expediente = self::Clean($c_expediente);
    }

    public function getC_expediente()
    {
        return $this->c_expediente;
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

    public function setFecha_registro($fecha_registro)
    {
        if(empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    public function setId_recaudo_bbva($id_recaudo_bbva)
    {
        if(empty($id_recaudo_bbva)) return;
        $this->id_recaudo_bbva = self::Clean($id_recaudo_bbva);
    }

    public function getId_recaudo_bbva()
    {
        return $this->id_recaudo_bbva;
    }

    public function setBanco($banco)
    {
        if(empty($banco)) return;
        $this->banco = self::Clean($banco);
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function setOperacion($operacion)
    {
        if(empty($operacion)) return;
        $this->operacion = self::Clean($operacion);
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

    public function setFecha_op($fecha_op)
    {
        if(empty($fecha_op)) return;
        $this->fecha_op = self::Clean($fecha_op);
    }

    public function getFecha_op()
    {
        return $this->fecha_op;
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

    public function setBanco2($banco2)
    {
        if(empty($banco2)) return;
        $this->banco2 = self::Clean($banco2);
    }

    public function getBanco2()
    {
        return $this->banco2;
    }

    public function setOperacion2($operacion2)
    {
        if(empty($operacion2)) return;
        $this->operacion2 = self::Clean($operacion2);
    }

    public function getOperacion2()
    {
        return $this->operacion2;
    }

    public function setFecha_op2($fecha_op2)
    {
        if(empty($fecha_op2)) return;
        $this->fecha_op2 = self::Clean($fecha_op2);
    }

    public function getFecha_op2()
    {
        return $this->fecha_op2;
    }

    public function setMonto2($monto2)
    {
        if(empty($monto2)) return;
        $this->monto2 = self::Clean($monto2);
    }

    public function getMonto2()
    {
        return $this->monto2;
    }

    public function setCod_tram_recaudo($cod_tram_recaudo)
    {
        if(empty($cod_tram_recaudo)) return;
        $this->cod_tram_recaudo = self::Clean($cod_tram_recaudo);
    }

    public function getCod_tram_recaudo()
    {
        return $this->cod_tram_recaudo;
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

    public function setC_usuario_ingreso($c_usuario_ingreso)
    {
        if(empty($c_usuario_ingreso)) return;
        $this->c_usuario_ingreso = self::Clean($c_usuario_ingreso);
    }

    public function getC_usuario_ingreso()
    {
        return $this->c_usuario_ingreso;
    }

    public function setFecha_ingreso($fecha_ingreso)
    {
        if(empty($fecha_ingreso)) return;
        $this->fecha_ingreso = self::Clean($fecha_ingreso);
    }

    public function getFecha_ingreso()
    {
        return $this->fecha_ingreso;
    }


    public function setDesde($desde)
    {
        if(empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function setHasta($hasta)
    {
        if(empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta()
    {
        return $this->hasta;
    }

}