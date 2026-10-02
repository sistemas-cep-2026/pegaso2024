<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/seg_modulo.php");

class dao_seg_modulo
{
    private $conecta;
    public function __construct()
    {
        $this->conecta = new Conecta();
    }
    public function consulta($sql)
    {
        return $this->conecta->ArrayLista($sql);
    }

    public function lista_tablas()
    {
        return $this->conecta->lista_tablas();
    }
    
    public function lista_campo($tabla)
    {
        return $this->conecta->lista_campo($tabla);
    }

    
}
