<?php
require_once dirname(__DIR__) . '/entidad/gen_personas_discapacidad.php';
require_once(u_src() . "dao/_conexa_.php");
class dao_gen_personas_discapacidad
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

    public function insertar(gen_personas_discapacidad $obj)
    {
        $sql = "INSERT INTO dbo.gen_personas_discapacidad(
        cc_persona,
        cod_tipo,
        obs,
        reg_conadis,
        fecha_registro,
        flag,
        user_crea,
        fecha_crea
        )values(
        '{$obj->getCc_persona()}',
        {$obj->getCod_tipo()},
        '{$obj->getObs()}',
        {$obj->getReg_conadis()},
        '{$obj->getFecha_registro()}',
        '{$obj->getFlag()}',
        '{$obj->getUser_crea()}',
        getdate()
        )";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_personas_discapacidad $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_personas_discapacidad $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }
}
