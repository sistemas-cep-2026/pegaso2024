<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/tram_documentos_recibidos.php");
class dao_tram_documentos_recibidos
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

    public function ProcesarDocumentosRecibidos(tram_documentos_recibidos $obj)
    {
        $sql = "EXEC sp_v1_documentos_recibidos 
        '" . $obj->getCc_docrecibidos() . "',
        '" . $obj->getC_tipo_de_documento() . "',
        '" . $obj->getNum_documento() . "',             
        '" . $obj->getFecha_documento() . "',
        '" . $obj->getC_persona() . "',             
        '" . $obj->getC_persona_pf() . "',
        '" . $obj->getAsunto() . "',        
        '" . $obj->getAsunto2() . "',              
        '" . $obj->getC_local() . "',             
        '" . $obj->getC_usuario() . "',
        '" . $obj->getTipo_persona() . "',
        '" . $obj->getDestrinatario() . "',
        '" . $obj->getC_local_origen() . "',
        '" . $obj->getC_cargo() . "',
        '" . $obj->getTokenumero() . "',
        '07',
        '" . $obj->getOpc() . "'";
        //echo $sql;
        if ($obj->getOpc() == "I") {
            $result = $this->conecta->sql_query($sql);
            return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
        } else {
            return $this->conecta->sql_query($sql);
        }
    }
    public function subir_file(tram_documentos_recibidos $obj)
    {
        $sql = "update documentos_recibidos1 
        set documento_enviado='{$obj->getDocumento_enviado()}' 
        where cc_docrecibidos={$obj->getCc_docrecibidos()}
        and (documento_enviado is null or rtrim(documento_enviado)='')";
        return $this->conecta->sql_query($sql);
    }
    public function eliminar_file(tram_documentos_recibidos $obj)
    {
        $sql = "update documentos_recibidos1 
        set documento_enviado=NULL
        where cc_docrecibidos={$obj->getCc_docrecibidos()}
        and rtrim(documento_enviado) like '%.pdf'";
        return $this->conecta->sql_query($sql);
    }
}
