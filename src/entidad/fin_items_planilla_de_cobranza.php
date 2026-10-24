<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_items_planilla_de_cobranza extends Parse
{
    private $cc_itemplanilla;
    private $cc_ventas;
    private $c_planilla_cobranza;
    private $cod_ingr_egre;
    private $c_cuenta;
    private $cod_documento;
    private $num_documento;
    private $fecha;
    private $cod_forma_de_pago;
    private $monto;
    private $monto_aplicado;
    private $num_referencia;
    private $fecha_referencia;
    private $c_banco_ref;
    private $cta_cte_deposito;
    private $c_usuario;
    private $flag_automatico;
    private $flag_anulado;
    private $flag_adelanto;
    private $flag_aplicado;
    private $linea;
    private $observacion;
    private $c_operacion;
    private $cod_oficina_cobrador;
    private $c_persona;
    private $tipo_de_cambio;
    private $cod_moneda;
    private $c_tarjeta_de_credito;
    private $c_banco;
    private $c_cta_corriente;
    private $c_vendedor;
    private $flag_rebotado;
    private $flag_con_facturas;
    private $num_comprobante;
    private $linea_de_ref;
    private $c_planilla_diferido;
    private $linea_diferido;
    private $c_cobrador;
    private $cod_diferido;
    private $voucher;
    private $dif_cambio;
    private $c_operacion_dif_cambio;
    private $tipo_de_cambio_actualizacion;
    private $flag_voucher;
    private $flag_voucher_letras;
    private $t_cancelacion;
    private $flag_canje;
    private $tipo_pago;
    private $monto_pago;
    private $cod_documento_ref;
    private $num_documento_ref;
    private $c_usuario_anula;
    private $fecha_anula;
    private $num_cheque;
    private $c_banco_cheque;

    function __construct()
    {
        $this->cc_itemplanilla = 0;
        $this->cc_ventas = 0;
        $this->c_planilla_cobranza = '';
        $this->cod_ingr_egre = '';
        $this->c_cuenta = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->fecha = '';
        $this->cod_forma_de_pago = '';
        $this->monto = 0;
        $this->monto_aplicado = 0;
        $this->num_referencia = '';
        $this->fecha_referencia = '';
        $this->c_banco_ref = '';
        $this->cta_cte_deposito = '';
        $this->c_usuario = '';
        $this->flag_automatico = '';
        $this->flag_anulado = '';
        $this->flag_adelanto = '';
        $this->flag_aplicado = '';
        $this->linea = 0;
        $this->observacion = '';
        $this->c_operacion = '';
        $this->cod_oficina_cobrador = '';
        $this->c_persona = '';
        $this->tipo_de_cambio = 0;
        $this->cod_moneda = '';
        $this->c_tarjeta_de_credito = '';
        $this->c_banco = '';
        $this->c_cta_corriente = '';
        $this->c_vendedor = '';
        $this->flag_rebotado = '';
        $this->flag_con_facturas = '';
        $this->num_comprobante = '';
        $this->linea_de_ref = 0;
        $this->c_planilla_diferido = '';
        $this->linea_diferido = 0;
        $this->c_cobrador = '';
        $this->cod_diferido = '';
        $this->voucher = '';
        $this->dif_cambio = 0;
        $this->c_operacion_dif_cambio = '';
        $this->tipo_de_cambio_actualizacion = 0;
        $this->flag_voucher = '';
        $this->flag_voucher_letras = '';
        $this->t_cancelacion = '';
        $this->flag_canje = '';
        $this->tipo_pago = '';
        $this->monto_pago = 0;
        $this->cod_documento_ref = '';
        $this->num_documento_ref = '';
        $this->c_usuario_anula = '';
        $this->fecha_anula = '';
        $this->num_cheque = '';
        $this->c_banco_cheque = '';
    }

    public function setCc_itemplanilla($cc_itemplanilla)
    {
        if (empty($cc_itemplanilla)) return;
        $this->cc_itemplanilla = self::Clean($cc_itemplanilla);
    }

    public function getCc_itemplanilla()
    {
        return $this->cc_itemplanilla;
    }

    public function setCc_ventas($cc_ventas)
    {
        if (empty($cc_ventas)) return;
        $this->cc_ventas = self::Clean($cc_ventas);
    }

    public function getCc_ventas()
    {
        return $this->cc_ventas;
    }

    public function setC_planilla_cobranza($c_planilla_cobranza)
    {
        if (empty($c_planilla_cobranza)) return;
        $this->c_planilla_cobranza = self::Clean($c_planilla_cobranza);
    }

    public function getC_planilla_cobranza()
    {
        return $this->c_planilla_cobranza;
    }

    public function setCod_ingr_egre($cod_ingr_egre)
    {
        if (empty($cod_ingr_egre)) return;
        $this->cod_ingr_egre = self::Clean($cod_ingr_egre);
    }

    public function getCod_ingr_egre()
    {
        return $this->cod_ingr_egre;
    }

    public function setC_cuenta($c_cuenta)
    {
        if (empty($c_cuenta)) return;
        $this->c_cuenta = self::Clean($c_cuenta);
    }

    public function getC_cuenta()
    {
        return $this->c_cuenta;
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

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setCod_forma_de_pago($cod_forma_de_pago)
    {
        if (empty($cod_forma_de_pago)) return;
        $this->cod_forma_de_pago = self::Clean($cod_forma_de_pago);
    }

    public function getCod_forma_de_pago()
    {
        return $this->cod_forma_de_pago;
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

    public function setMonto_aplicado($monto_aplicado)
    {
        if (empty($monto_aplicado)) return;
        $this->monto_aplicado = self::Clean($monto_aplicado);
    }

    public function getMonto_aplicado()
    {
        return $this->monto_aplicado;
    }

    public function setNum_referencia($num_referencia)
    {
        if (empty($num_referencia)) return;
        $this->num_referencia = self::Clean($num_referencia);
    }

    public function getNum_referencia()
    {
        return $this->num_referencia;
    }

    public function setFecha_referencia($fecha_referencia)
    {
        if (empty($fecha_referencia)) return;
        $this->fecha_referencia = self::Clean($fecha_referencia);
    }

    public function getFecha_referencia()
    {
        return $this->fecha_referencia;
    }

    public function setC_banco_ref($c_banco_ref)
    {
        if (empty($c_banco_ref)) return;
        $this->c_banco_ref = self::Clean($c_banco_ref);
    }

    public function getC_banco_ref()
    {
        return $this->c_banco_ref;
    }

    public function setCta_cte_deposito($cta_cte_deposito)
    {
        if (empty($cta_cte_deposito)) return;
        $this->cta_cte_deposito = self::Clean($cta_cte_deposito);
    }

    public function getCta_cte_deposito()
    {
        return $this->cta_cte_deposito;
    }

    public function setC_usuario($c_usuario)
    {
        if (empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
    }

    public function setFlag_automatico($flag_automatico)
    {
        if (empty($flag_automatico)) return;
        $this->flag_automatico = self::Clean($flag_automatico);
    }

    public function getFlag_automatico()
    {
        return $this->flag_automatico;
    }

    public function setFlag_anulado($flag_anulado)
    {
        if (empty($flag_anulado)) return;
        $this->flag_anulado = self::Clean($flag_anulado);
    }

    public function getFlag_anulado()
    {
        return $this->flag_anulado;
    }

    public function setFlag_adelanto($flag_adelanto)
    {
        if (empty($flag_adelanto)) return;
        $this->flag_adelanto = self::Clean($flag_adelanto);
    }

    public function getFlag_adelanto()
    {
        return $this->flag_adelanto;
    }

    public function setFlag_aplicado($flag_aplicado)
    {
        if (empty($flag_aplicado)) return;
        $this->flag_aplicado = self::Clean($flag_aplicado);
    }

    public function getFlag_aplicado()
    {
        return $this->flag_aplicado;
    }

    public function setLinea($linea)
    {
        if (empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
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

    public function setC_operacion($c_operacion)
    {
        if (empty($c_operacion)) return;
        $this->c_operacion = self::Clean($c_operacion);
    }

    public function getC_operacion()
    {
        return $this->c_operacion;
    }

    public function setCod_oficina_cobrador($cod_oficina_cobrador)
    {
        if (empty($cod_oficina_cobrador)) return;
        $this->cod_oficina_cobrador = self::Clean($cod_oficina_cobrador);
    }

    public function getCod_oficina_cobrador()
    {
        return $this->cod_oficina_cobrador;
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

    public function setTipo_de_cambio($tipo_de_cambio)
    {
        if (empty($tipo_de_cambio)) return;
        $this->tipo_de_cambio = self::Clean($tipo_de_cambio);
    }

    public function getTipo_de_cambio()
    {
        return $this->tipo_de_cambio;
    }

    public function setCod_moneda($cod_moneda)
    {
        if (empty($cod_moneda)) return;
        $this->cod_moneda = self::Clean($cod_moneda);
    }

    public function getCod_moneda()
    {
        return $this->cod_moneda;
    }

    public function setC_tarjeta_de_credito($c_tarjeta_de_credito)
    {
        if (empty($c_tarjeta_de_credito)) return;
        $this->c_tarjeta_de_credito = self::Clean($c_tarjeta_de_credito);
    }

    public function getC_tarjeta_de_credito()
    {
        return $this->c_tarjeta_de_credito;
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

    public function setC_cta_corriente($c_cta_corriente)
    {
        if (empty($c_cta_corriente)) return;
        $this->c_cta_corriente = self::Clean($c_cta_corriente);
    }

    public function getC_cta_corriente()
    {
        return $this->c_cta_corriente;
    }

    public function setC_vendedor($c_vendedor)
    {
        if (empty($c_vendedor)) return;
        $this->c_vendedor = self::Clean($c_vendedor);
    }

    public function getC_vendedor()
    {
        return $this->c_vendedor;
    }

    public function setFlag_rebotado($flag_rebotado)
    {
        if (empty($flag_rebotado)) return;
        $this->flag_rebotado = self::Clean($flag_rebotado);
    }

    public function getFlag_rebotado()
    {
        return $this->flag_rebotado;
    }

    public function setFlag_con_facturas($flag_con_facturas)
    {
        if (empty($flag_con_facturas)) return;
        $this->flag_con_facturas = self::Clean($flag_con_facturas);
    }

    public function getFlag_con_facturas()
    {
        return $this->flag_con_facturas;
    }

    public function setNum_comprobante($num_comprobante)
    {
        if (empty($num_comprobante)) return;
        $this->num_comprobante = self::Clean($num_comprobante);
    }

    public function getNum_comprobante()
    {
        return $this->num_comprobante;
    }

    public function setLinea_de_ref($linea_de_ref)
    {
        if (empty($linea_de_ref)) return;
        $this->linea_de_ref = self::Clean($linea_de_ref);
    }

    public function getLinea_de_ref()
    {
        return $this->linea_de_ref;
    }

    public function setC_planilla_diferido($c_planilla_diferido)
    {
        if (empty($c_planilla_diferido)) return;
        $this->c_planilla_diferido = self::Clean($c_planilla_diferido);
    }

    public function getC_planilla_diferido()
    {
        return $this->c_planilla_diferido;
    }

    public function setLinea_diferido($linea_diferido)
    {
        if (empty($linea_diferido)) return;
        $this->linea_diferido = self::Clean($linea_diferido);
    }

    public function getLinea_diferido()
    {
        return $this->linea_diferido;
    }

    public function setC_cobrador($c_cobrador)
    {
        if (empty($c_cobrador)) return;
        $this->c_cobrador = self::Clean($c_cobrador);
    }

    public function getC_cobrador()
    {
        return $this->c_cobrador;
    }

    public function setCod_diferido($cod_diferido)
    {
        if (empty($cod_diferido)) return;
        $this->cod_diferido = self::Clean($cod_diferido);
    }

    public function getCod_diferido()
    {
        return $this->cod_diferido;
    }

    public function setVoucher($voucher)
    {
        if (empty($voucher)) return;
        $this->voucher = self::Clean($voucher);
    }

    public function getVoucher()
    {
        return $this->voucher;
    }

    public function setDif_cambio($dif_cambio)
    {
        if (empty($dif_cambio)) return;
        $this->dif_cambio = self::Clean($dif_cambio);
    }

    public function getDif_cambio()
    {
        return $this->dif_cambio;
    }

    public function setC_operacion_dif_cambio($c_operacion_dif_cambio)
    {
        if (empty($c_operacion_dif_cambio)) return;
        $this->c_operacion_dif_cambio = self::Clean($c_operacion_dif_cambio);
    }

    public function getC_operacion_dif_cambio()
    {
        return $this->c_operacion_dif_cambio;
    }

    public function setTipo_de_cambio_actualizacion($tipo_de_cambio_actualizacion)
    {
        if (empty($tipo_de_cambio_actualizacion)) return;
        $this->tipo_de_cambio_actualizacion = self::Clean($tipo_de_cambio_actualizacion);
    }

    public function getTipo_de_cambio_actualizacion()
    {
        return $this->tipo_de_cambio_actualizacion;
    }

    public function setFlag_voucher($flag_voucher)
    {
        if (empty($flag_voucher)) return;
        $this->flag_voucher = self::Clean($flag_voucher);
    }

    public function getFlag_voucher()
    {
        return $this->flag_voucher;
    }

    public function setFlag_voucher_letras($flag_voucher_letras)
    {
        if (empty($flag_voucher_letras)) return;
        $this->flag_voucher_letras = self::Clean($flag_voucher_letras);
    }

    public function getFlag_voucher_letras()
    {
        return $this->flag_voucher_letras;
    }

    public function setT_cancelacion($t_cancelacion)
    {
        if (empty($t_cancelacion)) return;
        $this->t_cancelacion = self::Clean($t_cancelacion);
    }

    public function getT_cancelacion()
    {
        return $this->t_cancelacion;
    }

    public function setFlag_canje($flag_canje)
    {
        if (empty($flag_canje)) return;
        $this->flag_canje = self::Clean($flag_canje);
    }

    public function getFlag_canje()
    {
        return $this->flag_canje;
    }

    public function setTipo_pago($tipo_pago)
    {
        if (empty($tipo_pago)) return;
        $this->tipo_pago = self::Clean($tipo_pago);
    }

    public function getTipo_pago()
    {
        return $this->tipo_pago;
    }

    public function setMonto_pago($monto_pago)
    {
        if (empty($monto_pago)) return;
        $this->monto_pago = self::Clean($monto_pago);
    }

    public function getMonto_pago()
    {
        return $this->monto_pago;
    }

    public function setCod_documento_ref($cod_documento_ref)
    {
        if (empty($cod_documento_ref)) return;
        $this->cod_documento_ref = self::Clean($cod_documento_ref);
    }

    public function getCod_documento_ref()
    {
        return $this->cod_documento_ref;
    }

    public function setNum_documento_ref($num_documento_ref)
    {
        if (empty($num_documento_ref)) return;
        $this->num_documento_ref = self::Clean($num_documento_ref);
    }

    public function getNum_documento_ref()
    {
        return $this->num_documento_ref;
    }

    public function setC_usuario_anula($c_usuario_anula)
    {
        if (empty($c_usuario_anula)) return;
        $this->c_usuario_anula = self::Clean($c_usuario_anula);
    }

    public function getC_usuario_anula()
    {
        return $this->c_usuario_anula;
    }

    public function setFecha_anula($fecha_anula)
    {
        if (empty($fecha_anula)) return;
        $this->fecha_anula = self::Clean($fecha_anula);
    }

    public function getFecha_anula()
    {
        return $this->fecha_anula;
    }

    public function setNum_cheque($num_cheque)
    {
        if (empty($num_cheque)) return;
        $this->num_cheque = self::Clean($num_cheque);
    }

    public function getNum_cheque()
    {
        return $this->num_cheque;
    }

    public function setC_banco_cheque($c_banco_cheque)
    {
        if (empty($c_banco_cheque)) return;
        $this->c_banco_cheque = self::Clean($c_banco_cheque);
    }

    public function getC_banco_cheque()
    {
        return $this->c_banco_cheque;
    }
}
