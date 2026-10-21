<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_seguimiento_documentos_recibid extends Parse
{
    private $cc_docrecibidos_det;
    private $cc_docrecibidos;
    private $c_area_adm;
    private $fecha_entrega;
    private $c_accion;
    private $cod_original;
    private $observacion;
    private $c_local;
    private $accion_a_tomar;
    private $file_adjunto;
    private $c_usuario;
    private $feha_respuesta;
    private $fecha_verif;
    private $usu_recep;
    private $usu_atien;
    private $flag;
    private $tipo_persona;
    private $c_local_destino;
    private $c_expediente;
    private $linea;
    private $c_usuario_destino;

    private $opc;

    function __construct()
    {
        $this->cc_docrecibidos_det = 0;
        $this->cc_docrecibidos = 0;
        $this->c_area_adm = '';
        $this->fecha_entrega = '';
        $this->c_accion = 0;
        $this->cod_original = '';
        $this->observacion = '';
        $this->c_local = '';
        $this->accion_a_tomar = '';
        $this->file_adjunto = '';
        $this->c_usuario = '';
        $this->feha_respuesta = '';
        $this->fecha_verif = '';
        $this->usu_recep = '';
        $this->usu_atien = '';
        $this->flag = '';
        $this->tipo_persona = '';
        $this->c_local_destino = '';
        $this->c_expediente = '';
        $this->linea = 0;
        $this->c_usuario_destino = '';

        $this->opc = '';
    }

    public function setCc_docrecibidos_det($cc_docrecibidos_det)
    {
        if (empty($cc_docrecibidos_det)) return;
        $this->cc_docrecibidos_det = self::Clean($cc_docrecibidos_det);
    }

    public function getCc_docrecibidos_det()
    {
        return $this->cc_docrecibidos_det;
    }

    public function setCc_docrecibidos($cc_docrecibidos)
    {
        if (empty($cc_docrecibidos)) return;
        $this->cc_docrecibidos = self::Clean($cc_docrecibidos);
    }

    public function getCc_docrecibidos()
    {
        return $this->cc_docrecibidos;
    }

    public function setC_area_adm($c_area_adm)
    {
        if (empty($c_area_adm)) return;
        $this->c_area_adm = self::Clean($c_area_adm);
    }

    public function getC_area_adm()
    {
        return $this->c_area_adm;
    }

    public function setFecha_entrega($fecha_entrega)
    {
        if (empty($fecha_entrega)) return;
        $this->fecha_entrega = self::Clean($fecha_entrega);
    }

    public function getFecha_entrega()
    {
        return $this->fecha_entrega;
    }

    public function setC_accion($c_accion)
    {
        if (empty($c_accion)) return;
        $this->c_accion = self::Clean($c_accion);
    }

    public function getC_accion()
    {
        return $this->c_accion;
    }

    public function setCod_original($cod_original)
    {
        if (empty($cod_original)) return;
        $this->cod_original = self::Clean($cod_original);
    }

    public function getCod_original()
    {
        return $this->cod_original;
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

    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setAccion_a_tomar($accion_a_tomar)
    {
        if (empty($accion_a_tomar)) return;
        $this->accion_a_tomar = self::Clean($accion_a_tomar);
    }

    public function getAccion_a_tomar()
    {
        return $this->accion_a_tomar;
    }

    public function setFile_adjunto($file_adjunto)
    {
        if (empty($file_adjunto)) return;
        $this->file_adjunto = self::Clean($file_adjunto);
    }

    public function getFile_adjunto()
    {
        return $this->file_adjunto;
    }

    public function setC_usuario($c_usuario)
    {
        if (empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
    }

    public function setFeha_respuesta($feha_respuesta)
    {
        if (empty($feha_respuesta)) return;
        $this->feha_respuesta = self::Clean($feha_respuesta);
    }

    public function getFeha_respuesta()
    {
        return $this->feha_respuesta;
    }

    public function setFecha_verif($fecha_verif)
    {
        if (empty($fecha_verif)) return;
        $this->fecha_verif = self::Clean($fecha_verif);
    }

    public function getFecha_verif()
    {
        return $this->fecha_verif;
    }

    public function setUsu_recep($usu_recep)
    {
        if (empty($usu_recep)) return;
        $this->usu_recep = self::Clean($usu_recep);
    }

    public function getUsu_recep()
    {
        return $this->usu_recep;
    }

    public function setUsu_atien($usu_atien)
    {
        if (empty($usu_atien)) return;
        $this->usu_atien = self::Clean($usu_atien);
    }

    public function getUsu_atien()
    {
        return $this->usu_atien;
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

    public function setTipo_persona($tipo_persona)
    {
        if (empty($tipo_persona)) return;
        $this->tipo_persona = self::Clean($tipo_persona);
    }

    public function getTipo_persona()
    {
        return $this->tipo_persona;
    }

    public function setC_local_destino($c_local_destino)
    {
        if (empty($c_local_destino)) return;
        $this->c_local_destino = self::Clean($c_local_destino);
    }

    public function getC_local_destino()
    {
        return $this->c_local_destino;
    }

    public function setC_expediente($c_expediente)
    {
        if (empty($c_expediente)) return;
        $this->c_expediente = self::Clean($c_expediente);
    }

    public function getC_expediente()
    {
        return $this->c_expediente;
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

    public function setC_usuario_destino($c_usuario_destino)
    {
        if (empty($c_usuario_destino)) return;
        $this->c_usuario_destino = self::Clean($c_usuario_destino);
    }

    public function getC_usuario_destino()
    {
        return $this->c_usuario_destino;
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
}
