<?php
require_once dirname(__DIR__) . '/entidad/web_tram_colegiacion_doc.php';
require_once __DIR__ . '/_conexa_.php';
class dao_web_tram_colegiacion_doc
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

    public function insertar(web_tram_colegiacion_doc $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(web_tram_colegiacion_doc $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(web_tram_colegiacion_doc $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}