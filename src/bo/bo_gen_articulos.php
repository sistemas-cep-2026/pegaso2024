<?php
require_once dirname(__DIR__) . '/dao/dao_gen_articulos.php';
class bo_gen_articulos
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_gen_articulos();
    }

    public function control(gen_articulos $obj, $opc)
    {
        switch ($opc) {
            case "I":
                return $this->dao->insertar($obj);
                break;
            case "U":
                return $this->dao->modificar($obj);
                break;
            case "E":
                return $this->dao->eliminar($obj);/*eliminar de la tabla user*/
                break;
        }
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function listar(?gen_articulos $obj = null)
    {
        $sql = "SELECT  c_articulo, RTRIM(nombre) AS nombre_concepto
        FROM gen_articulos
        WHERE flag_activo = 'A'
        AND cod_tipo = 'CU'
        AND nombre LIKE '%{$obj->getNombre()}%'
        ORDER BY nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarUsuarios(?gen_articulos $obj = null)
    {
        $sql = "SELECT  a.c_articulo, RTRIM(a.nombre) AS nombre_concepto
FROM gen_articulos a
WHERE a.flag_activo = 'A'
  AND a.cod_tipo = 'CU'
  AND a.nombre LIKE '%{$obj->getNombre()}%'
  AND NOT EXISTS (
      SELECT 1 
      FROM gen_articulos_usuario u
      WHERE u.c_articulo = a.c_articulo
        AND u.c_usuario = '{$obj->getC_usuario()}'
  )
ORDER BY a.nombre";
        return $this->dao->consulta($sql);
    }


    public function ConceptoUsuario(?gen_articulos $obj = null)
    {
        $sql = "select c.c_articulo, RTRIM(c.nombre) as nombre_articulo
            from gen_articulos_usuario u inner join gen_articulos c
            on u.c_articulo=c.c_articulo
            where u.c_usuario='{$obj->getC_usuario()}' and flag='&'
            AND nombre LIKE '%{$obj->getNombre()}%'
            order by nombre";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function ListarConcetosCaja(?gen_articulos $obj = null)
    {
        $sql = "select a.c_articulo, 
            LTRIM(RTRIM(a.nombre)) AS nombre_concepto
            FROM gen_articulos a iNNER JOIN gen_articulos_usuario u 
            ON a.c_articulo = u.c_articulo
            WHERE u.c_usuario = '{$obj->getC_usuario()}'
            ORDER BY nombre_concepto ASC";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarSelect(?gen_articulos $obj = null)
    {
        $sql = "select a.c_articulo, 
        rtrim(a.nombre) as nombre, 
        CAST(l.stock_actual AS INT) AS stock_actual,a.unidad
        from dbo.gen_articulos_local l LEFT join dbo.gen_articulos a
        on l.c_articulo=a.c_articulo
        where l.c_local='" . $obj->getC_local() . "' 
        and a.nombre like '%" . $obj->getNombre() . "%' 
        and l.flag='A'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
    public function listarid(?gen_articulos $obj = null)
    {
        $sql = "select a.c_articulo,
        a.unidad,
        a.nombre nombre_articulo,
        a.c_familia,
        a.c_sub_familia,
        f.nombre familia_nombre,
        sf.nombre sub_familia_nombre ,al.stock_actual saldo
        from gen_articulos a
        left join gen_articulos_familias f 
        on f.c_familia=a.c_familia
        left join gen_articulos_sub_familias sf 
        on sf.c_sub_familia=a.c_sub_familia 
        and f.c_familia=a.c_familia
        inner join gen_articulos_local al on al.c_articulo=a.c_articulo and al.c_local='" . $obj->getC_local() . "'
        where a.c_articulo='" . $obj->getC_articulo() . "' ";
      // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarSelect_caja(?gen_articulos $obj = null)
    {
        $sql = "select a.c_articulo, 
        rtrim(a.nombre) as nombre 
        from dbo.articulos a
        where   a.c_articulo like '%" . $obj->getC_articulo() . "%' 
        ";
        //echo $sql;
        return $this->dao->consulta($sql);
    }
}
