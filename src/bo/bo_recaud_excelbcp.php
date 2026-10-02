<?php
require_once dirname(__DIR__) . '/dao/dao_recaud_excelbcp.php';
class bo_recaud_excelbcp
{
    private $dao;

    function __construct()
    {
        $this->dao = new dao_recaud_excelbcp();
    }

    public function errores()
    {
        return $this->dao->errores();
    }

    public function subirRecaudadorabcp(recaud_excelbcp $obj)
    {
        return $this->dao->subirRecaudadorabcp($obj);
    }

    public function procesarRecaudadorabcp(recaud_excelbcp $obj)
    {
        return $this->dao->procesarRecaudadorabcp($obj);
    }

    public function ultimaActualizacion()
    {
        // bcp_proceso_detalle es tabla permanente (la usan otros módulos), no necesita blindaje
        $sql = "select dbo.fc_v1_fecha_hora(max(fecha_id)) as ultimo 
    from bcp_proceso_detalle";
        return $this->dao->consulta($sql);
    }
    public function Recaudadora_Excelbcp()
    {
        // recaud_excelbcp es tabla transitoria (carga cruda del archivo, se limpia/recrea
        // en cada ciclo), igual que recaud_excelbbva. Se verifica antes de consultarla
        // para no provocar un error SQL fatal si no existe en este momento.
        $sql = "IF OBJECT_ID('dbo.recaud_excelbcp', 'U') IS NOT NULL
            select codigo_depositante,
            dato_adicional,
            fecha,
            fecha_vencimiento,
            monto,
            mora,
            total,
            sucursal,
            numero_operacion,
            referencia,
            terminal,
            medio,
            hora,
            cheque,
            codigo_banco,
            cargo,
            extorno,
            documento_pago,
            operacion_db,
            operacion_canal
            FROM recaud_excelbcp(nolock)
            order by fecha,hora";
        //echo $sql;
        return $this->dao->consulta($sql);
    }

    /**
     * Dashboard — montos ya procesados/distribuidos (BCP_proceso_detalle, tabla permanente).
     * OJO 1: 'fecha' aquí NO es un tipo fecha nativo, es texto de 8 caracteres sin
     * separadores (se carga como substr($linea, 57, 8) en recau_bcp_update.php).
     * Se asume formato AAAAMMDD y se filtra/agrupa como texto en vez de usar
     * YEAR()/MONTH(), que fallan al intentar convertir el string a fecha.
     * OJO 2: según la estructura real de la tabla, existen dos columnas de monto
     * distinto uso: 'nacional' (la parte que corresponde al Consejo Nacional,
     * de TODAS las transacciones del sistema) y 'region' (la parte que
     * corresponde a un consejo regional puntual, solo de sus propias filas).
     * Vista Consejo Nacional (c_local vacío o '28'): SUM(nacional), sin filtrar por c_local.
     * Vista de un consejo regional específico: SUM(region) WHERE c_local = ese consejo.
     */


    public function downloadTodo()
    {
        //$sql="exec SP_BCP_archivo_recaudo_SUBIDA_202309;";
        return $this->dao->consulta($sql);
    }
}
