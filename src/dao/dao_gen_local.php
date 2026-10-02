<?php
require_once dirname(__DIR__) . '/entidad/gen_local.php';
require_once __DIR__ . '/Conecta.php';
class dao_gen_local
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

    public function insertar(gen_local $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_local $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_local $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}