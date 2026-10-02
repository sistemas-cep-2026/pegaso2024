<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cont_items_voucher extends Parse
{
    private $cc_voucher_det;
    private $cc_voucher;
    private $numero;
    private $linea;
    private $c_cuenta;
    private $debe;
    private $haber;
    private $flag_automaticas;
    private $flag_centro_costo;
    private $c_cuenta_origen;
    private $porc_distribuicion;
    private $porc_ventas;
    private $porc_administracion;
    private $porc_produccion;
    private $porc_financiero;
    private $debe_dolar;
    private $tipo_de_cambio;
    private $haber_dolar;
    private $flag_proceso_ajuste;
    private $flag_inaf_afect;
    private $cod_documento;
    private $num_documento;
    private $fecha_emision;
    private $fecha_vencimiento;
    private $ruc;
    private $c_persona_items;
    private $c_cuenta_obs;
    private $c_centro_de_costo;
    private $numerox;

    private $opcd;
    

    function __construct()
    {
        $this->cc_voucher_det = 0;
        $this->cc_voucher = 0;
        $this->numero = '';
        $this->linea = 0;
        $this->c_cuenta = '';
        $this->debe = 0;
        $this->haber = 0;
        $this->flag_automaticas = '';
        $this->flag_centro_costo = '';
        $this->c_cuenta_origen = '';
        $this->porc_distribuicion = 0;
        $this->porc_ventas = 0;
        $this->porc_administracion = 0;
        $this->porc_produccion = 0;
        $this->porc_financiero = 0;
        $this->debe_dolar = 0;
        $this->tipo_de_cambio = 0;
        $this->haber_dolar = 0;
        $this->flag_proceso_ajuste = '';
        $this->flag_inaf_afect = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->fecha_emision = '';
        $this->fecha_vencimiento = '';
        $this->ruc = '';
        $this->c_persona_items = '';
        $this->c_cuenta_obs = '';
        $this->c_centro_de_costo = '';
        $this->numerox = '';
        
        $this->opcd='';
    }

    public function setCc_voucher_det($cc_voucher_det)
    {
        if(empty($cc_voucher_det)) return;
        $this->cc_voucher_det = self::Clean($cc_voucher_det);
    }

    public function getCc_voucher_det()
    {
        return $this->cc_voucher_det;
    }

    public function setCc_voucher($cc_voucher)
    {
        if(empty($cc_voucher)) return;
        $this->cc_voucher = self::Clean($cc_voucher);
    }

    public function getCc_voucher()
    {
        return $this->cc_voucher;
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

    public function setLinea($linea)
    {
        if(empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
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

    public function setDebe($debe)
    {
        if(empty($debe)) return;
        $this->debe = self::Clean($debe);
    }

    public function getDebe()
    {
        return $this->debe;
    }

    public function setHaber($haber)
    {
        if(empty($haber)) return;
        $this->haber = self::Clean($haber);
    }

    public function getHaber()
    {
        return $this->haber;
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

    public function setPorc_distribuicion($porc_distribuicion)
    {
        if(empty($porc_distribuicion)) return;
        $this->porc_distribuicion = self::Clean($porc_distribuicion);
    }

    public function getPorc_distribuicion()
    {
        return $this->porc_distribuicion;
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

    public function setDebe_dolar($debe_dolar)
    {
        if(empty($debe_dolar)) return;
        $this->debe_dolar = self::Clean($debe_dolar);
    }

    public function getDebe_dolar()
    {
        return $this->debe_dolar;
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

    public function setHaber_dolar($haber_dolar)
    {
        if(empty($haber_dolar)) return;
        $this->haber_dolar = self::Clean($haber_dolar);
    }

    public function getHaber_dolar()
    {
        return $this->haber_dolar;
    }

    public function setFlag_proceso_ajuste($flag_proceso_ajuste)
    {
        if(empty($flag_proceso_ajuste)) return;
        $this->flag_proceso_ajuste = self::Clean($flag_proceso_ajuste);
    }

    public function getFlag_proceso_ajuste()
    {
        return $this->flag_proceso_ajuste;
    }

    public function setFlag_inaf_afect($flag_inaf_afect)
    {
        if(empty($flag_inaf_afect)) return;
        $this->flag_inaf_afect = self::Clean($flag_inaf_afect);
    }

    public function getFlag_inaf_afect()
    {
        return $this->flag_inaf_afect;
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

    public function setFecha_emision($fecha_emision)
    {
        if(empty($fecha_emision)) return;
        $this->fecha_emision = self::Clean($fecha_emision);
    }

    public function getFecha_emision()
    {
        return $this->fecha_emision;
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

    public function setRuc($ruc)
    {
        if(empty($ruc)) return;
        $this->ruc = self::Clean($ruc);
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function setC_persona_items($c_persona_items)
    {
        if(empty($c_persona_items)) return;
        $this->c_persona_items = self::Clean($c_persona_items);
    }

    public function getC_persona_items()
    {
        return $this->c_persona_items;
    }

    public function setC_cuenta_obs($c_cuenta_obs)
    {
        if(empty($c_cuenta_obs)) return;
        $this->c_cuenta_obs = self::Clean($c_cuenta_obs);
    }

    public function getC_cuenta_obs()
    {
        return $this->c_cuenta_obs;
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

    public function setNumerox($numerox)
    {
        if(empty($numerox)) return;
        $this->numerox = self::Clean($numerox);
    }

    public function getNumerox()
    {
        return $this->numerox;
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

}