<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class bbva_proceso_detalle extends Parse
{
    private $tipo;
    private $nombre;
    private $referencia1;
    private $referencia2;
    private $importe1;
    private $importe2;
    private $mora;
    private $oficina;
    private $num_movimiento;
    private $fecha_pago;
    private $tipo_valor;
    private $entrada;
    private $vacio;
    private $fecha_proceso_id;
    private $op1;
    private $c_local;
    private $flag;
    private $porcentaje;
    private $total;
    private $distribuir;
    private $fijoregion;
    private $region;
    private $nacional;
    private $fechax;
    private $recaudo;
    private $c_persona;
    private $num_banco;
    private $id;
    private $fijocn;
    private $fecha_id;
    private $flag_tramite;
    private $adicional;

    function __construct()
    {
        $this->tipo = '';
        $this->nombre = '';
        $this->referencia1 = '';
        $this->referencia2 = '';
        $this->importe1 = '';
        $this->importe2 = '';
        $this->mora = '';
        $this->oficina = '';
        $this->num_movimiento = '';
        $this->fecha_pago = '';
        $this->tipo_valor = '';
        $this->entrada = '';
        $this->vacio = '';
        $this->fecha_proceso_id = '';
        $this->op1 = '';
        $this->c_local = '';
        $this->flag = '';
        $this->porcentaje = 0;
        $this->total = 0;
        $this->distribuir = 0;
        $this->fijoregion = 0;
        $this->region = 0;
        $this->nacional = 0;
        $this->fechax = '';
        $this->recaudo = '';
        $this->c_persona = '';
        $this->num_banco = '';
        $this->id = 0;
        $this->fijocn = 0;
        $this->fecha_id = '';
        $this->flag_tramite = '';
        $this->adicional = '';
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

    public function setNombre($nombre)
    {
        if(empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setReferencia1($referencia1)
    {
        if(empty($referencia1)) return;
        $this->referencia1 = self::Clean($referencia1);
    }

    public function getReferencia1()
    {
        return $this->referencia1;
    }

    public function setReferencia2($referencia2)
    {
        if(empty($referencia2)) return;
        $this->referencia2 = self::Clean($referencia2);
    }

    public function getReferencia2()
    {
        return $this->referencia2;
    }

    public function setImporte1($importe1)
    {
        if(empty($importe1)) return;
        $this->importe1 = self::Clean($importe1);
    }

    public function getImporte1()
    {
        return $this->importe1;
    }

    public function setImporte2($importe2)
    {
        if(empty($importe2)) return;
        $this->importe2 = self::Clean($importe2);
    }

    public function getImporte2()
    {
        return $this->importe2;
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

    public function setOficina($oficina)
    {
        if(empty($oficina)) return;
        $this->oficina = self::Clean($oficina);
    }

    public function getOficina()
    {
        return $this->oficina;
    }

    public function setNum_movimiento($num_movimiento)
    {
        if(empty($num_movimiento)) return;
        $this->num_movimiento = self::Clean($num_movimiento);
    }

    public function getNum_movimiento()
    {
        return $this->num_movimiento;
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

    public function setTipo_valor($tipo_valor)
    {
        if(empty($tipo_valor)) return;
        $this->tipo_valor = self::Clean($tipo_valor);
    }

    public function getTipo_valor()
    {
        return $this->tipo_valor;
    }

    public function setEntrada($entrada)
    {
        if(empty($entrada)) return;
        $this->entrada = self::Clean($entrada);
    }

    public function getEntrada()
    {
        return $this->entrada;
    }

    public function setVacio($vacio)
    {
        if(empty($vacio)) return;
        $this->vacio = self::Clean($vacio);
    }

    public function getVacio()
    {
        return $this->vacio;
    }

    public function setFecha_proceso_id($fecha_proceso_id)
    {
        if(empty($fecha_proceso_id)) return;
        $this->fecha_proceso_id = self::Clean($fecha_proceso_id);
    }

    public function getFecha_proceso_id()
    {
        return $this->fecha_proceso_id;
    }

    public function setOp1($op1)
    {
        if(empty($op1)) return;
        $this->op1 = self::Clean($op1);
    }

    public function getOp1()
    {
        return $this->op1;
    }

    public function setC_local($c_local)
    {
        if(empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
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

    public function setPorcentaje($porcentaje)
    {
        if(empty($porcentaje)) return;
        $this->porcentaje = self::Clean($porcentaje);
    }

    public function getPorcentaje()
    {
        return $this->porcentaje;
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

    public function setDistribuir($distribuir)
    {
        if(empty($distribuir)) return;
        $this->distribuir = self::Clean($distribuir);
    }

    public function getDistribuir()
    {
        return $this->distribuir;
    }

    public function setFijoregion($fijoregion)
    {
        if(empty($fijoregion)) return;
        $this->fijoregion = self::Clean($fijoregion);
    }

    public function getFijoregion()
    {
        return $this->fijoregion;
    }

    public function setRegion($region)
    {
        if(empty($region)) return;
        $this->region = self::Clean($region);
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setNacional($nacional)
    {
        if(empty($nacional)) return;
        $this->nacional = self::Clean($nacional);
    }

    public function getNacional()
    {
        return $this->nacional;
    }

    public function setFechax($fechax)
    {
        if(empty($fechax)) return;
        $this->fechax = self::Clean($fechax);
    }

    public function getFechax()
    {
        return $this->fechax;
    }

    public function setRecaudo($recaudo)
    {
        if(empty($recaudo)) return;
        $this->recaudo = self::Clean($recaudo);
    }

    public function getRecaudo()
    {
        return $this->recaudo;
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

    public function setNum_banco($num_banco)
    {
        if(empty($num_banco)) return;
        $this->num_banco = self::Clean($num_banco);
    }

    public function getNum_banco()
    {
        return $this->num_banco;
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

    public function setFijocn($fijocn)
    {
        if(empty($fijocn)) return;
        $this->fijocn = self::Clean($fijocn);
    }

    public function getFijocn()
    {
        return $this->fijocn;
    }

    public function setFecha_id($fecha_id)
    {
        if(empty($fecha_id)) return;
        $this->fecha_id = self::Clean($fecha_id);
    }

    public function getFecha_id()
    {
        return $this->fecha_id;
    }

    public function setFlag_tramite($flag_tramite)
    {
        if(empty($flag_tramite)) return;
        $this->flag_tramite = self::Clean($flag_tramite);
    }

    public function getFlag_tramite()
    {
        return $this->flag_tramite;
    }

    public function setAdicional($adicional)
    {
        if(empty($adicional)) return;
        $this->adicional = self::Clean($adicional);
    }

    public function getAdicional()
    {
        return $this->adicional;
    }

}