<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_personas_especialidad extends Parse
{
    private $linea;
    private $cc_especialidad;
    private $cc_persona;
    private $cc_universidad;
    private $cc_reg_esp;
    private $fecha;
    private $c_local;
    private $flag_escolarizado;
    private $n_libro_cole;
    private $n_resolucion_cole;
    private $n_folio_cole;
    private $tipo_especialidad;
    private $fecha_diploma;
    private $c_especialidad_res;
    private $literal;
    private $residentado;
    private $semipresencial;

    private $pago_recaudo;
    private $id_recaudo_bbva;

    private $banco;
    private $operacion;
    private $fecha_op;
    private $monto;

    private $banco2;
    private $operacion2;
    private $fecha_op2;
    private $monto2;

    private $flag_regularizado;
    private $obs;

    private $opc;

    private $desde;
    private $hasta;

    function __construct()
    {

        $this->linea = '';
        $this->cc_especialidad = '';
        $this->cc_persona = '';
        $this->cc_universidad = '';
        $this->cc_reg_esp = '';
        $this->fecha = '';
        $this->c_local = '';
        $this->flag_escolarizado = '';
        $this->n_libro_cole = '';
        $this->n_resolucion_cole = '';
        $this->n_folio_cole = '';
        $this->tipo_especialidad = '';
        $this->fecha_diploma = '';
        $this->c_especialidad_res = '';
        $this->literal = '';
        $this->residentado = '';
        $this->semipresencial = '';

        $this->pago_recaudo = '';
        $this->id_recaudo_bbva = '';

        $this->banco = '';
        $this->operacion = '';
        $this->fecha_op = '';
        $this->monto = '0.00';

        $this->opc = '';

        $this->desde = '';
        $this->hasta = '';
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

    public function setCc_especialidad($cc_especialidad)
    {
        if (empty($cc_especialidad)) return;
        $this->cc_especialidad = self::Clean($cc_especialidad);
    }

    public function getCc_especialidad()
    {
        return $this->cc_especialidad;
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

    public function setCc_universidad($cc_universidad)
    {
        if (empty($cc_universidad)) return;
        $this->cc_universidad = self::Clean($cc_universidad);
    }

    public function getCc_universidad()
    {
        return $this->cc_universidad;
    }

    public function setCc_reg_esp($cc_reg_esp)
    {
        if (empty($cc_reg_esp)) return;
        $this->cc_reg_esp = self::Clean($cc_reg_esp);
    }

    public function getCc_reg_esp()
    {
        return $this->cc_reg_esp;
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

    public function setc_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getc_local()
    {
        return $this->c_local;
    }

    public function setFlag_escolarizado($flag_escolarizado)
    {
        if (empty($flag_escolarizado)) return;
        $this->flag_escolarizado = self::Clean($flag_escolarizado);
    }

    public function getFlag_escolarizado()
    {
        return $this->flag_escolarizado;
    }

    public function setN_libro_cole($n_libro_cole)
    {
        if (empty($n_libro_cole)) return;
        $this->n_libro_cole = self::Clean($n_libro_cole);
    }

    public function getN_libro_cole()
    {
        return $this->n_libro_cole;
    }

    public function setN_resolucion_cole($n_resolucion_cole)
    {
        if (empty($n_resolucion_cole)) return;
        $this->n_resolucion_cole = self::Clean($n_resolucion_cole);
    }

    public function getN_resolucion_cole()
    {
        return $this->n_resolucion_cole;
    }

    public function setN_folio_cole($n_folio_cole)
    {
        if (empty($n_folio_cole)) return;
        $this->n_folio_cole = self::Clean($n_folio_cole);
    }

    public function getN_folio_cole()
    {
        return $this->n_folio_cole;
    }

    public function setTipo_especialidad($tipo_especialidad)
    {
        if (empty($tipo_especialidad)) return;
        $this->tipo_especialidad = self::Clean($tipo_especialidad);
    }

    public function getTipo_especialidad()
    {
        return $this->tipo_especialidad;
    }

    public function setFecha_diploma($fecha_diploma)
    {
        if (empty($fecha_diploma)) return;
        $this->fecha_diploma = self::Clean($fecha_diploma);
    }

    public function getFecha_diploma()
    {
        return $this->fecha_diploma;
    }

    public function setC_especialidad_res($c_especialidad_res)
    {
        if (empty($c_especialidad_res)) return;
        $this->c_especialidad_res = self::Clean($c_especialidad_res);
    }

    public function getC_especialidad_res()
    {
        return $this->c_especialidad_res;
    }

    public function setLiteral($literal)
    {
        if (empty($literal)) return;
        $this->literal = self::Clean($literal);
    }

    public function getLiteral()
    {
        return $this->literal;
    }

    public function setResidentado($residentado)
    {
        if (empty($residentado)) return;
        $this->residentado = self::Clean($residentado);
    }

    public function getResidentado()
    {
        return $this->residentado;
    }

    public function setSemipresencial($semipresencial)
    {
        if (empty($semipresencial)) return;
        $this->semipresencial = self::Clean($semipresencial);
    }

    public function getSemipresencial()
    {
        return $this->semipresencial;
    }


    public function setPago_recaudo($pago_recaudo)
    {
        if (empty($pago_recaudo)) return;
        $this->pago_recaudo = self::Clean($pago_recaudo);
    }

    public function getPago_recaudo()
    {
        return $this->pago_recaudo;
    }

    public function setId_recaudo_bbva($id_recaudo_bbva)
    {
        if (empty($id_recaudo_bbva)) return;
        $this->id_recaudo_bbva = self::Clean($id_recaudo_bbva);
    }

    public function getId_recaudo_bbva()
    {
        return $this->id_recaudo_bbva;
    }




    public function setBanco($banco)
    {
        if (empty($banco)) return;
        $this->banco = self::Clean($banco);
    }

    public function getBanco()
    {
        return $this->banco;
    }

    public function setOperacion($operacion)
    {
        if (empty($operacion)) return;
        $this->operacion = self::Clean($operacion);
    }

    public function getOperacion()
    {
        return $this->operacion;
    }

    public function setFecha_op($fecha_op)
    {
        if (empty($fecha_op)) return;
        $this->fecha_op = self::Clean($fecha_op);
    }

    public function getFecha_op()
    {
        return $this->fecha_op;
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



    public function setBanco2($banco2)
    {
        if (empty($banco2)) return;
        $this->banco2 = self::Clean($banco2);
    }

    public function getBanco2()
    {
        return $this->banco2;
    }

    public function setOperacion2($operacion2)
    {
        if (empty($operacion2)) return;
        $this->operacion2 = self::Clean($operacion2);
    }

    public function getOperacion2()
    {
        return $this->operacion2;
    }

    public function setFecha_op2($fecha_op2)
    {
        if (empty($fecha_op2)) return;
        $this->fecha_op2 = self::Clean($fecha_op2);
    }

    public function getFecha_op2()
    {
        return $this->fecha_op2;
    }

    public function setMonto2($monto2)
    {
        if (empty($monto2)) return;
        $this->monto2 = self::Clean($monto2);
    }

    public function getMonto2()
    {
        return $this->monto2;
    }


    public function setFlag_regularizado($flag_regularizado)
    {
        if (empty($flag_regularizado)) return;
        $this->flag_regularizado = self::Clean($flag_regularizado);
    }

    public function getFlag_regularizado()
    {
        return $this->flag_regularizado;
    }

    public function setObs($obs)
    {
        if (empty($obs)) return;
        $this->obs = self::Clean($obs);
    }

    public function getObs()
    {
        return $this->obs;
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
}
