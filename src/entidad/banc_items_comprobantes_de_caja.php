<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class banc_items_comprobantes_de_caja extends Parse
{
    private $cc_documento_det;
    private $cc_documento;
    private $c_cuenta;
    private $cod_ing_egre;
    private $cod_documento;
    private $num_documento;
    private $c_persona;
    private $fecha_cancelacion;
    private $monto;
    private $flag_amarre;
    private $monto_aplicado;
    private $c_operacion;
    private $voucher;
    private $flag_automaticas;
    private $c_centro_de_costo;
    private $flag_centro_costo;
    private $c_cuenta_origen;
    private $observacion;
    private $fecha_centralizado;
    private $linea;
    private $c_cta_corriente_ref;
    private $c_banco_ref;
    private $numero_ref;
    private $numero;
    private $c_partida;
    private $porc_distribucion;
    private $porc_ventas;
    private $porc_administracion;
    private $porc_produccion;
    private $porc_financiero;
    private $num_cuota_pagare;
    private $dif_cambio;
    private $c_operacion_dif_cambio;
    private $tipo_de_cambio;
    private $tipo_de_cambio_actualizacion;
    private $flag_voucher;
    private $flag_voucher_letras;
    private $monto_pactado;
    private $t_cancelacion;
    private $flag_nomostrar_cierre;
    private $tipo_pago;
    private $monto_pago;
    private $c_cta_corriente_provee;
    private $c_banco;
    private $c_fondo;
    private $c_cheque_gerencia;

    private $opcd;
    private $cc_compra;


    function __construct()
    {
        $this->cc_documento_det = 0;
        $this->cc_documento = 0;
        $this->c_cuenta = '';
        $this->cod_ing_egre = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->c_persona = '';
        $this->fecha_cancelacion = '';
        $this->monto = 0;
        $this->flag_amarre = '';
        $this->monto_aplicado = 0;
        $this->c_operacion = '';
        $this->voucher = '';
        $this->flag_automaticas = '';
        $this->c_centro_de_costo = '';
        $this->flag_centro_costo = '';
        $this->c_cuenta_origen = '';
        $this->observacion = '';
        $this->fecha_centralizado = '';
        $this->linea = 0;
        $this->c_cta_corriente_ref = '';
        $this->c_banco_ref = '';
        $this->numero_ref = '';
        $this->numero = '';
        $this->c_partida = '';
        $this->porc_distribucion = 0;
        $this->porc_ventas = 0;
        $this->porc_administracion = 0;
        $this->porc_produccion = 0;
        $this->porc_financiero = 0;
        $this->num_cuota_pagare = 0;
        $this->dif_cambio = 0;
        $this->c_operacion_dif_cambio = '';
        $this->tipo_de_cambio = 0;
        $this->tipo_de_cambio_actualizacion = 0;
        $this->flag_voucher = '';
        $this->flag_voucher_letras = '';
        $this->monto_pactado = 0;
        $this->t_cancelacion = '';
        $this->flag_nomostrar_cierre = '';
        $this->tipo_pago = '';
        $this->monto_pago = 0;
        $this->c_cta_corriente_provee = '';
        $this->c_banco = '';
        $this->c_fondo = '';
        $this->c_cheque_gerencia = '';

        $this->opcd='';
        $this->cc_compra='';
    }

    public function setCc_documento_det($cc_documento_det)
    {
        if(empty($cc_documento_det)) return;
        $this->cc_documento_det = self::Clean($cc_documento_det);
    }

    public function getCc_documento_det()
    {
        return $this->cc_documento_det;
    }

    public function setCc_documento($cc_documento)
    {
        if(empty($cc_documento)) return;
        $this->cc_documento = self::Clean($cc_documento);
    }

    public function getCc_documento()
    {
        return $this->cc_documento;
    }

    public function setC_cuenta($c_cuenta)
    {
        if(empty($c_cuenta)) return;
        $this->c_cuenta = self::Clean($c_cuenta);
    }

    public function getC_cuenta()
    {
        return $this->c_cuenta;
    }

    public function setCod_ing_egre($cod_ing_egre)
    {
        if(empty($cod_ing_egre)) return;
        $this->cod_ing_egre = self::Clean($cod_ing_egre);
    }

    public function getCod_ing_egre()
    {
        return $this->cod_ing_egre;
    }

    public function setCod_documento($cod_documento)
    {
        if(empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento()
    {
        return $this->cod_documento;
    }

    public function setNum_documento($num_documento)
    {
        if(empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
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

    public function setFecha_cancelacion($fecha_cancelacion)
    {
        if(empty($fecha_cancelacion)) return;
        $this->fecha_cancelacion = self::Clean($fecha_cancelacion);
    }

    public function getFecha_cancelacion()
    {
        return $this->fecha_cancelacion;
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

    public function setFlag_amarre($flag_amarre)
    {
        if(empty($flag_amarre)) return;
        $this->flag_amarre = self::Clean($flag_amarre);
    }

    public function getFlag_amarre()
    {
        return $this->flag_amarre;
    }

    public function setMonto_aplicado($monto_aplicado)
    {
        if(empty($monto_aplicado)) return;
        $this->monto_aplicado = self::Clean($monto_aplicado);
    }

    public function getMonto_aplicado()
    {
        return $this->monto_aplicado;
    }

    public function setC_operacion($c_operacion)
    {
        if(empty($c_operacion)) return;
        $this->c_operacion = self::Clean($c_operacion);
    }

    public function getC_operacion()
    {
        return $this->c_operacion;
    }

    public function setVoucher($voucher)
    {
        if(empty($voucher)) return;
        $this->voucher = self::Clean($voucher);
    }

    public function getVoucher()
    {
        return $this->voucher;
    }

    public function setFlag_automaticas($flag_automaticas)
    {
        if(empty($flag_automaticas)) return;
        $this->flag_automaticas = self::Clean($flag_automaticas);
    }

    public function getFlag_automaticas()
    {
        return $this->flag_automaticas;
    }

    public function setC_centro_de_costo($c_centro_de_costo)
    {
        if(empty($c_centro_de_costo)) return;
        $this->c_centro_de_costo = self::Clean($c_centro_de_costo);
    }

    public function getC_centro_de_costo()
    {
        return $this->c_centro_de_costo;
    }

    public function setFlag_centro_costo($flag_centro_costo)
    {
        if(empty($flag_centro_costo)) return;
        $this->flag_centro_costo = self::Clean($flag_centro_costo);
    }

    public function getFlag_centro_costo()
    {
        return $this->flag_centro_costo;
    }

    public function setC_cuenta_origen($c_cuenta_origen)
    {
        if(empty($c_cuenta_origen)) return;
        $this->c_cuenta_origen = self::Clean($c_cuenta_origen);
    }

    public function getC_cuenta_origen()
    {
        return $this->c_cuenta_origen;
    }

    public function setObservacion($observacion)
    {
        if(empty($observacion)) return;
        $this->observacion = self::Clean($observacion);
    }

    public function getObservacion()
    {
        return $this->observacion;
    }

    public function setFecha_centralizado($fecha_centralizado)
    {
        if(empty($fecha_centralizado)) return;
        $this->fecha_centralizado = self::Clean($fecha_centralizado);
    }

    public function getFecha_centralizado()
    {
        return $this->fecha_centralizado;
    }

    public function setLinea($linea)
    {
        if(empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
    }

    public function setC_cta_corriente_ref($c_cta_corriente_ref)
    {
        if(empty($c_cta_corriente_ref)) return;
        $this->c_cta_corriente_ref = self::Clean($c_cta_corriente_ref);
    }

    public function getC_cta_corriente_ref()
    {
        return $this->c_cta_corriente_ref;
    }

    public function setC_banco_ref($c_banco_ref)
    {
        if(empty($c_banco_ref)) return;
        $this->c_banco_ref = self::Clean($c_banco_ref);
    }

    public function getC_banco_ref()
    {
        return $this->c_banco_ref;
    }

    public function setNumero_ref($numero_ref)
    {
        if(empty($numero_ref)) return;
        $this->numero_ref = self::Clean($numero_ref);
    }

    public function getNumero_ref()
    {
        return $this->numero_ref;
    }

    public function setNumero($numero)
    {
        if(empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setC_partida($c_partida)
    {
        if(empty($c_partida)) return;
        $this->c_partida = self::Clean($c_partida);
    }

    public function getC_partida()
    {
        return $this->c_partida;
    }

    public function setPorc_distribucion($porc_distribucion)
    {
        if(empty($porc_distribucion)) return;
        $this->porc_distribucion = self::Clean($porc_distribucion);
    }

    public function getPorc_distribucion()
    {
        return $this->porc_distribucion;
    }

    public function setPorc_ventas($porc_ventas)
    {
        if(empty($porc_ventas)) return;
        $this->porc_ventas = self::Clean($porc_ventas);
    }

    public function getPorc_ventas()
    {
        return $this->porc_ventas;
    }

    public function setPorc_administracion($porc_administracion)
    {
        if(empty($porc_administracion)) return;
        $this->porc_administracion = self::Clean($porc_administracion);
    }

    public function getPorc_administracion()
    {
        return $this->porc_administracion;
    }

    public function setPorc_produccion($porc_produccion)
    {
        if(empty($porc_produccion)) return;
        $this->porc_produccion = self::Clean($porc_produccion);
    }

    public function getPorc_produccion()
    {
        return $this->porc_produccion;
    }

    public function setPorc_financiero($porc_financiero)
    {
        if(empty($porc_financiero)) return;
        $this->porc_financiero = self::Clean($porc_financiero);
    }

    public function getPorc_financiero()
    {
        return $this->porc_financiero;
    }

    public function setNum_cuota_pagare($num_cuota_pagare)
    {
        if(empty($num_cuota_pagare)) return;
        $this->num_cuota_pagare = self::Clean($num_cuota_pagare);
    }

    public function getNum_cuota_pagare()
    {
        return $this->num_cuota_pagare;
    }

    public function setDif_cambio($dif_cambio)
    {
        if(empty($dif_cambio)) return;
        $this->dif_cambio = self::Clean($dif_cambio);
    }

    public function getDif_cambio()
    {
        return $this->dif_cambio;
    }

    public function setC_operacion_dif_cambio($c_operacion_dif_cambio)
    {
        if(empty($c_operacion_dif_cambio)) return;
        $this->c_operacion_dif_cambio = self::Clean($c_operacion_dif_cambio);
    }

    public function getC_operacion_dif_cambio()
    {
        return $this->c_operacion_dif_cambio;
    }

    public function setTipo_de_cambio($tipo_de_cambio)
    {
        if(empty($tipo_de_cambio)) return;
        $this->tipo_de_cambio = self::Clean($tipo_de_cambio);
    }

    public function getTipo_de_cambio()
    {
        return $this->tipo_de_cambio;
    }

    public function setTipo_de_cambio_actualizacion($tipo_de_cambio_actualizacion)
    {
        if(empty($tipo_de_cambio_actualizacion)) return;
        $this->tipo_de_cambio_actualizacion = self::Clean($tipo_de_cambio_actualizacion);
    }

    public function getTipo_de_cambio_actualizacion()
    {
        return $this->tipo_de_cambio_actualizacion;
    }

    public function setFlag_voucher($flag_voucher)
    {
        if(empty($flag_voucher)) return;
        $this->flag_voucher = self::Clean($flag_voucher);
    }

    public function getFlag_voucher()
    {
        return $this->flag_voucher;
    }

    public function setFlag_voucher_letras($flag_voucher_letras)
    {
        if(empty($flag_voucher_letras)) return;
        $this->flag_voucher_letras = self::Clean($flag_voucher_letras);
    }

    public function getFlag_voucher_letras()
    {
        return $this->flag_voucher_letras;
    }

    public function setMonto_pactado($monto_pactado)
    {
        if(empty($monto_pactado)) return;
        $this->monto_pactado = self::Clean($monto_pactado);
    }

    public function getMonto_pactado()
    {
        return $this->monto_pactado;
    }

    public function setT_cancelacion($t_cancelacion)
    {
        if(empty($t_cancelacion)) return;
        $this->t_cancelacion = self::Clean($t_cancelacion);
    }

    public function getT_cancelacion()
    {
        return $this->t_cancelacion;
    }

    public function setFlag_nomostrar_cierre($flag_nomostrar_cierre)
    {
        if(empty($flag_nomostrar_cierre)) return;
        $this->flag_nomostrar_cierre = self::Clean($flag_nomostrar_cierre);
    }

    public function getFlag_nomostrar_cierre()
    {
        return $this->flag_nomostrar_cierre;
    }

    public function setTipo_pago($tipo_pago)
    {
        if(empty($tipo_pago)) return;
        $this->tipo_pago = self::Clean($tipo_pago);
    }

    public function getTipo_pago()
    {
        return $this->tipo_pago;
    }

    public function setMonto_pago($monto_pago)
    {
        if(empty($monto_pago)) return;
        $this->monto_pago = self::Clean($monto_pago);
    }

    public function getMonto_pago()
    {
        return $this->monto_pago;
    }

    public function setC_cta_corriente_provee($c_cta_corriente_provee)
    {
        if(empty($c_cta_corriente_provee)) return;
        $this->c_cta_corriente_provee = self::Clean($c_cta_corriente_provee);
    }

    public function getC_cta_corriente_provee()
    {
        return $this->c_cta_corriente_provee;
    }

    public function setC_banco($c_banco)
    {
        if(empty($c_banco)) return;
        $this->c_banco = self::Clean($c_banco);
    }

    public function getC_banco()
    {
        return $this->c_banco;
    }

    public function setC_fondo($c_fondo)
    {
        if(empty($c_fondo)) return;
        $this->c_fondo = self::Clean($c_fondo);
    }

    public function getC_fondo()
    {
        return $this->c_fondo;
    }

    public function setC_cheque_gerencia($c_cheque_gerencia)
    {
        if(empty($c_cheque_gerencia)) return;
        $this->c_cheque_gerencia = self::Clean($c_cheque_gerencia);
    }

    public function getC_cheque_gerencia()
    {
        return $this->c_cheque_gerencia;
    }

    public function setOpcd($opcd)
    {
        if(empty($opcd)) return;
        $this->opcd = self::Clean($opcd);
    }

    public function getOpcd()
    {
        return $this->opcd;
    }
    public function setCc_compra($cc_compra)
    {
        if(empty($cc_compra)) return;
        $this->cc_compra = self::Clean($cc_compra);
    }

    public function getCc_compra()
    {
        return $this->cc_compra;
    }

}