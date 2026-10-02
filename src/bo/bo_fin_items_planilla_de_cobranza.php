<?php
require_once dirname(__DIR__) . '/dao/dao_fin_items_planilla_de_cobranza.php';
class bo_fin_items_planilla_de_cobranza
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_fin_items_planilla_de_cobranza();
    }

    public function control(fin_items_planilla_de_cobranza $obj, $opc)
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
    public function validarOperacion(?fin_items_planilla_de_cobranza $obj = null)
    {
        $sql = "SELECT TOP 1 1
            FROM items_planilla_de_cobranza
            WHERE c_banco_ref = '{$obj->getC_banco_ref()}'
            AND cta_cte_deposito = '{$obj->getCta_cte_deposito()}'
            AND num_referencia = '{$obj->getNum_referencia()}'
            AND fecha_referencia = '{$obj->getFecha_referencia()}';";
        return $this->dao->consulta($sql);
    }

    public function ListarIdVentas(?fin_items_planilla_de_cobranza $obj = null)
    {
        $sql = "select c.cc_itemplanilla, 
            c.cc_ventas, 
            rtrim(c.cod_forma_de_pago) cod_forma_de_pago,
            dbo.fc_v1_parametro_valor('items_planilla_de_cobranza','cod_forma_de_pago',c.cod_forma_de_pago) as cod_forma_de_pago_text,
            c.c_banco_ref,
            b.nombre as c_banco_ref_text,
            c.cta_cte_deposito, 
            c.num_referencia, 
            dbo.fc_v1_fecha_texto(c.fecha_referencia) as fecha_referencia_text, 
            c.monto  
            from items_planilla_de_cobranza c left join gen_bancos b
            on c.c_banco_ref=b.c_banco
            where c.cc_ventas={$obj->getCc_ventas()}";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(?fin_items_planilla_de_cobranza $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
