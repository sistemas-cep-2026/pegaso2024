<?php
require_once dirname(__DIR__) . '/entidad/tram_personas_especialidad.php';
require_once __DIR__ . '/_conexa_.php';
class dao_tram_personas_especialidad
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

    public function insertar(tram_personas_especialidad $obj){
         $sql="exec sp_v1_web_personas_especialidad '".
                 $obj->getOpc()."','".
                 $obj->getCc_reg_esp()."','".
                 $obj->getTipo_especialidad()."','".
                 $obj->getCc_persona()."','".
                 $obj->getCc_universidad()."','".
                 // $obj->getCc_especialidad()."','".
                 $obj->getFecha()."','".
                 $obj->getC_local()."','".
                 $obj->getFlag_escolarizado()."','".
                 $obj->getFecha_diploma()."','".
                 $obj->getLiteral()."','".
                 $obj->getResidentado()."',
                 '".s_usuario()."',
                 '".$obj->getSemipresencial()."',
                 '".$obj->getLinea()."',
                 '".$obj->getId_recaudo_bbva()."',
                 '".$obj->getBanco()."',
                 '".$obj->getOperacion()."',
                 '".$obj->getFecha_op()."',
                 ".$obj->getMonto().",
                 '".$obj->getFlag_regularizado()."',
                 '".$obj->getObs()."';";
        //echo $sql;
        return $this->conecta->sql_query($sql);
	}

    public function modificar(tram_honorabilidad $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

}
