<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos_inscripcion extends Parse
{
    private $cc_evento_insc;
    private $cc_evento;
    private $codigo;
    private $c_persona;
    private $celular;
    private $correo;
    private $user_crea;
    private $fech_crea;
    private $fech_mod;
    private $fecha_voucher;
    private $n_operacion_voucher;
    private $monto;
    private $sino;
    private $flag;

    function __construct()
    {
        $this->cc_evento_insc = 0;
        $this->cc_evento = 0;
        $this->codigo = '';
        $this->c_persona = '';
        $this->celular = '';
        $this->correo = '';
        $this->user_crea = '';
        $this->fech_crea = '';
        $this->fech_mod = '';
        $this->fecha_voucher = '';
        $this->n_operacion_voucher = '';
        $this->monto = '';
        $this->sino = '';
        $this->flag = '';
    }

    public function setCc_evento_insc($cc_evento_insc)
    {
        if(empty($cc_evento_insc)) return;
        $this->cc_evento_insc = self::Clean($cc_evento_insc);
    }

    public function getCc_evento_insc()
    {
        return $this->cc_evento_insc;
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

    public function setCelular($celular)
    {
        if(empty($celular)) return;
        $this->celular = self::Clean($celular);
    }

    public function getCelular()
    {
        return $this->celular;
    }

    public function setCorreo($correo)
    {
        if(empty($correo)) return;
        $this->correo = self::Clean($correo);
    }

    public function getCorreo()
    {
        return $this->correo;
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

    public function setFech_crea($fech_crea)
    {
        if(empty($fech_crea)) return;
        $this->fech_crea = self::Clean($fech_crea);
    }

    public function getFech_crea()
    {
        return $this->fech_crea;
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

    public function setFecha_voucher($fecha_voucher)
    {
        if(empty($fecha_voucher)) return;
        $this->fecha_voucher = self::Clean($fecha_voucher);
    }

    public function getFecha_voucher()
    {
        return $this->fecha_voucher;
    }

    public function setN_operacion_voucher($n_operacion_voucher)
    {
        if(empty($n_operacion_voucher)) return;
        $this->n_operacion_voucher = self::Clean($n_operacion_voucher);
    }

    public function getN_operacion_voucher()
    {
        return $this->n_operacion_voucher;
    }

    public function setMonto($monto)
    {
        if(empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setSino($sino)
    {
        if(empty($sino)) return;
        $this->sino = self::Clean($sino);
    }

    public function getSino()
    {
        return $this->sino;
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