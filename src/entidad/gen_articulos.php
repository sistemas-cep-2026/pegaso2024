<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_articulos extends Parse
{
    private $c_articulo;
    private $c_familia;
    private $c_sub_familia;
    private $cod_tipo;
    private $nombre;
    private $unidad;
    private $c_cuenta_ventas;

    private $c_usuario;

    private $flag_activo;
    private $c_local;
    /**************fin***********/
    
    private $c_clase;
    private $c_calidad;
    private $c_letra_dscto;
    private $c_categoria;
    private $c_cuenta;
    private $otro_nombre;
    private $cod_moneda;
    private $costo_especial;
    private $costo_obligado;
    private $costo;
    private $porc_descto;
    private $venta;
    private $cantidad;
    private $ancho;
    private $sub_total_us;
    private $sub_total_soles;
    private $stock_minimo;
    private $stock_maximo;
    private $stock_actual;
    private $stock_comprometido;
    private $stock_transito;
    private $observacion;
    private $ultimo_costo;
    private $ultima_compra;
    private $ultima_venta;
    private $flag_abc;
    private $factor_mt;
    private $factor_mt2;
    private $unidad_de_compra;
    private $factor_mt3;
    private $equivalencia;
    private $c_cuenta_Compra;
    private $c_S_tipo;
    private $Codprod;
    private $flag_lista_precios;
    private $c_tipo;
    private $procentaje_error;
    private $c_genero;
    private $flag_importado;
    private $ubicacion;
    private $s_categoria;
    private $venta_soles;
    private $metros_pieza;
    private $fam;
    private $flag_congelado;
    private $flag_exportar;
    private $marc_inv;
    private $estante;
    private $casillero;
    private $flag_tienda;
    private $num_documento_compra;
    private $stock_compra;
    private $stock_compra_fisico;
    private $stock_compra_comprometido;
    private $costo_especial_soles;
    private $flack_costo_soles_esp;
    private $flag_proc_stock;
    private $fecha_act_precio;
    private $flag_proc_stock_copia;
    private $venta_min;
    private $venta_soles_min;
    private $flag_diseno_esp;
    private $venta_soles_min_copia_141202;
    private $flag_oculta_lista_precios;
    private $venta_soles_adi1;
    private $venta_adi1;
    private $costo_soles;
    private $costo_dolares;
    private $fecha_ingreso;
    private $venta_E_min;
    private $venta_E_min_soles;
    private $flag_dibcol_nuevo;
    private $venta_soles_COPIA;
    private $venta_soles_min_COPIA;
    private $venta_soles_adi1_COPIA;
    private $Costo_Soles_COPIA;
    private $venta_E_min_COPIA;
    private $venta_E_min_soles_COPIA;
    private $venta_soles_COPIA_1;
    private $venta_soles_min_COPIA1;
    private $venta_soles_adi1_COPIA1;
    private $c_vendedor;
    private $fecha_cambio_vendedor;
    private $venta_zona;
    private $venta_zona_min;
    private $venta_zona_soles;
    private $venta_zona_min_soles;
    private $flag_nuevos;
    private $flag_esta_cliente_ven;
    private $VENTA_SOLES_19;
    private $VENTA_SOLES_MIN_19;
    private $VENTA_19;
    private $VENTA_MIN_19;
    private $costo_soles_copia2;
    private $costo_dolares_copia2;
    private $costo_soles_19;
    private $costo_dolares_19;
    private $flag_filtro_est_vtas;
    private $flag_bloquea_venta;
    private $pag_inventario;
    private $cant_defento;
    private $precio_d_choche_3001;
    private $codigo_alterno;
    private $c_divicion;
    private $fecha_inicio_ventas;
    private $prod_piezas;
    private $c_desc_alterna;
    private $desc_alterna;
    private $c_articulo_alterno;
    private $flag_articulo_alterno;
    private $por_confencion;
    private $f_ultimo_ingreso;
    private $tipo_de_cambio;
    private $Fecha_Vencimiento;
    private $Flag_estampado;
    private $Terminal;
    private $precio_promo_soles;
    private $precio_promo_dolar;
    private $flag_precio_promo;
    private $factor_util_neto;
    private $flag_programado;
    private $fecha_programado;
    private $flag_doblado;
    private $fecha_doblado;
    private $c_cronografo;
    private $c_cta_admin;
    private $flag_serie;
    private $c_igv;
    private $OBS;
    private $vale;

    function __construct()
    {
        $this->c_articulo = 0;
        $this->c_familia = '';
        $this->c_sub_familia = '';
        $this->cod_tipo = '';
        $this->nombre = '';
        $this->unidad = '';
        $this->c_cuenta_ventas = '';

        $this->c_usuario = '';
        $this->c_local = '';

        $this->flag_activo = '';
        $this->c_clase = '';
        $this->c_calidad = '';
        $this->c_letra_dscto = '';
        $this->c_categoria = '';
        $this->c_cuenta = '';
        $this->otro_nombre = '';
        $this->cod_moneda = '';
        $this->costo_especial = 0;
        $this->costo_obligado = 0;
        $this->costo = 0;
        $this->porc_descto = 0;
        $this->venta = 0;
        $this->cantidad = 0;
        $this->ancho = 0;
        $this->sub_total_us = 0;
        $this->sub_total_soles = 0;
        $this->stock_minimo = 0;
        $this->stock_maximo = 0;
        $this->stock_actual = 0;
        $this->stock_comprometido = 0;
        $this->stock_transito = 0;
        $this->observacion = '';
        $this->ultimo_costo = 0;
        $this->ultima_compra = '';
        $this->ultima_venta = '';
        $this->flag_abc = '';
        $this->factor_mt = 0;
        $this->factor_mt2 = 0;
        $this->unidad_de_compra = '';
        $this->factor_mt3 = 0;
        $this->equivalencia = 0;
        $this->c_cuenta_Compra = '';
        $this->c_S_tipo = '';
        $this->Codprod = '';
        $this->flag_lista_precios = '';
        $this->c_tipo = '';
        $this->procentaje_error = 0;
        $this->c_genero = '';
        $this->flag_importado = '';
        $this->ubicacion = '';
        $this->s_categoria = '';
        $this->venta_soles = 0;
        $this->metros_pieza = 0;
        $this->fam = '';
        $this->flag_congelado = '';
        $this->flag_exportar = '';
        $this->marc_inv = '';
        $this->estante = '';
        $this->casillero = '';
        $this->flag_tienda = '';
        $this->num_documento_compra = '';
        $this->stock_compra = 0;
        $this->stock_compra_fisico = 0;
        $this->stock_compra_comprometido = 0;
        $this->costo_especial_soles = 0;
        $this->flack_costo_soles_esp = '';
        $this->flag_proc_stock = '';
        $this->fecha_act_precio = '';
        $this->flag_proc_stock_copia = '';
        $this->venta_min = 0;
        $this->venta_soles_min = 0;
        $this->flag_diseno_esp = '';
        $this->venta_soles_min_copia_141202 = 0;
        $this->flag_oculta_lista_precios = '';
        $this->venta_soles_adi1 = 0;
        $this->venta_adi1 = 0;
        $this->costo_soles = 0;
        $this->costo_dolares = 0;
        $this->fecha_ingreso = '';
        $this->venta_E_min = 0;
        $this->venta_E_min_soles = 0;
        $this->flag_dibcol_nuevo = '';
        $this->venta_soles_COPIA = 0;
        $this->venta_soles_min_COPIA = 0;
        $this->venta_soles_adi1_COPIA = 0;
        $this->Costo_Soles_COPIA = 0;
        $this->venta_E_min_COPIA = 0;
        $this->venta_E_min_soles_COPIA = 0;
        $this->venta_soles_COPIA_1 = 0;
        $this->venta_soles_min_COPIA1 = 0;
        $this->venta_soles_adi1_COPIA1 = 0;
        $this->c_vendedor = '';
        $this->fecha_cambio_vendedor = '';
        $this->venta_zona = 0;
        $this->venta_zona_min = 0;
        $this->venta_zona_soles = 0;
        $this->venta_zona_min_soles = 0;
        $this->flag_nuevos = '';
        $this->flag_esta_cliente_ven = '';
        $this->VENTA_SOLES_19 = 0;
        $this->VENTA_SOLES_MIN_19 = 0;
        $this->VENTA_19 = 0;
        $this->VENTA_MIN_19 = 0;
        $this->costo_soles_copia2 = 0;
        $this->costo_dolares_copia2 = 0;
        $this->costo_soles_19 = 0;
        $this->costo_dolares_19 = 0;
        $this->flag_filtro_est_vtas = '';
        $this->flag_bloquea_venta = '';
        $this->pag_inventario = '';
        $this->cant_defento = 0;
        $this->precio_d_choche_3001 = 0;
        $this->codigo_alterno = '';
        $this->c_divicion = '';
        $this->fecha_inicio_ventas = '';
        $this->prod_piezas = 0;
        $this->c_desc_alterna = '';
        $this->desc_alterna = '';
        $this->c_articulo_alterno = '';
        $this->flag_articulo_alterno = '';
        $this->por_confencion = '';
        $this->f_ultimo_ingreso = '';
        $this->tipo_de_cambio = 0;
        $this->Fecha_Vencimiento = '';
        $this->Flag_estampado = '';
        $this->Terminal = '';
        $this->precio_promo_soles = 0;
        $this->precio_promo_dolar = 0;
        $this->flag_precio_promo = '';
        $this->factor_util_neto = 0;
        $this->flag_programado = '';
        $this->fecha_programado = '';
        $this->flag_doblado = '';
        $this->fecha_doblado = '';
        $this->c_cronografo = '';
        $this->c_cta_admin = '';
        $this->flag_serie = '';
        $this->c_igv = '';
        $this->OBS = '';
        $this->vale = '';
    }

    public function setC_articulo($c_articulo)
    {
        if(empty($c_articulo)) return;
        $this->c_articulo = self::Clean($c_articulo);
    }

    public function getC_articulo()
    {
        return $this->c_articulo;
    }

    public function setC_familia($c_familia)
    {
        if(empty($c_familia)) return;
        $this->c_familia = self::Clean($c_familia);
    }

    public function getC_familia()
    {
        return $this->c_familia;
    }

    public function setC_sub_familia($c_sub_familia)
    {
        if(empty($c_sub_familia)) return;
        $this->c_sub_familia = self::Clean($c_sub_familia);
    }

    public function getC_sub_familia()
    {
        return $this->c_sub_familia;
    }

    public function setCod_tipo($cod_tipo)
    {
        if(empty($cod_tipo)) return;
        $this->cod_tipo = self::Clean($cod_tipo);
    }

    public function getCod_tipo()
    {
        return $this->cod_tipo;
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

    public function setUnidad($unidad)
    {
        if(empty($unidad)) return;
        $this->unidad = self::Clean($unidad);
    }

    public function getUnidad()
    {
        return $this->unidad;
    }

    public function setC_cuenta_ventas($c_cuenta_ventas)
    {
        if(empty($c_cuenta_ventas)) return;
        $this->c_cuenta_ventas = self::Clean($c_cuenta_ventas);
    }

    public function getC_cuenta_ventas()
    {
        return $this->c_cuenta_ventas;
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

    public function setC_usuario($c_usuario)
    {
        if(empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
    }


    public function setFlag_activo($flag_activo)
    {
        if(empty($flag_activo)) return;
        $this->flag_activo = self::Clean($flag_activo);
    }

    public function getFlag_activo()
    {
        return $this->flag_activo;
    }

    public function setC_clase($c_clase)
    {
        if(empty($c_clase)) return;
        $this->c_clase = self::Clean($c_clase);
    }

    public function getC_clase()
    {
        return $this->c_clase;
    }

    public function setC_calidad($c_calidad)
    {
        if(empty($c_calidad)) return;
        $this->c_calidad = self::Clean($c_calidad);
    }

    public function getC_calidad()
    {
        return $this->c_calidad;
    }

    public function setC_letra_dscto($c_letra_dscto)
    {
        if(empty($c_letra_dscto)) return;
        $this->c_letra_dscto = self::Clean($c_letra_dscto);
    }

    public function getC_letra_dscto()
    {
        return $this->c_letra_dscto;
    }

    public function setC_categoria($c_categoria)
    {
        if(empty($c_categoria)) return;
        $this->c_categoria = self::Clean($c_categoria);
    }

    public function getC_categoria()
    {
        return $this->c_categoria;
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

    public function setOtro_nombre($otro_nombre)
    {
        if(empty($otro_nombre)) return;
        $this->otro_nombre = self::Clean($otro_nombre);
    }

    public function getOtro_nombre()
    {
        return $this->otro_nombre;
    }

    public function setCod_moneda($cod_moneda)
    {
        if(empty($cod_moneda)) return;
        $this->cod_moneda = self::Clean($cod_moneda);
    }

    public function getCod_moneda()
    {
        return $this->cod_moneda;
    }

    public function setCosto_especial($costo_especial)
    {
        if(empty($costo_especial)) return;
        $this->costo_especial = self::Clean($costo_especial);
    }

    public function getCosto_especial()
    {
        return $this->costo_especial;
    }

    public function setCosto_obligado($costo_obligado)
    {
        if(empty($costo_obligado)) return;
        $this->costo_obligado = self::Clean($costo_obligado);
    }

    public function getCosto_obligado()
    {
        return $this->costo_obligado;
    }

    public function setCosto($costo)
    {
        if(empty($costo)) return;
        $this->costo = self::Clean($costo);
    }

    public function getCosto()
    {
        return $this->costo;
    }

    public function setPorc_descto($porc_descto)
    {
        if(empty($porc_descto)) return;
        $this->porc_descto = self::Clean($porc_descto);
    }

    public function getPorc_descto()
    {
        return $this->porc_descto;
    }

    public function setVenta($venta)
    {
        if(empty($venta)) return;
        $this->venta = self::Clean($venta);
    }

    public function getVenta()
    {
        return $this->venta;
    }

    public function setCantidad($cantidad)
    {
        if(empty($cantidad)) return;
        $this->cantidad = self::Clean($cantidad);
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setAncho($ancho)
    {
        if(empty($ancho)) return;
        $this->ancho = self::Clean($ancho);
    }

    public function getAncho()
    {
        return $this->ancho;
    }

    public function setSub_total_us($sub_total_us)
    {
        if(empty($sub_total_us)) return;
        $this->sub_total_us = self::Clean($sub_total_us);
    }

    public function getSub_total_us()
    {
        return $this->sub_total_us;
    }

    public function setSub_total_soles($sub_total_soles)
    {
        if(empty($sub_total_soles)) return;
        $this->sub_total_soles = self::Clean($sub_total_soles);
    }

    public function getSub_total_soles()
    {
        return $this->sub_total_soles;
    }

    public function setStock_minimo($stock_minimo)
    {
        if(empty($stock_minimo)) return;
        $this->stock_minimo = self::Clean($stock_minimo);
    }

    public function getStock_minimo()
    {
        return $this->stock_minimo;
    }

    public function setStock_maximo($stock_maximo)
    {
        if(empty($stock_maximo)) return;
        $this->stock_maximo = self::Clean($stock_maximo);
    }

    public function getStock_maximo()
    {
        return $this->stock_maximo;
    }

    public function setStock_actual($stock_actual)
    {
        if(empty($stock_actual)) return;
        $this->stock_actual = self::Clean($stock_actual);
    }

    public function getStock_actual()
    {
        return $this->stock_actual;
    }

    public function setStock_comprometido($stock_comprometido)
    {
        if(empty($stock_comprometido)) return;
        $this->stock_comprometido = self::Clean($stock_comprometido);
    }

    public function getStock_comprometido()
    {
        return $this->stock_comprometido;
    }

    public function setStock_transito($stock_transito)
    {
        if(empty($stock_transito)) return;
        $this->stock_transito = self::Clean($stock_transito);
    }

    public function getStock_transito()
    {
        return $this->stock_transito;
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

    public function setUltimo_costo($ultimo_costo)
    {
        if(empty($ultimo_costo)) return;
        $this->ultimo_costo = self::Clean($ultimo_costo);
    }

    public function getUltimo_costo()
    {
        return $this->ultimo_costo;
    }

    public function setUltima_compra($ultima_compra)
    {
        if(empty($ultima_compra)) return;
        $this->ultima_compra = self::Clean($ultima_compra);
    }

    public function getUltima_compra()
    {
        return $this->ultima_compra;
    }

    public function setUltima_venta($ultima_venta)
    {
        if(empty($ultima_venta)) return;
        $this->ultima_venta = self::Clean($ultima_venta);
    }

    public function getUltima_venta()
    {
        return $this->ultima_venta;
    }

    public function setFlag_abc($flag_abc)
    {
        if(empty($flag_abc)) return;
        $this->flag_abc = self::Clean($flag_abc);
    }

    public function getFlag_abc()
    {
        return $this->flag_abc;
    }

    public function setFactor_mt($factor_mt)
    {
        if(empty($factor_mt)) return;
        $this->factor_mt = self::Clean($factor_mt);
    }

    public function getFactor_mt()
    {
        return $this->factor_mt;
    }

    public function setFactor_mt2($factor_mt2)
    {
        if(empty($factor_mt2)) return;
        $this->factor_mt2 = self::Clean($factor_mt2);
    }

    public function getFactor_mt2()
    {
        return $this->factor_mt2;
    }

    public function setUnidad_de_compra($unidad_de_compra)
    {
        if(empty($unidad_de_compra)) return;
        $this->unidad_de_compra = self::Clean($unidad_de_compra);
    }

    public function getUnidad_de_compra()
    {
        return $this->unidad_de_compra;
    }

    public function setFactor_mt3($factor_mt3)
    {
        if(empty($factor_mt3)) return;
        $this->factor_mt3 = self::Clean($factor_mt3);
    }

    public function getFactor_mt3()
    {
        return $this->factor_mt3;
    }

    public function setEquivalencia($equivalencia)
    {
        if(empty($equivalencia)) return;
        $this->equivalencia = self::Clean($equivalencia);
    }

    public function getEquivalencia()
    {
        return $this->equivalencia;
    }

    public function setC_cuenta_Compra($c_cuenta_Compra)
    {
        if(empty($c_cuenta_Compra)) return;
        $this->c_cuenta_Compra = self::Clean($c_cuenta_Compra);
    }

    public function getC_cuenta_Compra()
    {
        return $this->c_cuenta_Compra;
    }

    public function setC_S_tipo($c_S_tipo)
    {
        if(empty($c_S_tipo)) return;
        $this->c_S_tipo = self::Clean($c_S_tipo);
    }

    public function getC_S_tipo()
    {
        return $this->c_S_tipo;
    }

    public function setCodprod($Codprod)
    {
        if(empty($Codprod)) return;
        $this->Codprod = self::Clean($Codprod);
    }

    public function getCodprod()
    {
        return $this->Codprod;
    }

    public function setFlag_lista_precios($flag_lista_precios)
    {
        if(empty($flag_lista_precios)) return;
        $this->flag_lista_precios = self::Clean($flag_lista_precios);
    }

    public function getFlag_lista_precios()
    {
        return $this->flag_lista_precios;
    }

    public function setC_tipo($c_tipo)
    {
        if(empty($c_tipo)) return;
        $this->c_tipo = self::Clean($c_tipo);
    }

    public function getC_tipo()
    {
        return $this->c_tipo;
    }

    public function setProcentaje_error($procentaje_error)
    {
        if(empty($procentaje_error)) return;
        $this->procentaje_error = self::Clean($procentaje_error);
    }

    public function getProcentaje_error()
    {
        return $this->procentaje_error;
    }

    public function setC_genero($c_genero)
    {
        if(empty($c_genero)) return;
        $this->c_genero = self::Clean($c_genero);
    }

    public function getC_genero()
    {
        return $this->c_genero;
    }

    public function setFlag_importado($flag_importado)
    {
        if(empty($flag_importado)) return;
        $this->flag_importado = self::Clean($flag_importado);
    }

    public function getFlag_importado()
    {
        return $this->flag_importado;
    }

    public function setUbicacion($ubicacion)
    {
        if(empty($ubicacion)) return;
        $this->ubicacion = self::Clean($ubicacion);
    }

    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    public function setS_categoria($s_categoria)
    {
        if(empty($s_categoria)) return;
        $this->s_categoria = self::Clean($s_categoria);
    }

    public function getS_categoria()
    {
        return $this->s_categoria;
    }

    public function setVenta_soles($venta_soles)
    {
        if(empty($venta_soles)) return;
        $this->venta_soles = self::Clean($venta_soles);
    }

    public function getVenta_soles()
    {
        return $this->venta_soles;
    }

    public function setMetros_pieza($metros_pieza)
    {
        if(empty($metros_pieza)) return;
        $this->metros_pieza = self::Clean($metros_pieza);
    }

    public function getMetros_pieza()
    {
        return $this->metros_pieza;
    }

    public function setFam($fam)
    {
        if(empty($fam)) return;
        $this->fam = self::Clean($fam);
    }

    public function getFam()
    {
        return $this->fam;
    }

    public function setFlag_congelado($flag_congelado)
    {
        if(empty($flag_congelado)) return;
        $this->flag_congelado = self::Clean($flag_congelado);
    }

    public function getFlag_congelado()
    {
        return $this->flag_congelado;
    }

    public function setFlag_exportar($flag_exportar)
    {
        if(empty($flag_exportar)) return;
        $this->flag_exportar = self::Clean($flag_exportar);
    }

    public function getFlag_exportar()
    {
        return $this->flag_exportar;
    }

    public function setMarc_inv($marc_inv)
    {
        if(empty($marc_inv)) return;
        $this->marc_inv = self::Clean($marc_inv);
    }

    public function getMarc_inv()
    {
        return $this->marc_inv;
    }

    public function setEstante($estante)
    {
        if(empty($estante)) return;
        $this->estante = self::Clean($estante);
    }

    public function getEstante()
    {
        return $this->estante;
    }

    public function setCasillero($casillero)
    {
        if(empty($casillero)) return;
        $this->casillero = self::Clean($casillero);
    }

    public function getCasillero()
    {
        return $this->casillero;
    }

    public function setFlag_tienda($flag_tienda)
    {
        if(empty($flag_tienda)) return;
        $this->flag_tienda = self::Clean($flag_tienda);
    }

    public function getFlag_tienda()
    {
        return $this->flag_tienda;
    }

    public function setNum_documento_compra($num_documento_compra)
    {
        if(empty($num_documento_compra)) return;
        $this->num_documento_compra = self::Clean($num_documento_compra);
    }

    public function getNum_documento_compra()
    {
        return $this->num_documento_compra;
    }

    public function setStock_compra($stock_compra)
    {
        if(empty($stock_compra)) return;
        $this->stock_compra = self::Clean($stock_compra);
    }

    public function getStock_compra()
    {
        return $this->stock_compra;
    }

    public function setStock_compra_fisico($stock_compra_fisico)
    {
        if(empty($stock_compra_fisico)) return;
        $this->stock_compra_fisico = self::Clean($stock_compra_fisico);
    }

    public function getStock_compra_fisico()
    {
        return $this->stock_compra_fisico;
    }

    public function setStock_compra_comprometido($stock_compra_comprometido)
    {
        if(empty($stock_compra_comprometido)) return;
        $this->stock_compra_comprometido = self::Clean($stock_compra_comprometido);
    }

    public function getStock_compra_comprometido()
    {
        return $this->stock_compra_comprometido;
    }

    public function setCosto_especial_soles($costo_especial_soles)
    {
        if(empty($costo_especial_soles)) return;
        $this->costo_especial_soles = self::Clean($costo_especial_soles);
    }

    public function getCosto_especial_soles()
    {
        return $this->costo_especial_soles;
    }

    public function setFlack_costo_soles_esp($flack_costo_soles_esp)
    {
        if(empty($flack_costo_soles_esp)) return;
        $this->flack_costo_soles_esp = self::Clean($flack_costo_soles_esp);
    }

    public function getFlack_costo_soles_esp()
    {
        return $this->flack_costo_soles_esp;
    }

    public function setFlag_proc_stock($flag_proc_stock)
    {
        if(empty($flag_proc_stock)) return;
        $this->flag_proc_stock = self::Clean($flag_proc_stock);
    }

    public function getFlag_proc_stock()
    {
        return $this->flag_proc_stock;
    }

    public function setFecha_act_precio($fecha_act_precio)
    {
        if(empty($fecha_act_precio)) return;
        $this->fecha_act_precio = self::Clean($fecha_act_precio);
    }

    public function getFecha_act_precio()
    {
        return $this->fecha_act_precio;
    }

    public function setFlag_proc_stock_copia($flag_proc_stock_copia)
    {
        if(empty($flag_proc_stock_copia)) return;
        $this->flag_proc_stock_copia = self::Clean($flag_proc_stock_copia);
    }

    public function getFlag_proc_stock_copia()
    {
        return $this->flag_proc_stock_copia;
    }

    public function setVenta_min($venta_min)
    {
        if(empty($venta_min)) return;
        $this->venta_min = self::Clean($venta_min);
    }

    public function getVenta_min()
    {
        return $this->venta_min;
    }

    public function setVenta_soles_min($venta_soles_min)
    {
        if(empty($venta_soles_min)) return;
        $this->venta_soles_min = self::Clean($venta_soles_min);
    }

    public function getVenta_soles_min()
    {
        return $this->venta_soles_min;
    }

    public function setFlag_diseno_esp($flag_diseno_esp)
    {
        if(empty($flag_diseno_esp)) return;
        $this->flag_diseno_esp = self::Clean($flag_diseno_esp);
    }

    public function getFlag_diseno_esp()
    {
        return $this->flag_diseno_esp;
    }

    public function setVenta_soles_min_copia_141202($venta_soles_min_copia_141202)
    {
        if(empty($venta_soles_min_copia_141202)) return;
        $this->venta_soles_min_copia_141202 = self::Clean($venta_soles_min_copia_141202);
    }

    public function getVenta_soles_min_copia_141202()
    {
        return $this->venta_soles_min_copia_141202;
    }

    public function setFlag_oculta_lista_precios($flag_oculta_lista_precios)
    {
        if(empty($flag_oculta_lista_precios)) return;
        $this->flag_oculta_lista_precios = self::Clean($flag_oculta_lista_precios);
    }

    public function getFlag_oculta_lista_precios()
    {
        return $this->flag_oculta_lista_precios;
    }

    public function setVenta_soles_adi1($venta_soles_adi1)
    {
        if(empty($venta_soles_adi1)) return;
        $this->venta_soles_adi1 = self::Clean($venta_soles_adi1);
    }

    public function getVenta_soles_adi1()
    {
        return $this->venta_soles_adi1;
    }

    public function setVenta_adi1($venta_adi1)
    {
        if(empty($venta_adi1)) return;
        $this->venta_adi1 = self::Clean($venta_adi1);
    }

    public function getVenta_adi1()
    {
        return $this->venta_adi1;
    }

    public function setCosto_soles($costo_soles)
    {
        if(empty($costo_soles)) return;
        $this->costo_soles = self::Clean($costo_soles);
    }

    public function getCosto_soles()
    {
        return $this->costo_soles;
    }

    public function setCosto_dolares($costo_dolares)
    {
        if(empty($costo_dolares)) return;
        $this->costo_dolares = self::Clean($costo_dolares);
    }

    public function getCosto_dolares()
    {
        return $this->costo_dolares;
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

    public function setVenta_E_min($venta_E_min)
    {
        if(empty($venta_E_min)) return;
        $this->venta_E_min = self::Clean($venta_E_min);
    }

    public function getVenta_E_min()
    {
        return $this->venta_E_min;
    }

    public function setVenta_E_min_soles($venta_E_min_soles)
    {
        if(empty($venta_E_min_soles)) return;
        $this->venta_E_min_soles = self::Clean($venta_E_min_soles);
    }

    public function getVenta_E_min_soles()
    {
        return $this->venta_E_min_soles;
    }

    public function setFlag_dibcol_nuevo($flag_dibcol_nuevo)
    {
        if(empty($flag_dibcol_nuevo)) return;
        $this->flag_dibcol_nuevo = self::Clean($flag_dibcol_nuevo);
    }

    public function getFlag_dibcol_nuevo()
    {
        return $this->flag_dibcol_nuevo;
    }

    public function setVenta_soles_COPIA($venta_soles_COPIA)
    {
        if(empty($venta_soles_COPIA)) return;
        $this->venta_soles_COPIA = self::Clean($venta_soles_COPIA);
    }

    public function getVenta_soles_COPIA()
    {
        return $this->venta_soles_COPIA;
    }

    public function setVenta_soles_min_COPIA($venta_soles_min_COPIA)
    {
        if(empty($venta_soles_min_COPIA)) return;
        $this->venta_soles_min_COPIA = self::Clean($venta_soles_min_COPIA);
    }

    public function getVenta_soles_min_COPIA()
    {
        return $this->venta_soles_min_COPIA;
    }

    public function setVenta_soles_adi1_COPIA($venta_soles_adi1_COPIA)
    {
        if(empty($venta_soles_adi1_COPIA)) return;
        $this->venta_soles_adi1_COPIA = self::Clean($venta_soles_adi1_COPIA);
    }

    public function getVenta_soles_adi1_COPIA()
    {
        return $this->venta_soles_adi1_COPIA;
    }

    public function setCosto_Soles_COPIA($Costo_Soles_COPIA)
    {
        if(empty($Costo_Soles_COPIA)) return;
        $this->Costo_Soles_COPIA = self::Clean($Costo_Soles_COPIA);
    }

    public function getCosto_Soles_COPIA()
    {
        return $this->Costo_Soles_COPIA;
    }

    public function setVenta_E_min_COPIA($venta_E_min_COPIA)
    {
        if(empty($venta_E_min_COPIA)) return;
        $this->venta_E_min_COPIA = self::Clean($venta_E_min_COPIA);
    }

    public function getVenta_E_min_COPIA()
    {
        return $this->venta_E_min_COPIA;
    }

    public function setVenta_E_min_soles_COPIA($venta_E_min_soles_COPIA)
    {
        if(empty($venta_E_min_soles_COPIA)) return;
        $this->venta_E_min_soles_COPIA = self::Clean($venta_E_min_soles_COPIA);
    }

    public function getVenta_E_min_soles_COPIA()
    {
        return $this->venta_E_min_soles_COPIA;
    }

    public function setVenta_soles_COPIA_1($venta_soles_COPIA_1)
    {
        if(empty($venta_soles_COPIA_1)) return;
        $this->venta_soles_COPIA_1 = self::Clean($venta_soles_COPIA_1);
    }

    public function getVenta_soles_COPIA_1()
    {
        return $this->venta_soles_COPIA_1;
    }

    public function setVenta_soles_min_COPIA1($venta_soles_min_COPIA1)
    {
        if(empty($venta_soles_min_COPIA1)) return;
        $this->venta_soles_min_COPIA1 = self::Clean($venta_soles_min_COPIA1);
    }

    public function getVenta_soles_min_COPIA1()
    {
        return $this->venta_soles_min_COPIA1;
    }

    public function setVenta_soles_adi1_COPIA1($venta_soles_adi1_COPIA1)
    {
        if(empty($venta_soles_adi1_COPIA1)) return;
        $this->venta_soles_adi1_COPIA1 = self::Clean($venta_soles_adi1_COPIA1);
    }

    public function getVenta_soles_adi1_COPIA1()
    {
        return $this->venta_soles_adi1_COPIA1;
    }

    public function setC_vendedor($c_vendedor)
    {
        if(empty($c_vendedor)) return;
        $this->c_vendedor = self::Clean($c_vendedor);
    }

    public function getC_vendedor()
    {
        return $this->c_vendedor;
    }

    public function setFecha_cambio_vendedor($fecha_cambio_vendedor)
    {
        if(empty($fecha_cambio_vendedor)) return;
        $this->fecha_cambio_vendedor = self::Clean($fecha_cambio_vendedor);
    }

    public function getFecha_cambio_vendedor()
    {
        return $this->fecha_cambio_vendedor;
    }

    public function setVenta_zona($venta_zona)
    {
        if(empty($venta_zona)) return;
        $this->venta_zona = self::Clean($venta_zona);
    }

    public function getVenta_zona()
    {
        return $this->venta_zona;
    }

    public function setVenta_zona_min($venta_zona_min)
    {
        if(empty($venta_zona_min)) return;
        $this->venta_zona_min = self::Clean($venta_zona_min);
    }

    public function getVenta_zona_min()
    {
        return $this->venta_zona_min;
    }

    public function setVenta_zona_soles($venta_zona_soles)
    {
        if(empty($venta_zona_soles)) return;
        $this->venta_zona_soles = self::Clean($venta_zona_soles);
    }

    public function getVenta_zona_soles()
    {
        return $this->venta_zona_soles;
    }

    public function setVenta_zona_min_soles($venta_zona_min_soles)
    {
        if(empty($venta_zona_min_soles)) return;
        $this->venta_zona_min_soles = self::Clean($venta_zona_min_soles);
    }

    public function getVenta_zona_min_soles()
    {
        return $this->venta_zona_min_soles;
    }

    public function setFlag_nuevos($flag_nuevos)
    {
        if(empty($flag_nuevos)) return;
        $this->flag_nuevos = self::Clean($flag_nuevos);
    }

    public function getFlag_nuevos()
    {
        return $this->flag_nuevos;
    }

    public function setFlag_esta_cliente_ven($flag_esta_cliente_ven)
    {
        if(empty($flag_esta_cliente_ven)) return;
        $this->flag_esta_cliente_ven = self::Clean($flag_esta_cliente_ven);
    }

    public function getFlag_esta_cliente_ven()
    {
        return $this->flag_esta_cliente_ven;
    }

    public function setVENTA_SOLES_19($VENTA_SOLES_19)
    {
        if(empty($VENTA_SOLES_19)) return;
        $this->VENTA_SOLES_19 = self::Clean($VENTA_SOLES_19);
    }

    public function getVENTA_SOLES_19()
    {
        return $this->VENTA_SOLES_19;
    }

    public function setVENTA_SOLES_MIN_19($VENTA_SOLES_MIN_19)
    {
        if(empty($VENTA_SOLES_MIN_19)) return;
        $this->VENTA_SOLES_MIN_19 = self::Clean($VENTA_SOLES_MIN_19);
    }

    public function getVENTA_SOLES_MIN_19()
    {
        return $this->VENTA_SOLES_MIN_19;
    }

    public function setVENTA_19($VENTA_19)
    {
        if(empty($VENTA_19)) return;
        $this->VENTA_19 = self::Clean($VENTA_19);
    }

    public function getVENTA_19()
    {
        return $this->VENTA_19;
    }

    public function setVENTA_MIN_19($VENTA_MIN_19)
    {
        if(empty($VENTA_MIN_19)) return;
        $this->VENTA_MIN_19 = self::Clean($VENTA_MIN_19);
    }

    public function getVENTA_MIN_19()
    {
        return $this->VENTA_MIN_19;
    }

    public function setCosto_soles_copia2($costo_soles_copia2)
    {
        if(empty($costo_soles_copia2)) return;
        $this->costo_soles_copia2 = self::Clean($costo_soles_copia2);
    }

    public function getCosto_soles_copia2()
    {
        return $this->costo_soles_copia2;
    }

    public function setCosto_dolares_copia2($costo_dolares_copia2)
    {
        if(empty($costo_dolares_copia2)) return;
        $this->costo_dolares_copia2 = self::Clean($costo_dolares_copia2);
    }

    public function getCosto_dolares_copia2()
    {
        return $this->costo_dolares_copia2;
    }

    public function setCosto_soles_19($costo_soles_19)
    {
        if(empty($costo_soles_19)) return;
        $this->costo_soles_19 = self::Clean($costo_soles_19);
    }

    public function getCosto_soles_19()
    {
        return $this->costo_soles_19;
    }

    public function setCosto_dolares_19($costo_dolares_19)
    {
        if(empty($costo_dolares_19)) return;
        $this->costo_dolares_19 = self::Clean($costo_dolares_19);
    }

    public function getCosto_dolares_19()
    {
        return $this->costo_dolares_19;
    }

    public function setFlag_filtro_est_vtas($flag_filtro_est_vtas)
    {
        if(empty($flag_filtro_est_vtas)) return;
        $this->flag_filtro_est_vtas = self::Clean($flag_filtro_est_vtas);
    }

    public function getFlag_filtro_est_vtas()
    {
        return $this->flag_filtro_est_vtas;
    }

    public function setFlag_bloquea_venta($flag_bloquea_venta)
    {
        if(empty($flag_bloquea_venta)) return;
        $this->flag_bloquea_venta = self::Clean($flag_bloquea_venta);
    }

    public function getFlag_bloquea_venta()
    {
        return $this->flag_bloquea_venta;
    }

    public function setPag_inventario($pag_inventario)
    {
        if(empty($pag_inventario)) return;
        $this->pag_inventario = self::Clean($pag_inventario);
    }

    public function getPag_inventario()
    {
        return $this->pag_inventario;
    }

    public function setCant_defento($cant_defento)
    {
        if(empty($cant_defento)) return;
        $this->cant_defento = self::Clean($cant_defento);
    }

    public function getCant_defento()
    {
        return $this->cant_defento;
    }

    public function setPrecio_d_choche_3001($precio_d_choche_3001)
    {
        if(empty($precio_d_choche_3001)) return;
        $this->precio_d_choche_3001 = self::Clean($precio_d_choche_3001);
    }

    public function getPrecio_d_choche_3001()
    {
        return $this->precio_d_choche_3001;
    }

    public function setCodigo_alterno($codigo_alterno)
    {
        if(empty($codigo_alterno)) return;
        $this->codigo_alterno = self::Clean($codigo_alterno);
    }

    public function getCodigo_alterno()
    {
        return $this->codigo_alterno;
    }

    public function setC_divicion($c_divicion)
    {
        if(empty($c_divicion)) return;
        $this->c_divicion = self::Clean($c_divicion);
    }

    public function getC_divicion()
    {
        return $this->c_divicion;
    }

    public function setFecha_inicio_ventas($fecha_inicio_ventas)
    {
        if(empty($fecha_inicio_ventas)) return;
        $this->fecha_inicio_ventas = self::Clean($fecha_inicio_ventas);
    }

    public function getFecha_inicio_ventas()
    {
        return $this->fecha_inicio_ventas;
    }

    public function setProd_piezas($prod_piezas)
    {
        if(empty($prod_piezas)) return;
        $this->prod_piezas = self::Clean($prod_piezas);
    }

    public function getProd_piezas()
    {
        return $this->prod_piezas;
    }

    public function setC_desc_alterna($c_desc_alterna)
    {
        if(empty($c_desc_alterna)) return;
        $this->c_desc_alterna = self::Clean($c_desc_alterna);
    }

    public function getC_desc_alterna()
    {
        return $this->c_desc_alterna;
    }

    public function setDesc_alterna($desc_alterna)
    {
        if(empty($desc_alterna)) return;
        $this->desc_alterna = self::Clean($desc_alterna);
    }

    public function getDesc_alterna()
    {
        return $this->desc_alterna;
    }

    public function setC_articulo_alterno($c_articulo_alterno)
    {
        if(empty($c_articulo_alterno)) return;
        $this->c_articulo_alterno = self::Clean($c_articulo_alterno);
    }

    public function getC_articulo_alterno()
    {
        return $this->c_articulo_alterno;
    }

    public function setFlag_articulo_alterno($flag_articulo_alterno)
    {
        if(empty($flag_articulo_alterno)) return;
        $this->flag_articulo_alterno = self::Clean($flag_articulo_alterno);
    }

    public function getFlag_articulo_alterno()
    {
        return $this->flag_articulo_alterno;
    }

    public function setPor_confencion($por_confencion)
    {
        if(empty($por_confencion)) return;
        $this->por_confencion = self::Clean($por_confencion);
    }

    public function getPor_confencion()
    {
        return $this->por_confencion;
    }

    public function setF_ultimo_ingreso($f_ultimo_ingreso)
    {
        if(empty($f_ultimo_ingreso)) return;
        $this->f_ultimo_ingreso = self::Clean($f_ultimo_ingreso);
    }

    public function getF_ultimo_ingreso()
    {
        return $this->f_ultimo_ingreso;
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

    public function setFecha_Vencimiento($Fecha_Vencimiento)
    {
        if(empty($Fecha_Vencimiento)) return;
        $this->Fecha_Vencimiento = self::Clean($Fecha_Vencimiento);
    }

    public function getFecha_Vencimiento()
    {
        return $this->Fecha_Vencimiento;
    }

    public function setFlag_estampado($Flag_estampado)
    {
        if(empty($Flag_estampado)) return;
        $this->Flag_estampado = self::Clean($Flag_estampado);
    }

    public function getFlag_estampado()
    {
        return $this->Flag_estampado;
    }

    public function setTerminal($Terminal)
    {
        if(empty($Terminal)) return;
        $this->Terminal = self::Clean($Terminal);
    }

    public function getTerminal()
    {
        return $this->Terminal;
    }

    public function setPrecio_promo_soles($precio_promo_soles)
    {
        if(empty($precio_promo_soles)) return;
        $this->precio_promo_soles = self::Clean($precio_promo_soles);
    }

    public function getPrecio_promo_soles()
    {
        return $this->precio_promo_soles;
    }

    public function setPrecio_promo_dolar($precio_promo_dolar)
    {
        if(empty($precio_promo_dolar)) return;
        $this->precio_promo_dolar = self::Clean($precio_promo_dolar);
    }

    public function getPrecio_promo_dolar()
    {
        return $this->precio_promo_dolar;
    }

    public function setFlag_precio_promo($flag_precio_promo)
    {
        if(empty($flag_precio_promo)) return;
        $this->flag_precio_promo = self::Clean($flag_precio_promo);
    }

    public function getFlag_precio_promo()
    {
        return $this->flag_precio_promo;
    }

    public function setFactor_util_neto($factor_util_neto)
    {
        if(empty($factor_util_neto)) return;
        $this->factor_util_neto = self::Clean($factor_util_neto);
    }

    public function getFactor_util_neto()
    {
        return $this->factor_util_neto;
    }

    public function setFlag_programado($flag_programado)
    {
        if(empty($flag_programado)) return;
        $this->flag_programado = self::Clean($flag_programado);
    }

    public function getFlag_programado()
    {
        return $this->flag_programado;
    }

    public function setFecha_programado($fecha_programado)
    {
        if(empty($fecha_programado)) return;
        $this->fecha_programado = self::Clean($fecha_programado);
    }

    public function getFecha_programado()
    {
        return $this->fecha_programado;
    }

    public function setFlag_doblado($flag_doblado)
    {
        if(empty($flag_doblado)) return;
        $this->flag_doblado = self::Clean($flag_doblado);
    }

    public function getFlag_doblado()
    {
        return $this->flag_doblado;
    }

    public function setFecha_doblado($fecha_doblado)
    {
        if(empty($fecha_doblado)) return;
        $this->fecha_doblado = self::Clean($fecha_doblado);
    }

    public function getFecha_doblado()
    {
        return $this->fecha_doblado;
    }

    public function setC_cronografo($c_cronografo)
    {
        if(empty($c_cronografo)) return;
        $this->c_cronografo = self::Clean($c_cronografo);
    }

    public function getC_cronografo()
    {
        return $this->c_cronografo;
    }

    public function setC_cta_admin($c_cta_admin)
    {
        if(empty($c_cta_admin)) return;
        $this->c_cta_admin = self::Clean($c_cta_admin);
    }

    public function getC_cta_admin()
    {
        return $this->c_cta_admin;
    }

    public function setFlag_serie($flag_serie)
    {
        if(empty($flag_serie)) return;
        $this->flag_serie = self::Clean($flag_serie);
    }

    public function getFlag_serie()
    {
        return $this->flag_serie;
    }

    public function setC_igv($c_igv)
    {
        if(empty($c_igv)) return;
        $this->c_igv = self::Clean($c_igv);
    }

    public function getC_igv()
    {
        return $this->c_igv;
    }

    public function setOBS($OBS)
    {
        if(empty($OBS)) return;
        $this->OBS = self::Clean($OBS);
    }

    public function getOBS()
    {
        return $this->OBS;
    }

    public function setVale($vale)
    {
        if(empty($vale)) return;
        $this->vale = self::Clean($vale);
    }

    public function getVale()
    {
        return $this->vale;
    }

}