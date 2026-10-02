<?php
require_once dirname(__DIR__) . '/entidad/gen_personas_baja_control.php';
require_once __DIR__ . '/_conexa_.php';
class dao_gen_personas_baja_control
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

    public function insertar(gen_personas_baja_control $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_personas_baja_control $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_personas_baja_control $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}