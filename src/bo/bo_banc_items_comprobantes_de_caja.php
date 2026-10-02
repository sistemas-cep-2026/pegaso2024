<?php
require_once dirname(__DIR__) . '/dao/dao_banc_items_comprobantes_de_caja.php';
class bo_banc_items_comprobantes_de_caja
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_banc_items_comprobantes_de_caja();
    }

    public function errores()
    {
        return $this->dao->errores();
    }


    public function procesar_detalle(?banc_items_comprobantes_de_caja $obj)
    {
        return $this->dao->procesar_detalle($obj);
    }

    public function listar(?banc_items_comprobantes_de_caja $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(?banc_items_comprobantes_de_caja $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function ListarIdComprobante(?banc_items_comprobantes_de_caja $obj = null)
    {
        $sql = "SELECT icc.cc_documento_det, 
                icc.cc_documento, 
                icc.c_persona as c_persona_hijo, isnull(p.ruc,'')+'-'+rtrim(p.nombre) as nombre_completo, 
                icc.c_cuenta,
                RTRIM(c.nombre) as nombre_cuenta,
                icc.cod_documento, 
                RTRIM(icc.num_documento) AS num_documento, 
                icc.monto, 
                p.nombre 
                FROM items_comprobantes_de_caja icc left JOIN personas p 
                ON icc.c_persona = p.c_persona
                left join plan_de_cuentas_year c
                on icc.c_cuenta=c.c_cuenta
                WHERE icc.cc_documento='{$obj->getCc_documento()}'
                and c.version='5' 
                order by icc.cc_documento_det desc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
