<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/alm_guias_de_salida.php");
class dao_alm_guias_de_salida
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
    public function consumos_mensual(alm_guias_de_salida $obj)
    {
        $sql = "exec sp_kardex_totales_ibi_ti_tg_sf '" . $obj->getAnho() . "','" . $obj->getPeriodo() . "','" . $obj->getC_local(). "'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function procesar(alm_guias_de_salida $obj)
    {
        $sql = "exec sp_v1_GestionGuiasDeSalida
        '".$obj->getCc_guia()."',
        '".$obj->getC_area_adm()."',
        '".$obj->getFecha()."',
        '".$obj->getJustificacion()."',
        '".$obj->getC_local()."',
        '".$obj->getUser_crea()."',
        '".$obj->getOpc()."'
        ";

 
       if ($obj->getOpc() == "I") {
           $result = $this->conecta->sql_query($sql);
           return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
       } else {
           return $this->conecta->sql_query($sql);
       } 
            
   }

}