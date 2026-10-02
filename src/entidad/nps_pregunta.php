<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class nps_pregunta extends Parse
{
    private $cc_pregunta;
    private $pregunta;
    private $min_text;
    private $max_text;

    function __construct()
    {
        $this->cc_pregunta = 0;
        $this->pregunta = '';
        $this->min_text = '';
        $this->max_text = '';
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

    public function setPregunta($pregunta)
    {
        if(empty($pregunta)) return;
        $this->pregunta = self::Clean($pregunta);
    }

    public function getPregunta()
    {
        return $this->pregunta;
    }

    public function setMin_text($min_text)
    {
        if(empty($min_text)) return;
        $this->min_text = self::Clean($min_text);
    }

    public function getMin_text()
    {
        return $this->min_text;
    }

    public function setMax_text($max_text)
    {
        if(empty($max_text)) return;
        $this->max_text = self::Clean($max_text);
    }

    public function getMax_text()
    {
        return $this->max_text;
    }

}