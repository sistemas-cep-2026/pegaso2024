<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/fin_documentos_de_venta.php");
class dao_fin_documentos_de_venta
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

    public function procesarBoleta(?fin_documentos_de_venta $obj)
    {
        $sql = "exec sp_v1_documento_venta 
        '" . $obj->getCc_ventas() . "',
        '" . $obj->getC_persona_ref() . "',
        '" . $obj->getC_persona() . "',
        '" . $obj->getCod_documento() . "',
        '" . $obj->getC_punto_de_venta() . "',
        '" . $obj->getHost_registro() . "',
        '" . $obj->getUsuario_registro() . "',
        '" . $obj->getC_local() . "',
        '" . $obj->getObservacion() . "',
        '" . $obj->getOpc() . "'";
        //echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            return $this->conecta->sql_query($sql);
        }
    }
}
