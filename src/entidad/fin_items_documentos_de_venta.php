<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_items_documentos_de_venta extends Parse
{
    private $cc_ventadetall;
    private $cc_ventas;
    private $cod_documento;
    private $num_documento;
    private $c_articulo;
    private $nombre_pr;
    private $cantidad;
    private $venta;
    private $precio;
    private $observacion;
    private $ano;
    private $mes_desde;
    private $mes_hasta;
    private $c_igv;
    private $flag_voucher;
    private $linea;
    private $descuento;
    private $tc_doc_ref;
    private $c_descripcion;
    private $cod_procedencia;
    private $serie;
    private $costo;
    private $porc_descuento1;
    private $porc_descuento2;
    private $costo_prom_us;
    private $costo_prom_soles;
    private $cod_documento_ref;
    private $num_documento_ref;
    private $monto;
    private $voucher;
    private $fecha_aplicacion;
    private $numero_gs;
    private $linea_gs;
    private $c_operacion;
    private $precio_corte;
    private $factor_corte;
    private $desc_manual;
    private $adelanto_items;
    private $glosa;

    function __construct()
    {
        $this->cc_ventadetall = 0;
        $this->cc_ventas = 0;
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->c_articulo = '';
        $this->nombre_pr = '';
        $this->cantidad = 0;
        $this->venta = 0;
        $this->precio = 0;
        $this->observacion = '';
        $this->ano = '';
        $this->mes_desde = '';
        $this->mes_hasta = '';
        $this->c_igv = '';
        $this->flag_voucher = '';
        $this->linea = 0;
        $this->descuento = 0;
        $this->tc_doc_ref = 0;
        $this->c_descripcion = 0;
        $this->cod_procedencia = '';
        $this->serie = '';
        $this->costo = 0;
        $this->porc_descuento1 = 0;
        $this->porc_descuento2 = 0;
        $this->costo_prom_us = 0;
        $this->costo_prom_soles = 0;
        $this->cod_documento_ref = '';
        $this->num_documento_ref = '';
        $this->monto = 0;
        $this->voucher = '';
        $this->fecha_aplicacion = '';
        $this->numero_gs = '';
        $this->linea_gs = 0;
        $this->c_operacion = '';
        $this->precio_corte = 0;
        $this->factor_corte = 0;
        $this->desc_manual = '';
        $this->adelanto_items = 0;
        $this->glosa = '';
    }

    public function setCc_ventadetall($cc_ventadetall)
    {
        if (empty($cc_ventadetall)) return;
        $this->cc_ventadetall = self::Clean($cc_ventadetall);
    }

    public function getCc_ventadetall()
    {
        return $this->cc_ventadetall;
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

    public function setC_articulo($c_articulo)
    {
        if (empty($c_articulo)) return;
        $this->c_articulo = self::Clean($c_articulo);
    }

    public function getC_articulo()
    {
        return $this->c_articulo;
    }

    public function setNombre_pr($nombre_pr)
    {
        if (empty($nombre_pr)) return;
        $this->nombre_pr = self::Clean($nombre_pr);
    }

    public function getNombre_pr()
    {
        return $this->nombre_pr;
    }

    public function setCantidad($cantidad)
    {
        if (empty($cantidad)) return;
        $this->cantidad = self::Clean($cantidad);
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setVenta($venta)
    {
        if (empty($venta)) return;
        $this->venta = self::Clean($venta);
    }

    public function getVenta()
    {
        return $this->venta;
    }

    public function setPrecio($precio)
    {
        if (empty($precio)) return;
        $this->precio = self::Clean($precio);
    }

    public function getPrecio()
    {
        return $this->precio;
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

    public function setAno($ano)
    {
        if (empty($ano)) return;
        $this->ano = self::Clean($ano);
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setMes_desde($mes_desde)
    {
        if (empty($mes_desde)) return;
        $this->mes_desde = self::Clean($mes_desde);
    }

    public function getMes_desde()
    {
        return $this->mes_desde;
    }

    public function setMes_hasta($mes_hasta)
    {
        if (empty($mes_hasta)) return;
        $this->mes_hasta = self::Clean($mes_hasta);
    }

    public function getMes_hasta()
    {
        return $this->mes_hasta;
    }

    public function setC_igv($c_igv)
    {
        if (empty($c_igv)) return;
        $this->c_igv = self::Clean($c_igv);
    }

    public function getC_igv()
    {
        return $this->c_igv;
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

    public function setLinea($linea)
    {
        if (empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
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

    public function setTc_doc_ref($tc_doc_ref)
    {
        if (empty($tc_doc_ref)) return;
        $this->tc_doc_ref = self::Clean($tc_doc_ref);
    }

    public function getTc_doc_ref()
    {
        return $this->tc_doc_ref;
    }

    public function setC_descripcion($c_descripcion)
    {
        if (empty($c_descripcion)) return;
        $this->c_descripcion = self::Clean($c_descripcion);
    }

    public function getC_descripcion()
    {
        return $this->c_descripcion;
    }

    public function setCod_procedencia($cod_procedencia)
    {
        if (empty($cod_procedencia)) return;
        $this->cod_procedencia = self::Clean($cod_procedencia);
    }

    public function getCod_procedencia()
    {
        return $this->cod_procedencia;
    }

    public function setSerie($serie)
    {
        if (empty($serie)) return;
        $this->serie = self::Clean($serie);
    }

    public function getSerie()
    {
        return $this->serie;
    }

    public function setCosto($costo)
    {
        if (empty($costo)) return;
        $this->costo = self::Clean($costo);
    }

    public function getCosto()
    {
        return $this->costo;
    }

    public function setPorc_descuento1($porc_descuento1)
    {
        if (empty($porc_descuento1)) return;
        $this->porc_descuento1 = self::Clean($porc_descuento1);
    }

    public function getPorc_descuento1()
    {
        return $this->porc_descuento1;
    }

    public function setPorc_descuento2($porc_descuento2)
    {
        if (empty($porc_descuento2)) return;
        $this->porc_descuento2 = self::Clean($porc_descuento2);
    }

    public function getPorc_descuento2()
    {
        return $this->porc_descuento2;
    }

    public function setCosto_prom_us($costo_prom_us)
    {
        if (empty($costo_prom_us)) return;
        $this->costo_prom_us = self::Clean($costo_prom_us);
    }

    public function getCosto_prom_us()
    {
        return $this->costo_prom_us;
    }

    public function setCosto_prom_soles($costo_prom_soles)
    {
        if (empty($costo_prom_soles)) return;
        $this->costo_prom_soles = self::Clean($costo_prom_soles);
    }

    public function getCosto_prom_soles()
    {
        return $this->costo_prom_soles;
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

    public function setMonto($monto)
    {
        if (empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
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

    public function setFecha_aplicacion($fecha_aplicacion)
    {
        if (empty($fecha_aplicacion)) return;
        $this->fecha_aplicacion = self::Clean($fecha_aplicacion);
    }

    public function getFecha_aplicacion()
    {
        return $this->fecha_aplicacion;
    }

    public function setNumero_gs($numero_gs)
    {
        if (empty($numero_gs)) return;
        $this->numero_gs = self::Clean($numero_gs);
    }

    public function getNumero_gs()
    {
        return $this->numero_gs;
    }

    public function setLinea_gs($linea_gs)
    {
        if (empty($linea_gs)) return;
        $this->linea_gs = self::Clean($linea_gs);
    }

    public function getLinea_gs()
    {
        return $this->linea_gs;
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

    public function setPrecio_corte($precio_corte)
    {
        if (empty($precio_corte)) return;
        $this->precio_corte = self::Clean($precio_corte);
    }

    public function getPrecio_corte()
    {
        return $this->precio_corte;
    }

    public function setFactor_corte($factor_corte)
    {
        if (empty($factor_corte)) return;
        $this->factor_corte = self::Clean($factor_corte);
    }

    public function getFactor_corte()
    {
        return $this->factor_corte;
    }

    public function setDesc_manual($desc_manual)
    {
        if (empty($desc_manual)) return;
        $this->desc_manual = self::Clean($desc_manual);
    }

    public function getDesc_manual()
    {
        return $this->desc_manual;
    }

    public function setAdelanto_items($adelanto_items)
    {
        if (empty($adelanto_items)) return;
        $this->adelanto_items = self::Clean($adelanto_items);
    }

    public function getAdelanto_items()
    {
        return $this->adelanto_items;
    }

    public function setGlosa($glosa)
    {
        if (empty($glosa)) return;
        $this->glosa = self::Clean($glosa);
    }

    public function getGlosa()
    {
        return $this->glosa;
    }
}
