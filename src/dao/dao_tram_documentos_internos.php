<?php
require_once dirname(__DIR__) . '/entidad/tram_documentos_internos.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_documentos_internos
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

    public function insertar(tram_documentos_internos $obj)
    {
        $sql = "EXEC sp_v1_web_habilitacion_temp '{$obj->getC_local()}', '{$obj->getC_usuario_n()}','{$obj->getC_persona()}','{$obj->getFecha_visado()}','{$obj->getFecha_entrega()}','{$obj->getC_tipo()}','{$obj->getOBS()}','{$obj->getC_expediente()}','{$obj->getCod_codigo()}','01';";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(tram_documentos_internos $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(tram_documentos_internos $obj)
    {
        $sql = "UPDATE Documentos_Internos SET flag='A', obs = RTRIM(obs)+' - ANULADO '+' (".date('d/m/Y H:i:s')."  {$obj->getC_usuario_n()})' WHERE id_doc='{$obj->getId_doc()}'";
        return $this->conecta->sql_query($sql);
    }
}
