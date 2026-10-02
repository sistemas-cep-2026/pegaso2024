<?php
require_once dirname(__DIR__) . '/entidad/cap_eventos_matricula_temp.php';
require_once __DIR__ . '/_conexa_.php';
class dao_cap_eventos_matricula_temp
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

    public function insertar(cap_eventos_matricula_temp $obj)
    {
        $cep = $obj->getCep() !== null ? "'{$obj->getCep()}'" : 'NULL';
        $num_documento = $obj->getNum_documento() !== null ? "'{$obj->getNum_documento()}'" : 'NULL';

        $sql = "INSERT INTO cap_eventos_matricula_temp (
            cc_evento,
            cep,
            num_documento,
            nombre,
            asistente,
            ponente,
            organizador )
        VALUES (
            {$obj->getCc_evento()},
            {$cep},
            {$num_documento},
            '{$obj->getNombre()}',
            '{$obj->getAsistente()}',
            '{$obj->getPonente()}',
            '{$obj->getOrganizador()}')";
        return $this->conecta->sql_query($sql);
    }

    public function eliminarPorEvento(cap_eventos_matricula_temp $obj)
    {
        $sql = "DELETE FROM cap_eventos_matricula_temp
        WHERE cc_evento = {$obj->getCc_evento()}";
        return $this->conecta->sql_query($sql);
    }

    public function procesar($cc_evento, $usuario)
    {
        $sql = "exec sp_v1_cap_matricula_procesar {$cc_evento}, '{$usuario}'";
        return $this->conecta->ArrayLista($sql);
    }
}
