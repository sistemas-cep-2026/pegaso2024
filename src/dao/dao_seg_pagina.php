<?php
require_once(u_src()."dao/_conexa_.php");
require_once(u_src()."entidad/seg_pagina.php");

class dao_seg_pagina {
    private $conecta;
    public function __construct(){
        $this->conecta = new Conecta(); 
    }
    public function consulta($sql){
        return $this->conecta->ArrayLista($sql);
    }
    public function total_pagina(){
      return $this->conecta->total_pagina();
  }
  public function insertar(seg_pagina $obj){
    $sql="";
    return $this->conecta->sql_query($sql);
}
public function modificar(seg_pagina $obj ){

    $sql = "";			
    return $this->conecta->sql_query($sql);
}

}
?>