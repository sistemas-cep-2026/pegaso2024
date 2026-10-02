<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class alm_requisicion extends Parse
{
 
    private  $fecha;
    private  $observacion;
    private  $c_usuario;
    private  $cc_local;
    private  $c_area_adm;
    private  $cc_requisicion;
    private  $flag;
    private  $user_crea;
    private  $opc;

    private $anho;
    private $periodo;
     

    function __construct()
    {
       
        $this->fecha='';
        $this->observacion='';
        $this->c_usuario='';
        $this->cc_local='';
        $this->c_area_adm = '';
        $this->cc_requisicion = '';

        $this->flag = '';
        $this->user_crea = '';
        
        $this->opc = '';
        $this->anho='';
        $this->periodo='';
    }
 
    
    public function setFecha($fecha)
    {
        if(empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }
    public function getFecha()
    {
        return $this->fecha;
    }

    public function setObservacion($observacion)
    {
        if(empty($observacion)) return;
        $this->observacion = self::Clean($observacion);
    }
    public function getObservacion()
    {
        return $this->observacion;
    }

    public function setC_usuario($c_usuario)
    {
        if(empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }
    public function getC_usuario()
    {
        return $this->c_usuario;
    }

    public function setCc_local($cc_local)
    {
        if(empty($cc_local)) return;
        $this->cc_local = self::Clean($cc_local);
    }
    public function getCc_local()
    {
        return $this->cc_local;
    }

    public function setC_area_adm($c_area_adm)
    {
        if(empty($c_area_adm)) return;
        $this->c_area_adm = self::Clean($c_area_adm);
    }
    public function getC_area_adm()
    {
        return $this->c_area_adm;
    }

    public function setCc_requisicion($cc_requisicion)
    {
        if(empty($cc_requisicion)) return;
        $this->cc_requisicion = self::Clean($cc_requisicion);
    }
    public function getCc_requisicion()
    {
        return $this->cc_requisicion;
    }

    public function setUser_crea($user_crea)
    {
        if(empty($user_crea)) return;
        $this->user_crea = self::Clean($user_crea);
    }
    public function getUser_crea()
    {
        return $this->user_crea;
    }

    public function setFlag($flag)
    {
        if(empty($flag)) return;
        $this->flag = self::Clean($flag);
    }
    public function getFlag()
    {
        return $this->flag;
    }

    public function setOpc($opc)
    {
        if(empty($opc)) return;
        $this->opc = self::Clean($opc);
    }
    public function getOpc()
    {
        return $this->opc;
    }
     
    public function setAnho($anho)
    {
        if(empty($anho)) return;
        $this->anho = self::Clean($anho);
    }
    public function getAnho()
    {
        return $this->anho;
    }

     
    public function setPeriodo($periodo)
    {
        if(empty($periodo)) return;
        $this->periodo = self::Clean($periodo);
    }
    public function getPeriodo()
    {
        return $this->periodo;
    }


}