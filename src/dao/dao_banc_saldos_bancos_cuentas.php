<?php
require_once dirname(__DIR__) . '/entidad/banc_saldos_bancos_cuentas.php';
require_once __DIR__ . '/_conexa_.php';
class dao_banc_saldos_bancos_cuentas
{
    private $conecta;

    function __construct()
    {
        $this->conecta = new Conecta();
    }

    public function consulta($sql)
    {
        return $this->conecta->ArrayLista($sql);
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    public function procesar(banc_saldos_bancos_cuentas $obj)
    {
        $sql = "exec sp_v1_saldos_bancos_cuentas
        '" . $obj->getCc_saldo() . "',          
        '" . $obj->getFecha() . "',       
        '" . $obj->getC_banco() . "',
        '" . $obj->getC_cta_cte() . "',
        '" . $obj->getSaldo_final() . "',
        '" . $obj->getCod_ano() . "',
        '" . $obj->getCod_mes() . "',
        '" . $obj->getCc_local() . "',
        '" . $obj->getC_usuario() . "',
        '" . $obj->getOpc() . "'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
