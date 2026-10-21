<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class recaud_bcp_detalle extends Parse
{
    private $ID;
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
    private $c_local;
    private $c_persona;
    private $flag;
    private $registro_bancos;
    private $porcentaje;
    private $total_distribuir;
    private $distribuir;
    private $fijoregion;
    private $region;
    private $nacional;
    private $fechax;
    private $numero_banco;

    private $tipo;
    private $perido;

    function __construct()
    {
        $this->ID = 0;
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
        $this->c_local = '';
        $this->c_persona = '';
        $this->flag = '';
        $this->registro_bancos = '';
        $this->porcentaje = 0;
        $this->total_distribuir = 0;
        $this->distribuir = 0;
        $this->fijoregion = 0;
        $this->region = 0;
        $this->nacional = 0;
        $this->fechax = '';
        $this->numero_banco = '';

        $this->tipo='';
        $this->periodo='';
    }

    public function setID($ID)
    {
        if(empty($ID)) return;
        $this->ID = self::Clean($ID);
    }

    public function getID()
    {
        return $this->ID;
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

    public function setC_local($c_local)
    {
        if(empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
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

    public function setFlag($flag)
    {
        if(empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function setRegistro_bancos($registro_bancos)
    {
        if(empty($registro_bancos)) return;
        $this->registro_bancos = self::Clean($registro_bancos);
    }

    public function getRegistro_bancos()
    {
        return $this->registro_bancos;
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

    public function setTotal_distribuir($total_distribuir)
    {
        if(empty($total_distribuir)) return;
        $this->total_distribuir = self::Clean($total_distribuir);
    }

    public function getTotal_distribuir()
    {
        return $this->total_distribuir;
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

    public function setNumero_banco($numero_banco)
    {
        if(empty($numero_banco)) return;
        $this->numero_banco = self::Clean($numero_banco);
    }

    public function getNumero_banco()
    {
        return $this->numero_banco;
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

    public function setPeriodo($periodo)
    {
        if(empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

}