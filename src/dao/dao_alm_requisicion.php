<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/alm_requisicion.php");
class dao_alm_requisicion
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
    

    public function procesar(alm_requisicion $obj)
    {
        $sql = "exec sp_v1_GestionRequisicion
        '".$obj->getFecha()."',
        '".$obj->getObservacion()."',
        '".$obj->getC_usuario()."',
        '".$obj->getCc_local()."',
        '".$obj->getC_area_adm()."',
        '".$obj->getCc_requisicion()."',
        '".$obj->getUser_crea()."',
        '".$obj->getOpc()."';";
        if ($obj->getOpc() == "I") {
         $result = $this->conecta->sql_query($sql);
         return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
     } else {
       // echo $sql;
         return $this->conecta->sql_query($sql);
     }
 }

}