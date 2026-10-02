<?php
require_once dirname(__DIR__) . '/entidad/fin_estado_cuenta_periodo_detalle.php';
require_once __DIR__ . '/_conexa_.php';
class dao_fin_estado_cuenta_periodo_detalle
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

    public function insertar(fin_estado_cuenta_periodo_detalle $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(fin_estado_cuenta_periodo_detalle $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(fin_estado_cuenta_periodo_detalle $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
