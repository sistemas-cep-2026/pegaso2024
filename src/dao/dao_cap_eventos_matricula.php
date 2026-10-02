<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos_matricula.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos_matricula
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


/// excep sp_v1_eventos_matricula
    public function insertar(cap_eventos_matricula $obj)
    {
        $sql = "insert into cap_eventos_matricula(cc_evento,
        c_persona,
        asistente,
        ponente,
        organizador,
        documento,
        modalidad,
        user_crea,
        fech_crea
        )values(
        '{$obj->getCc_evento()}',
        '{$obj->getC_persona()}',
        {$obj->getAsistente()},
        {$obj->getPonente()},
        {$obj->getOrganizador()},
        '1',
        'V',
        '{$obj->getUser_crea()}',
        GETDATE()
    )";
    //echo $sql;
    return $this->conecta->sql_query($sql);
}

public function modificar(cap_eventos_matricula $obj)
{
    $sql = "update cap_eventos_matricula set 
    asistente={$obj->getAsistente()},
    ponente={$obj->getPonente()},
    organizador={$obj->getOrganizador()},
    documento='1',
    modalidad='V',
    user_mod='{$obj->getUser_crea()}',
    fech_mod=GETDATE()
    FROM dbo.cap_eventos_matricula
    WHERE cc_evento_mat='{$obj->getCc_evento_mat()}'";
        //echo $sql;
    return $this->conecta->sql_query($sql);
}

public function eliminar(cap_eventos_matricula $obj)
{
    $sql = "delete from dbo.cap_eventos_matricula 
    where cc_evento_mat='{$obj->getCc_evento_mat()}'";
        //echo $sql;
    return $this->conecta->sql_query($sql);
}

}