<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_periodos extends Parse
{
    private $c_ano;
    private $c_mes;
    private $fecha_inicial;
    private $fecha_final;
    private $cmprb_compras_nac;
    private $cmprb_compras_ext;
    private $cmprb_bancos;
    private $voucher_contable;
    private $cmprb_caja_chica;
    private $tipo_de_cambio;
    private $flag_cierre_compras;
    private $flag_cierre_bancos;
    private $flag_cierre_contabilidad;
    private $flag_cierre_fondos;
    private $flag_cierre_empleado;
    private $fecha_inicial_empleado;
    private $fecha_final_empleado;
    private $flag_cierre_obrero_primera;
    private $fecha_inicial_primera;
    private $fecha_final_primera;
    private $flag_cierre_obrero_segunda;
    private $fecha_inicial_segunda;
    private $fecha_final_segunda;
    private $flag_cierre_obrero_tercera;
    private $fecha_inicial_tercera;
    private $fecha_final_tercera;
    private $flag_cierre_obrero_cuarta;
    private $fecha_inicial_cuarta;
    private $fecha_final_cuarta;
    private $flag_cierre_obrero_quinta;
    private $fecha_inicial_quinta;
    private $fecha_final_quinta;
    private $cmprb_compras_caja_chica;
    private $contrato;
    private $cmprb_planilla_letras;
    private $cmprb_recibo_honorarios;
    private $cmprb_fondos;
    private $flag_cierre_ventas;
    private $igv;
    private $retencion_4;
    private $pla_essalud;
    private $recaudo_bcp_666;
    private $recaudo_bbva_571;

    function __construct()
    {
        $this->c_ano = '';
        $this->c_mes = '';
        $this->fecha_inicial = '';
        $this->fecha_final = '';
        $this->cmprb_compras_nac = '';
        $this->cmprb_compras_ext = '';
        $this->cmprb_bancos = '';
        $this->voucher_contable = '';
        $this->cmprb_caja_chica = '';
        $this->tipo_de_cambio = 0;
        $this->flag_cierre_compras = '';
        $this->flag_cierre_bancos = '';
        $this->flag_cierre_contabilidad = '';
        $this->flag_cierre_fondos = '';
        $this->flag_cierre_empleado = '';
        $this->fecha_inicial_empleado = '';
        $this->fecha_final_empleado = '';
        $this->flag_cierre_obrero_primera = '';
        $this->fecha_inicial_primera = '';
        $this->fecha_final_primera = '';
        $this->flag_cierre_obrero_segunda = '';
        $this->fecha_inicial_segunda = '';
        $this->fecha_final_segunda = '';
        $this->flag_cierre_obrero_tercera = '';
        $this->fecha_inicial_tercera = '';
        $this->fecha_final_tercera = '';
        $this->flag_cierre_obrero_cuarta = '';
        $this->fecha_inicial_cuarta = '';
        $this->fecha_final_cuarta = '';
        $this->flag_cierre_obrero_quinta = '';
        $this->fecha_inicial_quinta = '';
        $this->fecha_final_quinta = '';
        $this->cmprb_compras_caja_chica = '';
        $this->contrato = '';
        $this->cmprb_planilla_letras = '';
        $this->cmprb_recibo_honorarios = '';
        $this->cmprb_fondos = '';
        $this->flag_cierre_ventas = '';
        $this->igv = 0;
        $this->retencion_4 = 0;
        $this->pla_essalud = 0;
        $this->recaudo_bcp_666 = 0;
        $this->recaudo_bbva_571 = 0;
    }

    public function setC_ano($c_ano)
    {
        if (empty($c_ano)) return;
        $this->c_ano = self::Clean($c_ano);
    }

    public function getC_ano()
    {
        return $this->c_ano;
    }

    public function setC_mes($c_mes)
    {
        if (empty($c_mes)) return;
        $this->c_mes = self::Clean($c_mes);
    }

    public function getC_mes()
    {
        return $this->c_mes;
    }

    public function setFecha_inicial($fecha_inicial)
    {
        if (empty($fecha_inicial)) return;
        $this->fecha_inicial = self::Clean($fecha_inicial);
    }

    public function getFecha_inicial()
    {
        return $this->fecha_inicial;
    }

    public function setFecha_final($fecha_final)
    {
        if (empty($fecha_final)) return;
        $this->fecha_final = self::Clean($fecha_final);
    }

    public function getFecha_final()
    {
        return $this->fecha_final;
    }

    public function setCmprb_compras_nac($cmprb_compras_nac)
    {
        if (empty($cmprb_compras_nac)) return;
        $this->cmprb_compras_nac = self::Clean($cmprb_compras_nac);
    }

    public function getCmprb_compras_nac()
    {
        return $this->cmprb_compras_nac;
    }

    public function setCmprb_compras_ext($cmprb_compras_ext)
    {
        if (empty($cmprb_compras_ext)) return;
        $this->cmprb_compras_ext = self::Clean($cmprb_compras_ext);
    }

    public function getCmprb_compras_ext()
    {
        return $this->cmprb_compras_ext;
    }

    public function setCmprb_bancos($cmprb_bancos)
    {
        if (empty($cmprb_bancos)) return;
        $this->cmprb_bancos = self::Clean($cmprb_bancos);
    }

    public function getCmprb_bancos()
    {
        return $this->cmprb_bancos;
    }

    public function setVoucher_contable($voucher_contable)
    {
        if (empty($voucher_contable)) return;
        $this->voucher_contable = self::Clean($voucher_contable);
    }

    public function getVoucher_contable()
    {
        return $this->voucher_contable;
    }

    public function setCmprb_caja_chica($cmprb_caja_chica)
    {
        if (empty($cmprb_caja_chica)) return;
        $this->cmprb_caja_chica = self::Clean($cmprb_caja_chica);
    }

    public function getCmprb_caja_chica()
    {
        return $this->cmprb_caja_chica;
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

    public function setFlag_cierre_compras($flag_cierre_compras)
    {
        if (empty($flag_cierre_compras)) return;
        $this->flag_cierre_compras = self::Clean($flag_cierre_compras);
    }

    public function getFlag_cierre_compras()
    {
        return $this->flag_cierre_compras;
    }

    public function setFlag_cierre_bancos($flag_cierre_bancos)
    {
        if (empty($flag_cierre_bancos)) return;
        $this->flag_cierre_bancos = self::Clean($flag_cierre_bancos);
    }

    public function getFlag_cierre_bancos()
    {
        return $this->flag_cierre_bancos;
    }

    public function setFlag_cierre_contabilidad($flag_cierre_contabilidad)
    {
        if (empty($flag_cierre_contabilidad)) return;
        $this->flag_cierre_contabilidad = self::Clean($flag_cierre_contabilidad);
    }

    public function getFlag_cierre_contabilidad()
    {
        return $this->flag_cierre_contabilidad;
    }

    public function setFlag_cierre_fondos($flag_cierre_fondos)
    {
        if (empty($flag_cierre_fondos)) return;
        $this->flag_cierre_fondos = self::Clean($flag_cierre_fondos);
    }

    public function getFlag_cierre_fondos()
    {
        return $this->flag_cierre_fondos;
    }

    public function setFlag_cierre_empleado($flag_cierre_empleado)
    {
        if (empty($flag_cierre_empleado)) return;
        $this->flag_cierre_empleado = self::Clean($flag_cierre_empleado);
    }

    public function getFlag_cierre_empleado()
    {
        return $this->flag_cierre_empleado;
    }

    public function setFecha_inicial_empleado($fecha_inicial_empleado)
    {
        if (empty($fecha_inicial_empleado)) return;
        $this->fecha_inicial_empleado = self::Clean($fecha_inicial_empleado);
    }

    public function getFecha_inicial_empleado()
    {
        return $this->fecha_inicial_empleado;
    }

    public function setFecha_final_empleado($fecha_final_empleado)
    {
        if (empty($fecha_final_empleado)) return;
        $this->fecha_final_empleado = self::Clean($fecha_final_empleado);
    }

    public function getFecha_final_empleado()
    {
        return $this->fecha_final_empleado;
    }

    public function setFlag_cierre_obrero_primera($flag_cierre_obrero_primera)
    {
        if (empty($flag_cierre_obrero_primera)) return;
        $this->flag_cierre_obrero_primera = self::Clean($flag_cierre_obrero_primera);
    }

    public function getFlag_cierre_obrero_primera()
    {
        return $this->flag_cierre_obrero_primera;
    }

    public function setFecha_inicial_primera($fecha_inicial_primera)
    {
        if (empty($fecha_inicial_primera)) return;
        $this->fecha_inicial_primera = self::Clean($fecha_inicial_primera);
    }

    public function getFecha_inicial_primera()
    {
        return $this->fecha_inicial_primera;
    }

    public function setFecha_final_primera($fecha_final_primera)
    {
        if (empty($fecha_final_primera)) return;
        $this->fecha_final_primera = self::Clean($fecha_final_primera);
    }

    public function getFecha_final_primera()
    {
        return $this->fecha_final_primera;
    }

    public function setFlag_cierre_obrero_segunda($flag_cierre_obrero_segunda)
    {
        if (empty($flag_cierre_obrero_segunda)) return;
        $this->flag_cierre_obrero_segunda = self::Clean($flag_cierre_obrero_segunda);
    }

    public function getFlag_cierre_obrero_segunda()
    {
        return $this->flag_cierre_obrero_segunda;
    }

    public function setFecha_inicial_segunda($fecha_inicial_segunda)
    {
        if (empty($fecha_inicial_segunda)) return;
        $this->fecha_inicial_segunda = self::Clean($fecha_inicial_segunda);
    }

    public function getFecha_inicial_segunda()
    {
        return $this->fecha_inicial_segunda;
    }

    public function setFecha_final_segunda($fecha_final_segunda)
    {
        if (empty($fecha_final_segunda)) return;
        $this->fecha_final_segunda = self::Clean($fecha_final_segunda);
    }

    public function getFecha_final_segunda()
    {
        return $this->fecha_final_segunda;
    }

    public function setFlag_cierre_obrero_tercera($flag_cierre_obrero_tercera)
    {
        if (empty($flag_cierre_obrero_tercera)) return;
        $this->flag_cierre_obrero_tercera = self::Clean($flag_cierre_obrero_tercera);
    }

    public function getFlag_cierre_obrero_tercera()
    {
        return $this->flag_cierre_obrero_tercera;
    }

    public function setFecha_inicial_tercera($fecha_inicial_tercera)
    {
        if (empty($fecha_inicial_tercera)) return;
        $this->fecha_inicial_tercera = self::Clean($fecha_inicial_tercera);
    }

    public function getFecha_inicial_tercera()
    {
        return $this->fecha_inicial_tercera;
    }

    public function setFecha_final_tercera($fecha_final_tercera)
    {
        if (empty($fecha_final_tercera)) return;
        $this->fecha_final_tercera = self::Clean($fecha_final_tercera);
    }

    public function getFecha_final_tercera()
    {
        return $this->fecha_final_tercera;
    }

    public function setFlag_cierre_obrero_cuarta($flag_cierre_obrero_cuarta)
    {
        if (empty($flag_cierre_obrero_cuarta)) return;
        $this->flag_cierre_obrero_cuarta = self::Clean($flag_cierre_obrero_cuarta);
    }

    public function getFlag_cierre_obrero_cuarta()
    {
        return $this->flag_cierre_obrero_cuarta;
    }

    public function setFecha_inicial_cuarta($fecha_inicial_cuarta)
    {
        if (empty($fecha_inicial_cuarta)) return;
        $this->fecha_inicial_cuarta = self::Clean($fecha_inicial_cuarta);
    }

    public function getFecha_inicial_cuarta()
    {
        return $this->fecha_inicial_cuarta;
    }

    public function setFecha_final_cuarta($fecha_final_cuarta)
    {
        if (empty($fecha_final_cuarta)) return;
        $this->fecha_final_cuarta = self::Clean($fecha_final_cuarta);
    }

    public function getFecha_final_cuarta()
    {
        return $this->fecha_final_cuarta;
    }

    public function setFlag_cierre_obrero_quinta($flag_cierre_obrero_quinta)
    {
        if (empty($flag_cierre_obrero_quinta)) return;
        $this->flag_cierre_obrero_quinta = self::Clean($flag_cierre_obrero_quinta);
    }

    public function getFlag_cierre_obrero_quinta()
    {
        return $this->flag_cierre_obrero_quinta;
    }

    public function setFecha_inicial_quinta($fecha_inicial_quinta)
    {
        if (empty($fecha_inicial_quinta)) return;
        $this->fecha_inicial_quinta = self::Clean($fecha_inicial_quinta);
    }

    public function getFecha_inicial_quinta()
    {
        return $this->fecha_inicial_quinta;
    }

    public function setFecha_final_quinta($fecha_final_quinta)
    {
        if (empty($fecha_final_quinta)) return;
        $this->fecha_final_quinta = self::Clean($fecha_final_quinta);
    }

    public function getFecha_final_quinta()
    {
        return $this->fecha_final_quinta;
    }

    public function setCmprb_compras_caja_chica($cmprb_compras_caja_chica)
    {
        if (empty($cmprb_compras_caja_chica)) return;
        $this->cmprb_compras_caja_chica = self::Clean($cmprb_compras_caja_chica);
    }

    public function getCmprb_compras_caja_chica()
    {
        return $this->cmprb_compras_caja_chica;
    }

    public function setContrato($contrato)
    {
        if (empty($contrato)) return;
        $this->contrato = self::Clean($contrato);
    }

    public function getContrato()
    {
        return $this->contrato;
    }

    public function setCmprb_planilla_letras($cmprb_planilla_letras)
    {
        if (empty($cmprb_planilla_letras)) return;
        $this->cmprb_planilla_letras = self::Clean($cmprb_planilla_letras);
    }

    public function getCmprb_planilla_letras()
    {
        return $this->cmprb_planilla_letras;
    }

    public function setCmprb_recibo_honorarios($cmprb_recibo_honorarios)
    {
        if (empty($cmprb_recibo_honorarios)) return;
        $this->cmprb_recibo_honorarios = self::Clean($cmprb_recibo_honorarios);
    }

    public function getCmprb_recibo_honorarios()
    {
        return $this->cmprb_recibo_honorarios;
    }

    public function setCmprb_fondos($cmprb_fondos)
    {
        if (empty($cmprb_fondos)) return;
        $this->cmprb_fondos = self::Clean($cmprb_fondos);
    }

    public function getCmprb_fondos()
    {
        return $this->cmprb_fondos;
    }

    public function setFlag_cierre_ventas($flag_cierre_ventas)
    {
        if (empty($flag_cierre_ventas)) return;
        $this->flag_cierre_ventas = self::Clean($flag_cierre_ventas);
    }

    public function getFlag_cierre_ventas()
    {
        return $this->flag_cierre_ventas;
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

    public function setRetencion_4($retencion_4)
    {
        if (empty($retencion_4)) return;
        $this->retencion_4 = self::Clean($retencion_4);
    }

    public function getRetencion_4()
    {
        return $this->retencion_4;
    }

    public function setPla_essalud($pla_essalud)
    {
        if (empty($pla_essalud)) return;
        $this->pla_essalud = self::Clean($pla_essalud);
    }

    public function getPla_essalud()
    {
        return $this->pla_essalud;
    }

    public function setRecaudo_bcp_666($recaudo_bcp_666)
    {
        if (empty($recaudo_bcp_666)) return;
        $this->recaudo_bcp_666 = self::Clean($recaudo_bcp_666);
    }

    public function getRecaudo_bcp_666()
    {
        return $this->recaudo_bcp_666;
    }

    public function setRecaudo_bbva_571($recaudo_bbva_571)
    {
        if (empty($recaudo_bbva_571)) return;
        $this->recaudo_bbva_571 = self::Clean($recaudo_bbva_571);
    }

    public function getRecaudo_bbva_571()
    {
        return $this->recaudo_bbva_571;
    }
}
