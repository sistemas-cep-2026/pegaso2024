<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos_asistencia extends Parse
{
    private $cc_asistencia;
    private $cc_evento;
    private $c_persona;
    private $fech_crea;
    private $user_crea;
    private $flag;

    function __construct()
    {
        $this->cc_asistencia = 0;
        $this->cc_evento = 0;
        $this->c_persona = '';
        $this->fech_crea = '';
        $this->user_crea = '';
        $this->flag = '';
    }

    public function setCc_asistencia($cc_asistencia)
    {
        if(empty($cc_asistencia)) return;
        $this->cc_asistencia = self::Clean($cc_asistencia);
    }

    public function getCc_asistencia()
    {
        return $this->cc_asistencia;
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

    public function setC_persona($c_persona)
    {
        if(empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
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

    public function setUser_crea($user_crea)
    {
        if(empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }

    public function getUser_crea()
    {
        return $this->user_crea;
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

}