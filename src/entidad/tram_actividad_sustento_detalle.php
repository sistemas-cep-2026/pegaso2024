<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_actividad_sustento_detalle extends Parse
{
    private $numero;
    private $fecha;
    private $c_area_adm;
    private $obs;
    private $fechaf;
    private $valido;
    private $cc_sustento_det;
    private $cc_sustento;
    private $horaini;
    private $horafin;

    function __construct()
    {
        $this->numero = '';
        $this->fecha = '';
        $this->c_area_adm = '';
        $this->obs = '';
        $this->fechaf = '';
        $this->valido = '';
        $this->cc_sustento_det = 0;
        $this->cc_sustento = 0;
        $this->horaini='';
        $this->horafin='';

    }

    public function setNumero($numero)
    {
        if(empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setC_area_adm($c_area_adm)
    {
        if(empty($c_area_adm)) return;
        $this->c_area_adm = self::Clean($c_area_adm);
    }

    public function getC_area_adm()
    {
        return $this->c_area_adm;
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

    public function setFechaf($fechaf)
    {
        if(empty($fechaf)) return;
        $this->fechaf = self::Clean($fechaf);
    }

    public function getFechaf()
    {
        return $this->fechaf;
    }

    public function setValido($valido)
    {
        if(empty($valido)) return;
        $this->valido = self::Clean($valido);
    }

    public function getValido()
    {
        return $this->valido;
    }

    public function setCc_sustento_det($cc_sustento_det)
    {
        if(empty($cc_sustento_det)) return;
        $this->cc_sustento_det = self::Clean($cc_sustento_det);
    }

    public function getCc_sustento_det()
    {
        return $this->cc_sustento_det;
    }

    public function setCc_sustento($cc_sustento)
    {
        if(empty($cc_sustento)) return;
        $this->cc_sustento = self::Clean($cc_sustento);
    }

    public function getCc_sustento()
    {
        return $this->cc_sustento;
    }

    public function setHoraini($horaini)
    {
        if(empty($horaini)) return;
        $this->horaini = self::Clean($horaini);
    }

    public function getHoraini()
    {
        return $this->horaini;
    }
    public function setHorafin($horafin)
    {
        if(empty($horafin)) return;
        $this->horafin = self::Clean($horafin);
    }

    public function getHorafin()
    {
        return $this->horafin;
    }


}