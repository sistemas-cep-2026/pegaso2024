<?php
require_once dirname(__DIR__) . '/entidad/tram_seguimiento_documentos_recibid.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_seguimiento_documentos_recibid
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

    public function procesar_docRecibidos_detalle(?tram_seguimiento_documentos_recibid $obj)
    {
        $sql = "EXEC sp_v1_documentos_recibidos_detalle
        '" . $obj->getCc_docrecibidos_det() . "',
        '" . $obj->getCc_docrecibidos() . "',
        '" . $obj->getC_area_adm() . "',
        '" . $obj->getCod_original() . "',
        '" . $obj->getObservacion() . "',
        '" . $obj->getC_accion() . "',
        '" . $obj->getFlag() . "',
        '" . $obj->getC_usuario() . "',
        '" . $obj->getAccion_a_tomar() . "',
        '" . $obj->getOpc() . "',
        '" . $obj->getLinea() . "'
        ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
