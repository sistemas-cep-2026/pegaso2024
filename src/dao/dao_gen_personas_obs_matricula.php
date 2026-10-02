<?php
require_once(u_src()."entidad/gen_personas_obs_matricula.php");
require_once(u_src() . "dao/_conexa_.php");
class dao_gen_personas_obs_matricula
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
  public function modificar(gen_personas_obs_matricula $obj)
    {   
        $sql = "update personas_obs_matricula set 
        fecha_reportado='".$obj->getFecha_reportado()."',
        doc_envio_numero='".$obj->getDoc_envio_numero()."', 
        fecha_respuesta='".$obj->getFecha_respuesta()."', 
        respuesta='".$obj->getRespuesta()."'
        WHERE cc_personaobs='".$obj->getCc_personaobs()."'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }


}