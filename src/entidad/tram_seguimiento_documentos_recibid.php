<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_seguimiento_documentos_recibid extends Parse
{
    private $cc_docrecibidos_det;
    private $cc_docrecibidos;
    private $c_expediente;
    private $linea;
    private $c_area_adm;
    private $fecha_entrega;
    private $cod_original;
    private $accion_a_tomar;
    private $observacion;
    private $c_local;
    private $c_accion;
    private $flag;
    private $c_usuario;
    private $c_local_destino;
    private $c_usuario_destino;
    private $fecha_respuesta;
    private $tipo_persona;
    private $fecha_verif;
    private $usu_recep;
    private $usu_atien;

    private $opc;

    function __construct()
    {
        $this->cc_docrecibidos_det = 0;
        $this->cc_docrecibidos = 0;
        $this->c_expediente = '';
        $this->linea = 0;
        $this->c_area_adm = '';
        $this->fecha_entrega = '';
        $this->cod_original = '';
        $this->accion_a_tomar = '';
        $this->observacion = '';
        $this->c_local = '';
        $this->c_accion = 0;
        $this->flag = '';
        $this->c_usuario = '';
        $this->c_local_destino = '';
        $this->c_usuario_destino = '';
        $this->fecha_respuesta = '';
        $this->tipo_persona = '';
        $this->fecha_verif = '';
        $this->usu_recep = '';
        $this->usu_atien = '';

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

    public function setCod_original($cod_original)
    {
        if (empty($cod_original)) return;
        $this->cod_original = self::Clean($cod_original);
    }

    public function getCod_original()
    {
        return $this->cod_original;
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

    public function setC_accion($c_accion)
    {
        if (empty($c_accion)) return;
        $this->c_accion = self::Clean($c_accion);
    }

    public function getC_accion()
    {
        return $this->c_accion;
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

    public function setC_usuario($c_usuario)
    {
        if (empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
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

    public function setC_usuario_destino($c_usuario_destino)
    {
        if (empty($c_usuario_destino)) return;
        $this->c_usuario_destino = self::Clean($c_usuario_destino);
    }

    public function getC_usuario_destino()
    {
        return $this->c_usuario_destino;
    }

    public function setFecha_respuesta($fecha_respuesta)
    {
        if (empty($fecha_respuesta)) return;
        $this->fecha_respuesta = self::Clean($fecha_respuesta);
    }

    public function getFecha_respuesta()
    {
        return $this->fecha_respuesta;
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
