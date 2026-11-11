<?php
// require_once dirname(__DIR__) . '/entidad/cont_asistencia.php';
require_once __DIR__ . '/_conexa_.php';
class dao_contabilidad_centralizar
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

    public function errores()
    {
        return $this->conecta->errores();
    }


    public function procesarCompras($cc_local, $anho, $periodo)
    {
        // Escapar valores al utilizar la interfaz SQL existente (ArrayLista).
        $local = str_replace("'", "''", $cc_local);
        $anho = (int) $anho;
        $periodo = (int) $periodo;
        //$sql = "EXEC sp_centralizar_compras @cc_local = '" . $local . "', @anho = " . $anho . ", @periodo = " . $periodo;
        $sql="exec sp_centralizar_web '".$local."','".$anho."','".$periodo."','C'";
        $resultado = $this->conecta->ArrayLista($sql);
        if ($resultado === false) {
            throw new RuntimeException('No se pudo ejecutar el procedimiento almacenado.');
        }
        return $resultado;
    }

   public function procesarBancos($cc_local, $anho, $periodo)
    {

        $local = str_replace("'", "''", $cc_local);
        $anho = (int) $anho;
        $periodo = (int) $periodo;
      
        $sql="exec sp_centralizar_web '".$local."','".$anho."','".$periodo."','B'";
        echo $sql;
        $resultado = $this->conecta->ArrayLista($sql);
        if ($resultado === false) {
            throw new RuntimeException('No se pudo ejecutar el procedimiento almacenado.');
        }
        return $resultado;
    }

   public function procesarCaja($cc_local, $anho, $periodo)
    {

        $local = str_replace("'", "''", $cc_local);
        $anho = (int) $anho;
        $periodo = (int) $periodo;
   
        $sql="exec sp_centralizar_web '".$local."','".$anho."','".$periodo."','T'";
        $resultado = $this->conecta->ArrayLista($sql);
        if ($resultado === false) {
            throw new RuntimeException('No se pudo ejecutar el procedimiento almacenado.');
        }
        return $resultado;
    }

   public function procesarPlanilla728($cc_local, $anho, $periodo)
    {

        $local = str_replace("'", "''", $cc_local);
        $anho = (int) $anho;
        $periodo = (int) $periodo;
  
        $sql="exec sp_centralizar_web '".$local."','".$anho."','".$periodo."','P'";
        $resultado = $this->conecta->ArrayLista($sql);
        if ($resultado === false) {
            throw new RuntimeException('No se pudo ejecutar el procedimiento almacenado.');
        }
        return $resultado;
    }

}