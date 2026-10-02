<?php
require_once dirname(__DIR__) . '/dao/dao_fin_estado_de_cuenta.php';
class bo_fin_estado_de_cuenta
{
  private $dao;

  function __construct()
  {
    $this->dao = new dao_fin_estado_de_cuenta();
  }

  public function control(fin_estado_de_cuenta $obj, $opc)
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

  public function ListarID($cc_persona)
  {
    $sql = "WITH estado_de_cuenta_info AS (
  SELECT
  SUBSTRING(es.num_documento, 8, 4) AS ano,
  SUBSTRING(es.num_documento, 5, 2) AS mes,
  es.monto,
  es.cod_documento,
  es.c_local,
  es.tipo_pago
  FROM estado_de_cuenta es (nolock)
  WHERE es.monto != 0 
  AND es.cod_documento = '99'
  AND es.c_persona = '" . $cc_persona . "'
)
SELECT
ano,
SUM(CASE WHEN mes = '01' AND monto >= 0 THEN monto ELSE 0.00 END) AS c1,
(SUM(CASE WHEN mes = '01' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m1,
MAX(CASE WHEN mes = '01' AND monto < 0 THEN c_local ELSE '' END) AS aportoen1,
MAX(CASE WHEN mes = '01' AND monto < 0 THEN tipo_pago ELSE '' END) AS p1,

SUM(CASE WHEN mes = '02' AND monto >= 0 THEN monto ELSE 0.00 END) AS c2,
(SUM(CASE WHEN mes = '02' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m2,
MAX(CASE WHEN mes = '02' AND monto < 0 THEN c_local ELSE '' END) AS aportoen2,
MAX(CASE WHEN mes = '02' AND monto < 0 THEN tipo_pago ELSE '' END) AS p2,

SUM(CASE WHEN mes = '03' AND monto >= 0 THEN monto ELSE 0.00 END) AS c3,
(SUM(CASE WHEN mes = '03' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m3,
MAX(CASE WHEN mes = '03' AND monto < 0 THEN c_local ELSE '' END) AS aportoen3,
MAX(CASE WHEN mes = '03' AND monto < 0 THEN tipo_pago ELSE '' END) AS p3,

SUM(CASE WHEN mes = '04' AND monto >= 0 THEN monto ELSE 0.00 END) AS c4,
(SUM(CASE WHEN mes = '04' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m4,
MAX(CASE WHEN mes = '04' AND monto < 0 THEN c_local ELSE '' END) AS aportoen4,
MAX(CASE WHEN mes = '04' AND monto < 0 THEN tipo_pago ELSE '' END) AS p4,

SUM(CASE WHEN mes = '05' AND monto >= 0 THEN monto ELSE 0.00 END) AS c5,
(SUM(CASE WHEN mes = '05' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m5,
MAX(CASE WHEN mes = '05' AND monto < 0 THEN c_local ELSE '' END) AS aportoen5,
MAX(CASE WHEN mes = '05' AND monto < 0 THEN tipo_pago ELSE '' END) AS p5,

SUM(CASE WHEN mes = '06' AND monto >= 0 THEN monto ELSE 0.00 END) AS c6,
(SUM(CASE WHEN mes = '06' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m6,
MAX(CASE WHEN mes = '06' AND monto < 0 THEN c_local ELSE '' END) AS aportoen6,
MAX(CASE WHEN mes = '06' AND monto < 0 THEN tipo_pago ELSE '' END) AS p6,

SUM(CASE WHEN mes = '07' AND monto >= 0 THEN monto ELSE 0.00 END) AS c7,
(SUM(CASE WHEN mes = '07' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m7,
MAX(CASE WHEN mes = '07' AND monto < 0 THEN c_local ELSE '' END) AS aportoen7,
MAX(CASE WHEN mes = '07' AND monto < 0 THEN tipo_pago ELSE '' END) AS p7,

SUM(CASE WHEN mes = '08' AND monto >= 0 THEN monto ELSE 0.00 END) AS c8,
(SUM(CASE WHEN mes = '08' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m8,
MAX(CASE WHEN mes = '08' AND monto < 0 THEN c_local ELSE '' END) AS aportoen8,
MAX(CASE WHEN mes = '08' AND monto < 0 THEN tipo_pago ELSE '' END) AS p8,

SUM(CASE WHEN mes = '09' AND monto >= 0 THEN monto ELSE 0.00 END) AS c9,
(SUM(CASE WHEN mes = '09' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m9,
MAX(CASE WHEN mes = '09' AND monto < 0 THEN c_local ELSE '' END) AS aportoen9,
MAX(CASE WHEN mes = '09' AND monto < 0 THEN tipo_pago ELSE '' END) AS p9,

SUM(CASE WHEN mes = '10' AND monto >= 0 THEN monto ELSE 0.00 END) AS c10,
(SUM(CASE WHEN mes = '10' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m10,
MAX(CASE WHEN mes = '10' AND monto < 0 THEN c_local ELSE '' END) AS aportoen10,
MAX(CASE WHEN mes = '10' AND monto < 0 THEN tipo_pago ELSE '' END) AS p10,

SUM(CASE WHEN mes = '11' AND monto >= 0 THEN monto ELSE 0.00 END) AS c11,
(SUM(CASE WHEN mes = '11' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m11,
MAX(CASE WHEN mes = '11' AND monto < 0 THEN c_local ELSE '' END) AS aportoen11,
MAX(CASE WHEN mes = '11' AND monto < 0 THEN tipo_pago ELSE '' END) AS p11,

SUM(CASE WHEN mes = '12' AND monto >= 0 THEN monto ELSE 0.00 END) AS c12,
(SUM(CASE WHEN mes = '12' AND monto < 0 THEN monto ELSE 0.00 END) * -1) AS m12,
MAX(CASE WHEN mes = '12' AND monto < 0 THEN c_local ELSE '' END) AS aportoen12,
MAX(CASE WHEN mes = '12' AND monto < 0 THEN tipo_pago ELSE '' END) AS p12,

MAX(CASE WHEN mes = '12' AND monto >= 0 THEN c_local ELSE '' END) AS debea12,
MAX(CASE WHEN mes = '11' AND monto >= 0 THEN c_local ELSE '' END) AS debea11,
MAX(CASE WHEN mes = '10' AND monto >= 0 THEN c_local ELSE '' END) AS debea10,
MAX(CASE WHEN mes = '09' AND monto >= 0 THEN c_local ELSE '' END) AS debea9,
MAX(CASE WHEN mes = '08' AND monto >= 0 THEN c_local ELSE '' END) AS debea8,
MAX(CASE WHEN mes = '07' AND monto >= 0 THEN c_local ELSE '' END) AS debea7,
MAX(CASE WHEN mes = '06' AND monto >= 0 THEN c_local ELSE '' END) AS debea6,
MAX(CASE WHEN mes = '05' AND monto >= 0 THEN c_local ELSE '' END) AS debea5,
MAX(CASE WHEN mes = '04' AND monto >= 0 THEN c_local ELSE '' END) AS debea4,
MAX(CASE WHEN mes = '03' AND monto >= 0 THEN c_local ELSE '' END) AS debea3,
MAX(CASE WHEN mes = '02' AND monto >= 0 THEN c_local ELSE '' END) AS debea2,
MAX(CASE WHEN mes = '01' AND monto >= 0 THEN c_local ELSE '' END) AS debea1
FROM estado_de_cuenta_info
 GROUP BY ano,c_local
order by ano desc,c_local desc;";
 //   echo $sql;
    return $this->dao->consulta($sql);
  }
  
  public function ListarID_total($cc_persona)
  {
    $sql = " 
WITH estado_de_cuenta_cr AS ( 
SELECT   es.monto, 
es.c_local  FROM estado_de_cuenta es (nolock) WHERE es.monto != 0 AND es.cod_documento = '99' AND es.c_persona = '" . $cc_persona . "' ) 
 

select c_local, sum(case when monto>0 then monto else 0 end) deuda,sum(case when monto<0 then monto else 0 end) abono, SUM(monto) saldo from estado_de_cuenta_cr group by c_local order by c_local;";
 //   echo $sql;
    return $this->dao->consulta($sql);
  }
}
