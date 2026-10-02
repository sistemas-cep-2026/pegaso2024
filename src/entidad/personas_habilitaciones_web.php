<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class personas_habilitaciones_web extends Parse
{
    private $id_doc;
    private $c_tipo;
    private $c_local;
    private $numero;
    private $gestion;
    private $c_persona;
    private $fecha;
    private $flag_expediente;
    private $c_expediente;
    private $vigencia;
    private $flag;
    private $visado;
    private $fecha_visado;
    private $fecha_entrega;
    private $c_usuario_n;
    private $c_usuario_v;
    private $N_REC;
    private $OBS;
    private $fecha_adeudo;
    private $num_hoja;
    private $hg;
    private $Cod_codigo;
    private $caducidad;
    private $c_persona_institucion;
    private $c_actividad;
    private $decano;
    private $firma_decano;
    private $firma_nacional;

    function __construct()
    {
        $this->id_doc = 0;
        $this->c_tipo = '';
        $this->c_local = '';
        $this->numero = '';
        $this->gestion = '';
        $this->c_persona = '';
        $this->fecha = '';
        $this->flag_expediente = '';
        $this->c_expediente = '';
        $this->vigencia = '';
        $this->flag = '';
        $this->visado = '';
        $this->fecha_visado = '';
        $this->fecha_entrega = '';
        $this->c_usuario_n = '';
        $this->c_usuario_v = '';
        $this->N_REC = '';
        $this->OBS = '';
        $this->fecha_adeudo = '';
        $this->num_hoja = '';
        $this->hg = '';
        $this->Cod_codigo = '';
        $this->caducidad = '';
        $this->c_persona_institucion = '';
        $this->c_actividad = '';
        $this->decano = '';
        $this->firma_decano = '';
        $this->firma_nacional = '';
    }

    public function setId_doc($id_doc)
    {
        if(empty($id_doc)) return;
        $this->id_doc = self::Clean($id_doc);
    }

    public function getId_doc()
    {
        return $this->id_doc;
    }

    public function setC_tipo($c_tipo)
    {
        if(empty($c_tipo)) return;
        $this->c_tipo = self::Clean($c_tipo);
    }

    public function getC_tipo()
    {
        return $this->c_tipo;
    }

    public function setC_local($c_local)
    {
        if(empty($c_local)) return;
        $this->c_local = self::Clean($c_local);
    }

    public function getC_local()
    {
        return $this->c_local;
    }

    public function setNumero($numero)
    {
        if(empty($numero)) return;
        $this->numero = self::Clean($numero);
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setGestion($gestion)
    {
        if(empty($gestion)) return;
        $this->gestion = self::Clean($gestion);
    }

    public function getGestion()
    {
        return $this->gestion;
    }

    public function setC_persona($c_persona)
    {
        if(empty($c_persona)) return;
        $this->c_persona = self::Clean($c_persona);
    }

    public function getC_persona()
    {
        return $this->c_persona;
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

    public function setFlag_expediente($flag_expediente)
    {
        if(empty($flag_expediente)) return;
        $this->flag_expediente = self::Clean($flag_expediente);
    }

    public function getFlag_expediente()
    {
        return $this->flag_expediente;
    }

    public function setC_expediente($c_expediente)
    {
        if(empty($c_expediente)) return;
        $this->c_expediente = self::Clean($c_expediente);
    }

    public function getC_expediente()
    {
        return $this->c_expediente;
    }

    public function setVigencia($vigencia)
    {
        if(empty($vigencia)) return;
        $this->vigencia = self::Clean($vigencia);
    }

    public function getVigencia()
    {
        return $this->vigencia;
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

    public function setVisado($visado)
    {
        if(empty($visado)) return;
        $this->visado = self::Clean($visado);
    }

    public function getVisado()
    {
        return $this->visado;
    }

    public function setFecha_visado($fecha_visado)
    {
        if(empty($fecha_visado)) return;
        $this->fecha_visado = self::Clean($fecha_visado);
    }

    public function getFecha_visado()
    {
        return $this->fecha_visado;
    }

    public function setFecha_entrega($fecha_entrega)
    {
        if(empty($fecha_entrega)) return;
        $this->fecha_entrega = self::Clean($fecha_entrega);
    }

    public function getFecha_entrega()
    {
        return $this->fecha_entrega;
    }

    public function setC_usuario_n($c_usuario_n)
    {
        if(empty($c_usuario_n)) return;
        $this->c_usuario_n = self::Clean($c_usuario_n);
    }

    public function getC_usuario_n()
    {
        return $this->c_usuario_n;
    }

    public function setC_usuario_v($c_usuario_v)
    {
        if(empty($c_usuario_v)) return;
        $this->c_usuario_v = self::Clean($c_usuario_v);
    }

    public function getC_usuario_v()
    {
        return $this->c_usuario_v;
    }

    public function setN_REC($N_REC)
    {
        if(empty($N_REC)) return;
        $this->N_REC = self::Clean($N_REC);
    }

    public function getN_REC()
    {
        return $this->N_REC;
    }

    public function setOBS($OBS)
    {
        if(empty($OBS)) return;
        $this->OBS = self::Clean($OBS);
    }

    public function getOBS()
    {
        return $this->OBS;
    }

    public function setFecha_adeudo($fecha_adeudo)
    {
        if(empty($fecha_adeudo)) return;
        $this->fecha_adeudo = self::Clean($fecha_adeudo);
    }

    public function getFecha_adeudo()
    {
        return $this->fecha_adeudo;
    }

    public function setNum_hoja($num_hoja)
    {
        if(empty($num_hoja)) return;
        $this->num_hoja = self::Clean($num_hoja);
    }

    public function getNum_hoja()
    {
        return $this->num_hoja;
    }

    public function setHg($hg)
    {
        if(empty($hg)) return;
        $this->hg = self::Clean($hg);
    }

    public function getHg()
    {
        return $this->hg;
    }

    public function setCod_codigo($Cod_codigo)
    {
        if(empty($Cod_codigo)) return;
        $this->Cod_codigo = self::Clean($Cod_codigo);
    }

    public function getCod_codigo()
    {
        return $this->Cod_codigo;
    }

    public function setCaducidad($caducidad)
    {
        if(empty($caducidad)) return;
        $this->caducidad = self::Clean($caducidad);
    }

    public function getCaducidad()
    {
        return $this->caducidad;
    }

    public function setC_persona_institucion($c_persona_institucion)
    {
        if(empty($c_persona_institucion)) return;
        $this->c_persona_institucion = self::Clean($c_persona_institucion);
    }

    public function getC_persona_institucion()
    {
        return $this->c_persona_institucion;
    }

    public function setC_actividad($c_actividad)
    {
        if(empty($c_actividad)) return;
        $this->c_actividad = self::Clean($c_actividad);
    }

    public function getC_actividad()
    {
        return $this->c_actividad;
    }

    public function setDecano($decano)
    {
        if(empty($decano)) return;
        $this->decano = self::Clean($decano);
    }

    public function getDecano()
    {
        return $this->decano;
    }

    public function setFirma_decano($firma_decano)
    {
        if(empty($firma_decano)) return;
        $this->firma_decano = self::Clean($firma_decano);
    }

    public function getFirma_decano()
    {
        return $this->firma_decano;
    }

    public function setFirma_nacional($firma_nacional)
    {
        if(empty($firma_nacional)) return;
        $this->firma_nacional = self::Clean($firma_nacional);
    }

    public function getFirma_nacional()
    {
        return $this->firma_nacional;
    }

}