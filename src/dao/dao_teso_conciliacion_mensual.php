<?php
require_once dirname(__DIR__) . '/entidad/teso_conciliacion_mensual.php';
require_once __DIR__ . '/_conexa_.php';
class dao_teso_conciliacion_mensual
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
     public function procesar(teso_conciliacion_mensual $obj)
    {
        $sql = "EXEC sp_v1_conciliacion_mensual
        '{$obj->getCod_mes()}',
        '{$obj->getCod_anho()}',
        '{$obj->getCc_local()}',
        '{$obj->getUsuario()}',
        '{$obj->getMonto()}',
        '{$obj->getOpc()}' ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

       public function procesar_asiento(teso_conciliacion_mensual $obj)
    {
        $sql = "EXEC sp_v1_asiento_conciacion_liq_a_conta
        '{$obj->getCc_local()}',
        '{$obj->getCod_anho()}',
        '{$obj->getCod_mes()}',
        '{$obj->getAsiento_usuario()}'  ";
     //  echo $sql;
        return $this->conecta->sql_query($sql);
    }

}