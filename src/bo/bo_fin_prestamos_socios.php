<?php
require_once dirname(__DIR__) . '/dao/dao_fin_prestamos_socios.php';
class bo_fin_prestamos_socios
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_prestamos_socios();
    }

    public function control(?fin_prestamos_socios $obj, $opc)
    {
        switch ($opc) {
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

    public function listarCuotasRecibo(?fin_prestamos_socios $obj = null)
    {
        $sql = "SELECT d.cc_fraccionamiento_d,
    'CUOTA => '+ dbo.fc_v1_fecha_texto(d.fecha_vencimiento)+ ' | ' + CAST(d.cuota_capital AS VARCHAR(20)) AS cuota,
	d.cuota_capital
    FROM prestamos_socios p
    INNER JOIN detalle_prestamos_socios d
    ON p.cc_fraccionamiento = d.cc_fraccionamiento
    WHERE p.c_persona = '{$obj->getC_persona()}'
    AND p.flag = '*'
    AND d.flag_cancelado = '&'
    ORDER BY d.fecha_vencimiento";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?fin_prestamos_socios $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
