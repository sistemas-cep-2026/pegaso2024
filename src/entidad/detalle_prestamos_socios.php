<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class detalle_prestamos_socios extends Parse
{
    private $c_ano;
    private $numero;
    private $linea;
    private $fecha_vencimiento;
    private $cuota_capital;
    private $cuota_interes;
    private $flag_cancelado;
    private $fecha_cancelado;
    private $voucher;
    private $CODAFI2;
    private $NUMPRE;
    private $cod_documento_ref;
    private $num_documento_ref;
    private $cc_fraccionamiento;
    private $cc_fraccionamiento_d;

    function __construct()
    {
        $this->c_ano = '';
        $this->numero = '';
        $this->linea = 0;
        $this->fecha_vencimiento = '';
        $this->cuota_capital = 0;
        $this->cuota_interes = 0;
        $this->flag_cancelado = '';
        $this->fecha_cancelado = '';
        $this->voucher = '';
        $this->CODAFI2 = '';
        $this->NUMPRE = '';
        $this->cod_documento_ref = '';
        $this->num_documento_ref = '';
        $this->cc_fraccionamiento = 0;
        $this->cc_fraccionamiento_d = 0;
    }

    public function setC_ano($c_ano)
    {
        if(empty($c_ano)) return;
        $this->c_ano = self::Clean($c_ano);
    }

    public function getC_ano()
    {
        return $this->c_ano;
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

    public function setLinea($linea)
    {
        if(empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
    }

    public function setFecha_vencimiento($fecha_vencimiento)
    {
        if(empty($fecha_vencimiento)) return;
        $this->fecha_vencimiento = self::Clean($fecha_vencimiento);
    }

    public function getFecha_vencimiento()
    {
        return $this->fecha_vencimiento;
    }

    public function setCuota_capital($cuota_capital)
    {
        if(empty($cuota_capital)) return;
        $this->cuota_capital = self::Clean($cuota_capital);
    }

    public function getCuota_capital()
    {
        return $this->cuota_capital;
    }

    public function setCuota_interes($cuota_interes)
    {
        if(empty($cuota_interes)) return;
        $this->cuota_interes = self::Clean($cuota_interes);
    }

    public function getCuota_interes()
    {
        return $this->cuota_interes;
    }

    public function setFlag_cancelado($flag_cancelado)
    {
        if(empty($flag_cancelado)) return;
        $this->flag_cancelado = self::Clean($flag_cancelado);
    }

    public function getFlag_cancelado()
    {
        return $this->flag_cancelado;
    }

    public function setFecha_cancelado($fecha_cancelado)
    {
        if(empty($fecha_cancelado)) return;
        $this->fecha_cancelado = self::Clean($fecha_cancelado);
    }

    public function getFecha_cancelado()
    {
        return $this->fecha_cancelado;
    }

    public function setVoucher($voucher)
    {
        if(empty($voucher)) return;
        $this->voucher = self::Clean($voucher);
    }

    public function getVoucher()
    {
        return $this->voucher;
    }

    public function setCODAFI2($CODAFI2)
    {
        if(empty($CODAFI2)) return;
        $this->CODAFI2 = self::Clean($CODAFI2);
    }

    public function getCODAFI2()
    {
        return $this->CODAFI2;
    }

    public function setNUMPRE($NUMPRE)
    {
        if(empty($NUMPRE)) return;
        $this->NUMPRE = self::Clean($NUMPRE);
    }

    public function getNUMPRE()
    {
        return $this->NUMPRE;
    }

    public function setCod_documento_ref($cod_documento_ref)
    {
        if(empty($cod_documento_ref)) return;
        $this->cod_documento_ref = self::Clean($cod_documento_ref);
    }

    public function getCod_documento_ref()
    {
        return $this->cod_documento_ref;
    }

    public function setNum_documento_ref($num_documento_ref)
    {
        if(empty($num_documento_ref)) return;
        $this->num_documento_ref = self::Clean($num_documento_ref);
    }

    public function getNum_documento_ref()
    {
        return $this->num_documento_ref;
    }

    public function setCc_fraccionamiento($cc_fraccionamiento)
    {
        if(empty($cc_fraccionamiento)) return;
        $this->cc_fraccionamiento = self::Clean($cc_fraccionamiento);
    }

    public function getCc_fraccionamiento()
    {
        return $this->cc_fraccionamiento;
    }

    public function setCc_fraccionamiento_d($cc_fraccionamiento_d)
    {
        if(empty($cc_fraccionamiento_d)) return;
        $this->cc_fraccionamiento_d = self::Clean($cc_fraccionamiento_d);
    }

    public function getCc_fraccionamiento_d()
    {
        return $this->cc_fraccionamiento_d;
    }

}