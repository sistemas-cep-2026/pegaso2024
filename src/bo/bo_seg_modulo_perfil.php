<?php
require_once(u_src() . "dao/dao_seg_modulo_perfil.php");
class bo_seg_modulo_perfil
{
    private $dao;
    function __construct()
    {
        $this->dao = new dao_seg_modulo_perfil();
    }
    public function errores()
    {
        return $this->dao->errores();
    }
    public function control(seg_modulo_perfil $obj)
    {
        return $this->dao->insertar($obj);
    }

    public function eliminar($cc_modulo)
    {
        return $this->dao->eliminar($cc_modulo);
    }


    public function asignado_modulo($cc_modulo, $cc_perfil)
    {
        /**ok admin*/
        $sql = "select 
        p.cc_perfil,
        m.mod_nombre, 
        m.mod_nivel, 
        m.mod_carpeta,
        mod_carpeta+'js/'+mod_js AS js,
        mod_carpeta+mod_url AS url,
        m.mod_url, 
        m.mod_ico, 
        m.mod_js, 
        m.mod_estado, 
        m.mod_orden,
        m.mod_ico,
        m.mod_vista,
        m.cc_modulo,
        (SELECT m2.mod_nombre FROM seg_modulo m2 
        WHERE m2.cc_modulo = LEFT(m.cc_modulo,2)+'0000'
        ) AS mod_nombre_principal,
        (CASE WHEN m.mod_vista = 'P' THEN 'Proceso' 
        WHEN m.mod_vista = 'R' THEN 'Reporte' ELSE 'Dashboard' END
        ) AS mod_vista_text
        FROM seg_modulo m
        INNER JOIN seg_modulo_perfil p ON p.cc_modulo= m.cc_modulo
        WHERE m.mod_vista IN('P','R') 
        AND m.cc_modulo ='" . $cc_modulo . "' 
        AND p.cc_perfil = '" . $cc_perfil . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }


    public function modulo($cc_perfil)
    {  /**ok admin*/
        $sql = "select m.cc_modulo,
        m.mod_orden,
        SUBSTRING(cast(p.cc_modulo as varchar(6)),1,2) AS mod_id1,
        m.mod_nivel,
        m.mod_nombre, 
        m.mod_ico
        from seg_modulo m inner join seg_modulo_perfil p
        ON SUBSTRING(cast(m.cc_modulo as varchar(6)),1,2)=SUBSTRING(cast(p.cc_modulo as varchar(6)),1,2)
        WHERE p.cc_perfil='" . $cc_perfil . "' 
        AND m.mod_nivel='1'
        and m.mod_estado='1' 
        and m.mod_vista='M'
        GROUP BY m.cc_modulo,
        m.mod_orden,SUBSTRING(cast(p.cc_modulo as varchar(6)),1,2), m.mod_nivel,m.mod_nombre, m.mod_ico
        ORDER BY m.mod_orden ASC, m.mod_nombre";
        //echo $sql;

        return $this->dao->consulta($sql);
    }

    public function menu($cc_perfil, $cc_modulo, $mod_vista)
    {/**ok*/
        $sql = "select m.cc_modulo,
        m.mod_nivel,    
        mod_carpeta+'js/'+mod_js AS js,
        mod_carpeta+mod_url AS url,
        m.mod_nombre,
        m.mod_orden,
        m.mod_ico
        from seg_modulo_perfil p INNER JOIN seg_modulo m
        on p.cc_modulo=m.cc_modulo
        where p.cc_perfil='" . $cc_perfil . "' 
        and m.mod_estado='1'
        AND LEFT(m.cc_modulo,3)='" . $cc_modulo . "'
        and m.mod_vista='" . $mod_vista . "'
        ORDER BY m.mod_orden ASC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }






    /************************************fin***************************/

    public function moduloId($cc_modulo)
    {
        $sql = "select concat(rtrim(mod_id1),'',rtrim(mod_id2),'',rtrim(mod_id3)) AS cc_modulo,
        mod_ico,
        mod_nombre
        FROM seg_modulo
        WHERE mod_id1=SUBSTRING('" . $cc_modulo . "',1,2)
        AND mod_id2='00'
        AND mod_id3='00'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }






    public function listar_modulo1_perfil($cc_perfil)
    {
        $sql = "select m.mod_orden,
        SUBSTRING(CAST(p.cc_modulo AS VARCHAR), 1, 2) AS mod_id1,
        m.mod_nivel,
        m.mod_nombre, 
        m.mod_ico
        from seg_modulo m inner join seg_modulo_rol p
        ON rtrim(m.mod_id1)=SUBSTRING(CAST(p.cc_modulo AS VARCHAR), 1, 2)
        WHERE p.cc_perfil='" . $cc_perfil . "' 
        AND m.mod_nivel='1'
        and m.mod_estado='1' 
        GROUP BY m.mod_orden,SUBSTRING(CAST(p.cc_modulo AS VARCHAR), 1, 2), m.mod_nivel,m.mod_nombre, m.mod_ico
        ORDER BY m.mod_orden ASC, m.mod_nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listar_modulo2_usuario($cc_rol, $mod_id1)
    {

        $sql = "select 
        RTRIM(m.mod_id1) AS mod_id1,
        RTRIM(m.mod_id2) AS mod_id2,
        m.mod_nivel,
        m.mod_nombre,
        m.MOD_ORDEN
        from seg_modulo_rol p INNER JOIN seg_modulo m
        on SUBSTRING(p.cc_modulo,1,4)=concat(m.mod_id1,'',m.mod_id2)
        where p.cc_rol='" . $cc_rol . "' 
        and m.mod_estado='1'
        AND m.mod_nivel='2'
        AND m.mod_id1='" . $mod_id1 . "'
        GROUP BY
        RTRIM(m.mod_id1),
        RTRIM(m.mod_id2),
        m.mod_orden,
        m.mod_nivel,
        m.mod_nombre
        ORDER BY m.mod_orden ASC";
        return $this->dao->consulta($sql);
    }
    public function listar_modulo3_usuario($cc_rol, $mod_id1, $mod_id2)
    {

        $sql = "select concat(rtrim(m.mod_id1),'',rtrim(m.mod_id2),'',rtrim(m.mod_id3)) AS cc_modulo,
        m.mod_nivel,    
        rtrim(m.mod_id3) as mod_id3,
        m.mod_nombre,
        m.mod_orden
        from seg_modulo_rol p INNER JOIN seg_modulo m
        on p.cc_modulo=concat(m.mod_id1,'',m.mod_id2,'',m.mod_id3)
        where p.cc_rol='" . $cc_rol . "' 
        and m.mod_estado='1'
        AND m.mod_nivel='3'
        AND m.mod_id1='" . $mod_id1 . "'
        AND m.mod_id2='" . $mod_id2 . "'
        and m.mod_vista='priv'
        ORDER BY m.mod_orden ASC, m.mod_nombre";

        return $this->dao->consulta($sql);
    }

    public function modulo_publico($tipo)
    {
        $sql = "select concat(mod_id1,'',mod_id2,'',mod_id3) as cc_modulo,
        mod_nombre, 
        mod_nivel, 
        mod_carpeta, 
        mod_url, 
        mod_ico, 
        mod_js, 
        mod_estado, 
        mod_orden, 
        mod_ico, 
        mod_vista, 
        mod_vista_user
        from seg_modulo m

        WHERE m.mod_nivel='3'
        and m.mod_estado='1' 
        and m.mod_vista='publ'
        and mod_vista_user='" . $tipo . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarId($cc_modulo)
    {
        $sql = "select 
        cc_modulo,
        cc_rol,
        cc_usuario_audit,
        df_log,
        ct_ip
        FROM seg_modulo_rol
        WHERE cc_modulo='" . $cc_modulo . "'";
        return $this->dao->consulta($sql);
    }

    public function listar(seg_modulo_rol $obj)
    {
        $sql = "select 
        cc_modulo,
        cc_rol,
        cc_usuario_audit,
        df_log,
        ct_ip
        FROM seg_modulo_rol
        WHERE cc_modulo='" . $obj->getCc_modulo() . "'";
        return $this->dao->consulta($sql);
    }

    public function listarIdPerfil($cc_rol)
    {
        $sql = "select 
        cc_modulo,
        SUBSTRING(cc_modulo, 1,2) as mod_id1,
        SUBSTRING(cc_modulo, 3,2) as mod_id2,
        SUBSTRING(cc_modulo, 5,2) as mod_id3,
        cc_rol,
        cc_usuario_audit,
        df_log,
        ct_ip
        FROM seg_modulo_rol
        WHERE cc_rol='" . $cc_rol . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

}
