<?php
require_once dirname(__DIR__) . '/entidad/prestamos_socios.php';
require_once __DIR__ . '/_conexa_.php';
class dao_prestamos_socios
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

    public function insertar(prestamos_socios $obj)
    {
        $sql="EXEC sp_v1_fraccionamiento '".$obj->getOpc()."','".$obj->getCc_fraccionamiento()."','".$obj->getC_persona()."',".$obj->getNum_cuotas().",'".$obj->getC_usuario()."'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(prestamos_socios $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(prestamos_socios $obj)
    {
     $sql="EXEC sp_v1_fraccionamiento '".$obj->getOpc()."','".$obj->getCc_fraccionamiento()."','".$obj->getC_persona()."',".$obj->getNum_cuotas().",'".$obj->getC_usuario()."'";
      //  echo $sql;
        return $this->conecta->sql_query($sql);
    }

}