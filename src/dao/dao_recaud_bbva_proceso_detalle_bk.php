<?php
require_once dirname(__DIR__) . '/entidad/recaud_bbva_proceso_detalle.php';
require_once __DIR__ . '/_conexa_.php';
class dao_recaud_bbva_proceso_detalle
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

    public function insertar(recaud_bbva_proceso_detalle $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(recaud_bbva_proceso_detalle $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(recaud_bbva_proceso_detalle $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
