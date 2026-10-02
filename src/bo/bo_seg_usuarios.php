<?php
require_once dirname(__DIR__) . '/dao/dao_seg_usuarios.php';
class bo_seg_usuarios
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_seg_usuarios();
    }

    public function control_usuarios(seg_usuarios $obj)
    {
        return $this->dao->procesar_usuarios($obj);
    }


    public function control(seg_usuarios $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "CN":
                return $this->dao->cambiaClave($obj);
                break;
            case "UPLOAD":
                return $this->dao->actualizarFoto($obj);
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function validar($usu_usuario, $usu_clave)
    {
        $data = array();
        $returna = array();
        $sql = "select p.c_persona,
        u.usuario,
        u.tiempo_sesion,
        u.cc_perfil,
        rtrim(u.tp_user) as tp_user,
        u.cc_local,
        rtrim(p.nombre) as nombre_usuario,
        u.flag,
        u.clave as validar
        from seg_usuarios u left join personas p (nolock)
        on u.cc_persona=p.c_persona
        where RTRIM(u.usuario)=rtrim('{$usu_usuario}')
        and u.flag='A'
        AND PWDCOMPARE('{$usu_clave}',u.clave) = 1";

        $data = $this->dao->consultaParams($sql, [$usu_usuario, $usu_clave]);
        if (empty($data)) {
            return $returna[] = "N";
        }
        foreach ($data as $row) {
            if ($row["validar"] == '0') {
                return $returna[] = "N";
            }
            $returna[] = "S";
            $returna[] = $row["c_persona"];
            $returna[] = $row["usuario"];
            $returna[] = $row["tiempo_sesion"];
            $returna[] = $row["cc_perfil"];
            $returna[] = $row["tp_user"];
            $returna[] = $row["cc_local"];
            $returna[] = $row["nombre_usuario"];
            return $returna;
        }
    }

    public function listarId(seg_usuarios $obj)
    {
        $sql = "select u.cc_usuario,
        u.cc_persona,
        rtrim(u.cc_perfil) as cc_perfil,
        u.cc_local,
        u.c_area,
        (select gen_local.nombre from gen_local where gen_local.c_local=u.cc_local) as cc_local_text,
        rtrim(u.tp_user) as tp_user,
        rtrim(u.usuario) as usuario,
        u.tiempo_sesion,
        u.foto, 
        u.obs,
        u.cambio,
        u.user_crea,
        u.fech_crea,
        u.user_mod,
        u.fech_mod,
         dbo.fc_fecha_texto(u.fech_mod) as fech_mod_text,
        u.flag,
        u.fech_bloquea,
        rtrim(p.nombre) as nombre
        from seg_usuarios u inner join personas p (nolock)
        on u.cc_persona=p.c_persona
        WHERE u.usuario='" . $obj->getUsuario() . "'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function ListarUsuarios(seg_usuarios $obj)
    {
        $sql = "select rtrim(u.cc_persona) c_persona,
        rtrim(u.usuario) usuario,
        p.nombre
        from seg_usuarios u inner join personas p (nolock)
        on u.cc_persona=p.c_persona
        where u.cc_local='" . $obj->getCc_local() . "' 
        and u.flag='A' 
        order by p.nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listar(seg_usuarios $obj)
    {
        $sql = "select u.cc_usuario, p.cc_persona,
        dbo.fc_fecha_texto(u.fech_crea) fecha_registro,
        dbo.fc_fecha_texto(u.fech_bloquea) fecha_bloqueo,
        u.cc_local,
        u.usuario,
        p.nombre,
        pr.ct_perfil,
        l.nombre as cc_local_text,
        u.flag,
        dbo.fc_v1_parametro_valor('seg_usuarios','flag',u.flag) as flag_text 
        from seg_usuarios u inner join personas p
        on u.cc_persona=p.c_persona
        inner join seg_perfil pr
        on pr.cc_perfil=u.cc_perfil
        inner join gen_local l
        on l.c_local=u.cc_local
        where p.nombre like '%" . $obj->getNombre() . "%'";
        if (strlen($obj->getUsuario()) > 0) {
            $sql .= " and u.usuario='" . $obj->getUsuario() . "'";
        }
        if (strlen($obj->getCc_local()) > 0) {
            $sql .= " and u.cc_local='" . $obj->getCc_local() . "'";
        }
        if (strlen($obj->getFlag()) > 0) {
            $sql .= " and u.flag='" . $obj->getFlag() . "'";
        }
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarUsuarioPerido($anho, $periodo, $usuario, $c_local)
    {
        $sql = "select tas.usuario,
        su.usuario AS usuario_sistema,
        p.c_persona,
        p.nombre,
        p.apellido_paterno,
        p.apellido_materno,
        tas.fecha_registro
        FROM (
        select *,
        ROW_NUMBER() OVER (PARTITION BY usuario ORDER BY fecha_registro DESC) AS rn
        FROM tram_actividad_sustento
        WHERE YEAR(fecha) = '{$anho}'
        and cc_local='{$c_local}'
        AND MONTH(fecha) = '{$periodo}'";
        if (!empty($usuario)) {
            $sql .= " AND usuario = '{$usuario}'";
        }
        $sql .= ") AS tas
        INNER JOIN seg_usuarios su ON tas.usuario = su.usuario
        INNER JOIN personas p ON su.cc_persona = p.c_persona
        WHERE tas.rn = 1";
        return $this->dao->consulta($sql);
    }

    /**Dashboard*/
    public function Dash_UserLocal()
    {
        $sql = "SELECT 
    l.c_local, 
    l.nombre, 
    COUNT(CASE WHEN u.flag = 'A' THEN 1 END) AS activos,
    COUNT(CASE WHEN u.flag = 'I' THEN 1 END) AS inactivos
    FROM seg_usuarios u
    INNER JOIN gen_local l ON u.cc_local = l.c_local
    WHERE l.c_local IN ('1','2','3','4','5','6','7','8','9','10','11','12',
                        '13','14','15','16','17','18','19','20','21','22','23',
                        '24','15','26','27','28','58')
    GROUP BY l.c_local, l.nombre
    ORDER BY l.c_local";
        return $this->dao->consulta($sql);
    }

    public function existeUsuario($usuario)
    {
        $sql = "SELECT usuario FROM seg_usuarios WHERE usuario = '{$usuario}'";
        return $this->dao->consulta($sql);
    }
}
