<?php
require_once(u_src() . "dao/dao_seg_modulo_pagina.php");
class bo_seg_modulo_pagina
{
   private $dao;
   function __construct()
   {
      $this->dao = new dao_seg_modulo_pagina();
   }
   public function control(seg_modulo_pagina $obj, $opc)
   {
      if ($opc == "I") {
         return $this->dao->insertar($obj);
      } else {
         return $this->dao->modificar($obj);
      }
   }

   public function eliminar($cc_modulo)
   {
      return $this->dao->eliminar($cc_modulo);
   }

   public function listarId($cc_modulo)
   {
      $sql = "SELECT 
      cc_modulo,
      cc_pagina,
      FROM seg_modulo_pagina
      WHERE cc_modulo='" . $cc_modulo . "'";
      return $this->dao->consulta($sql);
   }

   public function listar(seg_modulo_pagina $obj)
   {
      $sql = "SELECT 
      cc_modulo,
      cc_pagina,
      FROM seg_modulo_pagina
      WHERE cc_modulo='" . $obj->getCc_modulo() . "'";
      return $this->dao->consulta($sql);
   }

   public function asignado_pagina($codigo, $sec)
   {
      $sql = "select m.cc_modulo,
      p.cc_pagina, 
      m.mod_carpeta,
      m.mod_carpeta+'js/'+p.ct_js as js,
      m.mod_carpeta+p.ct_url as url,
      m.mod_url,
      m.mod_nombre,
      m.mod_ico,
      (SELECT m2.mod_nombre FROM seg_modulo m2
      WHERE m2.cc_modulo = LEFT(m.cc_modulo,2)+'0000'
      ) AS mod_nombre_principal,
      (CASE WHEN m.mod_vista = 'P' THEN 'Proceso'
      WHEN m.mod_vista = 'R' THEN 'Reporte' ELSE 'Dashboard' END
      ) AS mod_vista_text
      FROM seg_modulo m INNER JOIN seg_modulo_pagina mp 
      ON m.cc_modulo=mp.cc_modulo
      INNER JOIN seg_pagina p
      ON p.cc_pagina=mp.cc_pagina
      WHERE m.cc_modulo='" . $codigo . "'
      AND p.cc_pagina='" . $sec . "'";
     // echo $sql;
      return $this->dao->consulta($sql);
   }
   public function asignado_pagina_dashboard($cc_modulo)
   {
      $sql = "select m.cc_modulo,
      m.mod_nombre,
      m.mod_carpeta
      FROM seg_modulo m
      WHERE m.cc_modulo='" . $cc_modulo . "'
      AND mod_vista = 'M'";
      //echo $sql;
      return $this->dao->consulta($sql);
   }

   /*****************Fin*******/
}
