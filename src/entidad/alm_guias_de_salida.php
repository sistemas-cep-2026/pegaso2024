<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class alm_guias_de_salida extends Parse
{
    private $cc_guia;
    private $c_local;
    private $c_area_adm;
    private $fecha;
    private $flag;
    private $justificacion;
    private $user_crea;
    private $fech_crea;
 

    private $opc;
    private $anho;
    private $periodo;
    private $desde;
    private $hasta;
    private $c_articulo;
    

    function __construct()
    {
        $this->cc_guia=0;
        $this->c_local='';
        $this->c_area_adm='';
        $this->fecha='';
     
        $this->flag='';
        $this->justificacion='';
        $this->user_crea = '';
        $this->fech_crea = '';
 

        $this->opc = '';
        $this->anho='';
        $this->periodo='';
        $this->desde='';
        $this->hasta='';
        $this->c_articulo='';
    }

    public function setCc_guia($cc_guia)
    {
        if (empty($cc_guia)) return;
        $this->cc_guia = self::Clean($cc_guia);
    }

    public function getCc_guia() 
    {
        return $this->cc_guia;
    }

    public function setC_local($c_local) 
    {
        if (empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local() 
    {
        return $this->c_local;
    }

    public function setC_area_adm($c_area_adm) 
    {
        if (empty($c_area_adm)) return;
        $this->c_area_adm = self::Clean($c_area_adm);
    }

    public function getC_area_adm() 
    {
        return $this->c_area_adm;
    }

    public function setFecha($fecha) 
    {
        if (empty($fecha)) return;
        $this->fecha = self::Clean($fecha);
    }

    public function getFecha() 
    {
        return $this->fecha;
    }

    public function setFlag($flag) 
    {
        if (empty($flag)) return;
        $this->flag = self::Clean($flag);
    }

    public function getFlag() 
    {
        return $this->flag;
    }

    public function setJustificacion($justificacion) 
    {
        if (empty($justificacion)) return;
        $this->justificacion = self::Clean($justificacion);
    }

    public function getJustificacion() 
    {
        return $this->justificacion;
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

    public function setFech_crea($fecha_crea)
    {
        if(empty($fech_crea)) return;
        $this->fech_crea = self::Clean($fech_crea);
    }

    public function getFech_crea()
    {
        return $this->fech_crea;
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

    public function setDesde($desde)
    {
        if(empty($desde)) return;
        $this->desde = self::Clean($desde);
    }

    public function getDesde()
    {
        return $this->desde;
    }

    public function setHasta($hasta)
    {
        if(empty($hasta)) return;
        $this->hasta = self::Clean($hasta);
    }

    public function getHasta()
    {
        return $this->hasta;
    }
    public function setC_articulo($c_articulo)
    {
        if(empty($c_articulo)) return;
        $this->c_articulo = self::Clean($c_articulo);
    }

    public function getC_articulo()
    {
        return $this->c_articulo;
    }

}