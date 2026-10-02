<?php
require_once(u_src() . "entidad/gen_personas.php");
require_once(u_src() . "dao/_conexa_.php");
class dao_gen_personas_pagos extends gen_personas
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

    public function deuda_c_persona(gen_personas $obj)
    {
        // $sql = "select deuda from vista_colegiados_deuda where c_persona='".$c_persona."'
        $sql = "exec sp_estado_habilidad '{$obj->getCc_persona()}'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
