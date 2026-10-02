<?php
require_once dirname(__DIR__) . '/entidad/gen_articulos.php';
require_once __DIR__ . '/_conexa_.php';
class dao_gen_articulos
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

    public function insertar(gen_articulos $obj)
    {
        $sql = "insert into gen_articulos_usuario(c_usuario, 
        c_articulo,
        flag
        )values(
        '{$obj->getC_usuario()}',
       '{$obj->getC_articulo()}',
       '&'
        )";
        // echo $sql;
        return $this->conecta->sql_query($sql);
    }

    public function modificar(gen_articulos $obj)
    {
        $sql = "";
        return $this->conecta->sql_query($sql);
    }

    public function eliminar(gen_articulos $obj)/*tabla gen_articulos_usuario*/
    {
        $sql = "delete from gen_articulos_usuario 
        where c_articulo='{$obj->getC_articulo()}'
        and c_usuario='{$obj->getC_usuario()}'";
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
}
