<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/alm_guias_de_entrada.php");
class dao_alm_guias_de_entrada
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
    

    public function procesar(alm_guias_de_entrada $obj)
    {
        $sql = "exec sp_v1_GestionGuiasdeEntrada
        '".$obj->getCc_local()."',    
        '".$obj->getCc_persona()."',
        '".$obj->getCod_documento()."',
        '".$obj->getNum_documento()."',
        '".$obj->getFecha()."',
        '".$obj->getCc_requisicion()."',
        '".$obj->getCc_guia()."',
        '".$obj->getCc_usuario()."',
        '".$obj->getObservacion()."',
        '".$obj->getOpc()."';";
          // echo $sql;
       if ($obj->getOpc() == "I") {
           $result = $this->conecta->sql_query($sql);
           return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
       } else {
       // echo $sql;
           return $this->conecta->sql_query($sql);
       }   }

}