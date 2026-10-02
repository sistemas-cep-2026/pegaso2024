<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_personas_obs_matricula extends Parse
{
    private $cc_personaobs;
    private $c_persona;
    private $fecha;
    private $tip_registro;
    private $reg_sunedu;
    private $universidad;
    private $cert_est;
    private $cod_observacion;
    private $observacion;
    private $doc_envio_tipo;
    private $doc_envio_numero;
    private $respuesta;
    private $fecha_respuesta;
    private $absuelto;
    private $usuario;
    private $flag;
    private $reportado;
    private $fecha_reportado;

    private $nombre;
    private $cep;
    

    function __construct()
    {
        $this->cc_personaobs=0;
        $this->c_persona = 0;
        $this->fecha = '';
        $this->tip_registro = '';
        $this->reg_sunedu = '';
        $this->universidad = '';
        $this->cert_est = '';
        $this->cod_observacion = '';
        $this->observacion = '';
        $this->doc_envio_tipo = '';
        $this->doc_envio_numero = '';
        $this->respuesta = '';
        $this->fecha_respuesta = '';
        $this->absuelto = '';
        $this->usuario = '';
        $this->flag = '';
        $this->reportado = '';
        $this->fecha_reportado = '';

        $this->nombre = '';
        $this->cep = '';
    }

    public function setCc_personaobs($cc_personaobs)
    {
        if (empty($cc_personaobs)) return;
        $this->cc_personaobs = self::Clean($cc_personaobs);
    }

    public function getCc_personaobs()
    {
        return $this->cc_personaobs;
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

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setTip_registro($tip_registro)
    {
        if (empty($tip_registro)) return;
        $this->tip_registro = self::Clean($tip_registro);
    }

    public function getTip_registro()
    {
        return $this->tip_registro;
    }

    public function setReg_sunedu($reg_sunedu)
    {
        if (empty($reg_sunedu)) return;
        $this->reg_sunedu = self::Clean($reg_sunedu);
    }

    public function getReg_sunedu()
    {
        return $this->reg_sunedu;
    }

    public function setUniversidad($universidad)
    {
        if (empty($universidad)) return;
        $this->universidad = self::Clean($universidad);
    }

    public function getUniversidad()
    {
        return $this->universidad;
    }

    public function setCert_est($cert_est)
    {
        if (empty($cert_est)) return;
        $this->cert_est = self::Clean($cert_est);
    }

    public function getCert_est()
    {
        return $this->cert_est;
    }

    public function setCod_observacion($cod_observacion)
    {
        if (empty($cod_observacion)) return;
        $this->cod_observacion = self::Clean($cod_observacion);
    }

    public function getCod_observacion()
    {
        return $this->cod_observacion;
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

    public function setDoc_envio_tipo($doc_envio_tipo)
    {
        if (empty($doc_envio_tipo)) return;
        $this->doc_envio_tipo = self::Clean($doc_envio_tipo);
    }

    public function getDoc_envio_tipo()
    {
        return $this->doc_envio_tipo;
    }

    public function setDoc_envio_numero($doc_envio_numero)
    {
        if (empty($doc_envio_numero)) return;
        $this->doc_envio_numero = self::Clean($doc_envio_numero);
    }

    public function getDoc_envio_numero()
    {
        return $this->doc_envio_numero;
    }

    public function setRespuesta($respuesta)
    {
        if (empty($respuesta)) return;
        $this->respuesta = self::Clean($respuesta);
    }

    public function getRespuesta()
    {
        return $this->respuesta;
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

    public function setAbsuelto($absuelto)
    {
        if (empty($absuelto)) return;
        $this->absuelto = self::Clean($absuelto);
    }

    public function getAbsuelto()
    {
        return $this->absuelto;
    }

    public function setUsuario($usuario)
    {
        if (empty($usuario)) return;
        $this->usuario = self::Clean($usuario);
    }

    public function getUsuario()
    {
        return $this->usuario;
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

    public function setReportado($reportado)
    {
        if (empty($reportado)) return;
        $this->reportado = self::Clean($reportado);
    }

    public function getReportado()
    {
        return $this->reportado;
    }

    public function setFecha_reportado($fecha_reportado)
    {
        if (empty($fecha_reportado)) return;
        $this->fecha_reportado = self::Clean($fecha_reportado);
    }

    public function getFecha_reportado()
    {
        return $this->fecha_reportado;
    }

    public function setNombre($nombre)
    {
        if (empty($nombre)) return;
        $this->nombre = self::Clean($nombre);
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setCep($cep)
    {
        if (empty($cep)) return;
        $this->cep = self::Clean($cep);
    }

    public function getCep()
    {
        return $this->cep;
    }

}