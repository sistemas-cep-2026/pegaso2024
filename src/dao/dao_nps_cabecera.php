<?php
require_once dirname(__DIR__) . '/entidad/nps_cabecera.php';
require_once __DIR__ . '/_conexa_.php';
class dao_nps_cabecera
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

    public function insertar(nps_cabecera $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(nps_cabecera $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(nps_cabecera $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}