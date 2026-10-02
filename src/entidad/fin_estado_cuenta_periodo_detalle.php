<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_estado_cuenta_periodo_detalle extends Parse
{
    private $cc_identidad;
    private $c_persona;
    private $c_entidad_pagadora;
    private $c_periodo;
    private $fecha;
    private $cod_documento;
    private $boleta;
    private $importe;
    private $observacion;
    private $ddirecto;
    private $flag_grabado;
    private $cod_concepto;
    private $num_benef;
    private $ccceips_codigo;
    private $detalle;
    private $c_entidad;
    private $pendiente;
    private $x;

    private $cc_local;
    private $periodo;
    private $cod_presupuestal;

    function __construct()
    {
        $this->cc_identidad = 0;
        $this->c_persona = '';
        $this->c_entidad_pagadora = '';
        $this->c_periodo = '';
        $this->fecha = '';
        $this->cod_documento = '';
        $this->boleta = '';
        $this->importe = '';
        $this->observacion = '';
        $this->ddirecto = '';
        $this->flag_grabado = '';
        $this->cod_concepto = '';
        $this->num_benef = 0;
        $this->ccceips_codigo = '';
        $this->detalle = '';
        $this->c_entidad = '';
        $this->pendiente = '';
        $this->x = '';

        $this->cc_local = '';
        $this->periodo = '';
        $this->cod_presupuestal = '';
    }

    public function setCc_identidad($cc_identidad)
    {
        if (empty($cc_identidad)) return;
        $this->cc_identidad = self::Clean($cc_identidad);
    }

    public function getCc_identidad()
    {
        return $this->cc_identidad;
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

    public function setC_entidad_pagadora($c_entidad_pagadora)
    {
        if (empty($c_entidad_pagadora)) return;
        $this->c_entidad_pagadora = self::Clean($c_entidad_pagadora);
    }

    public function getC_entidad_pagadora()
    {
        return $this->c_entidad_pagadora;
    }

    public function setC_periodo($c_periodo)
    {
        if (empty($c_periodo)) return;
        $this->c_periodo = self::Clean($c_periodo);
    }

    public function getC_periodo()
    {
        return $this->c_periodo;
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

    public function setCod_documento($cod_documento)
    {
        if (empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento()
    {
        return $this->cod_documento;
    }

    public function setBoleta($boleta)
    {
        if (empty($boleta)) return;
        $this->boleta = self::Clean($boleta);
    }

    public function getBoleta()
    {
        return $this->boleta;
    }

    public function setImporte($importe)
    {
        if (empty($importe)) return;
        $this->importe = self::Clean($importe);
    }

    public function getImporte()
    {
        return $this->importe;
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

    public function setDdirecto($ddirecto)
    {
        if (empty($ddirecto)) return;
        $this->ddirecto = self::Clean($ddirecto);
    }

    public function getDdirecto()
    {
        return $this->ddirecto;
    }

    public function setFlag_grabado($flag_grabado)
    {
        if (empty($flag_grabado)) return;
        $this->flag_grabado = self::Clean($flag_grabado);
    }

    public function getFlag_grabado()
    {
        return $this->flag_grabado;
    }

    public function setCod_concepto($cod_concepto)
    {
        if (empty($cod_concepto)) return;
        $this->cod_concepto = self::Clean($cod_concepto);
    }

    public function getCod_concepto()
    {
        return $this->cod_concepto;
    }

    public function setNum_benef($num_benef)
    {
        if (empty($num_benef)) return;
        $this->num_benef = self::Clean($num_benef);
    }

    public function getNum_benef()
    {
        return $this->num_benef;
    }

    public function setCcceips_codigo($ccceips_codigo)
    {
        if (empty($ccceips_codigo)) return;
        $this->ccceips_codigo = self::Clean($ccceips_codigo);
    }

    public function getCcceips_codigo()
    {
        return $this->ccceips_codigo;
    }

    public function setDetalle($detalle)
    {
        if (empty($detalle)) return;
        $this->detalle = self::Clean($detalle);
    }

    public function getDetalle()
    {
        return $this->detalle;
    }

    public function setC_entidad($c_entidad)
    {
        if (empty($c_entidad)) return;
        $this->c_entidad = self::Clean($c_entidad);
    }

    public function getC_entidad()
    {
        return $this->c_entidad;
    }

    public function setPendiente($pendiente)
    {
        if (empty($pendiente)) return;
        $this->pendiente = self::Clean($pendiente);
    }

    public function getPendiente()
    {
        return $this->pendiente;
    }

    public function setX($x)
    {
        if (empty($x)) return;
        $this->x = self::Clean($x);
    }

    public function getX()
    {
        return $this->x;
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
    public function setPeriodo($periodo)
    {
        if (empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setCod_presupuestal($cod_presupuestal)
    {
        if (empty($cod_presupuestal)) return;
        $this->cod_presupuestal = self::Clean($cod_presupuestal);
    }

    public function getCod_presupuestal()
    {
        return $this->cod_presupuestal;
    }
}
