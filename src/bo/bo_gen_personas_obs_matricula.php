<?php
require_once dirname(__DIR__) . '/dao/dao_gen_personas_obs_matricula.php';
class bo_gen_personas_obs_matricula
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_personas_obs_matricula();
    }

    public function control(gen_personas_obs_matricula $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "E":
                return $this->dao->eliminar($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(?gen_personas_obs_matricula $obj = null)
    {
        $sql = "select o.cc_personaobs, 
        p.c_persona, 
        rtrim(p.c_cmp) cep, 
        rtrim(num_documento) dni, 
        rtrim(p.nombre) nombre,
        p.c_local, rtrim(p.Email1) correo, 
        rtrim(celular1) celular,
        dbo.fc_fecha_texto(o.fecha_reportado) fecha_envio,
        o.doc_envio_tipo, 
        o.doc_envio_numero,
        o.respuesta,
        o.fecha_respuesta,
        dbo.fc_fecha_texto(o.fecha_respuesta) fecha_respuesta_text
        from personas p (nolock) inner join personas_obs_matricula o (nolock)
        on p.c_persona=o.c_persona
        where o.reportado='S'
        and p.nombre like '%" . $obj->getNombre() . "%'";
        if (strlen($obj->getCep()) > 0) {
            $sql .= " and p.c_cmp like'%" . $obj->getCep() . "%'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(gen_personas_obs_matricula $obj = null)/*vistas cortas**/
    {
        $sql = "select 
        cc_personaobs, 
        c_persona, 
        fecha, 
        tip_registro, 
        reg_sunedu, 
        universidad, 
        cert_est, 
        cod_observacion, 
        observacion, 
        doc_envio_tipo, 
        doc_envio_numero, 
        respuesta, 
        fecha_respuesta,
        dbo.fc_fecha_from(fecha_respuesta) fecha_respuesta_text,
        absuelto, 
        usuario, 
        flag, 
        reportado, 
        fecha_reportado,
        dbo.fc_fecha_from(fecha_reportado) fecha_reportado_text
        from dbo.personas_obs_matricula
        WHERE cc_personaobs='" . $obj->getCc_personaobs() . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
