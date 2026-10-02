<?php
require_once dirname(__DIR__) . '/entidad/fin_contabilidad_balance.php';
require_once __DIR__ . '/_conexa_.php';
class dao_fin_contabilidad_balance
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


    public function ProcesarBalanceComprobacion(fin_contabilidad_balance $obj)
    {
        $sql = "exec sp_v1_balance_comprobacion 
        '".$obj->getCc_local()."',
        '".$obj->getDigitos()."',
        '".$obj->getAnho()."',
        '".$obj->getDesde()."',
        '".$obj->getHasta()."'";
        return $this->conecta->sql_query($sql);
    }


}