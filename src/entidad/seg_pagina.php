<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class seg_pagina extends Parse
{
    private $cc_pagina;
    private $cc_modulo;
    private $ct_pagina;
    private $ct_url;
    private $ct_js;
    private $ct_clase_cuerpo;
    private $cfl_vigencia;

    function __construct()
    {
        $this->cc_pagina = 0;
        $this->cc_modulo = '';
        $this->ct_pagina = '';
        $this->ct_url = '';
        $this->ct_js = '';
        $this->ct_clase_cuerpo = '';
        $this->cfl_vigencia = '';
    }

    public function setCc_pagina($cc_pagina)
    {
        if(empty($cc_pagina)) return;
        $this->cc_pagina = self::Clean($cc_pagina);
    }

    public function getCc_pagina()
    {
        return $this->cc_pagina;
    }

    public function setCc_modulo($cc_modulo)
    {
        if(empty($cc_modulo)) return;
        $this->cc_modulo = self::Clean($cc_modulo);
    }

    public function getCc_modulo()
    {
        return $this->cc_modulo;
    }

    public function setCt_pagina($ct_pagina)
    {
        if(empty($ct_pagina)) return;
        $this->ct_pagina = self::Clean($ct_pagina);
    }

    public function getCt_pagina()
    {
        return $this->ct_pagina;
    }

    public function setCt_url($ct_url)
    {
        if(empty($ct_url)) return;
        $this->ct_url = self::Clean($ct_url);
    }

    public function getCt_url()
    {
        return $this->ct_url;
    }

    public function setCt_js($ct_js)
    {
        if(empty($ct_js)) return;
        $this->ct_js = self::Clean($ct_js);
    }

    public function getCt_js()
    {
        return $this->ct_js;
    }

    public function setCt_clase_cuerpo($ct_clase_cuerpo)
    {
        if(empty($ct_clase_cuerpo)) return;
        $this->ct_clase_cuerpo = self::Clean($ct_clase_cuerpo);
    }

    public function getCt_clase_cuerpo()
    {
        return $this->ct_clase_cuerpo;
    }

    public function setCfl_vigencia($cfl_vigencia)
    {
        if(empty($cfl_vigencia)) return;
        $this->cfl_vigencia = self::Clean($cfl_vigencia);
    }

    public function getCfl_vigencia()
    {
        return $this->cfl_vigencia;
    }

}