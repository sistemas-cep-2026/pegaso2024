<?php
require_once dirname(__DIR__) . '/entidad/gen_personas_exoneraciones.php';
require_once __DIR__ . '/_conexa_.php';
class dao_gen_personas_exoneraciones
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

    public function insertar(gen_personas_exoneraciones $obj)
    {
         $sql = "exec sp_v1_web_personas_exoneracion '{$obj->getC_persona()}',
         {$obj->getPais()},'{$obj->getMotivo()}',
         '{$obj->getMes_salida()}',{$obj->getYear_salida()},
         '{$obj->getMes_retorno()}',{$obj->getYear_retorno()},
         '{$obj->getUsuario()}','{$obj->getSustento()}',
         '{$obj->getFlag_no_retorno()}';";
      //  echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_personas_exoneraciones $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_personas_exoneraciones $obj)
    {
        $sql = "update personas_exoneracion set flag='&' where cc_exoneracion='{$obj->getFlag_no_retorno()}'";
        return $this->conecta->sql_query($sql);
    }
}
