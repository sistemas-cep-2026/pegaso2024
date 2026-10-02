<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class alm_guias_de_entrada extends Parse
{
 
    private $cc_local;  
    private $cc_persona; 
    private $cod_documento;
    private $num_documento;
    private $fecha;
    private $flag;
    private $cc_requisicion;
    private $cc_guia;
    private $cc_usuario;
    private $observacion;
    
    private $opc;

    private $anho;
    private $periodo;

    function __construct()
    {       
        $this->cc_local='';
        $this->cc_persona='';
        $this->cod_documento='';
        $this->num_documento='';
        $this->fecha='';
        $this->flag = '';
        $this->cc_requisicion='';
        $this->cc_guia = 0;
        $this->cc_usuario='';
        $this->observacion='';
                           
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
        $this->cc_usuario = self::Clean($c_usuario);
    }
    public function getC_usuario()
    {
        return $this->cc_usuario;
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

    public function setCc_persona($cc_persona)
    {
        if(empty($cc_persona)) return;
        $this->cc_persona = self::Clean($cc_persona);
    }
    public function getCc_persona()
    {
        return $this->cc_persona;
    }

    public function setCc_guia($cc_guia)
    {
        if(empty($cc_guia)) return;
        $this->cc_guia = self::Clean($cc_guia);
    }
    public function getCc_guia()
    {
        return $this->cc_guia;
    }

    public function setCc_usuario($cc_usuario)
    {
        if(empty($cc_usuario)) return;
        $this->cc_usuario = self::Clean($cc_usuario);
    }
    public function getCc_usuario()
    {
        return $this->cc_usuario;
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


    public function setCod_documento($cod_documento)
    {
        if(empty($cod_documento)) return;
        $this->cod_documento = self::Clean($cod_documento);
    }
    public function getCod_documento()
    {
        return $this->cod_documento;
    }


    public function setNum_documento($num_documento)
    {
        if(empty($num_documento)) return;
        $this->num_documento = self::Clean($num_documento);
    }
    public function getNum_documento()
    {
        return $this->num_documento;
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



}