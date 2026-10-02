<?php
require_once dirname(__DIR__) . '/entidad/fin_detalle_prestamos_socios.php';
require_once __DIR__ . '/_conexa_.php';
class dao_fin_detalle_prestamos_socios
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

    public function insertar(?fin_detalle_prestamos_socios $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(?fin_detalle_prestamos_socios $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(?fin_detalle_prestamos_socios $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
