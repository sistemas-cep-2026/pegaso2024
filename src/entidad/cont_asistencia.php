<?php
require_once dirname(__DIR__) . '/security/Parse.php';
class cont_asistencia extends Parse
{

    private $id;
    private $cc_persona;
    private $punch_time;
    private $flag;
    private $status;

    function __construct()
    {
        $this->id = 0;
        $this->cc_persona = '';
        $this->punch_time = '';
        $this->flag = '';
        $this->status='';

    }

    public function setId($id)
    {
        if (empty($id)) return;
        $this->id = self::Clean($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setCc_persona($cc_persona)
    {
        if (empty($cc_persona)) return;
        $this->cc_persona = self::Clean($cc_persona);
    }

    public function getCc_persona()
    {
        return $this->cc_persona;
    }


    public function setPunch_time($punch_time)
    {
        if (empty($punch_time)) return;
        $this->punch_time = self::Clean($punch_time);
    }

    public function getPunch_time()
    {
        return $this->punch_time;
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

    public function setStatus($status)
    {
        if (empty($status)) return;
        $this->status = self::Clean($status);
    }

    public function getStatus()
    {
        return $this->status;
    }

}
