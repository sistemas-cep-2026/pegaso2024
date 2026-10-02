<?php
require_once dirname(__DIR__) . '/dao/dao_teso_conciliacion_mensual_transferencia.php';
class bo_teso_conciliacion_mensual_transferencia
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_teso_conciliacion_mensual_transferencia();
    }

    public function control(teso_conciliacion_mensual_transferencia $obj, $opc)
    {
        switch($opc){
        case "I":
            return $this->dao->insertar($obj);
            break;
        case "U":
            return $this->dao->modificar($obj);
            break;
        case "E":
            return $this->dao->eliminar($obj);
            break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function ListarConciDetalle(?teso_conciliacion_mensual_transferencia $obj = null)
    {
        $sql = "select cc_transferencia, 
            cc_local, 
            cod_anho, 
            cod_mes, 
            fecha, 
            banco_cuenta, 
            vnop, 
            dbo.fc_fecha_texto(vfecha) AS vfecha_text, 
            vmonto, 
            user_crea, 
            obs
            FROM teso_conciliacion_mensual_transferencia
            WHERE cc_local='{$obj->getCc_local()}' AND cod_anho='{$obj->getCod_anho()}' AND cod_mes='{$obj->getCod_mes()}'";
            //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(teso_conciliacion_mensual_transferencia $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

}