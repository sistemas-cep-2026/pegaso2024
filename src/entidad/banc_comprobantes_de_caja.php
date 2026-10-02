<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class banc_comprobantes_de_caja extends Parse
{
    private $cc_documento;
    private $c_persona;
    private $cod_ingreso_egreso;
    private $c_forma_cancelacion;
    private $c_local;
    private $cod_ano;
    private $cod_mes;
    private $comprobante;
    private $c_banco;
    private $c_cta_corriente;
    private $fecha;
    private $fecha_text;
    private $observacion;
    private $flag_centralizado;
    private $flag_conciliado;
    private $c_usuario;
    private $numero;
    private $fecha_anul;
    private $usuario;
    private $maquina;
    private $fecha_concluir;
    private $fecha_proc;
    private $fecha_centralizado;
    private $fecha_abrir;
    private $num_boleta_cheque;
    private $flag;
    private $comprb_cta_cte;
    private $cod_comprobante;
    private $tipo_de_cambio;
    private $voucher;
    private $periodo_conciliado;
    private $monto;
    private $saldo;
    private $orden_de_compra;
    private $observacion2;
    private $c_usuario_gerencia;
    private $c_usuario_contador;
    private $c_usuario_registrado;
    private $c_usuario_revisado;
    private $flag_por_identificar;
    private $flag_concluir;
    private $recibo;
    private $movimiento;
    private $registro_contable;
    private $registro_mes;
    private $registro_ano;
    private $c_liquidacion_caja_chica;
    private $c_c_banco_nombre;
    private $c_c_cta_corriente;
    private $orige_cancelacion;
    private $motivo_comprobante;
    private $nro_liquidacion_amarre;
    private $c_fondo;
    private $flag_manual;
    private $flag_impresion;
    private $observacion_anul;
    private $c_motivo_anul;
    private $c_local_beneficiario;
    private $vinculo;

    private $razon_social;
    private $opc;

    function __construct()
    {
        $this->cc_documento = 0;
        $this->c_persona = '';
        $this->cod_ingreso_egreso = '';
        $this->c_forma_cancelacion = '';
        $this->c_local = '';
        $this->cod_ano = '';
        $this->cod_mes = '';
        $this->comprobante = '';
        $this->c_banco = '';
        $this->c_cta_corriente = '';
        $this->fecha = '';
                $this->fecha_text = '';
        $this->observacion = '';
        $this->flag_centralizado = '';
        $this->flag_conciliado = '';
        $this->c_usuario = '';
        $this->numero = '';
        $this->fecha_anul = '';
        $this->usuario = '';
        $this->maquina = '';
        $this->fecha_concluir = '';
        $this->fecha_proc = '';
        $this->fecha_centralizado = '';
        $this->fecha_abrir = '';
        $this->num_boleta_cheque = '';
        $this->flag = '';
        $this->comprb_cta_cte = '';
        $this->cod_comprobante = '';
        $this->tipo_de_cambio = 0;
        $this->voucher = '';
        $this->periodo_conciliado = '';
        $this->monto = 0;
        $this->saldo = 0;
        $this->orden_de_compra = '';
        $this->observacion2 = '';
        $this->c_usuario_gerencia = '';
        $this->c_usuario_contador = '';
        $this->c_usuario_registrado = '';
        $this->c_usuario_revisado = '';
        $this->flag_por_identificar = '';
        $this->flag_concluir = '';
        $this->recibo = '';
        $this->movimiento = '';
        $this->registro_contable = '';
        $this->registro_mes = '';
        $this->registro_ano = '';
        $this->c_liquidacion_caja_chica = '';
        $this->c_c_banco_nombre = '';
        $this->c_c_cta_corriente = '';
        $this->orige_cancelacion = '';
        $this->motivo_comprobante = '';
        $this->nro_liquidacion_amarre = '';
        $this->c_fondo = '';
        $this->flag_manual = '';
        $this->flag_impresion = '';
        $this->observacion_anul = '';
        $this->c_motivo_anul = '';
        $this->c_local_beneficiario = '';
        $this->vinculo = '';

        $this->razon_social='';
        $this->opc='';
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

    public function setC_persona($c_persona)
    {
        if(empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
    }

    public function setCod_ingreso_egreso($cod_ingreso_egreso)
    {
        if(empty($cod_ingreso_egreso)) return;
        $this->cod_ingreso_egreso = self::Clean($cod_ingreso_egreso);
    }

    public function getCod_ingreso_egreso()
    {
        return $this->cod_ingreso_egreso;
    }

    public function setC_forma_cancelacion($c_forma_cancelacion)
    {
        if(empty($c_forma_cancelacion)) return;
        $this->c_forma_cancelacion = self::Clean($c_forma_cancelacion);
    }

    public function getC_forma_cancelacion()
    {
        return $this->c_forma_cancelacion;
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

    public function setCod_ano($cod_ano)
    {
        if(empty($cod_ano)) return;
        $this->cod_ano = self::Clean($cod_ano);
    }

    public function getCod_ano()
    {
        return $this->cod_ano;
    }

    public function setCod_mes($cod_mes)
    {
        if(empty($cod_mes)) return;
        $this->cod_mes = self::Clean($cod_mes);
    }

    public function getCod_mes()
    {
        return $this->cod_mes;
    }

    public function setComprobante($comprobante)
    {
        if(empty($comprobante)) return;
        $this->comprobante = self::Clean($comprobante);
    }

    public function getComprobante()
    {
        return $this->comprobante;
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

    public function setC_cta_corriente($c_cta_corriente)
    {
        if(empty($c_cta_corriente)) return;
        $this->c_cta_corriente = self::Clean($c_cta_corriente);
    }

    public function getC_cta_corriente()
    {
        return $this->c_cta_corriente;
    }

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
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

    public function setFlag_centralizado($flag_centralizado)
    {
        if(empty($flag_centralizado)) return;
        $this->flag_centralizado = self::Clean($flag_centralizado);
    }

    public function getFlag_centralizado()
    {
        return $this->flag_centralizado;
    }

    public function setFlag_conciliado($flag_conciliado)
    {
        if(empty($flag_conciliado)) return;
        $this->flag_conciliado = self::Clean($flag_conciliado);
    }

    public function getFlag_conciliado()
    {
        return $this->flag_conciliado;
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

    public function setNumero($numero)
    {
        if(empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setFecha_anul($fecha_anul)
    {
        if(empty($fecha_anul)) return;
        $this->fecha_anul = self::Clean($fecha_anul);
    }

    public function getFecha_anul()
    {
        return $this->fecha_anul;
    }

    public function setUsuario($usuario)
    {
        if(empty($usuario)) return;
        $this->usuario = self::Clean($usuario);
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setMaquina($maquina)
    {
        if(empty($maquina)) return;
        $this->maquina = self::Clean($maquina);
    }

    public function getMaquina()
    {
        return $this->maquina;
    }

    public function setFecha_concluir($fecha_concluir)
    {
        if(empty($fecha_concluir)) return;
        $this->fecha_concluir = self::Clean($fecha_concluir);
    }

    public function getFecha_concluir()
    {
        return $this->fecha_concluir;
    }

    public function setFecha_proc($fecha_proc)
    {
        if(empty($fecha_proc)) return;
        $this->fecha_proc = self::Clean($fecha_proc);
    }

    public function getFecha_proc()
    {
        return $this->fecha_proc;
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

    public function setFecha_abrir($fecha_abrir)
    {
        if(empty($fecha_abrir)) return;
        $this->fecha_abrir = self::Clean($fecha_abrir);
    }

    public function getFecha_abrir()
    {
        return $this->fecha_abrir;
    }

    public function setNum_boleta_cheque($num_boleta_cheque)
    {
        if(empty($num_boleta_cheque)) return;
        $this->num_boleta_cheque = self::Clean($num_boleta_cheque);
    }

    public function getNum_boleta_cheque()
    {
        return $this->num_boleta_cheque;
    }

    public function setFlag($flag)
    {
        if(empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag()
    {
        return $this->flag;
    }

    public function setComprb_cta_cte($comprb_cta_cte)
    {
        if(empty($comprb_cta_cte)) return;
        $this->comprb_cta_cte = self::Clean($comprb_cta_cte);
    }

    public function getComprb_cta_cte()
    {
        return $this->comprb_cta_cte;
    }

    public function setCod_comprobante($cod_comprobante)
    {
        if(empty($cod_comprobante)) return;
        $this->cod_comprobante = self::Clean($cod_comprobante);
    }

    public function getCod_comprobante()
    {
        return $this->cod_comprobante;
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

    public function setVoucher($voucher)
    {
        if(empty($voucher)) return;
        $this->voucher = self::Clean($voucher);
    }

    public function getVoucher()
    {
        return $this->voucher;
    }

    public function setPeriodo_conciliado($periodo_conciliado)
    {
        if(empty($periodo_conciliado)) return;
        $this->periodo_conciliado = self::Clean($periodo_conciliado);
    }

    public function getPeriodo_conciliado()
    {
        return $this->periodo_conciliado;
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

    public function setSaldo($saldo)
    {
        if(empty($saldo)) return;
        $this->saldo = self::Clean($saldo);
    }

    public function getSaldo()
    {
        return $this->saldo;
    }

    public function setOrden_de_compra($orden_de_compra)
    {
        if(empty($orden_de_compra)) return;
        $this->orden_de_compra = self::Clean($orden_de_compra);
    }

    public function getOrden_de_compra()
    {
        return $this->orden_de_compra;
    }

    public function setObservacion2($observacion2)
    {
        if(empty($observacion2)) return;
        $this->observacion2 = self::Clean($observacion2);
    }

    public function getObservacion2()
    {
        return $this->observacion2;
    }

    public function setC_usuario_gerencia($c_usuario_gerencia)
    {
        if(empty($c_usuario_gerencia)) return;
        $this->c_usuario_gerencia = self::Clean($c_usuario_gerencia);
    }

    public function getC_usuario_gerencia()
    {
        return $this->c_usuario_gerencia;
    }

    public function setC_usuario_contador($c_usuario_contador)
    {
        if(empty($c_usuario_contador)) return;
        $this->c_usuario_contador = self::Clean($c_usuario_contador);
    }

    public function getC_usuario_contador()
    {
        return $this->c_usuario_contador;
    }

    public function setC_usuario_registrado($c_usuario_registrado)
    {
        if(empty($c_usuario_registrado)) return;
        $this->c_usuario_registrado = self::Clean($c_usuario_registrado);
    }

    public function getC_usuario_registrado()
    {
        return $this->c_usuario_registrado;
    }

    public function setC_usuario_revisado($c_usuario_revisado)
    {
        if(empty($c_usuario_revisado)) return;
        $this->c_usuario_revisado = self::Clean($c_usuario_revisado);
    }

    public function getC_usuario_revisado()
    {
        return $this->c_usuario_revisado;
    }

    public function setFlag_por_identificar($flag_por_identificar)
    {
        if(empty($flag_por_identificar)) return;
        $this->flag_por_identificar = self::Clean($flag_por_identificar);
    }

    public function getFlag_por_identificar()
    {
        return $this->flag_por_identificar;
    }

    public function setFlag_concluir($flag_concluir)
    {
        if(empty($flag_concluir)) return;
        $this->flag_concluir = self::Clean($flag_concluir);
    }

    public function getFlag_concluir()
    {
        return $this->flag_concluir;
    }

    public function setRecibo($recibo)
    {
        if(empty($recibo)) return;
        $this->recibo = self::Clean($recibo);
    }

    public function getRecibo()
    {
        return $this->recibo;
    }

    public function setMovimiento($movimiento)
    {
        if(empty($movimiento)) return;
        $this->movimiento = self::Clean($movimiento);
    }

    public function getMovimiento()
    {
        return $this->movimiento;
    }

    public function setRegistro_contable($registro_contable)
    {
        if(empty($registro_contable)) return;
        $this->registro_contable = self::Clean($registro_contable);
    }

    public function getRegistro_contable()
    {
        return $this->registro_contable;
    }

    public function setRegistro_mes($registro_mes)
    {
        if(empty($registro_mes)) return;
        $this->registro_mes = self::Clean($registro_mes);
    }

    public function getRegistro_mes()
    {
        return $this->registro_mes;
    }

    public function setRegistro_ano($registro_ano)
    {
        if(empty($registro_ano)) return;
        $this->registro_ano = self::Clean($registro_ano);
    }

    public function getRegistro_ano()
    {
        return $this->registro_ano;
    }

    public function setC_liquidacion_caja_chica($c_liquidacion_caja_chica)
    {
        if(empty($c_liquidacion_caja_chica)) return;
        $this->c_liquidacion_caja_chica = self::Clean($c_liquidacion_caja_chica);
    }

    public function getC_liquidacion_caja_chica()
    {
        return $this->c_liquidacion_caja_chica;
    }

    public function setC_c_banco_nombre($c_c_banco_nombre)
    {
        if(empty($c_c_banco_nombre)) return;
        $this->c_c_banco_nombre = self::Clean($c_c_banco_nombre);
    }

    public function getC_c_banco_nombre()
    {
        return $this->c_c_banco_nombre;
    }

    public function setC_c_cta_corriente($c_c_cta_corriente)
    {
        if(empty($c_c_cta_corriente)) return;
        $this->c_c_cta_corriente = self::Clean($c_c_cta_corriente);
    }

    public function getC_c_cta_corriente()
    {
        return $this->c_c_cta_corriente;
    }

    public function setOrige_cancelacion($orige_cancelacion)
    {
        if(empty($orige_cancelacion)) return;
        $this->orige_cancelacion = self::Clean($orige_cancelacion);
    }

    public function getOrige_cancelacion()
    {
        return $this->orige_cancelacion;
    }

    public function setMotivo_comprobante($motivo_comprobante)
    {
        if(empty($motivo_comprobante)) return;
        $this->motivo_comprobante = self::Clean($motivo_comprobante);
    }

    public function getMotivo_comprobante()
    {
        return $this->motivo_comprobante;
    }

    public function setNro_liquidacion_amarre($nro_liquidacion_amarre)
    {
        if(empty($nro_liquidacion_amarre)) return;
        $this->nro_liquidacion_amarre = self::Clean($nro_liquidacion_amarre);
    }

    public function getNro_liquidacion_amarre()
    {
        return $this->nro_liquidacion_amarre;
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

    public function setFlag_manual($flag_manual)
    {
        if(empty($flag_manual)) return;
        $this->flag_manual = self::Clean($flag_manual);
    }

    public function getFlag_manual()
    {
        return $this->flag_manual;
    }

    public function setFlag_impresion($flag_impresion)
    {
        if(empty($flag_impresion)) return;
        $this->flag_impresion = self::Clean($flag_impresion);
    }

    public function getFlag_impresion()
    {
        return $this->flag_impresion;
    }

    public function setObservacion_anul($observacion_anul)
    {
        if(empty($observacion_anul)) return;
        $this->observacion_anul = self::Clean($observacion_anul);
    }

    public function getObservacion_anul()
    {
        return $this->observacion_anul;
    }

    public function setC_motivo_anul($c_motivo_anul)
    {
        if(empty($c_motivo_anul)) return;
        $this->c_motivo_anul = self::Clean($c_motivo_anul);
    }

    public function getC_motivo_anul()
    {
        return $this->c_motivo_anul;
    }

    public function setC_local_beneficiario($c_local_beneficiario)
    {
        if(empty($c_local_beneficiario)) return;
        $this->c_local_beneficiario = self::Clean($c_local_beneficiario);
    }

    public function getC_local_beneficiario()
    {
        return $this->c_local_beneficiario;
    }

    public function setVinculo($vinculo)
    {
        if(empty($vinculo)) return;
        $this->vinculo = self::Clean($vinculo);
    }

    public function getVinculo()
    {
        return $this->vinculo;
    }

    public function setRazon_social($razon_social)
    {
        if(empty($razon_social)) return;
        $this->razon_social = self::Clean($razon_social);
    }

    public function getRazon_social()
    {
        return $this->razon_social;
    }
    

    public function setOpc($opc)
    {
        if(empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }

}