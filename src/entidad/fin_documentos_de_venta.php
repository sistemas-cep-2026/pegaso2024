<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_documentos_de_venta extends Parse
{
    private $cc_ventas;
    private $cod_documento;
    private $num_documento;
    private $c_forma_de_pago;
    private $c_local;
    private $cod_tipo;
    private $c_cuenta;
    private $c_persona;
    private $c_punto_de_venta;
    private $fecha;
    private $fecha_de_pago;
    private $fecha_de_cancelacion;
    private $valor_venta;
    private $adelanto;
    private $observacion;
    private $flag_cancelado;
    private $flag_centralizado;
    private $total_original;
    private $fecha_registro;
    private $host_registro;
    private $usuario_registro;
    private $flag;

    private $nombre_completo;
    private $cod_anho;
    private $cod_desde;
    private $cod_hasta;
    private $opc;
    private $c_cuenta_ventas;
    private $c_articulo;


    private $cod_moneda;
    private $Tipo_de_cambio;
    private $Tipo_de_cambio_Actualizacion;
    private $igv;
    private $saldo_contable;
    private $adelanto_docs;
    private $franquicia;
    private $descuento;
    private $adicional_servicio;
    private $factor_igv;
    private $c_operacion;
    private $voucher;
    private $flag_factura;
    private $num_o_servicio;
    private $num_pedido;
    private $flag_factura_franquicia;
    private $flag_conforme;
    private $adelanto_sistema;
    private $c_persona_garante;
    private $guia_de_remision;
    private $num_contrato;
    private $tipo_cambio_contable;
    private $flag_igv;
    private $monto_liquidado;
    private $adelanto_soles;
    private $observacion_dif_cambio;
    private $adelanto_sjorge;
    private $responsabilida_vigente;
    private $saldo_linea_credito;
    private $plazo_letra;
    private $clasificacion_porcentaje;
    private $dias_asinados;
    private $dias_letras;
    private $flag_vou_letra;
    private $dif_cambio;
    private $c_operacion_dif_cambio;
    private $V_B_Factura;
    private $V_B_Revision;
    private $flag_provisionado;
    private $flag_vb;
    private $flag_vb_contralor;
    private $vb_llamada;
    private $obs_llamada;
    private $fecha_llamada;
    private $Clie_Ruc;
    private $Clie_Raz_Social;
    private $Clie_Direccion;
    private $Clie_postal;
    private $flag_exportar;
    private $nro_packinglist;
    private $dias_prom_letras;
    private $V_B_Emis_2_Rev;
    private $V_B_Anul_Tes;
    private $V_B_Anul_Aud;
    private $V_B_Canc_E_Tes;
    private $V_B_Canc_E_Aud;
    private $V_B_Canc_L_Tes;
    private $V_B_Canc_L_Aud;
    private $V_B_Recepcion;
    private $V_B_Gerencia;
    private $nro_pedido;
    private $fecha_plazo_cobro_interno;
    private $T_cancelacion;
    private $fecha_canje;
    private $id_c_operacion;
    private $contacto;
    private $c_centro_de_costo;
    private $flag_canc_deposito;
    private $fecha_canc_deposito;
    private $c_planilla_cobranza;
    private $nombre_tmp;
    private $flag_ref;
    private $c_persona_ref;
    private $c_entidad_pagadora;
    private $cod_documento_ref;
    private $num_documento_ref;
    private $num_referencia;
    private $orden_compra;
    private $fecha_referencia;
    private $c_banco;
    private $c_vendedor;
    private $flag_print;
    private $c_situacion_documento;
    private $c_tarjeta_de_credito;
    private $usuario_anula;
    private $fecha_situacion;
    private $cod_gravado;
    private $fecha_anula;

    function __construct()
    {
        $this->cc_ventas = 0;
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->c_forma_de_pago = '';
        $this->c_local = '';
        $this->cod_tipo = '';
        $this->c_cuenta = '';
        $this->c_persona = '';
        $this->c_punto_de_venta = '';
        $this->fecha = '';
        $this->fecha_de_pago = '';
        $this->fecha_de_cancelacion = '';
        $this->valor_venta = 0;
        $this->adelanto = 0;
        $this->observacion = '';
        $this->flag_cancelado = '';
        $this->flag_centralizado = '';
        $this->total_original = 0;
        $this->fecha_registro = '';
        $this->host_registro = '';
        $this->usuario_registro = '';
        $this->flag = '';

        $this->opc = '';
        $this->nombre_completo = '';
        $this->cod_desde = '';
        $this->cod_hasta = '';
        $this->c_cuenta_ventas = '';
        $this->c_articulo = '';
        $this->cod_anho = '';


        $this->cod_moneda = '';
        $this->Tipo_de_cambio = 0;
        $this->Tipo_de_cambio_Actualizacion = 0;
        $this->igv = 0;
        $this->saldo_contable = 0;
        $this->adelanto_docs = 0;
        $this->franquicia = 0;
        $this->descuento = 0;
        $this->adicional_servicio = 0;
        $this->factor_igv = 0;
        $this->c_operacion = '';
        $this->voucher = '';
        $this->flag_factura = '';
        $this->num_o_servicio = '';
        $this->num_pedido = '';
        $this->flag_factura_franquicia = '';
        $this->flag_conforme = '';
        $this->adelanto_sistema = 0;
        $this->c_persona_garante = '';
        $this->guia_de_remision = '';
        $this->num_contrato = '';
        $this->tipo_cambio_contable = 0;
        $this->flag_igv = '';
        $this->monto_liquidado = 0;
        $this->adelanto_soles = 0;
        $this->observacion_dif_cambio = '';
        $this->adelanto_sjorge = 0;
        $this->responsabilida_vigente = 0;
        $this->saldo_linea_credito = 0;
        $this->plazo_letra = 0;
        $this->clasificacion_porcentaje = 0;
        $this->dias_asinados = 0;
        $this->dias_letras = 0;
        $this->flag_vou_letra = '';
        $this->dif_cambio = 0;
        $this->c_operacion_dif_cambio = '';
        $this->V_B_Factura = '';
        $this->V_B_Revision = '';
        $this->flag_provisionado = '';
        $this->flag_vb = '';
        $this->flag_vb_contralor = '';
        $this->vb_llamada = '';
        $this->obs_llamada = '';
        $this->fecha_llamada = '';
        $this->Clie_Ruc = '';
        $this->Clie_Raz_Social = '';
        $this->Clie_Direccion = '';
        $this->Clie_postal = '';
        $this->flag_exportar = '';
        $this->nro_packinglist = '';
        $this->dias_prom_letras = 0;
        $this->V_B_Emis_2_Rev = '';
        $this->V_B_Anul_Tes = '';
        $this->V_B_Anul_Aud = '';
        $this->V_B_Canc_E_Tes = '';
        $this->V_B_Canc_E_Aud = '';
        $this->V_B_Canc_L_Tes = '';
        $this->V_B_Canc_L_Aud = '';
        $this->V_B_Recepcion = '';
        $this->V_B_Gerencia = '';
        $this->nro_pedido = '';
        $this->fecha_plazo_cobro_interno = '';
        $this->T_cancelacion = '';
        $this->fecha_canje = '';
        $this->id_c_operacion = 0;
        $this->contacto = '';
        $this->c_centro_de_costo = '';
        $this->flag_canc_deposito = '';
        $this->fecha_canc_deposito = '';
        $this->c_planilla_cobranza = '';
        $this->nombre_tmp = '';
        $this->flag_ref = '';
        $this->c_persona_ref = '';
        $this->c_entidad_pagadora = '';
        $this->cod_documento_ref = '';
        $this->num_documento_ref = '';
        $this->num_referencia = '';
        $this->orden_compra = '';
        $this->fecha_referencia = '';
        $this->c_banco = '';
        $this->c_vendedor = '';
        $this->flag_print = '';
        $this->c_situacion_documento = '';
        $this->c_tarjeta_de_credito = '';
        $this->usuario_anula = '';
        $this->fecha_situacion = '';
        $this->cod_gravado = '';
        $this->fecha_anula = '';
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

    public function setC_forma_de_pago($c_forma_de_pago)
    {
        if (empty($c_forma_de_pago)) return;
        $this->c_forma_de_pago = self::Clean($c_forma_de_pago);
    }

    public function getC_forma_de_pago()
    {
        return $this->c_forma_de_pago;
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

    public function setCod_tipo($cod_tipo)
    {
        if (empty($cod_tipo)) return;
        $this->cod_tipo = self::Clean($cod_tipo);
    }

    public function getCod_tipo()
    {
        return $this->cod_tipo;
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

    public function setC_persona($c_persona)
    {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

    public function setC_punto_de_venta($c_punto_de_venta)
    {
        if (empty($c_punto_de_venta)) return;
        $this->c_punto_de_venta = self::Clean($c_punto_de_venta);
    }

    public function getC_punto_de_venta()
    {
        return $this->c_punto_de_venta;
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

    public function setFecha_de_pago($fecha_de_pago)
    {
        if (empty($fecha_de_pago)) return;
        $this->fecha_de_pago = self::Clean($fecha_de_pago);
    }

    public function getFecha_de_pago()
    {
        return $this->fecha_de_pago;
    }

    public function setFecha_de_cancelacion($fecha_de_cancelacion)
    {
        if (empty($fecha_de_cancelacion)) return;
        $this->fecha_de_cancelacion = self::Clean($fecha_de_cancelacion);
    }

    public function getFecha_de_cancelacion()
    {
        return $this->fecha_de_cancelacion;
    }

    public function setValor_venta($valor_venta)
    {
        if (empty($valor_venta)) return;
        $this->valor_venta = self::Clean($valor_venta);
    }

    public function getValor_venta()
    {
        return $this->valor_venta;
    }

    public function setAdelanto($adelanto)
    {
        if (empty($adelanto)) return;
        $this->adelanto = self::Clean($adelanto);
    }

    public function getAdelanto()
    {
        return $this->adelanto;
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

    public function setFlag_cancelado($flag_cancelado)
    {
        if (empty($flag_cancelado)) return;
        $this->flag_cancelado = self::Clean($flag_cancelado);
    }

    public function getFlag_cancelado()
    {
        return $this->flag_cancelado;
    }

    public function setFlag_centralizado($flag_centralizado)
    {
        if (empty($flag_centralizado)) return;
        $this->flag_centralizado = self::Clean($flag_centralizado);
    }

    public function getFlag_centralizado()
    {
        return $this->flag_centralizado;
    }

    public function setTotal_original($total_original)
    {
        if (empty($total_original)) return;
        $this->total_original = self::Clean($total_original);
    }

    public function getTotal_original()
    {
        return $this->total_original;
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

    public function setHost_registro($host_registro)
    {
        if (empty($host_registro)) return;
        $this->host_registro = self::Clean($host_registro);
    }

    public function getHost_registro()
    {
        return $this->host_registro;
    }

    public function setUsuario_registro($usuario_registro)
    {
        if (empty($usuario_registro)) return;
        $this->usuario_registro = self::Clean($usuario_registro);
    }

    public function getUsuario_registro()
    {
        return $this->usuario_registro;
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


    public function setNombre_completo($nombre_completo)
    {
        if (empty($nombre_completo)) return;
        $this->nombre_completo = self::Clean($nombre_completo);
    }

    public function getNombre_completo()
    {
        return $this->nombre_completo;
    }

    public function setCod_desde($cod_desde)
    {
        if (empty($cod_desde)) return;
        $this->cod_desde = self::Clean($cod_desde);
    }

    public function getCod_desde()
    {
        return $this->cod_desde;
    }

    public function setCod_hasta($cod_hasta)
    {
        if (empty($cod_hasta)) return;
        $this->cod_hasta = self::Clean($cod_hasta);
    }

    public function getCod_hasta()
    {
        return $this->cod_hasta;
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

    public function setC_cuenta_ventas($c_cuenta_ventas)
    {
        if (empty($c_cuenta_ventas)) return;
        $this->c_cuenta_ventas = self::Clean($c_cuenta_ventas);
    }

    public function getC_cuenta_ventas()
    {
        return $this->c_cuenta_ventas;
    }

    public function setC_articulo($c_articulo)
    {
        if (empty($c_articulo)) return;
        $this->c_articulo = self::Clean($c_articulo);
    }

    public function getC_articulo()
    {
        return $this->c_articulo;
    }
    public function setCod_anho($cod_anho)
    {
        if (empty($cod_anho)) return;
        $this->cod_anho = self::Clean($cod_anho);
    }

    public function getCod_anho()
    {
        return $this->cod_anho;
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

    public function setTipo_de_cambio($Tipo_de_cambio)
    {
        if (empty($Tipo_de_cambio)) return;
        $this->Tipo_de_cambio = self::Clean($Tipo_de_cambio);
    }

    public function getTipo_de_cambio()
    {
        return $this->Tipo_de_cambio;
    }

    public function setTipo_de_cambio_Actualizacion($Tipo_de_cambio_Actualizacion)
    {
        if (empty($Tipo_de_cambio_Actualizacion)) return;
        $this->Tipo_de_cambio_Actualizacion = self::Clean($Tipo_de_cambio_Actualizacion);
    }

    public function getTipo_de_cambio_Actualizacion()
    {
        return $this->Tipo_de_cambio_Actualizacion;
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

    public function setSaldo_contable($saldo_contable)
    {
        if (empty($saldo_contable)) return;
        $this->saldo_contable = self::Clean($saldo_contable);
    }

    public function getSaldo_contable()
    {
        return $this->saldo_contable;
    }

    public function setAdelanto_docs($adelanto_docs)
    {
        if (empty($adelanto_docs)) return;
        $this->adelanto_docs = self::Clean($adelanto_docs);
    }

    public function getAdelanto_docs()
    {
        return $this->adelanto_docs;
    }

    public function setFranquicia($franquicia)
    {
        if (empty($franquicia)) return;
        $this->franquicia = self::Clean($franquicia);
    }

    public function getFranquicia()
    {
        return $this->franquicia;
    }

    public function setDescuento($descuento)
    {
        if (empty($descuento)) return;
        $this->descuento = self::Clean($descuento);
    }

    public function getDescuento()
    {
        return $this->descuento;
    }

    public function setAdicional_servicio($adicional_servicio)
    {
        if (empty($adicional_servicio)) return;
        $this->adicional_servicio = self::Clean($adicional_servicio);
    }

    public function getAdicional_servicio()
    {
        return $this->adicional_servicio;
    }

    public function setFactor_igv($factor_igv)
    {
        if (empty($factor_igv)) return;
        $this->factor_igv = self::Clean($factor_igv);
    }

    public function getFactor_igv()
    {
        return $this->factor_igv;
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

    public function setVoucher($voucher)
    {
        if (empty($voucher)) return;
        $this->voucher = self::Clean($voucher);
    }

    public function getVoucher()
    {
        return $this->voucher;
    }

    public function setFlag_factura($flag_factura)
    {
        if (empty($flag_factura)) return;
        $this->flag_factura = self::Clean($flag_factura);
    }

    public function getFlag_factura()
    {
        return $this->flag_factura;
    }

    public function setNum_o_servicio($num_o_servicio)
    {
        if (empty($num_o_servicio)) return;
        $this->num_o_servicio = self::Clean($num_o_servicio);
    }

    public function getNum_o_servicio()
    {
        return $this->num_o_servicio;
    }

    public function setNum_pedido($num_pedido)
    {
        if (empty($num_pedido)) return;
        $this->num_pedido = self::Clean($num_pedido);
    }

    public function getNum_pedido()
    {
        return $this->num_pedido;
    }

    public function setFlag_factura_franquicia($flag_factura_franquicia)
    {
        if (empty($flag_factura_franquicia)) return;
        $this->flag_factura_franquicia = self::Clean($flag_factura_franquicia);
    }

    public function getFlag_factura_franquicia()
    {
        return $this->flag_factura_franquicia;
    }

    public function setFlag_conforme($flag_conforme)
    {
        if (empty($flag_conforme)) return;
        $this->flag_conforme = self::Clean($flag_conforme);
    }

    public function getFlag_conforme()
    {
        return $this->flag_conforme;
    }

    public function setAdelanto_sistema($adelanto_sistema)
    {
        if (empty($adelanto_sistema)) return;
        $this->adelanto_sistema = self::Clean($adelanto_sistema);
    }

    public function getAdelanto_sistema()
    {
        return $this->adelanto_sistema;
    }

    public function setC_persona_garante($c_persona_garante)
    {
        if (empty($c_persona_garante)) return;
        $this->c_persona_garante = self::Clean($c_persona_garante);
    }

    public function getC_persona_garante()
    {
        return $this->c_persona_garante;
    }

    public function setGuia_de_remision($guia_de_remision)
    {
        if (empty($guia_de_remision)) return;
        $this->guia_de_remision = self::Clean($guia_de_remision);
    }

    public function getGuia_de_remision()
    {
        return $this->guia_de_remision;
    }

    public function setNum_contrato($num_contrato)
    {
        if (empty($num_contrato)) return;
        $this->num_contrato = self::Clean($num_contrato);
    }

    public function getNum_contrato()
    {
        return $this->num_contrato;
    }

    public function setTipo_cambio_contable($tipo_cambio_contable)
    {
        if (empty($tipo_cambio_contable)) return;
        $this->tipo_cambio_contable = self::Clean($tipo_cambio_contable);
    }

    public function getTipo_cambio_contable()
    {
        return $this->tipo_cambio_contable;
    }

    public function setFlag_igv($flag_igv)
    {
        if (empty($flag_igv)) return;
        $this->flag_igv = self::Clean($flag_igv);
    }

    public function getFlag_igv()
    {
        return $this->flag_igv;
    }

    public function setMonto_liquidado($monto_liquidado)
    {
        if (empty($monto_liquidado)) return;
        $this->monto_liquidado = self::Clean($monto_liquidado);
    }

    public function getMonto_liquidado()
    {
        return $this->monto_liquidado;
    }

    public function setAdelanto_soles($adelanto_soles)
    {
        if (empty($adelanto_soles)) return;
        $this->adelanto_soles = self::Clean($adelanto_soles);
    }

    public function getAdelanto_soles()
    {
        return $this->adelanto_soles;
    }

    public function setObservacion_dif_cambio($observacion_dif_cambio)
    {
        if (empty($observacion_dif_cambio)) return;
        $this->observacion_dif_cambio = self::Clean($observacion_dif_cambio);
    }

    public function getObservacion_dif_cambio()
    {
        return $this->observacion_dif_cambio;
    }

    public function setAdelanto_sjorge($adelanto_sjorge)
    {
        if (empty($adelanto_sjorge)) return;
        $this->adelanto_sjorge = self::Clean($adelanto_sjorge);
    }

    public function getAdelanto_sjorge()
    {
        return $this->adelanto_sjorge;
    }

    public function setResponsabilida_vigente($responsabilida_vigente)
    {
        if (empty($responsabilida_vigente)) return;
        $this->responsabilida_vigente = self::Clean($responsabilida_vigente);
    }

    public function getResponsabilida_vigente()
    {
        return $this->responsabilida_vigente;
    }

    public function setSaldo_linea_credito($saldo_linea_credito)
    {
        if (empty($saldo_linea_credito)) return;
        $this->saldo_linea_credito = self::Clean($saldo_linea_credito);
    }

    public function getSaldo_linea_credito()
    {
        return $this->saldo_linea_credito;
    }

    public function setPlazo_letra($plazo_letra)
    {
        if (empty($plazo_letra)) return;
        $this->plazo_letra = self::Clean($plazo_letra);
    }

    public function getPlazo_letra()
    {
        return $this->plazo_letra;
    }

    public function setClasificacion_porcentaje($clasificacion_porcentaje)
    {
        if (empty($clasificacion_porcentaje)) return;
        $this->clasificacion_porcentaje = self::Clean($clasificacion_porcentaje);
    }

    public function getClasificacion_porcentaje()
    {
        return $this->clasificacion_porcentaje;
    }

    public function setDias_asinados($dias_asinados)
    {
        if (empty($dias_asinados)) return;
        $this->dias_asinados = self::Clean($dias_asinados);
    }

    public function getDias_asinados()
    {
        return $this->dias_asinados;
    }

    public function setDias_letras($dias_letras)
    {
        if (empty($dias_letras)) return;
        $this->dias_letras = self::Clean($dias_letras);
    }

    public function getDias_letras()
    {
        return $this->dias_letras;
    }

    public function setFlag_vou_letra($flag_vou_letra)
    {
        if (empty($flag_vou_letra)) return;
        $this->flag_vou_letra = self::Clean($flag_vou_letra);
    }

    public function getFlag_vou_letra()
    {
        return $this->flag_vou_letra;
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

    public function setV_B_Factura($V_B_Factura)
    {
        if (empty($V_B_Factura)) return;
        $this->V_B_Factura = self::Clean($V_B_Factura);
    }

    public function getV_B_Factura()
    {
        return $this->V_B_Factura;
    }

    public function setV_B_Revision($V_B_Revision)
    {
        if (empty($V_B_Revision)) return;
        $this->V_B_Revision = self::Clean($V_B_Revision);
    }

    public function getV_B_Revision()
    {
        return $this->V_B_Revision;
    }

    public function setFlag_provisionado($flag_provisionado)
    {
        if (empty($flag_provisionado)) return;
        $this->flag_provisionado = self::Clean($flag_provisionado);
    }

    public function getFlag_provisionado()
    {
        return $this->flag_provisionado;
    }

    public function setFlag_vb($flag_vb)
    {
        if (empty($flag_vb)) return;
        $this->flag_vb = self::Clean($flag_vb);
    }

    public function getFlag_vb()
    {
        return $this->flag_vb;
    }

    public function setFlag_vb_contralor($flag_vb_contralor)
    {
        if (empty($flag_vb_contralor)) return;
        $this->flag_vb_contralor = self::Clean($flag_vb_contralor);
    }

    public function getFlag_vb_contralor()
    {
        return $this->flag_vb_contralor;
    }

    public function setVb_llamada($vb_llamada)
    {
        if (empty($vb_llamada)) return;
        $this->vb_llamada = self::Clean($vb_llamada);
    }

    public function getVb_llamada()
    {
        return $this->vb_llamada;
    }

    public function setObs_llamada($obs_llamada)
    {
        if (empty($obs_llamada)) return;
        $this->obs_llamada = self::Clean($obs_llamada);
    }

    public function getObs_llamada()
    {
        return $this->obs_llamada;
    }

    public function setFecha_llamada($fecha_llamada)
    {
        if (empty($fecha_llamada)) return;
        $this->fecha_llamada = self::Clean($fecha_llamada);
    }

    public function getFecha_llamada()
    {
        return $this->fecha_llamada;
    }

    public function setClie_Ruc($Clie_Ruc)
    {
        if (empty($Clie_Ruc)) return;
        $this->Clie_Ruc = self::Clean($Clie_Ruc);
    }

    public function getClie_Ruc()
    {
        return $this->Clie_Ruc;
    }

    public function setClie_Raz_Social($Clie_Raz_Social)
    {
        if (empty($Clie_Raz_Social)) return;
        $this->Clie_Raz_Social = self::Clean($Clie_Raz_Social);
    }

    public function getClie_Raz_Social()
    {
        return $this->Clie_Raz_Social;
    }

    public function setClie_Direccion($Clie_Direccion)
    {
        if (empty($Clie_Direccion)) return;
        $this->Clie_Direccion = self::Clean($Clie_Direccion);
    }

    public function getClie_Direccion()
    {
        return $this->Clie_Direccion;
    }

    public function setClie_postal($Clie_postal)
    {
        if (empty($Clie_postal)) return;
        $this->Clie_postal = self::Clean($Clie_postal);
    }

    public function getClie_postal()
    {
        return $this->Clie_postal;
    }

    public function setFlag_exportar($flag_exportar)
    {
        if (empty($flag_exportar)) return;
        $this->flag_exportar = self::Clean($flag_exportar);
    }

    public function getFlag_exportar()
    {
        return $this->flag_exportar;
    }

    public function setNro_packinglist($nro_packinglist)
    {
        if (empty($nro_packinglist)) return;
        $this->nro_packinglist = self::Clean($nro_packinglist);
    }

    public function getNro_packinglist()
    {
        return $this->nro_packinglist;
    }

    public function setDias_prom_letras($dias_prom_letras)
    {
        if (empty($dias_prom_letras)) return;
        $this->dias_prom_letras = self::Clean($dias_prom_letras);
    }

    public function getDias_prom_letras()
    {
        return $this->dias_prom_letras;
    }

    public function setV_B_Emis_2_Rev($V_B_Emis_2_Rev)
    {
        if (empty($V_B_Emis_2_Rev)) return;
        $this->V_B_Emis_2_Rev = self::Clean($V_B_Emis_2_Rev);
    }

    public function getV_B_Emis_2_Rev()
    {
        return $this->V_B_Emis_2_Rev;
    }

    public function setV_B_Anul_Tes($V_B_Anul_Tes)
    {
        if (empty($V_B_Anul_Tes)) return;
        $this->V_B_Anul_Tes = self::Clean($V_B_Anul_Tes);
    }

    public function getV_B_Anul_Tes()
    {
        return $this->V_B_Anul_Tes;
    }

    public function setV_B_Anul_Aud($V_B_Anul_Aud)
    {
        if (empty($V_B_Anul_Aud)) return;
        $this->V_B_Anul_Aud = self::Clean($V_B_Anul_Aud);
    }

    public function getV_B_Anul_Aud()
    {
        return $this->V_B_Anul_Aud;
    }

    public function setV_B_Canc_E_Tes($V_B_Canc_E_Tes)
    {
        if (empty($V_B_Canc_E_Tes)) return;
        $this->V_B_Canc_E_Tes = self::Clean($V_B_Canc_E_Tes);
    }

    public function getV_B_Canc_E_Tes()
    {
        return $this->V_B_Canc_E_Tes;
    }

    public function setV_B_Canc_E_Aud($V_B_Canc_E_Aud)
    {
        if (empty($V_B_Canc_E_Aud)) return;
        $this->V_B_Canc_E_Aud = self::Clean($V_B_Canc_E_Aud);
    }

    public function getV_B_Canc_E_Aud()
    {
        return $this->V_B_Canc_E_Aud;
    }

    public function setV_B_Canc_L_Tes($V_B_Canc_L_Tes)
    {
        if (empty($V_B_Canc_L_Tes)) return;
        $this->V_B_Canc_L_Tes = self::Clean($V_B_Canc_L_Tes);
    }

    public function getV_B_Canc_L_Tes()
    {
        return $this->V_B_Canc_L_Tes;
    }

    public function setV_B_Canc_L_Aud($V_B_Canc_L_Aud)
    {
        if (empty($V_B_Canc_L_Aud)) return;
        $this->V_B_Canc_L_Aud = self::Clean($V_B_Canc_L_Aud);
    }

    public function getV_B_Canc_L_Aud()
    {
        return $this->V_B_Canc_L_Aud;
    }

    public function setV_B_Recepcion($V_B_Recepcion)
    {
        if (empty($V_B_Recepcion)) return;
        $this->V_B_Recepcion = self::Clean($V_B_Recepcion);
    }

    public function getV_B_Recepcion()
    {
        return $this->V_B_Recepcion;
    }

    public function setV_B_Gerencia($V_B_Gerencia)
    {
        if (empty($V_B_Gerencia)) return;
        $this->V_B_Gerencia = self::Clean($V_B_Gerencia);
    }

    public function getV_B_Gerencia()
    {
        return $this->V_B_Gerencia;
    }

    public function setNro_pedido($nro_pedido)
    {
        if (empty($nro_pedido)) return;
        $this->nro_pedido = self::Clean($nro_pedido);
    }

    public function getNro_pedido()
    {
        return $this->nro_pedido;
    }

    public function setFecha_plazo_cobro_interno($fecha_plazo_cobro_interno)
    {
        if (empty($fecha_plazo_cobro_interno)) return;
        $this->fecha_plazo_cobro_interno = self::Clean($fecha_plazo_cobro_interno);
    }

    public function getFecha_plazo_cobro_interno()
    {
        return $this->fecha_plazo_cobro_interno;
    }

    public function setT_cancelacion($T_cancelacion)
    {
        if (empty($T_cancelacion)) return;
        $this->T_cancelacion = self::Clean($T_cancelacion);
    }

    public function getT_cancelacion()
    {
        return $this->T_cancelacion;
    }

    public function setFecha_canje($fecha_canje)
    {
        if (empty($fecha_canje)) return;
        $this->fecha_canje = self::Clean($fecha_canje);
    }

    public function getFecha_canje()
    {
        return $this->fecha_canje;
    }

    public function setId_c_operacion($id_c_operacion)
    {
        if (empty($id_c_operacion)) return;
        $this->id_c_operacion = self::Clean($id_c_operacion);
    }

    public function getId_c_operacion()
    {
        return $this->id_c_operacion;
    }

    public function setContacto($contacto)
    {
        if (empty($contacto)) return;
        $this->contacto = self::Clean($contacto);
    }

    public function getContacto()
    {
        return $this->contacto;
    }

    public function setC_centro_de_costo($c_centro_de_costo)
    {
        if (empty($c_centro_de_costo)) return;
        $this->c_centro_de_costo = self::Clean($c_centro_de_costo);
    }

    public function getC_centro_de_costo()
    {
        return $this->c_centro_de_costo;
    }

    public function setFlag_canc_deposito($flag_canc_deposito)
    {
        if (empty($flag_canc_deposito)) return;
        $this->flag_canc_deposito = self::Clean($flag_canc_deposito);
    }

    public function getFlag_canc_deposito()
    {
        return $this->flag_canc_deposito;
    }

    public function setFecha_canc_deposito($fecha_canc_deposito)
    {
        if (empty($fecha_canc_deposito)) return;
        $this->fecha_canc_deposito = self::Clean($fecha_canc_deposito);
    }

    public function getFecha_canc_deposito()
    {
        return $this->fecha_canc_deposito;
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

    public function setNombre_tmp($nombre_tmp)
    {
        if (empty($nombre_tmp)) return;
        $this->nombre_tmp = self::Clean($nombre_tmp);
    }

    public function getNombre_tmp()
    {
        return $this->nombre_tmp;
    }

    public function setFlag_ref($flag_ref)
    {
        if (empty($flag_ref)) return;
        $this->flag_ref = self::Clean($flag_ref);
    }

    public function getFlag_ref()
    {
        return $this->flag_ref;
    }

    public function setC_persona_ref($c_persona_ref)
    {
        if (empty($c_persona_ref)) return;
        $this->c_persona_ref = self::Clean($c_persona_ref);
    }

    public function getC_persona_ref()
    {
        return $this->c_persona_ref;
    }

    public function setC_entidad_pagadora($c_entidad_pagadora)
    {
        if (empty($c_entidad_pagadora)) return;
        $this->c_entidad_pagadora = self::Clean($c_entidad_pagadora);
    }

    public function getC_entidad_pagadora()
    {
        return $this->c_entidad_pagadora;
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

    public function setNum_referencia($num_referencia)
    {
        if (empty($num_referencia)) return;
        $this->num_referencia = self::Clean($num_referencia);
    }

    public function getNum_referencia()
    {
        return $this->num_referencia;
    }

    public function setOrden_compra($orden_compra)
    {
        if (empty($orden_compra)) return;
        $this->orden_compra = self::Clean($orden_compra);
    }

    public function getOrden_compra()
    {
        return $this->orden_compra;
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

    public function setC_banco($c_banco)
    {
        if (empty($c_banco)) return;
        $this->c_banco = self::Clean($c_banco);
    }

    public function getC_banco()
    {
        return $this->c_banco;
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

    public function setFlag_print($flag_print)
    {
        if (empty($flag_print)) return;
        $this->flag_print = self::Clean($flag_print);
    }

    public function getFlag_print()
    {
        return $this->flag_print;
    }

    public function setC_situacion_documento($c_situacion_documento)
    {
        if (empty($c_situacion_documento)) return;
        $this->c_situacion_documento = self::Clean($c_situacion_documento);
    }

    public function getC_situacion_documento()
    {
        return $this->c_situacion_documento;
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

    public function setUsuario_anula($usuario_anula)
    {
        if (empty($usuario_anula)) return;
        $this->usuario_anula = self::Clean($usuario_anula);
    }

    public function getUsuario_anula()
    {
        return $this->usuario_anula;
    }

    public function setFecha_situacion($fecha_situacion)
    {
        if (empty($fecha_situacion)) return;
        $this->fecha_situacion = self::Clean($fecha_situacion);
    }

    public function getFecha_situacion()
    {
        return $this->fecha_situacion;
    }

    public function setCod_gravado($cod_gravado)
    {
        if (empty($cod_gravado)) return;
        $this->cod_gravado = self::Clean($cod_gravado);
    }

    public function getCod_gravado()
    {
        return $this->cod_gravado;
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
}
