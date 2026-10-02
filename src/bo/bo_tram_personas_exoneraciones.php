<?php
require_once dirname(__DIR__) . '/dao/dao_tram_personas_exoneraciones.php';
class bo_tram_personas_exoneraciones
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_personas_exoneraciones();
    }

    public function control(tram_personas_exoneraciones $obj, $opc)
    {
        switch($opc){
            case "I":
            return $this->dao->insertar($obj);
            break;
            case "U":
            return $this->dao->modificar($obj);
            break;
            case "E":
            return $this->dao->eliminar($obj);
            break;
            case "A":
            return $this->dao->anular($obj);
            break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function max_numero(){
        $sql="";
        return $this->dao->consulta($sql);
    }

    public function listar(tram_personas_exoneraciones $obj = null)
    {
        $sql = "";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function exoneradoPersona($c_persona)
    {
        $sql = "select 
        pe.cc_exoneracion,
        pe.c_persona,
        pe.linea,
        p.nombre AS pais_text,
        pe.pais,
        pe.motivo,
        CASE 
        WHEN pe.motivo = 1 THEN 'PERSONAL'
        WHEN pe.motivo = 2 THEN 'TRABAJO'
        WHEN pe.motivo = 3 THEN 'ESTUDOS'
        ELSE 'OTRO'
        END AS motivo_text,
        pe.empresa_nombre,
        pe.nombre_inst,
        pe.funcion_laboral,
        DBO.fc_fecha_Texto(pe.fecha) AS fecha,
        pe.mes_salida+'/'+cast(pe.year_salida as char(4)) as desde,
        pe.mes_retorno+'/'+cast(pe.year_retorno as char(4)) as hasta,
        pe.usuario,
        pe.sustento,
        pe.flag_no_retorno
        FROM 
        personas_exoneraciones AS pe WITH (NOLOCK)
        LEFT JOIN 
        gen_pais AS p ON p.cc_pais = pe.pais
        WHERE 
        pe.c_persona = '".$c_persona."'
        ORDER BY 
        pe.fecha DESC;";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

}