<?php
require_once dirname(__DIR__) . '/entidad/recaud_excelbbva.php';
require_once __DIR__ . '/_conexa_.php';
class dao_recaud_excelbbva
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

    public function subirRecaudadorabbva(recaud_excelbbva $obj)
    {
        $sql = "insert into recaud_excelbbva(nombre, REFERENCIA1, REFERENCIA2, IMPORTE1, NUM_MOVIMIENTO, fecha_pago,hora) VALUES (
			'" . $obj->getNombre() . "',
			'" . $obj->getCodigo() . "',
			'" . $obj->getObs() . "',
			'" . $obj->getImp1() . "',
	 
			'" . $obj->getMov() . "',
			'" . $obj->getFecha_pago() . "' ,
			'" . $obj->getHora() . "' )";


             /*$sql = "insert into recaud_excelbbva(nombre, 
			codigo, 
			obs, 
			imp1, 
			imp2, 
			oficina, 
			mov, 
			fecha_pago, 
			fecha_proceso, 
			forma_pago, 
			canal
			) VALUES (
			'" . $obj->getNombre() . "',
			'" . $obj->getCodigo() . "',
			'" . $obj->getObs() . "',
			'" . $obj->getImp1() . "',
			'" . $obj->getImp2() . "',
			'" . $obj->getOficina() . "',
			'" . $obj->getMov() . "',
			'" . $obj->getFecha_pago() . "',
			'" . $obj->getFecha_proceso() . "',
			'" . $obj->getForma_pago() . "',
			'" . $obj->getCanal() . "')";*/
        //echo $sql;
        return $this->conecta->sql_query($sql);
    }
    public function procesarRecaudadoraBBVA(recaud_excelbbva $obj)
    {
      
	//	$sql = "exec sp_v1_proceso_recaudadora_BBVA";
	//	$sql = "exec sp_v1_proceso_recaudadora_BBVA";
		$sql = "insert sp_ejecutar_procesos (fecha,flag,proceso) VALUES (GETDATE(),'&','RE')";

        return $this->conecta->sql_query($sql);
    }
}
