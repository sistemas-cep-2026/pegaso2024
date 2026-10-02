<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_documentos_recibidos extends Parse
{
    private $cc_docrecibidos;
    private $c_local;
    private $tipo_persona;
    private $c_cargo;
    private $c_persona;
    private $c_tipo_de_documento;
    private $c_expediente;
    private $fecha_ingreso;
    private $num_documento;
    private $tokenumero;
    private $fecha_documento;
    private $asunto;
    private $asunto2;
    private $cod_original;
    private $c_local_origen;
    private $destrinatario;
    private $c_persona_pf;
    private $c_usuario;
    private $file_adjunto;
    private $destinatario;
    private $flag;

    private $cod_referencia;
    private $documento_enviado;
    private $cod_documento_enviado;
    private $fecha_plazo;
    private $cod_plazo;
    private $c_documento;
    private $c_usuario_origen;
    private $c_procedimiento;
    private $numero;
    private $f_archivado;
    private $remitente_externos;
    private $numerox;

    private $opc;
    private $razon_social;
    private $nombre_remitente;
    private $fecha_desde;
    private $fecha_hasta;
    private $num_desde;
    private $num_hasta;
    private $c_area_adm;
    private $gestion;



    function __construct()
    {
        $this->cc_docrecibidos = 0;
        $this->c_local = '';
        $this->tipo_persona = '';
        $this->c_cargo = '';
        $this->c_persona = '';
        $this->c_tipo_de_documento = '';
        $this->c_expediente = '';
        $this->fecha_ingreso = '';
        $this->num_documento = '';
        $this->tokenumero = '';
        $this->fecha_documento = '';
        $this->asunto = '';
        $this->asunto2 = '';
        $this->cod_original = '';
        $this->c_local_origen = '';
        $this->destrinatario = '';
        $this->c_persona_pf = '';
        $this->c_usuario = '';
        $this->file_adjunto = '';
        $this->destinatario = '';
        $this->flag = '';
        $this->cod_referencia = '';
        $this->documento_enviado = '';
        $this->cod_documento_enviado = '';
        $this->fecha_plazo = '';
        $this->cod_plazo = '';
        $this->c_documento = '';
        $this->c_usuario_origen = '';
        $this->c_procedimiento = 0;
        $this->numero = '';
        $this->f_archivado = '';
        $this->remitente_externos = '';
        $this->numerox = '';

        $this->opc = '';
        $this->razon_social = '';
        $this->nombre_remitente = '';
        $this->fecha_desde = '';
        $this->fecha_hasta = '';
        $this->num_desde = '';
        $this->num_hasta = '';
        $this->c_area_adm = '';
        $this->gestion = '';
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

    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
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

    public function setC_cargo($c_cargo)
    {
        if (empty($c_cargo)) return;
        $this->c_cargo = self::Clean($c_cargo);
    }

    public function getC_cargo()
    {
        return $this->c_cargo;
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

    public function setC_tipo_de_documento($c_tipo_de_documento)
    {
        if (empty($c_tipo_de_documento)) return;
        $this->c_tipo_de_documento = self::Clean($c_tipo_de_documento);
    }

    public function getC_tipo_de_documento()
    {
        return $this->c_tipo_de_documento;
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

    public function setFecha_ingreso($fecha_ingreso)
    {
        if (empty($fecha_ingreso)) return;
        $this->fecha_ingreso = self::Clean($fecha_ingreso);
    }

    public function getFecha_ingreso()
    {
        return $this->fecha_ingreso;
    }

    public function setNum_documento($num_documento)
    {
        if (empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }

    public function getNum_documento()
    {
        return $this->num_documento;
    }

    public function setTokenumero($tokenumero)
    {
        if (empty($tokenumero)) return;
        $this->tokenumero = self::Clean($tokenumero);
    }

    public function getTokenumero()
    {
        return $this->tokenumero;
    }

    public function setFecha_documento($fecha_documento)
    {
        if (empty($fecha_documento)) return;
        $this->fecha_documento = self::Clean($fecha_documento);
    }

    public function getFecha_documento()
    {
        return $this->fecha_documento;
    }

    public function setAsunto($asunto)
    {
        if (empty($asunto)) return;
        $this->asunto = self::Clean($asunto);
    }

    public function getAsunto()
    {
        return $this->asunto;
    }

    public function setAsunto2($asunto2)
    {
        if (empty($asunto2)) return;
        $this->asunto2 = self::Clean($asunto2);
    }

    public function getAsunto2()
    {
        return $this->asunto2;
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

    public function setC_local_origen($c_local_origen)
    {
        if (empty($c_local_origen)) return;
        $this->c_local_origen = self::Clean($c_local_origen);
    }

    public function getC_local_origen()
    {
        return $this->c_local_origen;
    }

    public function setDestrinatario($destrinatario)
    {
        if (empty($destrinatario)) return;
        $this->destrinatario = self::Clean($destrinatario);
    }

    public function getDestrinatario()
    {
        return $this->destrinatario;
    }

    public function setC_persona_pf($c_persona_pf)
    {
        if (empty($c_persona_pf)) return;
        $this->c_persona_pf = self::Clean($c_persona_pf);
    }

    public function getC_persona_pf()
    {
        return $this->c_persona_pf;
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

    public function setFile_adjunto($file_adjunto)
    {
        if (empty($file_adjunto)) return;
        $this->file_adjunto = self::Clean($file_adjunto);
    }

    public function getFile_adjunto()
    {
        return $this->file_adjunto;
    }

    public function setDestinatario($destinatario)
    {
        if (empty($destinatario)) return;
        $this->destinatario = self::Clean($destinatario);
    }

    public function getDestinatario()
    {
        return $this->destinatario;
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

    public function setCod_referencia($cod_referencia)
    {
        if (empty($cod_referencia)) return;
        $this->cod_referencia = self::Clean($cod_referencia);
    }

    public function getCod_referencia()
    {
        return $this->cod_referencia;
    }

    public function setDocumento_enviado($documento_enviado)
    {
        if (empty($documento_enviado)) return;
        $this->documento_enviado = self::Clean($documento_enviado);
    }

    public function getDocumento_enviado()
    {
        return $this->documento_enviado;
    }

    public function setCod_documento_enviado($cod_documento_enviado)
    {
        if (empty($cod_documento_enviado)) return;
        $this->cod_documento_enviado = self::Clean($cod_documento_enviado);
    }

    public function getCod_documento_enviado()
    {
        return $this->cod_documento_enviado;
    }

    public function setFecha_plazo($fecha_plazo)
    {
        if (empty($fecha_plazo)) return;
        $this->fecha_plazo = self::Clean($fecha_plazo);
    }

    public function getFecha_plazo()
    {
        return $this->fecha_plazo;
    }

    public function setCod_plazo($cod_plazo)
    {
        if (empty($cod_plazo)) return;
        $this->cod_plazo = self::Clean($cod_plazo);
    }

    public function getCod_plazo()
    {
        return $this->cod_plazo;
    }

    public function setC_documento($c_documento)
    {
        if (empty($c_documento)) return;
        $this->c_documento = self::Clean($c_documento);
    }

    public function getC_documento()
    {
        return $this->c_documento;
    }

    public function setC_usuario_origen($c_usuario_origen)
    {
        if (empty($c_usuario_origen)) return;
        $this->c_usuario_origen = self::Clean($c_usuario_origen);
    }

    public function getC_usuario_origen()
    {
        return $this->c_usuario_origen;
    }

    public function setC_procedimiento($c_procedimiento)
    {
        if (empty($c_procedimiento)) return;
        $this->c_procedimiento = self::Clean($c_procedimiento);
    }

    public function getC_procedimiento()
    {
        return $this->c_procedimiento;
    }

    public function setNumero($numero)
    {
        if (empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setF_archivado($f_archivado)
    {
        if (empty($f_archivado)) return;
        $this->f_archivado = self::Clean($f_archivado);
    }

    public function getF_archivado()
    {
        return $this->f_archivado;
    }

    public function setRemitente_externos($remitente_externos)
    {
        if (empty($remitente_externos)) return;
        $this->remitente_externos = self::Clean($remitente_externos);
    }

    public function getRemitente_externos()
    {
        return $this->remitente_externos;
    }

    public function setNumerox($numerox)
    {
        if (empty($numerox)) return;
        $this->numerox = self::Clean($numerox);
    }

    public function getNumerox()
    {
        return $this->numerox;
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

    public function setRazon_social($razon_social)
    {
        if (empty($razon_social)) return;
        $this->razon_social = self::Clean($razon_social);
    }

    public function getRazon_social()
    {
        return $this->razon_social;
    }

    public function setNombre_remitente($nombre_remitente)
    {
        if (empty($nombre_remitente)) return;
        $this->nombre_remitente = self::Clean($nombre_remitente);
    }

    public function getNombre_remitente()
    {
        return $this->nombre_remitente;
    }

    public function setFecha_desde($fecha_desde)
    {
        if (empty($fecha_desde)) return;
        $this->fecha_desde = self::Clean($fecha_desde);
    }

    public function getFecha_desde()
    {
        return $this->fecha_desde;
    }
    public function setFecha_hasta($fecha_hasta)
    {
        if (empty($fecha_hasta)) return;
        $this->fecha_hasta = self::Clean($fecha_hasta);
    }

    public function getFecha_hasta()
    {
        return $this->fecha_hasta;
    }

    public function setNum_desde($num_desde)
    {
        if (empty($num_desde)) return;
        $this->num_desde = self::Clean($num_desde);
    }

    public function getNum_desde()
    {
        return $this->num_desde;
    }
    public function setNum_hasta($num_hasta)
    {
        if (empty($num_hasta)) return;
        $this->num_hasta = self::Clean($num_hasta);
    }

    public function getNum_hasta()
    {
        return $this->num_hasta;
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

    public function setGestion($gestion)
    {
        if (empty($gestion)) return;
        $this->gestion = self::Clean($gestion);
    }

    public function getGestion()
    {
        return $this->gestion;
    }
}
