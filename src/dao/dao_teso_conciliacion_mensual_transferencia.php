<?php
require_once dirname(__DIR__) . '/entidad/teso_conciliacion_mensual_transferencia.php';
require_once __DIR__ . '/_conexa_.php';
class dao_teso_conciliacion_mensual_transferencia
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

    public function insertar(teso_conciliacion_mensual_transferencia $obj)
    {
        $sql = "insert into dbo.teso_conciliacion_mensual_transferencia(cc_local,
                cod_anho,
                cod_mes,
                fecha, 
                banco_cuenta, 
                vnop, 
                vfecha, 
                vmonto,
                obs,
                user_crea, 
                flag
                )VALUES(
                '{$obj->getCc_local()}',
                '{$obj->getCod_anho()}',
                '{$obj->getCod_mes()}',
                getdate(),
                '{$obj->getBanco_cuenta()}',
                '{$obj->getVnop()}',
                '{$obj->getVfecha()}',
                '{$obj->getVmonto()}',
                '{$obj->getObs()}',
                '{$obj->getUser_crea()}',
                'P')";
                //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(teso_conciliacion_mensual_transferencia $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(teso_conciliacion_mensual_transferencia $obj)
    {
        $sql = "DELETE from teso_conciliacion_mensual_transferencia 
        WHERE cc_transferencia={$obj->getCc_transferencia()}";
        return $this->conecta->sql_query($sql);
    }

}