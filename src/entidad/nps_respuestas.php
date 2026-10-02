<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class nps_respuestas extends Parse
{
    private $cc_nps;
    private $cc_cabecera;
    private $sector;
    private $sector_text;
    private $cc_pregunta;
    private $respuesta;
    private $respuesta_text;

    function __construct()
    {
        $this->cc_nps = 0;
        $this->cc_cabecera = 0;
        $this->sector = 0;
        $this->sector_text = '';
        $this->cc_pregunta = 0;
        $this->respuesta = '';
        $this->respuesta_text = '';
    }

    public function setCc_nps($cc_nps)
    {
        if(empty($cc_nps)) return;
        $this->cc_nps = self::Clean($cc_nps);
    }

    public function getCc_nps()
    {
        return $this->cc_nps;
    }

    public function setCc_cabecera($cc_cabecera)
    {
        if(empty($cc_cabecera)) return;
        $this->cc_cabecera = self::Clean($cc_cabecera);
    }

    public function getCc_cabecera()
    {
        return $this->cc_cabecera;
    }

    public function setSector($sector)
    {
        if(empty($sector)) return;
        $this->sector = self::Clean($sector);
    }

    public function getSector()
    {
        return $this->sector;
    }

    public function setSector_text($sector_text)
    {
        if(empty($sector_text)) return;
        $this->sector_text = self::Clean($sector_text);
    }

    public function getSector_text()
    {
        return $this->sector_text;
    }

    public function setCc_pregunta($cc_pregunta)
    {
        if(empty($cc_pregunta)) return;
        $this->cc_pregunta = self::Clean($cc_pregunta);
    }

    public function getCc_pregunta()
    {
        return $this->cc_pregunta;
    }

    public function setRespuesta($respuesta)
    {
        if(empty($respuesta)) return;
        $this->respuesta = self::Clean($respuesta);
    }

    public function getRespuesta()
    {
        return $this->respuesta;
    }

    public function setRespuesta_text($respuesta_text)
    {
        if(empty($respuesta_text)) return;
        $this->respuesta_text = self::Clean($respuesta_text);
    }

    public function getRespuesta_text()
    {
        return $this->respuesta_text;
    }

}