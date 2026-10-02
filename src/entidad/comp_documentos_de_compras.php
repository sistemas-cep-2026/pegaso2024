<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class comp_documentos_de_compras extends Parse
{
    private $cc_compra;
    private $flag;
    private $cc_persona;
    private $registro;
    private $flag_cancelado;
    private $flag_contabilidad;
    private $cc_asiento;
    private $cod_documento;
    private $num_documento;
    private $fecha_documento;
    private $fecha_registro;
    private $observacion;
    private $cod_ano;
    private $cod_mes;
    private $total;
    private $porcentaje;
    private $igv;
    private $cc_caja;
    private $cc_local;
    private $fecha_vencimiento;
    private $user_crea;
    private $fech_crea;
    private $user_mod;
    private $fech_mod;
    private $opc;
    private $tc;
    private $detraccion;
    private $cc_detraccion;
    private $cc_detraccion_por;
    private $moneda;
    private $c_liquidacion_caja_chica;
    private $c_local;

    private $desde;
    private $hasta;
    private $cliente;
    private $ruc;
    private $escajachica;
    private $razon_social;
    private $tipo;
    private $comprobante;

    private $tipo_desc;
    private $reten_numero;
    private $reten_fecha;

    function __construct()
    {
        $this->cc_compra = 0;
        $this->flag = '';
        $this->flag_cancelado = '';
        $this->cc_persona = 0;
        $this->registro = 0;
        $this->flag_contabilidad = '';
        $this->cc_asiento = 0;
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->fecha_documento = '';
        $this->fecha_registro = '';
        $this->observacion = '';
        $this->cod_ano = '';
        $this->cod_mes = '';
        $this->total = 0;
        $this->porcentaje = 0;
        $this->igv = 0;
        $this->cc_caja = 0;
        $this->cc_local = 0;
        $this->fecha_vencimiento = '';
        $this->user_crea = '';
        $this->fech_crea = '';
        $this->user_mod = '';
        $this->fech_mod = '';
        $this->opc = '';
        $this->tc = '';
        $this->detraccion = '';
        $this->cc_detraccion = 0;
        $this->cc_detraccion_por = 0;
        $this->moneda = '';
        $this->c_local = '';

        $this->desde = "";
        $this->hasta = "";
        $this->cliente = "";
        $this->ruc = "";
        $this->escajachica = 0;
        $this->razon_social = '';
        $this->tipo = '';
        $this->c_liquidacion_caja_chica = '';
        $this->comprobante = '';

        $this->tipo_desc = '';
        $this->reten_numero = '';
        $this->reten_fecha = '';
    }

    public function setCc_compra($cc_compra)
    {
        if (empty($cc_compra)) return;
        $this->cc_compra = self::Clean($cc_compra);
    }

    public function getCc_compra()
    {
        return $this->cc_compra;
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
    public function setFlag_cancelado($flag_cancelado)
    {
        if (empty($flag_cancelado)) return;
        $this->flag_cancelado = self::Clean($flag_cancelado);
    }

    public function getFlag_cancelado()
    {
        return $this->flag_cancelado;
    }
    public function setCc_persona($cc_persona)
    {
        if (empty($cc_persona)) return;
        $this->cc_persona = self::Clean($cc_persona);
    }

    public function getCc_persona()
    {
        return $this->cc_persona;
    }

    public function setRegistro($registro)
    {
        if (empty($registro)) return;
        $this->registro = self::Clean($registro);
    }

    public function getRegistro()
    {
        return $this->registro;
    }

    public function setFlag_contabilidad($flag_contabilidad)
    {
        if (empty($flag_contabilidad)) return;
        $this->flag_contabilidad = self::Clean($flag_contabilidad);
    }

    public function getFlag_contabilidad()
    {
        return $this->flag_contabilidad;
    }

    public function setCc_asiento($cc_asiento)
    {
        if (empty($cc_asiento)) return;
        $this->cc_asiento = self::Clean($cc_asiento);
    }

    public function getCc_asiento()
    {
        return $this->cc_asiento;
    }

    public function setCod_documento($cod_documento)
    {
        if (empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento()
    {
        return $this->cod_documento;
    }

    public function setNum_documento($num_documento)
    {
        if (empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
    }

    public function setFecha_documento($fecha_documento)
    {
        if (empty($fecha_documento)) return;
        $this->fecha_documento = self::Clean($fecha_documento);
    }

    public function getFecha_documento()
    {
        return $this->fecha_documento;
    }

    public function setFecha_registro($fecha_registro)
    {
        if (empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }

    public function setObservacion($observacion)
    {
        if (empty($observacion)) return;
        $this->observacion = self::Clean($observacion);
    }

    public function getObservacion()
    {
        return $this->observacion;
    }

    public function setCod_ano($cod_ano)
    {
        if (empty($cod_ano)) return;
        $this->cod_ano = self::Clean($cod_ano);
    }

    public function getCod_ano()
    {
        return $this->cod_ano;
    }

    public function setCod_mes($cod_mes)
    {
        if (empty($cod_mes)) return;
        $this->cod_mes = self::Clean($cod_mes);
    }

    public function getCod_mes()
    {
        return $this->cod_mes;
    }

    public function setTotal($total)
    {
        if (empty($total)) return;
        $this->total = self::Clean($total);
    }

    public function getTotal()
    {
        return $this->total;
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

    public function setIgv($igv)
    {
        if (empty($igv)) return;
        $this->igv = self::Clean($igv);
    }

    public function getIgv()
    {
        return $this->igv;
    }

    public function setCc_caja($cc_caja)
    {
        if (empty($cc_caja)) return;
        $this->cc_caja = self::Clean($cc_caja);
    }

    public function getCc_caja()
    {
        return $this->cc_caja;
    }

    public function setCc_local($cc_local)
    {
        if (empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }

    public function getCc_local()
    {
        return $this->cc_local;
    }

    public function setFecha_vencimiento($fecha_vencimiento)
    {
        if (empty($fecha_vencimiento)) return;
        $this->fecha_vencimiento = self::Clean($fecha_vencimiento);
    }

    public function getFecha_vencimiento()
    {
        return $this->fecha_vencimiento;
    }

    public function setUser_crea($user_crea)
    {
        if (empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setFech_crea($fech_crea)
    {
        if (empty($fech_crea)) return;
        $this->fech_crea = self::Clean($fech_crea);
    }

    public function getFech_crea()
    {
        return $this->fech_crea;
    }

    public function setUser_mod($user_mod)
    {
        if (empty($user_mod)) return;
        $this->user_mod = self::Clean($user_mod);
    }

    public function getUser_mod()
    {
        return $this->user_mod;
    }

    public function setFech_mod($fech_mod)
    {
        if (empty($fech_mod)) return;
        $this->fech_mod = self::Clean($fech_mod);
    }

    public function getFech_mod()
    {
        return $this->fech_mod;
    }


    public function setOpc($opc)
    {
        if (empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }

    public function setTc($tc)
    {
        if (empty($tc)) return;
        $this->tc = self::Clean($tc);
    }

    public function getTc()
    {
        return $this->tc;
    }

    public function setDetraccion($detraccion)
    {
        if (empty($detraccion)) return;
        $this->detraccion = self::Clean($detraccion);
    }

    public function getDetraccion()
    {
        return $this->detraccion;
    }


    public function setCc_detraccion($cc_detraccion)
    {
        if (empty($cc_detraccion)) return;
        $this->cc_detraccion = self::Clean($cc_detraccion);
    }

    public function getCc_detraccion()
    {
        return $this->cc_detraccion;
    }

    public function setCc_detraccion_por($cc_detraccion_por)
    {
        if (empty($cc_detraccion_por)) return;
        $this->cc_detraccion_por = self::Clean($cc_detraccion_por);
    }

    public function getCc_detraccion_por()
    {
        return $this->cc_detraccion_por;
    }

    public function setMoneda($moneda)
    {
        if (empty($moneda)) return;
        $this->moneda = self::Clean($moneda);
    }

    public function getMoneda()
    {
        return $this->moneda;
    }

    public function setDesde($desde)
    {
        if (empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function setHasta($hasta)
    {
        if (empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta()
    {
        return $this->hasta;
    }

    public function setCliente($cliente)
    {
        if (empty($cliente)) return;
        $this->cliente = self::Clean($cliente);
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setRuc($ruc)
    {
        if (empty($ruc)) return;
        $this->ruc = self::Clean($ruc);
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function setEscajachica($escajachica)
    {
        if (empty($escajachica)) return;
        $this->escajachica = self::Clean($escajachica);
    }

    public function getEscajachica()
    {
        return $this->escajachica;
    }

    public function setRazon_social($razon_social)
    {
        if (empty($razon_social)) return;
        $this->razon_social = self::Clean($razon_social);
    }

    public function getRazon_social()
    {
        return $this->razon_social;
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

    public function setC_liquidacion_caja_chica($c_liquidacion_caja_chica)
    {
        if (empty($c_liquidacion_caja_chica)) return;
        $this->c_liquidacion_caja_chica = self::Clean($c_liquidacion_caja_chica);
    }

    public function getC_liquidacion_caja_chica()
    {
        return $this->c_liquidacion_caja_chica;
    }

    public function setComprobante($comprobante)
    {
        if (empty($comprobante)) return;
        $this->comprobante = self::Clean($comprobante);
    }

    public function getComprobante()
    {
        return $this->comprobante;
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

    public function setTipo_desc($tipo_desc)
    {
        if (empty($tipo_desc)) return;
        $this->tipo_desc = self::Clean($tipo_desc);
    }

    public function getTipo_desc()
    {
        return $this->tipo_desc;
    }
    public function setReten_numero($reten_numero)
    {
        if (empty($reten_numero)) return;
        $this->reten_numero = self::Clean($reten_numero);
    }

    public function getReten_numero()
    {
        return $this->reten_numero;
    }
    public function setReten_fecha($reten_fecha)
    {
        if (empty($reten_fecha)) return;
        $this->reten_fecha = self::Clean($reten_fecha);
    }

    public function getReten_fecha()
    {
        return $this->reten_fecha;
    }
}
