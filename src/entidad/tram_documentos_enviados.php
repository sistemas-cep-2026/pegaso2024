<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_documentos_enviados extends Parse
{
    private $cc_docenviado;
    private $c_tipo_de_documento;
    private $gestion;
    private $num_documento;
    private $fecha;
    private $asunto;
    private $numero;
    private $c_usuario;
    private $c_local;
    private $c_area_adm_usuario;
    private $c_area_adm_doc;
    private $tipo_persona;
    private $flag;

    private $opc;

    private $c_expediente;
    private $cod_es_respuesta;
    private $cod_respuesta;
    private $c_area_adm;
    private $c_persona;
    private $c_documento;
    private $c_local_destino;
    private $cuerpo;
    private $c_usuario_destino;
    private $flag_c_local_destino_todos;
    private $fecha_max;
    private $d_frac;
    private $numerox;


        private $fecha_desde;
            private $fecha_hasta;


    function __construct()
    {
        $this->cc_docenviado = 0;
        $this->c_tipo_de_documento = '';
        $this->gestion = '';
        $this->num_documento = '';
        $this->fecha = '';
        $this->asunto = '';
        $this->numero = '';
        $this->c_usuario = '';
        $this->c_local = '';
        $this->c_area_adm_usuario = '';
        $this->c_area_adm_doc = '';
        $this->tipo_persona = '';
        $this->flag = '';

        $this->opc = '';

        $this->c_expediente = '';
        $this->cod_es_respuesta = '';
        $this->cod_respuesta = '';
        $this->c_area_adm = '';
        $this->c_persona = '';
        $this->c_documento = '';
        $this->c_local_destino = '';
        $this->cuerpo = '';
        $this->c_usuario_destino = '';
        $this->flag_c_local_destino_todos = '';
        $this->fecha_max = '';
        $this->d_frac = '';
        $this->numerox = '';

             $this->fecha_desde = '';
             $this->fecha_hasta = '';
    }

    public function setCc_docenviado($cc_docenviado)
    {
        if (empty($cc_docenviado)) return;
        $this->cc_docenviado = self::Clean($cc_docenviado);
    }

    public function getCc_docenviado()
    {
        return $this->cc_docenviado;
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

    public function setGestion($gestion)
    {
        if (empty($gestion)) return;
        $this->gestion = self::Clean($gestion);
    }

    public function getGestion()
    {
        return $this->gestion;
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

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
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

    public function setNumero($numero)
    {
        if (empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
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

    public function setC_local($c_local)
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setC_area_adm_usuario($c_area_adm_usuario)
    {
        if (empty($c_area_adm_usuario)) return;
        $this->c_area_adm_usuario = self::Clean($c_area_adm_usuario);
    }

    public function getC_area_adm_usuario()
    {
        return $this->c_area_adm_usuario;
    }

    public function setC_area_adm_doc($c_area_adm_doc)
    {
        if (empty($c_area_adm_doc)) return;
        $this->c_area_adm_doc = self::Clean($c_area_adm_doc);
    }

    public function getC_area_adm_doc()
    {
        return $this->c_area_adm_doc;
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


    public function setOpc($opc)
    {
        if (empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
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

    public function setC_expediente($c_expediente)
    {
        if (empty($c_expediente)) return;
        $this->c_expediente = self::Clean($c_expediente);
    }

    public function getC_expediente()
    {
        return $this->c_expediente;
    }

    public function setCod_es_respuesta($cod_es_respuesta)
    {
        if (empty($cod_es_respuesta)) return;
        $this->cod_es_respuesta = self::Clean($cod_es_respuesta);
    }

    public function getCod_es_respuesta()
    {
        return $this->cod_es_respuesta;
    }

    public function setCod_respuesta($cod_respuesta)
    {
        if (empty($cod_respuesta)) return;
        $this->cod_respuesta = self::Clean($cod_respuesta);
    }

    public function getCod_respuesta()
    {
        return $this->cod_respuesta;
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

    public function setC_persona($c_persona)
    {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
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

    public function setC_local_destino($c_local_destino)
    {
        if (empty($c_local_destino)) return;
        $this->c_local_destino = self::Clean($c_local_destino);
    }

    public function getC_local_destino()
    {
        return $this->c_local_destino;
    }

    public function setCuerpo($cuerpo)
    {
        if (empty($cuerpo)) return;
        $this->cuerpo = self::Clean($cuerpo);
    }

    public function getCuerpo()
    {
        return $this->cuerpo;
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

    public function setFlag_c_local_destino_todos($flag_c_local_destino_todos)
    {
        if (empty($flag_c_local_destino_todos)) return;
        $this->flag_c_local_destino_todos = self::Clean($flag_c_local_destino_todos);
    }

    public function getFlag_c_local_destino_todos()
    {
        return $this->flag_c_local_destino_todos;
    }

    public function setFecha_max($fecha_max)
    {
        if (empty($fecha_max)) return;
        $this->fecha_max = self::Clean($fecha_max);
    }

    public function getFecha_max()
    {
        return $this->fecha_max;
    }

    public function setD_frac($d_frac)
    {
        if (empty($d_frac)) return;
        $this->d_frac = self::Clean($d_frac);
    }

    public function getD_frac()
    {
        return $this->d_frac;
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

    public function getfecha_hasta()
    {
        return $this->fecha_hasta;
    }

}
