<?php
require_once(u_src() . "dao/dao_gen_parametro_det.php");
class bo_gen_parametro_det
{
    private $dao;
    function __construct()
    {
        $this->dao = new dao_gen_parametro_det();
    }
    public function control(gen_parametro_det $obj, $opc)
    {
        if ($opc == "I") {
            return $this->dao->insertar($obj);
        } else {
            return $this->dao->modificar($obj);
        }
    }
    public function eliminar($cc_par_det)
    {
        return $this->dao->eliminar($cc_par_det);
    }

    public function listarId($cc_parametro, $cc_par_det)
    {
        $sql = "SELECT
        cc_par_det,
        cc_parametro,
        cc_codigo,
        ct_par_det,
        ct_par_det_corto,
        nn_orden,
        flag,
        cc_usuario_audit,
        df_log,
        ct_ip
        FROM  gen_parametro_det 															
        WHERE cc_parametro='" . $cc_parametro . "'
        AND cc_par_det='" . $cc_par_det . "'";
        return $this->dao->consulta($sql);
    }
    public function listarParametroDet($cc_tabla, $cc_campo)
    {
        $sql = "SELECT
        p.cc_parametro, 
        p.ct_parametro, 
        RTRIM(pd.cc_codigo) as cc_codigo,
        pd.ct_par_det as detalle, 
        pd.ct_par_det_corto as detalle_corto, 
        pd.flag, 
        pt.cc_tabla, 
        pt.cc_campo
        FROM gen_parametro p,
        gen_parametro_det pd,
        gen_parametro_tabla pt
        WHERE p.cc_parametro=pd.cc_parametro
        AND p.cc_parametro=pt.cc_parametro
        AND pd.cc_parametro=pt.cc_parametro
        AND pd.flag='A'
        AND pt.cc_tabla='" . $cc_tabla . "'
        AND pt.cc_campo='" . $cc_campo . "'
        ORDER BY pd.nn_orden ";
        //echo $sql;

        return  $this->dao->consulta($sql);
    }
}
