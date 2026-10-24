<?php
require_once dirname(__DIR__) . '/entidad/tram_documentos_enviados.php';
require_once(u_src() . "dao/_conexa_.php");
class dao_tram_documentos_enviados
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

    public function ProcesarDocumentos(tram_documentos_enviados $obj)
    {
        $sql = "EXEC dbo.sp_v1_documentos_enviados
    '" . $obj->getCc_docenviado() . "',
    '" . $obj->getC_tipo_de_documento() . "',
    '" . $obj->getGestion() . "',
 
    '" . $obj->getAsunto() . "',
    '" . $obj->getC_usuario() . "',
    '" . $obj->getC_local() . "',
    '" . $obj->getC_area_adm_usuario() . "',
    '" . $obj->getC_area_adm_doc() . "',
    '" . $obj->getTipo_persona() . "',
    '" . $obj->getFlag() . "',
    '" . $obj->getOpc() . "'";
//echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            return $this->conecta->sql_query($sql);
        }
            
    }
    public function modificar(tram_documentos_enviados $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(tram_documentos_enviados $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
