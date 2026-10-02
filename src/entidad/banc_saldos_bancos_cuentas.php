<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class banc_saldos_bancos_cuentas extends Parse
{
    private $fecha;
    private $c_banco;
    private $c_cta_cte;
    private $saldo_inicial;
    private $saldo_final;
    private $cheques;
    private $cod_ano;
    private $cod_mes;
    private $cc_saldo;
    private $cc_local;

    private $fecha_registro;
    private $c_usuario;

    private $opc;

    function __construct()
    {
        $this->fecha = '';
        $this->c_banco = '';
        $this->c_cta_cte = '';
        $this->saldo_inicial = 0;
        $this->saldo_final = 0;
        $this->cheques = 0;
        $this->cod_ano = '';
        $this->cod_mes = '';
        $this->cc_saldo = 0;
        $this->opc = 0;
        $this->cc_local = 0;
        $this->c_usuario = '';
        $this->fecha_registro = '';
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

    public function setC_banco($c_banco)
    {
        if (empty($c_banco)) return;
        $this->c_banco = self::Clean($c_banco);
    }

    public function getC_banco()
    {
        return $this->c_banco;
    }

    public function setC_cta_cte($c_cta_cte)
    {
        if (empty($c_cta_cte)) return;
        $this->c_cta_cte = self::Clean($c_cta_cte);
    }

    public function getC_cta_cte()
    {
        return $this->c_cta_cte;
    }

    public function setSaldo_inicial($saldo_inicial)
    {
        if (empty($saldo_inicial)) return;
        $this->saldo_inicial = self::Clean($saldo_inicial);
    }

    public function getSaldo_inicial()
    {
        return $this->saldo_inicial;
    }

    public function setSaldo_final($saldo_final)
    {
        if (empty($saldo_final)) return;
        $this->saldo_final = self::Clean($saldo_final);
    }

    public function getSaldo_final()
    {
        return $this->saldo_final;
    }

    public function setCheques($cheques)
    {
        if (empty($cheques)) return;
        $this->cheques = self::Clean($cheques);
    }

    public function getCheques()
    {
        return $this->cheques;
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

    public function setCod_mes($cod_mes)
    {
        if (empty($cod_mes)) return;
        $this->cod_mes = self::Clean($cod_mes);
    }

    public function getCod_mes()
    {
        return $this->cod_mes;
    }

    public function setCc_saldo($cc_saldo)
    {
        if (empty($cc_saldo)) return;
        $this->cc_saldo = self::Clean($cc_saldo);
    }

    public function getCc_saldo()
    {
        return $this->cc_saldo;
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


    public function setCc_local($cc_local)
    {
        if (empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }

    public function getCc_local()
    {
        return $this->cc_local;
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



    public function setFecha_registro($fecha_registro)
    {
        if (empty($fecha_registro)) return;
        $this->fecha_registro = self::Clean($fecha_registro);
    }

    public function getFecha_registro()
    {
        return $this->fecha_registro;
    }
}
