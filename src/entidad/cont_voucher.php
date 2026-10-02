<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cont_voucher extends Parse
{
    private $cc_voucher;
    private $numero;
    private $c_local;
    private $voucher;
    private $c_subdiario;
    private $c_persona;
    private $ano_contable;
    private $cod_mes_contable;
    private $cod_documento;
    private $num_documento;
    private $fecha;
    private $cod_moneda;
    private $tipo_de_cambio;
    private $tipo_de_cambio_dm;
    private $observacion;
    private $ref_cod_documento;
    private $ref_num_documento;
    private $ref_c_persona;
    private $flag;
    private $c_centralizacion;
    private $c_usuario_gerencia;
    private $c_usuario_contador;
    private $c_usuario_registrado;
    private $c_usuario_revisado;
    private $flag_en_linea;
    private $cod_origen;
    private $usuario;
    private $maquina;
    private $movimiento;
    private $fecha_anul;
    private $fecha_abrir;
    private $fecha_proc;
    private $fecha_registro;
    private $flag_exportar;
    private $flag_anu_reg_vta;
    private $clie_ruc;
    private $clie_raz_social;
    private $comprobante;
    private $numerox;

    private $razon_social;
    private $opc;

    function __construct()
    {
        $this->cc_voucher = 0;
        $this->numero = '';
        $this->c_local = '';
        $this->voucher = '';
        $this->c_subdiario = '';
        $this->c_persona = '';
        $this->ano_contable = '';
        $this->cod_mes_contable = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->fecha = '';
        $this->cod_moneda = '';
        $this->tipo_de_cambio = 0;
        $this->tipo_de_cambio_dm = 0;
        $this->observacion = '';
        $this->ref_cod_documento = '';
        $this->ref_num_documento = '';
        $this->ref_c_persona = '';
        $this->flag = '';
        $this->c_centralizacion = '';
        $this->c_usuario_gerencia = '';
        $this->c_usuario_contador = '';
        $this->c_usuario_registrado = '';
        $this->c_usuario_revisado = '';
        $this->flag_en_linea = '';
        $this->cod_origen = '';
        $this->usuario = '';
        $this->maquina = '';
        $this->movimiento = '';
        $this->fecha_anul = '';
        $this->fecha_abrir = '';
        $this->fecha_proc = '';
        $this->fecha_registro = '';
        $this->flag_exportar = '';
        $this->flag_anu_reg_vta = '';
        $this->clie_ruc = '';
        $this->clie_raz_social = '';
        $this->comprobante = '';
        $this->numerox = '';

        $this->razon_social='';
        $this->opc='';
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

    public function setC_local($c_local)
    {
        if(empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
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

    public function setC_subdiario($c_subdiario)
    {
        if(empty($c_subdiario)) return;
        $this->c_subdiario = self::Clean($c_subdiario);
    }

    public function getC_subdiario()
    {
        return $this->c_subdiario;
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

    public function setAno_contable($ano_contable)
    {
        if(empty($ano_contable)) return;
        $this->ano_contable = self::Clean($ano_contable);
    }

    public function getAno_contable()
    {
        return $this->ano_contable;
    }

    public function setCod_mes_contable($cod_mes_contable)
    {
        if(empty($cod_mes_contable)) return;
        $this->cod_mes_contable = self::Clean($cod_mes_contable);
    }

    public function getCod_mes_contable()
    {
        return $this->cod_mes_contable;
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

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
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

    public function setTipo_de_cambio($tipo_de_cambio)
    {
        if(empty($tipo_de_cambio)) return;
        $this->tipo_de_cambio = self::Clean($tipo_de_cambio);
    }

    public function getTipo_de_cambio()
    {
        return $this->tipo_de_cambio;
    }

    public function setTipo_de_cambio_dm($tipo_de_cambio_dm)
    {
        if(empty($tipo_de_cambio_dm)) return;
        $this->tipo_de_cambio_dm = self::Clean($tipo_de_cambio_dm);
    }

    public function getTipo_de_cambio_dm()
    {
        return $this->tipo_de_cambio_dm;
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

    public function setRef_cod_documento($ref_cod_documento)
    {
        if(empty($ref_cod_documento)) return;
        $this->ref_cod_documento = self::Clean($ref_cod_documento);
    }

    public function getRef_cod_documento()
    {
        return $this->ref_cod_documento;
    }

    public function setRef_num_documento($ref_num_documento)
    {
        if(empty($ref_num_documento)) return;
        $this->ref_num_documento = self::Clean($ref_num_documento);
    }

    public function getRef_num_documento()
    {
        return $this->ref_num_documento;
    }

    public function setRef_c_persona($ref_c_persona)
    {
        if(empty($ref_c_persona)) return;
        $this->ref_c_persona = self::Clean($ref_c_persona);
    }

    public function getRef_c_persona()
    {
        return $this->ref_c_persona;
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

    public function setC_centralizacion($c_centralizacion)
    {
        if(empty($c_centralizacion)) return;
        $this->c_centralizacion = self::Clean($c_centralizacion);
    }

    public function getC_centralizacion()
    {
        return $this->c_centralizacion;
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

    public function setFlag_en_linea($flag_en_linea)
    {
        if(empty($flag_en_linea)) return;
        $this->flag_en_linea = self::Clean($flag_en_linea);
    }

    public function getFlag_en_linea()
    {
        return $this->flag_en_linea;
    }

    public function setCod_origen($cod_origen)
    {
        if(empty($cod_origen)) return;
        $this->cod_origen = self::Clean($cod_origen);
    }

    public function getCod_origen()
    {
        return $this->cod_origen;
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

    public function setMovimiento($movimiento)
    {
        if(empty($movimiento)) return;
        $this->movimiento = self::Clean($movimiento);
    }

    public function getMovimiento()
    {
        return $this->movimiento;
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

    public function setFecha_abrir($fecha_abrir)
    {
        if(empty($fecha_abrir)) return;
        $this->fecha_abrir = self::Clean($fecha_abrir);
    }

    public function getFecha_abrir()
    {
        return $this->fecha_abrir;
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

    public function setFecha_registro($fecha_registro)
    {
        if(empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
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

    public function setFlag_anu_reg_vta($flag_anu_reg_vta)
    {
        if(empty($flag_anu_reg_vta)) return;
        $this->flag_anu_reg_vta = self::Clean($flag_anu_reg_vta);
    }

    public function getFlag_anu_reg_vta()
    {
        return $this->flag_anu_reg_vta;
    }

    public function setClie_ruc($clie_ruc)
    {
        if(empty($clie_ruc)) return;
        $this->clie_ruc = self::Clean($clie_ruc);
    }

    public function getClie_ruc()
    {
        return $this->clie_ruc;
    }

    public function setClie_raz_social($clie_raz_social)
    {
        if(empty($clie_raz_social)) return;
        $this->clie_raz_social = self::Clean($clie_raz_social);
    }

    public function getClie_raz_social()
    {
        return $this->clie_raz_social;
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

    public function setNumerox($numerox)
    {
        if(empty($numerox)) return;
        $this->numerox = self::Clean($numerox);
    }

    public function getNumerox()
    {
        return $this->numerox;
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
