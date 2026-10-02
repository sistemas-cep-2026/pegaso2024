<?php
require_once dirname(__DIR__) . '/entidad/banc_comprobantes_de_caja.php';
require_once __DIR__ . '/_conexa_.php';
class dao_banc_comprobantes_de_caja
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

    public function procesarEgresos(?banc_comprobantes_de_caja $obj)
    {
        $sql = "exec sp_v1_gestionar_comprobante_caja_egresos
        '" . $obj->getOpc() . "', 
        '" . $obj->getCc_documento() . "', 
        '" . $obj->getC_persona() . "', 
        '" . $obj->getFecha() . "', 
        '" . $obj->getC_local() . "', 
        '" . $obj->getCod_ano() . "', 
        '" . $obj->getCod_mes() . "', 
        '" . $obj->getC_banco() . "', 
        '" . $obj->getC_cta_corriente() . "', 
        '" . $obj->getC_forma_cancelacion() . "',
        '" . $obj->getNum_boleta_cheque() . "',
        '" . $obj->getC_liquidacion_caja_chica() . "',
        '" . $obj->getObservacion() . "', 
        '" . $obj->getUsuario() . "'";
        //echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            //echo $sql;
            return $this->conecta->sql_query($sql);
        }
        /*cloud_HUAWEI.beta_app2023.dbo.*/
    }

    public function procesarIngresos(?banc_comprobantes_de_caja $obj)
    {
        $sql = "exec sp_v1_gestionar_comprobante_caja_ingresos
        '" . $obj->getOpc() . "', 
        '" . $obj->getCc_documento() . "', 
        '" . $obj->getC_persona() . "', 
        '" . $obj->getFecha() . "', 
        '" . $obj->getC_local() . "', 
        '" . $obj->getCod_ano() . "', 
        '" . $obj->getCod_mes() . "', 
        '" . $obj->getC_banco() . "', 
        '" . $obj->getC_cta_corriente() . "', 
        'I',
        '" . $obj->getC_forma_cancelacion() . "',
        '" . $obj->getNum_boleta_cheque() . "',
        '" . $obj->getObservacion() . "', 
        '" . $obj->getUsuario() . "'";
        //echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            //echo $sql;
            return $this->conecta->sql_query($sql);
        }
    }
}
