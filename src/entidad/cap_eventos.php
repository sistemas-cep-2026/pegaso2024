<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos extends Parse
{
    private $cc_evento;
    private $codigo;
    private $tipo;
    private $nombre;
    private $cc_local;
    private $fecha;
    private $fecha_ini;
    private $fecha_fin;
    private $horascreditos_text;
    private $img_certificado;
    private $fecha_evento_text;
    private $detalle;
    private $detalle_ponente;
    private $print_documento;
    private $text_documento;
    private $flag;
    private $user_crea;
    private $fecha_crea;
    private $user_mod;
    private $fecha_mod;
    private $administrativo;
    private $organizador;
    private $auspicio;
    private $firma03;
    private $firma01;
    private $firma02;
    private $horas;
    private $creditos;
    private $img_constancia;
    private $estado;
    private $sala;
    private $hora_inicio;
    private $print_documento_public;

    private $opc;

    function __construct()
    {
        $this->cc_evento = 0;
        $this->codigo = '';
        $this->tipo = '';
        $this->nombre = '';
        $this->cc_local = '';
        $this->fecha = '';
        $this->fecha_ini = '';
        $this->fecha_fin = '';
        $this->horascreditos_text = '';
        $this->img_certificado = '';
        $this->fecha_evento_text = '';
        $this-> = '';
        $this->_ponente = '';
        $this->print_documento = '';
        $this->text_documento = '';
        $this->flag = '';
        $this->user_crea = '';
        $this->fecha_crea = '';
        $this->user_mod = '';
        $this->fecha_mod = '';
        $this->administrativo = '';
        $this->organizador = '';
        $this->auspicio = '';
        $this->firma03 = '';
        $this->firma01 = '';
        $this->firma02 = '';
        $this->horas = '';
        $this->creditos = '';
        $this->img_constancia = '';
        $this->estado = '';
        $this->sala = '';
        $this->hora_inicio = '';
        $this->print_documento_public = '';

        $this->opc = '';
    }

    public function setCc_evento($cc_evento)
    {
        if (empty($cc_evento)) return;
        $this->cc_evento = self::Clean($cc_evento);
    }

    public function getCc_evento()
    {
        return $this->cc_evento;
    }

    public function setCodigo($codigo)
    {
        if (empty($codigo)) return;
        $this->codigo = self::Clean($codigo);
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setTipo($tipo)
    {
        if (empty($tipo)) return;
        $this->tipo = self::Clean($tipo);
    }

    public function getTipo()
    {
        return $this->tipo;
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

    public function setCc_local($cc_local)
    {
        if (empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }

    public function getCc_local()
    {
        return $this->cc_local;
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

    public function setFecha_ini($fecha_ini)
    {
        if (empty($fecha_ini)) return;
        $this->fecha_ini = self::Clean($fecha_ini);
    }

    public function getFecha_ini()
    {
        return $this->fecha_ini;
    }

    public function setFecha_fin($fecha_fin)
    {
        if (empty($fecha_fin)) return;
        $this->fecha_fin = self::Clean($fecha_fin);
    }

    public function getFecha_fin()
    {
        return $this->fecha_fin;
    }

    public function setHorascreditos_text($horascreditos_text)
    {
        if ($horascreditos_text === null || trim($horascreditos_text) === '') {
            $this->horascreditos_text = null;
            return;
        }

        $this->horascreditos_text = $horascreditos_text;
    }

    public function getHorascreditos_text()
    {
        return $this->horascreditos_text;
    }

    public function setImg_certificado($img_certificado)
    {
        if (empty($img_certificado)) return;
        $this->img_certificado = self::Clean($img_certificado);
    }

    public function getImg_certificado()
    {
        return $this->img_certificado;
    }

    public function setFecha_evento_text($fecha_evento_text)
    {
        if (empty($fecha_evento_text)) return;
        $this->fecha_evento_text = self::Clean($fecha_evento_text);
    }

    public function getFecha_evento_text()
    {
        return $this->fecha_evento_text;
    }

    public function setDetalle($detalle)
    {
        if ($detalle === null || trim($detalle) === '') {
            $this->detalle = null;
            return;
        }

        $this->detalle = $detalle;
    }

    public function getDetalle()
    {
        return $this->detalle;
    }

     public function setDetalle_ponente($detalle_ponente)
    {
        if ($detalle_ponente === null || trim($detalle_ponente) === '') {
            $this->detalle_ponente = null;
            return;
        }

        $this->detalle_ponente = $detalle_ponente;
    }

    public function getDetalle_ponente()
    {
        return $this->detalle_ponente;
    }

    public function setPrint_documento($print_documento)
    {
        if (empty($print_documento)) return;
        $this->print_documento = self::Clean($print_documento);
    }

    public function getPrint_documento()
    {
        return $this->print_documento;
    }

    public function setText_documento($text_documento)
    {
        if (empty($text_documento)) return;
        $this->text_documento = self::Clean($text_documento);
    }

    public function getText_documento()
    {
        return $this->text_documento;
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

    public function setUser_crea($user_crea)
    {
        if (empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setFecha_crea($fecha_crea)
    {
        if (empty($fecha_crea)) return;
        $this->fecha_crea = self::Clean($fecha_crea);
    }

    public function getFecha_crea()
    {
        return $this->fecha_crea;
    }

    public function setUser_mod($user_mod)
    {
        if (empty($user_mod)) return;
        $this->user_mod = self::Clean($user_mod);
    }

    public function getUser_mod()
    {
        return $this->user_mod;
    }

    public function setFecha_mod($fecha_mod)
    {
        if (empty($fecha_mod)) return;
        $this->fecha_mod = self::Clean($fecha_mod);
    }

    public function getFecha_mod()
    {
        return $this->fecha_mod;
    }

    public function setAdministrativo($administrativo)
    {
        if (empty($administrativo)) return;
        $this->administrativo = self::Clean($administrativo);
    }

    public function getAdministrativo()
    {
        return $this->administrativo;
    }

    public function setOrganizador($organizador)
    {
        if (empty($organizador)) return;
        $this->organizador = self::Clean($organizador);
    }

    public function getOrganizador()
    {
        return $this->organizador;
    }

    public function setAuspicio($auspicio)
    {
        if (empty($auspicio)) return;
        $this->auspicio = self::Clean($auspicio);
    }

    public function getAuspicio()
    {
        return $this->auspicio;
    }

    public function setFirma03($firma03)
    {
        if (empty($firma03)) return;
        $this->firma03 = self::Clean($firma03);
    }

    public function getFirma03()
    {
        return $this->firma03;
    }

    public function setFirma01($firma01)
    {
        if (empty($firma01)) return;
        $this->firma01 = self::Clean($firma01);
    }

    public function getFirma01()
    {
        return $this->firma01;
    }

    public function setFirma02($firma02)
    {
        if (empty($firma02)) return;
        $this->firma02 = self::Clean($firma02);
    }

    public function getFirma02()
    {
        return $this->firma02;
    }

    public function setHoras($horas)
    {
        if (empty($horas)) return;
        $this->horas = self::Clean($horas);
    }

    public function getHoras()
    {
        return $this->horas;
    }

    public function setCreditos($creditos)
    {
        if (empty($creditos)) return;
        $this->creditos = self::Clean($creditos);
    }

    public function getCreditos()
    {
        return $this->creditos;
    }

    public function setImg_constancia($img_constancia)
    {
        if (empty($img_constancia)) return;
        $this->img_constancia = self::Clean($img_constancia);
    }

    public function getImg_constancia()
    {
        return $this->img_constancia;
    }

    public function setEstado($estado)
    {
        if (empty($estado)) return;
        $this->estado = self::Clean($estado);
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setSala($sala)
    {
        if (empty($sala)) return;
        $this->sala = self::Clean($sala);
    }

    public function getSala()
    {
        return $this->sala;
    }

    public function setHora_inicio($hora_inicio)
    {
        if (empty($hora_inicio)) return;
        $this->hora_inicio = self::Clean($hora_inicio);
    }

    public function getHora_inicio()
    {
        return $this->hora_inicio;
    }

    public function setPrint_documento_public($print_documento_public)
    {
        if (empty($print_documento_public)) return;
        $this->print_documento_public = self::Clean($print_documento_public);
    }

    public function getPrint_documento_public()
    {
        return $this->print_documento_public;
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
