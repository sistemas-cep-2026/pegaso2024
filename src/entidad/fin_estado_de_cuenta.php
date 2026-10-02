<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class fin_estado_de_cuenta {
    private $c_persona;
    private $cod_tipo;
    private $cod_procedencia;
    private $cod_documento;
    private $num_documento;
    private $cod_documento_ref;
    private $num_documento_ref;
    private $fecha;
    private $referencia;
    private $cod_moneda;
    private $tipo_de_cambio;
    private $monto;
    private $observacion;
    private $fecha_registro;
    private $id_c_operacion;
    private $flag_cancelado;
    private $flag;
    private $hostname;
    private $tipo_pago;
    private $c_local;
    private $flag_activo;

    public function __construct() {
        $this->c_persona = 0;
        $this->cod_tipo = '';
        $this->cod_procedencia = '';
        $this->cod_documento = '';
        $this->num_documento = '';
        $this->cod_documento_ref = '';
        $this->num_documento_ref = '';
        $this->fecha = '';
        $this->referencia = '';
        $this->cod_moneda = '';
        $this->tipo_de_cambio = '';
        $this->monto = 0;
        $this->observacion = '';
        $this->fecha_registro = '';
        $this->id_c_operacion = '';
        $this->flag_cancelado = '';
        $this->flag = '';
        $this->hostname = '';
        $this->tipo_pago = '';
        $this->c_local = '';
        $this->flag_activo = '';
    }

    // c_persona
    public function setC_persona($c_persona) {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona() {
        return $this->c_persona;
    }

    // cod_tipo
    public function setCod_tipo($cod_tipo) {
        if (empty($cod_tipo)) return;
        $this->cod_tipo = self::Clean($cod_tipo);
    }

    public function getCod_tipo() {
        return $this->cod_tipo;
    }

    // cod_procedencia
    public function setCod_procedencia($cod_procedencia) {
        if (empty($cod_procedencia)) return;
        $this->cod_procedencia = self::Clean($cod_procedencia);
    }

    public function getCod_procedencia() {
        return $this->cod_procedencia;
    }

    // cod_documento
    public function setCod_documento($cod_documento) {
        if (empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }

    public function getCod_documento() {
        return $this->cod_documento;
    }

    // num_documento
    public function setNum_documento($num_documento) {
        if (empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento() {
        return $this->num_documento;
    }

    // cod_documento_ref
    public function setCod_documento_ref($cod_documento_ref) {
        if (empty($cod_documento_ref)) return;
        $this->cod_documento_ref = self::Clean($cod_documento_ref);
    }

    public function getCod_documento_ref() {
        return $this->cod_documento_ref;
    }

    // num_documento_ref
    public function setNum_documento_ref($num_documento_ref) {
        if (empty($num_documento_ref)) return;
        $this->num_documento_ref = self::Clean($num_documento_ref);
    }

    public function getNum_documento_ref() {
        return $this->num_documento_ref;
    }

    // fecha
    public function setFecha($fecha) {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha() {
        return $this->fecha;
    }

    // referencia
    public function setReferencia($referencia) {
        if (empty($referencia)) return;
        $this->referencia = self::Clean($referencia);
    }

    public function getReferencia() {
        return $this->referencia;
    }

    // cod_moneda
    public function setCod_moneda($cod_moneda) {
        if (empty($cod_moneda)) return;
        $this->cod_moneda = self::Clean($cod_moneda);
    }

    public function getCod_moneda() {
        return $this->cod_moneda;
    }

    // tipo_de_cambio
    public function setTipo_de_cambio($tipo_de_cambio) {
        if (empty($tipo_de_cambio)) return;
        $this->tipo_de_cambio = self::Clean($tipo_de_cambio);
    }

    public function getTipo_de_cambio() {
        return $this->tipo_de_cambio;
    }

    // monto
    public function setMonto($monto) {
        if (empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto() {
        return $this->monto;
    }

    // observacion
    public function setObservacion($observacion) {
        if (empty($observacion)) return;
        $this->observacion = self::Clean($observacion);
    }

    public function getObservacion() {
        return $this->observacion;
    }

    // fecha_registro
    public function setFecha_registro($fecha_registro) {
        if (empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro() {
        return $this->fecha_registro;
    }

    // id_c_operacion
    public function setId_c_operacion($id_c_operacion) {
        if (empty($id_c_operacion)) return;
        $this->id_c_operacion = self::Clean($id_c_operacion);
    }

    public function getId_c_operacion() {
        return $this->id_c_operacion;
    }

    // flag_cancelado
    public function setFlag_cancelado($flag_cancelado) {
        if (empty($flag_cancelado)) return;
        $this->flag_cancelado = self::Clean($flag_cancelado);
    }

    public function getFlag_cancelado() {
        return $this->flag_cancelado;
    }

    // flag
    public function setFlag($flag) {
        if (empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag() {
        return $this->flag;
    }

    // hostname
    public function setHostname($hostname) {
        if (empty($hostname)) return;
        $this->hostname = self::Clean($hostname);
    }

    public function getHostname() {
        return $this->hostname;
    }

    // tipo_pago
    public function setTipo_pago($tipo_pago) {
        if (empty($tipo_pago)) return;
        $this->tipo_pago = self::Clean($tipo_pago);
    }

    public function getTipo_pago() {
        return $this->tipo_pago;
    }

    // c_local
    public function setC_local($c_local) {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local() {
        return $this->c_local;
    }

    // flag_activo
    public function setFlag_activo($flag_activo) {
        if (empty($flag_activo)) return;
        $this->flag_activo = self::Clean($flag_activo);
    }

    public function getFlag_activo() {
        return $this->flag_activo;
    }

    // Example of the Clean method (implement this according to your needs)
    private static function Clean($value) {
        // Implement cleaning logic here
        return trim($value);
    }
}
