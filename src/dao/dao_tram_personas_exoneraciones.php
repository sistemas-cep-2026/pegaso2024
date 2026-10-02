<?php
require_once dirname(__DIR__) . '/entidad/tram_personas_exoneraciones.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_personas_exoneraciones
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

    public function insertar(tram_personas_exoneraciones $obj)
    {
        $sql = "";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(tram_personas_exoneraciones $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}
