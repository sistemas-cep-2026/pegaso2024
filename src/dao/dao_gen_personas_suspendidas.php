<?php
require_once dirname(__DIR__) . '/entidad/gen_personas_suspendidas.php';
require_once __DIR__ . '/_conexa_.php';
class dao_gen_personas_suspendidas
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

    public function insertar(gen_personas_suspendidas $obj)
    {
        $sql = "EXEC sp_v1_personas_cep_baja {$obj->getCc_psuspendidas()},
        '{$obj->getC_persona()}',
        '{$obj->getFlag()}',
        '{$obj->getObs()}',
        '{$obj->getUser_crea()}',
        '{$obj->getResol1()}',
        '{$obj->getDesde()}',
        '{$obj->getUrl()}',
        '{$obj->getOpc()}'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_personas_suspendidas $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_personas_suspendidas $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}