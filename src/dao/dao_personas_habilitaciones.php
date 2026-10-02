<?php
require_once dirname(__DIR__) . '/entidad/personas_habilitaciones.php';
require_once __DIR__ . '/_conexa_.php';
class dao_personas_habilitaciones
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

    public function insertar(personas_habilitaciones $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(personas_habilitaciones $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(personas_habilitaciones $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}