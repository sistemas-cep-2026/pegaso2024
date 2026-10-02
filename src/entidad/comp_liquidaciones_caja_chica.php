<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class comp_liquidaciones_caja_chica extends Parse
{
    private $cc_caja_chica;
    private $c_liquidacion_caja_chica;
    private $numero;
    private $fecha;
    private $nro_cheque;
    private $c_banco;
    private $monto;
    private $fecha_operacion;
    private $ubicacion;
    private $origen;
    private $c_vendedor;
    private $flag;
    private $monto_apertura;
    private $c_local;
    private $saldo;
    private $c_persona;
    private $flag_bancos;
    private $cheque_bancos;
    private $c_punto_caja;
    private $fecha_cierre;
    private $c_cta_corriente;
    private $c_usuario;

    private $opc;
    private $cod_ano;


    function __construct()
    {
        $this->cc_caja_chica = 0;
        $this->c_liquidacion_caja_chica = '';
        $this->numero = '';
        $this->fecha = '';
        $this->nro_cheque = '';
        $this->c_banco = '';
        $this->monto = 0;
        $this->fecha_operacion = '';
        $this->ubicacion = '';
        $this->origen = '';
        $this->c_vendedor = '';
        $this->flag = '';
        $this->monto_apertura = 0;
        $this->c_local = '';
        $this->saldo = 0;
        $this->c_persona = '';
        $this->flag_bancos = '';
        $this->cheque_bancos = '';
        $this->c_punto_caja = '';
        $this->fecha_cierre = '';
        $this->c_cta_corriente = '';
        $this->c_usuario = '';

        $this->opc = '';
        $this->cod_ano = '';
    }
    public function setCc_caja_chica($cc_caja_chica)
    {
        if (empty($cc_caja_chica)) return;
        $this->cc_caja_chica = self::Clean($cc_caja_chica);
    }

    public function getCc_caja_chica()
    {
        return $this->cc_caja_chica;
    }
    public function setC_liquidacion_caja_chica($c_liquidacion_caja_chica)
    {
        if (empty($c_liquidacion_caja_chica)) return;
        $this->c_liquidacion_caja_chica = self::Clean($c_liquidacion_caja_chica);
    }

    public function getC_liquidacion_caja_chica()
    {
        return $this->c_liquidacion_caja_chica;
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

    public function setFecha($fecha)
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setNro_cheque($nro_cheque)
    {
        if (empty($nro_cheque)) return;
        $this->nro_cheque = self::Clean($nro_cheque);
    }

    public function getNro_cheque()
    {
        return $this->nro_cheque;
    }

    public function setC_banco($c_banco)
    {
        if (empty($c_banco)) return;
        $this->c_banco = self::Clean($c_banco);
    }

    public function getC_banco()
    {
        return $this->c_banco;
    }

    public function setMonto($monto)
    {
        if (empty($monto)) return;
        $this->monto = self::Clean($monto);
    }

    public function getMonto()
    {
        return $this->monto;
    }

    public function setFecha_operacion($fecha_operacion)
    {
        if (empty($fecha_operacion)) return;
        $this->fecha_operacion = self::Clean($fecha_operacion);
    }

    public function getFecha_operacion()
    {
        return $this->fecha_operacion;
    }

    public function setUbicacion($ubicacion)
    {
        if (empty($ubicacion)) return;
        $this->ubicacion = self::Clean($ubicacion);
    }

    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    public function setOrigen($origen)
    {
        if (empty($origen)) return;
        $this->origen = self::Clean($origen);
    }

    public function getOrigen()
    {
        return $this->origen;
    }

    public function setC_vendedor($c_vendedor)
    {
        if (empty($c_vendedor)) return;
        $this->c_vendedor = self::Clean($c_vendedor);
    }

    public function getC_vendedor()
    {
        return $this->c_vendedor;
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

    public function setMonto_apertura($monto_apertura)
    {
        if (empty($monto_apertura)) return;
        $this->monto_apertura = self::Clean($monto_apertura);
    }

    public function getMonto_apertura()
    {
        return $this->monto_apertura;
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

    public function setSaldo($saldo)
    {
        if (empty($saldo)) return;
        $this->saldo = self::Clean($saldo);
    }

    public function getSaldo()
    {
        return $this->saldo;
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

    public function setFlag_bancos($flag_bancos)
    {
        if (empty($flag_bancos)) return;
        $this->flag_bancos = self::Clean($flag_bancos);
    }

    public function getFlag_bancos()
    {
        return $this->flag_bancos;
    }

    public function setCheque_bancos($cheque_bancos)
    {
        if (empty($cheque_bancos)) return;
        $this->cheque_bancos = self::Clean($cheque_bancos);
    }

    public function getCheque_bancos()
    {
        return $this->cheque_bancos;
    }

    public function setC_punto_caja($c_punto_caja)
    {
        if (empty($c_punto_caja)) return;
        $this->c_punto_caja = self::Clean($c_punto_caja);
    }

    public function getC_punto_caja()
    {
        return $this->c_punto_caja;
    }

    public function setFecha_cierre($fecha_cierre)
    {
        if (empty($fecha_cierre)) return;
        $this->fecha_cierre = self::Clean($fecha_cierre);
    }

    public function getFecha_cierre()
    {
        return $this->fecha_cierre;
    }

    public function setC_cta_corriente($c_cta_corriente)
    {
        if (empty($c_cta_corriente)) return;
        $this->c_cta_corriente = self::Clean($c_cta_corriente);
    }

    public function getC_cta_corriente()
    {
        return $this->c_cta_corriente;
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

    public function setOpc($opc)
    {
        if (empty($opc)) return;
        $this->opc = self::Clean($opc);
    }

    public function getOpc()
    {
        return $this->opc;
    }

    public function setCod_ano($cod_ano)
    {
        if (empty($cod_ano)) return;
        $this->cod_ano = self::Clean($cod_ano);
    }

    public function getCod_ano()
    {
        return $this->cod_ano;
    }
}
