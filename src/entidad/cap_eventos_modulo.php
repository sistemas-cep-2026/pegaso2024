<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cap_eventos_modulo extends Parse
{
    private $cc_capmod;
    private $cc_evento;
    private $ct_modulo;
    private $flag;

    function __construct()
    {
        $this->cc_capmod = 0;
        $this->cc_evento = 0;
        $this->ct_modulo = '';
        $this->flag = '';
    }

    public function setCc_capmod($cc_capmod)
    {
        if (empty($cc_capmod)) return;
        $this->cc_capmod = self::Clean($cc_capmod);
    }

    public function getCc_capmod()
    {
        return $this->cc_capmod;
    }

    public function setCc_evento($cc_evento)
    {
        if (empty($cc_evento)) return;
        $this->cc_evento = self::Clean($cc_evento);
    }

    public function getCc_evento()
    {
        return $this->cc_evento;
    }

    public function setCt_modulo($ct_modulo)
    {
        if ($ct_modulo === null || trim($ct_modulo) === '') {
            $this->ct_modulo = null;
            return;
        }

        $this->ct_modulo = $ct_modulo;
    }

    public function getCt_modulo()
    {
        return $this->ct_modulo;
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
}
