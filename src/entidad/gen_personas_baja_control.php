<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class gen_personas_baja_control extends Parse
{
    private $cc_baja_ctrl;
    private $cc_baja;
    private $flag;
    private $obs;
    private $fecha_crea;
    private $user_crea;

    function __construct()
    {
        $this->cc_baja_ctrl = 0;
        $this->cc_baja = 0;
        $this->flag = '';
        $this->obs = '';
        $this->fecha_crea = '';
        $this->user_crea = '';
    }

    public function setCc_baja_ctrl($cc_baja_ctrl)
    {
        if(empty($cc_baja_ctrl)) return;
        $this->cc_baja_ctrl = self::Clean($cc_baja_ctrl);
    }

    public function getCc_baja_ctrl()
    {
        return $this->cc_baja_ctrl;
    }

    public function setCc_baja($cc_baja)
    {
        if(empty($cc_baja)) return;
        $this->cc_baja = self::Clean($cc_baja);
    }

    public function getCc_baja()
    {
        return $this->cc_baja;
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

    public function setObs($obs)
    {
        if(empty($obs)) return;
        $this->obs = self::Clean($obs);
    }

    public function getObs()
    {
        return $this->obs;
    }

    public function setFecha_crea($fecha_crea)
    {
        if(empty($fecha_crea)) return;
        $this->fecha_crea = self::Clean($fecha_crea);
    }

    public function getFecha_crea()
    {
        return $this->fecha_crea;
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

}