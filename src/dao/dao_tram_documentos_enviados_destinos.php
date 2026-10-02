<?php
require_once dirname(__DIR__) . '/entidad/tram_documentos_enviados_destinos.php';
require_once(u_src() . "dao/_conexa_.php");
class dao_tram_documentos_enviados_destinos
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

    public function insertar(tram_documentos_enviados_destinos $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(tram_documentos_enviados_destinos $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(tram_documentos_enviados_destinos $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
