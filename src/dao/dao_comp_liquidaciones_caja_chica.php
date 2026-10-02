<?php
require_once dirname(__DIR__) . '/entidad/comp_liquidaciones_caja_chica.php';
require_once __DIR__ . '/_conexa_.php';
class dao_comp_liquidaciones_caja_chica
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

    public function procesar(comp_liquidaciones_caja_chica $obj)
    {
        $sql = "exec sp_v1_liquidaciones_caja_chica
        '".$obj->getCc_caja_chica()."',          
        '".$obj->getNro_cheque()."',       
        '".$obj->getC_banco()."',
        '".$obj->getC_cta_corriente()."',
        '".$obj->getMonto()."',
        '".$obj->getFecha_operacion()."',
        '".$obj->getC_local()."',
        '".$obj->getMonto_apertura()."',
        '".$obj->getC_persona()."',
        '".$obj->getC_usuario()."',
        '".$obj->getOpc()."'";
        // echo $sql;
        return $this->conecta->sql_query($sql);
    }

}
