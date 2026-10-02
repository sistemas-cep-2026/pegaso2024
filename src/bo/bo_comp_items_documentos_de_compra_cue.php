<?php
require_once dirname(__DIR__) . '/dao/dao_comp_items_documentos_de_compra_cue.php';
class bo_comp_items_documentos_de_compra_cue
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_comp_items_documentos_de_compra_cue();
    }

    public function errores()
    {
        return $this->dao->errores();
    }


    public function procesar_detalle(comp_items_documentos_de_compra_cue $obj)
    {
        return $this->dao->procesar_detalle($obj);
    }


    public function listaIDCompra(comp_items_documentos_de_compra_cue $obj)
    {
        $sql = "select d.cc_compra_det, 
        d.cc_compra,
        d.c_cuenta,
        d.debe,
        d.haber,
        rtrim(p.nombre) as nombre_cuenta
        from items_documentos_de_compra_cue d left join plan_de_cuentas_year p
        on d.c_cuenta=p.c_cuenta and p.version='5'
        where d.cc_compra='{$obj->getCc_compra()}'
        order by d.c_cuenta asc";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
