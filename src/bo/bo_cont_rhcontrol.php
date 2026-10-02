<?php
require_once dirname(__DIR__) . '/dao/dao_cont_rhcontrol.php';
class bo_cont_rhcontrol
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cont_rhcontrol();
    }

    /*public function control(cont_asistencia $obj, $opc)
    {
        switch($opc){
            case "I":
            return $this->dao->insertar($obj);
            break;
            case "U":
            return $this->dao->modificar($obj);
            break;
            case "A":
            return $this->dao->anular($obj);
            break;
        }
    }*/

    public function errores()
    {
        return $this->dao->errores();
    }
 public function preparar($cc_local, $anho, $periodo)
    {
                        $sql = " exec sp_v1_cont_rh_control '" . $cc_local . "','" . $anho . "','" . $periodo . "';";
                return $this->dao->consulta($sql);
            }
    public function listar()
    {
              $sql = " SELECT numero,cod_documento,num_documento,c_persona,ruc,
              nombre,dbo.fc_fecha_from(fecha_documento) fecha_documento,dbo.fc_fecha_from(fecha_pago) fecha_pago,total,retencion,osb
              from cont_rh_control";
                        return $this->dao->consulta($sql);
            }

 
    }
