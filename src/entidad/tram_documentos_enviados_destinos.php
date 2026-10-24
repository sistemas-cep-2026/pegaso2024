<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class tram_documentos_enviados_destinos extends Parse
{
    private $cc_docenviado_det;
    private $cc_docenviado;
    private $numero;
    private $c_persona;
    private $fecha;
    private $c_area_adm;
    private $cargo;
    private $c_usuario;
    private $flag;
    private $linea;
    private $c_local_destino;
    private $c_area_adm_usuario;
    private $sector_entidad;
    private $c_grupos_destinos;
    private $c_destinos;
    private $opcd;

    function __construct()
    {
        $this->cc_docenviado_det = 0;
        $this->cc_docenviado = 0;
        $this->numero = '';
        $this->c_persona = '';
        $this->fecha = '';
        $this->c_area_adm = '';
        $this->cargo = '';
        $this->c_usuario = '';
        $this->flag = '';
        $this->linea = 0;
        $this->c_local_destino = '';
        $this->c_area_adm_usuario = '';
        $this->sector_entidad = '';
        $this->c_grupos_destinos = '';
        $this->c_destinos = '';
        $this->opcd = '';

    }

    public function setCc_docenviado_det($cc_docenviado_det)
    {
        if (empty($cc_docenviado_det)) return;
        $this->cc_docenviado_det = self::Clean($cc_docenviado_det);
    }

    public function getCc_docenviado_det()
    {
        return $this->cc_docenviado_det;
    }

    public function setCc_docenviado($cc_docenviado)
    {
        if (empty($cc_docenviado)) return;
        $this->cc_docenviado = self::Clean($cc_docenviado);
    }

    public function getCc_docenviado()
    {
        return $this->cc_docenviado;
    }

    public function setNumero($numero)
    {
        if (empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setC_persona($c_persona)
    {
        if (empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
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

    public function setC_area_adm($c_area_adm)
    {
        if (empty($c_area_adm)) return;
        $this->c_area_adm = self::Clean($c_area_adm);
    }

    public function getC_area_adm()
    {
        return $this->c_area_adm;
    }

    public function setCargo($cargo)
    {
        if (empty($cargo)) return;
        $this->cargo = self::Clean($cargo);
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setC_usuario($c_usuario)
    {
        if (empty($c_usuario)) return;
        $this->c_usuario = self::Clean($c_usuario);
    }

    public function getC_usuario()
    {
        return $this->c_usuario;
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

    public function setLinea($linea)
    {
        if (empty($linea)) return;
        $this->linea = self::Clean($linea);
    }

    public function getLinea()
    {
        return $this->linea;
    }

    public function setC_local_destino($c_local_destino)
    {
        if (empty($c_local_destino)) return;
        $this->c_local_destino = self::Clean($c_local_destino);
    }

    public function getC_local_destino()
    {
        return $this->c_local_destino;
    }

    public function setC_area_adm_usuario($c_area_adm_usuario)
    {
        if (empty($c_area_adm_usuario)) return;
        $this->c_area_adm_usuario = self::Clean($c_area_adm_usuario);
    }

    public function getC_area_adm_usuario()
    {
        return $this->c_area_adm_usuario;
    }

    public function setSector_entidad($sector_entidad)
    {
        if (empty($sector_entidad)) return;
        $this->sector_entidad = self::Clean($sector_entidad);
    }

    public function getSector_entidad()
    {
        return $this->sector_entidad;
    }

    public function setC_grupos_destinos($c_grupos_destinos)
    {
        if (empty($c_grupos_destinos)) return;
        $this->c_grupos_destinos = self::Clean($c_grupos_destinos);
    }

    public function getC_grupos_destinos()
    {
        return $this->c_grupos_destinos;
    }

    public function setC_destinos($c_destinos)
    {
        if (empty($c_destinos)) return;
        $this->c_destinos = self::Clean($c_destinos);
    }

    public function getC_destinos()
    {
        return $this->c_destinos;
    }
    
    public function setOpcd($opcd)
    {
        if (empty($opcd)) return;
        $this->opcd = self::Clean($opcd);
    }

    public function getOpcd()
    {
        return $this->opcd;
    }
}
