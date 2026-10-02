<?php
require_once dirname(__DIR__) . '/dao/dao_tram_documentos_recaudo.php';
class bo_tram_documentos_recaudo
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_tram_documentos_recaudo();
    }

    public function control(tram_documentos_recaudo $obj, $opc)
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

    public function listar(tram_documentos_recaudo $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarID(tram_documentos_recaudo $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }

    public function listarXExpediente(tram_documentos_recaudo $obj)
    {
        $sql = "SELECT tr.c_expediente, tr.c_persona, dbo.fc_fecha_texto(tr.fecha_registro) fecha_registro, tr.c_usuario_ingreso,
                dbo.fc_fecha_texto(tr.fecha_ingreso) fecha_ingreso, tr.banco, tr.operacion, dbo.fc_fecha_texto(tr.fecha_op) fecha_op,
                tr.monto, tr.cod_tram_recaudo, tr.obs, p.nombre, p.c_cmp, b.id,b.referencia2, dbo.fc_fecha_texto(b.fecha_pago) fecha_pago_rec,
                b.total, b.num_movimiento, tr.id_recaudo_bbva, wt.rcd_concepto
                FROM tram_documentos_recaudo tr (NOLOCK)
                INNER JOIN personas p (NOLOCK) ON p.c_persona = tr.c_persona
                LEFT JOIN bbva_proceso_detalle b (NOLOCK) ON b.id = tr.id_recaudo_bbva
                LEFT JOIN web_tram_otrostramites wt (NOLOCK) ON tr.cod_tram_recaudo = wt.cod_tram_recaudo
                WHERE tr.c_expediente = '{$obj->getC_expediente()}'";
        return $this->dao->consulta($sql);
    }

    public function listarReporteTramitesRecaudo(tram_documentos_recaudo $obj)
    {
        $sql = "SELECT tr.c_expediente, tr.c_persona, dbo.fc_fecha_texto(tr.fecha_registro) fecha_registro, tr.c_usuario_ingreso,
                dbo.fc_fecha_texto(tr.fecha_ingreso) fecha_ingreso, tr.banco, tr.operacion, dbo.fc_fecha_texto(tr.fecha_op) fecha_op, tr.monto, tr.cod_tram_recaudo, tr.obs,
                p.nombre, p.c_cmp,
                b.id,b.referencia2, dbo.fc_fecha_texto(b.fecha_pago) fecha_pago_rec, b.total, b.num_movimiento, tr.id_recaudo_bbva,
                wt.rcd_concepto, wt.cod_tram_recaudo
                FROM tram_documentos_recaudo tr
                INNER JOIN personas p (NOLOCK) ON p.c_persona = tr.c_persona
                LEFT JOIN bbva_proceso_detalle b (NOLOCK) ON b.id = tr.id_recaudo_bbva
                LEFT JOIN web_tram_otrostramites wt (NOLOCK) ON tr.cod_tram_recaudo = wt.cod_tram_recaudo
                WHERE tr.fecha_registro BETWEEN '{$obj->getDesde()}' AND '{$obj->getHasta()}';";
        return $this->dao->consulta($sql);
    }
}
