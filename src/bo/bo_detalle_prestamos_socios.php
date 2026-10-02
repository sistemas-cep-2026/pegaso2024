<?php
require_once dirname(__DIR__) . '/dao/dao_detalle_prestamos_socios.php';
class bo_detalle_prestamos_socios
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_detalle_prestamos_socios();
    }

    public function control(detalle_prestamos_socios $obj, $opc)
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

    public function listar(detalle_prestamos_socios $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(detalle_prestamos_socios $obj = null)
    {
        $sql = "select *,        dbo.fc_fecha_texto(fecha_vencimiento) AS fecha_texto,
        dbo.fc_fecha_texto(fecha_cancelado) AS fecha_texto_cancelado 
        from detalle_prestamos_socios where cc_fraccionamiento='{$obj->getCc_fraccionamiento()}'";
        return $this->dao->consulta($sql);
    }

}