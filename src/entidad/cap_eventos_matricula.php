<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos_matricula extends Parse
{
    private $cc_evento_mat;
    private $cc_evento;
    private $codigo;
    private $c_persona;
    private $tipo;
    private $user_crea;
    private $user_mod;
    private $fech_crea;
    private $flag;
    private $fech_mod;
    private $obs;
    private $asistente;
    private $ponente;
    private $organizador;
    private $nota;
    private $documento;
    private $modalidad;

    function __construct()
    {
        $this->cc_evento_mat = 0;
        $this->cc_evento = 0;
        $this->codigo = '';
        $this->c_persona = '';
        $this->tipo = '';
        $this->user_crea = '';
        $this->user_mod = '';
        $this->fech_crea = '';
        $this->flag = '';
        $this->fech_mod = '';
        $this->obs = '';
        $this->asistente = '';
        $this->ponente = '';
        $this->organizador = '';
        $this->nota = '';
        $this->documento = '';
        $this->modalidad = '';
    }

    public function setCc_evento_mat($cc_evento_mat)
    {
        if(empty($cc_evento_mat)) return;
        $this->cc_evento_mat = self::Clean($cc_evento_mat);
    }

    public function getCc_evento_mat()
    {
        return $this->cc_evento_mat;
    }

    public function setCc_evento($cc_evento)
    {
        if(empty($cc_evento)) return;
        $this->cc_evento = self::Clean($cc_evento);
    }

    public function getCc_evento()
    {
        return $this->cc_evento;
    }

    public function setCodigo($codigo)
    {
        if(empty($codigo)) return;
        $this->codigo = self::Clean($codigo);
    }

    public function getCodigo()
    {
        return $this->codigo;
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

    public function setTipo($tipo)
    {
        if(empty($tipo)) return;
        $this->tipo = self::Clean($tipo);
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setUser_crea($user_crea)
    {
        if(empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setUser_mod($user_mod)
    {
        if(empty($user_mod)) return;
        $this->user_mod = self::Clean($user_mod);
    }

    public function getUser_mod()
    {
        return $this->user_mod;
    }

    public function setFech_crea($fech_crea)
    {
        if(empty($fech_crea)) return;
        $this->fech_crea = self::Clean($fech_crea);
    }

    public function getFech_crea()
    {
        return $this->fech_crea;
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

    public function setFech_mod($fech_mod)
    {
        if(empty($fech_mod)) return;
        $this->fech_mod = self::Clean($fech_mod);
    }

    public function getFech_mod()
    {
        return $this->fech_mod;
    }

    public function setObs($obs)
    {
        if(empty($obs)) return;
        $this->obs = self::Clean($obs);
    }

    public function getObs()
    {
        return $this->obs;
    }

    public function setAsistente($asistente)
    {
        if(empty($asistente)) return;
        $this->asistente = self::Clean($asistente);
    }

    public function getAsistente()
    {
        return $this->asistente;
    }

    public function setPonente($ponente)
    {
        if(empty($ponente)) return;
        $this->ponente = self::Clean($ponente);
    }

    public function getPonente()
    {
        return $this->ponente;
    }

    public function setOrganizador($organizador)
    {
        if(empty($organizador)) return;
        $this->organizador = self::Clean($organizador);
    }

    public function getOrganizador()
    {
        return $this->organizador;
    }

    public function setNota($nota)
    {
        if(empty($nota)) return;
        $this->nota = self::Clean($nota);
    }

    public function getNota()
    {
        return $this->nota;
    }

    public function setDocumento($documento)
    {
        if(empty($documento)) return;
        $this->documento = self::Clean($documento);
    }

    public function getDocumento()
    {
        return $this->documento;
    }

    public function setModalidad($modalidad)
    {
        if(empty($modalidad)) return;
        $this->modalidad = self::Clean($modalidad);
    }

    public function getModalidad()
    {
        return $this->modalidad;
    }

}