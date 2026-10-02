<?php
require_once dirname(__DIR__) . '/dao/dao_cont_items_voucher.php';
class bo_cont_items_voucher
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cont_items_voucher();
    }

      public function errores()
    {
        return $this->dao->errores();
    }

     public function procesarDetalle(cont_items_voucher $obj)/*crear documento*/
    {
        return $this->dao->procesarDetalle($obj);
    }

    public function listar(cont_items_voucher $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarIDvoucher(cont_items_voucher $obj = null)
    {
        $sql = "select 
        d.numero, 
        d.linea,
        rtrim(d.c_cuenta) as c_cuenta,
        rtrim(c.nombre) as nombre_cuenta,
        d.debe,
        d.haber
        from items_voucher d 
		INNER JOIN voucher v on v.numero=d.numero
		inner join plan_De_cuentas_year_version pcyv on pcyv.c_year=v.ano_contable
		inner join plan_de_cuentas_year c
        on d.c_cuenta=c.c_cuenta and pcyv.version=c.version
        where d.numero='{$obj->getCc_voucher()}' order by d.c_cuenta,d.linea
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

}