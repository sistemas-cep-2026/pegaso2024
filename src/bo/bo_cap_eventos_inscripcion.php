<?php
require_once dirname(__DIR__) . '/dao/dao_cap_eventos_inscripcion.php';
class bo_cap_eventos_inscripcion
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_cap_eventos_inscripcion();
    }

    public function Descaga_voucher_nube(cap_eventos_inscripcion $obj)
    {
        return $this->dao->Descaga_voucher_nube($obj);
    }


    public function control(cap_eventos_inscripcion $obj, $opc)
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

    public function listarRecaudoBCP(?cap_eventos_inscripcion $obj = null)
    {
        $sql = "select p.c_persona, p.c_cmp, p.num_documento, 
            RTRIM(p.nombre) as nombre_completo,
            p.c_local,
             p.email1, 
             p.celular1,
            CONVERT(VARCHAR(10), CONVERT(DATE, b.fecha, 112), 103) fecha,
            b.numero_operacion, 
            b.total_distribuir
            from bcp_proceso_detalle b LEFT join personas p
            on isnumeric(p.num_documento)=1 and cast(rtrim(p.num_documento) as real)=cast(b.codigo_depositante as real)
            where substring(b.dato_adicional,1,1)  in ('T') 
            and RIGHT(b.dato_adicional, 3)='{$obj->getCc_evento()}'
            order by p.nombre";
        // echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarParticipante(?cap_eventos_inscripcion $obj = null)
    {
        $sql = "select p.c_persona,
        p.c_cmp,
        dbo.fc_fecha_texto(i.fech_crea) as fecha,
        rtrim(p.nombre) as nombre_completo,
        i.celular,
        i.correo,
        i.cc_evento,
        i.codigo,
        rtrim(p.num_documento) as num_documento,
        CONVERT(VARCHAR(10), i.fecha_voucher, 103) AS fecha_voucher,
        i.n_operacion_voucher,
        i.monto,
        CAST(i.cc_evento AS VARCHAR(10)) + '-' + CAST(rtrim(p.num_documento) AS VARCHAR(20)) + '.jpg' AS img_foto
        from cap_eventos_inscripcion i inner join personas p
        on i.c_persona=p.c_persona
        where i.cc_evento='{$obj->getCc_evento()}'";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    public function listarID(cap_eventos_inscripcion $obj = null)
    {
        $sql = "";
        return $this->dao->consulta($sql);
    }
}
