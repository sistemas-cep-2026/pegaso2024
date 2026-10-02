<?php
require_once dirname(__DIR__) . '/entidad/cont_items_voucher.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cont_items_voucher
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

    public function procesarDetalle(cont_items_voucher $obj)
    {
        $sql = "exec sp_v1_web_asiento_detalle 
        '".$obj->getCc_voucher_det()."',
        '".$obj->getCc_voucher()."',
        '".$obj->getC_cuenta()."',
        '".$obj->getDebe()."',
        '".$obj->getHaber()."',           
        '".$obj->getOpcd()."'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

}