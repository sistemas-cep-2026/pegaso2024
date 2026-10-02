<?php
require_once dirname(__DIR__) . '/entidad/cont_voucher.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cont_voucher
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

    public function procesar(cont_voucher $obj)
    {
        $sql = "exec sp_v1_web_asiento 
        '".$obj->getCc_voucher()."',
        '".$obj->getC_local()."',
        '".$obj->getAno_contable()."',
        '".$obj->getCod_mes_contable()."',
        '".$obj->getC_persona()."',
        '".$obj->getC_subdiario()."',
        '".$obj->getCod_documento()."',            
        '".$obj->getNum_documento()."',
        '".$obj->getObservacion()."',
        '".$obj->getUsuario()."',
        '".$obj->getFecha()."',             
        '".$obj->getOpc()."'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

}