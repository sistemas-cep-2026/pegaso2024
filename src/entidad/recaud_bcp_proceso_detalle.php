<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class recaud_bcp_proceso_detalle extends Parse
{
    private $id;
    private $codigo_depositante;
    private $dato_adicional;
    private $fecha;
    private $monto;
    private $referencia;
    private $hora;
    private $operacion_canal;
    private $c_local;
    private $c_persona;
    private $flag;
    private $porcentaje;
    private $total_distribuir;
    private $distribuir;
    private $fijoregion;
    private $region;
    private $nacional;
    private $numero_banco;
    private $fecha_id;

    private $tipo;
    private $periodo;

    function __construct()
    {
        $this->id = 0;
        $this->codigo_depositante = '';
        $this->dato_adicional = '';
        $this->fecha = '';
        $this->monto = '';
        $this->referencia = '';
        $this->hora = '';
        $this->operacion_canal = '';
        $this->c_local = '';
        $this->c_persona = '';
        $this->flag = '';
        $this->porcentaje = 0;
        $this->total_distribuir = 0;
        $this->distribuir = 0;
        $this->fijoregion = 0;
        $this->region = 0;
        $this->nacional = 0;
        $this->numero_banco = '';
        $this->fecha_id = '';

        $this->tipo = '';
        $this->periodo = '';
    }

    public function setId($id)
    {
        if (empty($id)) return;
        $this->id = self::Clean($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCodigo_depositante($codigo_depositante)
    {
        if (empty($codigo_depositante)) return;
        $this->codigo_depositante = self::Clean($codigo_depositante);
    }

    public function getCodigo_depositante()
    {
        return $this->codigo_depositante;
    }

    public function setDato_adicional($dato_adicional)
    {
        if (empty($dato_adicional)) return;
        $this->dato_adicional = self::Clean($dato_adicional);
    }

    public function getDato_adicional()
    {
        return $this->dato_adicional;
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

    public function setMonto($monto)
    {
        if (empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setReferencia($referencia)
    {
        if (empty($referencia)) return;
        $this->referencia = self::Clean($referencia);
    }

    public function getReferencia()
    {
        return $this->referencia;
    }

    public function setHora($hora)
    {
        if (empty($hora)) return;
        $this->hora = self::Clean($hora);
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setOperacion_canal($operacion_canal)
    {
        if (empty($operacion_canal)) return;
        $this->operacion_canal = self::Clean($operacion_canal);
    }

    public function getOperacion_canal()
    {
        return $this->operacion_canal;
    }

    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setC_persona($c_persona)
    {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

    public function setFlag($flag)
    {
        if (empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function setPorcentaje($porcentaje)
    {
        if (empty($porcentaje)) return;
        $this->porcentaje = self::Clean($porcentaje);
    }

    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    public function setTotal_distribuir($total_distribuir)
    {
        if (empty($total_distribuir)) return;
        $this->total_distribuir = self::Clean($total_distribuir);
    }

    public function getTotal_distribuir()
    {
        return $this->total_distribuir;
    }

    public function setDistribuir($distribuir)
    {
        if (empty($distribuir)) return;
        $this->distribuir = self::Clean($distribuir);
    }

    public function getDistribuir()
    {
        return $this->distribuir;
    }

    public function setFijoregion($fijoregion)
    {
        if (empty($fijoregion)) return;
        $this->fijoregion = self::Clean($fijoregion);
    }

    public function getFijoregion()
    {
        return $this->fijoregion;
    }

    public function setRegion($region)
    {
        if (empty($region)) return;
        $this->region = self::Clean($region);
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setNacional($nacional)
    {
        if (empty($nacional)) return;
        $this->nacional = self::Clean($nacional);
    }

    public function getNacional()
    {
        return $this->nacional;
    }

    public function setNumero_banco($numero_banco)
    {
        if (empty($numero_banco)) return;
        $this->numero_banco = self::Clean($numero_banco);
    }

    public function getNumero_banco()
    {
        return $this->numero_banco;
    }

    public function setFecha_id($fecha_id)
    {
        if (empty($fecha_id)) return;
        $this->fecha_id = self::Clean($fecha_id);
    }

    public function getFecha_id()
    {
        return $this->fecha_id;
    }

    public function setTipo($tipo)
    {
        if (empty($tipo)) return;
        $this->tipo = self::Clean($tipo);
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setPeriodo($periodo)
    {
        if (empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }
}
