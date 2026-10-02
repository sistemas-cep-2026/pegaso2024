<?php
require_once dirname(__DIR__) . '/entidad/comp_documentos_de_compras.php';
require_once __DIR__ . '/_conexa_.php';
class dao_comp_documentos_de_compras
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

    public function procesar(comp_documentos_de_compras $obj)
    {
        $sql = "exec sp_v1_documentosCompras
        '" . $obj->getCc_compra() . "',          
        '" . $obj->getCod_documento() . "',
        '" . $obj->getNum_documento() . "',       
        '" . $obj->getCc_persona() . "',
        '" . $obj->getfecha_documento() . "',
        '" . $obj->getFecha_vencimiento() . "',
        '" . $obj->getTotal() . "',
        '" . $obj->getObservacion() . "',         
        '" . $obj->getCc_local() . "',
        '" . $obj->getUser_crea() . "',            
        '" . $obj->getOpc() . "',
        '" . $obj->getCod_ano() . "',
        '" . $obj->getCod_mes() . "',
        '" . $obj->getTipo_desc() . "',
        '" . $obj->getPorcentaje() . "',
        '" . $obj->getReten_numero() . "',
        '" . $obj->getReten_fecha() . "',
        '" . $obj->getC_liquidacion_caja_chica() . "'
        ";
        //echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            return $this->conecta->sql_query($sql);
        }
    }
}
