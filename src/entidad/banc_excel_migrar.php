<?php
require_once dirname(__DIR__) . '/security/Parse.php';

/**
 * PEGASO2024 — Entidad banc_excel_migrar
 * Tabla temporal/intermedia para migración de Excel
 * 
 * Campos (10 total):
 * - id: int IDENTITY (generado, no se importa)
 * - fecha: date
 * - numero_operacion: nchar(20)
 * - monto: decimal(10,2)
 * - referencia01: varchar(150)
 * - referencia02: varchar(150)
 * - cuenta_contable: char(10)
 * - banco: char(30)
 * - cuenta_bancaria: char(50)
 * - c_banco: char(6)
 * - num_banco: nvarchar(255)
 */
class banc_excel_migrar extends Parse
{
    private $id;
    private $fecha;
    private $numero_operacion;
    private $monto;
    private $referencia01;
    private $referencia02;
    private $cuenta_contable;
    private $banco;
    private $cuenta_bancaria;
    private $c_banco;
    private $num_banco;

    public function __construct()
    {
        $this->id = null;
        $this->fecha = '';
        $this->numero_operacion = '';
        $this->monto = 0;
        $this->referencia01 = '';
        $this->referencia02 = '';
        $this->cuenta_contable = '';
        $this->banco = '';
        $this->cuenta_bancaria = '';
        $this->c_banco = '';
        $this->num_banco = '';
    }

    // ═══════════════════════════════════════════════════════════════
    // GETTERS Y SETTERS
    // ═══════════════════════════════════════════════════════════════

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setNumero_operacion($numero_operacion)
    {
        if (empty($numero_operacion)) return;
        $this->numero_operacion = self::Clean($numero_operacion);
    }

    public function getNumero_operacion()
    {
        return $this->numero_operacion;
    }

    public function setMonto($monto)
    {
        if (empty($monto) && $monto !== 0 && $monto !== '0') return;
        $this->monto = floatval($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setReferencia01($referencia01)
    {
        if (empty($referencia01)) return;
        $this->referencia01 = self::Clean($referencia01);
    }

    public function getReferencia01()
    {
        return $this->referencia01;
    }

    public function setReferencia02($referencia02)
    {
        if (empty($referencia02)) return;
        $this->referencia02 = self::Clean($referencia02);
    }

    public function getReferencia02()
    {
        return $this->referencia02;
    }

    public function setCuenta_contable($cuenta_contable)
    {
        if (empty($cuenta_contable)) return;
        $this->cuenta_contable = self::Clean($cuenta_contable);
    }

    public function getCuenta_contable()
    {
        return $this->cuenta_contable;
    }

    public function setBanco($banco)
    {
        if (empty($banco)) return;
        $this->banco = self::Clean($banco);
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function setCuenta_bancaria($cuenta_bancaria)
    {
        if (empty($cuenta_bancaria)) return;
        $this->cuenta_bancaria = self::Clean($cuenta_bancaria);
    }

    public function getCuenta_bancaria()
    {
        return $this->cuenta_bancaria;
    }

    public function setC_banco($c_banco)
    {
        if (empty($c_banco)) return;
        $this->c_banco = self::Clean($c_banco);
    }

    public function getC_banco()
    {
        return $this->c_banco;
    }

    public function setNum_banco($num_banco)
    {
        if (empty($num_banco)) return;
        $this->num_banco = self::Clean($num_banco);
    }

    public function getNum_banco()
    {
        return $this->num_banco;
    }
}
