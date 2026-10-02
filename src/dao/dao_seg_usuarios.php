<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/seg_usuarios.php");

class dao_seg_usuarios
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

    public function consultaParams($sql, $params)
    {
        return $this->conecta->ArrayListaParams($sql, $params);
    }

    public function errores()
    {
        return $this->conecta->errores();
    }

    public function procesar_usuarios(seg_usuarios $obj)
    {
        $sql = "exec sp_v1_Usuarios
        '" . $obj->getCc_persona() . "',
        '" . $obj->getCc_perfil() . "',
        '" . $obj->getCc_local() . "',
        '" . $obj->getTp_user() . "',
        '" . $obj->getUsuario() . "',
        '" . $obj->getClave() . "',
        '" . $obj->getTiempo_sesion() . "',
        '" . $obj->getObs() . "',
        '" . $obj->getUser_crea() . "',
        '" . $obj->getOpc() . "',
        '" . $obj->getC_area() . "'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function insertar(seg_usuarios $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function modificar(seg_usuarios $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function actualizarFoto(seg_usuarios $obj)
    {
        $sql = "UPDATE seg_usuarios
        SET foto = '{$obj->getFoto()}'
        WHERE cc_usuario = {$obj->getCc_usuario()}";
        return $this->conecta->sql_query($sql);
    }

    public function cambiaClave(seg_usuarios $obj)
    {
        //$sql = "UPDATE seg_usuarios        SET clave = pwdencrypt('{$obj->getClave()}'),        cambio='NO'        WHERE usuario = '{$obj->getUsuario()}'        AND cc_usuario = {$obj->getCc_usuario()}";
        $sql = "exec sp_v1_password_user '{$obj->getClave()}',        '{$obj->getUsuario()}',        '{$obj->getCc_usuario()}'; ";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
