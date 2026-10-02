<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas_exoneraciones.php';
class bo_gen_personas_exoneraciones
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas_exoneraciones();
    }

    public function control(gen_personas_exoneraciones $obj, $opc)
    {
        switch($opc){
        case "I":
            return $this->dao->insertar($obj);
        case "U":
            return $this->dao->modificar($obj);
        case "E":
            return $this->dao->eliminar($obj);
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listarID(gen_personas_exoneraciones $obj)
	{
		$sql = "SELECT cc_exoneracion,c_persona,linea,(select pais.PAIS_NOM from pais where pais.PAIS_COD=personas_exoneraciones.pais) as n_pais,pais,
                dbo.fc_v1_parametro_valor('personas_exoneraciones','motivo',motivo) as motivo_text,
                motivo,empresa_nombre,nombre_inst,funcion_laboral,DBO.fc_fecha_Texto(fecha) as fecha,mes_salida,
				year_salida,mes_retorno,year_retorno,usuario,sustento,flag_no_retorno 
				from personas_exoneraciones(NOLOCK)  
				WHERE personas_exoneraciones.cc_exoneracion = '{$obj->getCc_exoneracion()}'";
		//echo $sql;
		return  $this->dao->consulta($sql);
	}

    public function listarIDXPersona(gen_personas_exoneraciones $obj)
    {
        $sql = "SELECT cc_exoneracion,c_persona,linea,(select pais.PAIS_NOM from pais where pais.PAIS_COD=personas_exoneraciones.pais) as n_pais,pais,
                dbo.fc_v1_parametro_valor('personas_exoneraciones','motivo',motivo) as motivo_text,
                motivo,empresa_nombre,nombre_inst,funcion_laboral,DBO.fc_fecha_Texto(fecha) as fecha,mes_salida,
				year_salida,mes_retorno,year_retorno,usuario,sustento,flag_no_retorno 
				from personas_exoneraciones(NOLOCK)  
				WHERE personas_exoneraciones.c_persona = '{$obj->getC_persona()}' 
				ORDER BY personas_exoneraciones.cc_exoneracion desc";
        return $this->dao->consulta($sql);
    }

}