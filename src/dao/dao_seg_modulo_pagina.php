<?php
require_once(u_src() . "dao/_conexa_.php");
require_once(u_src() . "entidad/seg_modulo_pagina.php");
class dao_seg_modulo_pagina
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
   public function totalPagina($sql)
   {
      return $this->conecta->sql_total($sql);
   }
   public function insertar(seg_modulo_pagina $obj)
   {
      $sql = "INSERT INTO seg_modulo_pagina(
       cc_modulo,
       cc_pagina,
       )VALUES(
       fc_correlativo('seg_modulo_pagina','',''),
       '" . $obj->getCc_pagina() . "',
    )";
    return $this->conecta->sql_query($sql);
 }
 public function modificar(seg_modulo_pagina $obj)
 {
   $sql = "UPDATE seg_modulo_pagina set 
   cc_pagina='" . $obj->getCc_pagina() . "',
   WHERE cc_modulo='" . $obj->getCc_modulo() . "'";
   return $this->conecta->sql_query($sql);
}
public function eliminar($cc_modulo)
{
   $sql = "DELETE FROM  seg_modulo_pagina
   WHERE cc_modulo='" . $cc_modulo . "'";
   return $this->conecta->sql_query($sql);
}

}
