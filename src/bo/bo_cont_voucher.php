<?php
require_once dirname(__DIR__) . '/dao/dao_cont_voucher.php';
class bo_cont_voucher
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cont_voucher();
    }

    public function errores()
    {
        return $this->dao->errores();
    }
    
    public function procesar(cont_voucher $obj)/*crear documento*/
    {
        return $this->dao->procesar($obj);
    }

    
    public function listarIDMax(){
        $sql="select max(numero) as maximo
        from voucher nolock";
        return $this->dao->consulta($sql);
    }


    public function listar(cont_voucher $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(cont_voucher $obj = null)
    {
        $sql = "select v.numero,
        v.voucher,
        v.c_local,
        v.c_subdiario,
        v.c_persona,
        rtrim(p.nombre) as razon_social,
        v.cod_documento,
        v.num_documento,
       
        v.observacion
       ,v.ano_contable,v.cod_mes_contable,s.nombre nombre_subdiario,p.ruc,
       dbo.fc_v1_fecha_hora(v.fecha)as fecha
        from voucher v (nolock) inner join personas p (nolock)
		on v.c_persona=p.c_persona
		inner join subdiarios s on s.c_subdiario=v.c_subdiario
        where v.numero='{$obj->getCc_voucher()}'";
         //echo $sql;
        return $this->dao->consulta($sql);
    }

}