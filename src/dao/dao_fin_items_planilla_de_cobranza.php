<?php
require_once dirname(__DIR__) . '/entidad/fin_items_planilla_de_cobranza.php';
require_once __DIR__ . '/_conexa_.php';
class dao_fin_items_planilla_de_cobranza
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

    public function insertar(fin_items_planilla_de_cobranza $obj)
    {
        $sql = "insert INTO items_planilla_de_cobranza(
            cc_ventas,
            cod_forma_de_pago,
            C_banco_ref,
            cta_cte_deposito,
            num_referencia,
            fecha_referencia,
            monto
        )values(
            '{$obj->getCc_ventas()}',
            '{$obj->getCod_forma_de_pago()}',
            '{$obj->getC_banco_ref()}',
            '{$obj->getCta_cte_deposito()}',
            '{$obj->getNum_referencia()}',
            '{$obj->getFecha_referencia()}',
            '{$obj->getMonto()}'
        )";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(fin_items_planilla_de_cobranza $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(fin_items_planilla_de_cobranza $obj)
    {
        $sql = "delete from items_planilla_de_cobranza 
        where cc_itemplanilla='{$obj->getCc_itemplanilla()}'";
        echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
