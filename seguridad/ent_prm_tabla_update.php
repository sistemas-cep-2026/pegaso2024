<?php
require_once(dirname(__DIR__) . "/util/seguridad.php");
require_once(dirname(__DIR__) . "/util/util.php");
require_once(u_src() . "bo/bo_seg_modulo.php");
s_validar_pagina();
$bo_modulo  = new bo_seg_modulo();
$tipo = $_REQUEST['tipo'];
$tabla = $_REQUEST['tabla'];
$nom_archivo = "";
switch ($tipo) {
    case 'E':
        $_class = '';
        $nom_archivo = BASE_MAIN_PATH . "src" . DIRECTORY_SEPARATOR . "entidad" . DIRECTORY_SEPARATOR . str_replace("'", '', $tabla) . ".php";
        if (!is_file($nom_archivo)) {
            $ar = fopen($nom_archivo, "w") or die("NO SE PUEDE UBICAR LA CARPETA A PROCESAR");
            $data_campo = $bo_modulo->lista_campo(str_replace("'", '', $tabla));
            $_class .= '<?php' . PHP_EOL;
            $_class .= "require_once dirname(__DIR__) . '/security/Parse.php';" . PHP_EOL;
            $_class .= 'class ' . str_replace("'", '', $tabla) . ' extends Parse' . PHP_EOL;
            $_class .= '{' . PHP_EOL;
            foreach ($data_campo as $campo) {
                $_class .= '    private $' . $campo['campo'] . ';' . PHP_EOL;
            }
            $_class .= PHP_EOL;
            $_class .= '    function __construct()' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            foreach ($data_campo as $campo) {
                $_class .= '        $this->' . $campo['campo'] . ' = ';

                if (in_array($campo['tipo_dato'], ['int', 'decimal', 'float'])) {
                    $_class .= "0;";
                } else {
                    $_class .= "'';";
                }
                $_class .= PHP_EOL;
            }
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            foreach ($data_campo as $campo) {
                $_class .= '    public function set' . ucfirst($campo['campo']) . '($' . $campo['campo'] . ')' . PHP_EOL;
                $_class .= '    {' . PHP_EOL;
                $_class .= '        if(empty($' . $campo['campo'] . ')) return;' . PHP_EOL;
                $_class .= '        $this->' . $campo['campo'] . ' = self::Clean($' . $campo['campo'] . ');' . PHP_EOL;
                $_class .= '    }';
                $_class .= PHP_EOL;
                $_class .= PHP_EOL;
                $_class .= '    public function get' . ucfirst($campo['campo']) . '()' . PHP_EOL;
                $_class .= '    {' . PHP_EOL;
                $_class .= '        return $this->' . $campo['campo'] . ';' . PHP_EOL;
                $_class .= '    }';
                $_class .= PHP_EOL;
                $_class .= PHP_EOL;
            }
            $_class .= '}';
            fwrite($ar, $_class);
            fclose($ar);
        }

        break;
    case 'D':

        $_class = '';
        $nom_archivo = BASE_MAIN_PATH . "src" . DIRECTORY_SEPARATOR . "dao" . DIRECTORY_SEPARATOR . 'dao_' . str_replace("'", '', $tabla) . ".php";
        if (!is_file($nom_archivo)) {
            $ar = fopen($nom_archivo, "w") or die("NO SE PUEDE UBICAR LA CARPETA A PROCESAR");
            $_class .= '<?php' . PHP_EOL;
            $_class .= "require_once dirname(__DIR__) . '/entidad/" . str_replace("'", '', $tabla) . ".php';" . PHP_EOL;
            $_class .= "require_once __DIR__ . '/_conexa_.php';" . PHP_EOL;
            $_class .= 'class dao_' . str_replace("'", '', $tabla) . '' . PHP_EOL;
            $_class .= '{' . PHP_EOL;
            $_class .= '    private $conecta;' . PHP_EOL;
            $_class .= PHP_EOL;
            $_class .= '    function __construct()' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $this->conecta = new Conecta();';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function consulta($sql)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        return $this->conecta->ArrayLista($sql);';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function errores()' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        return $this->conecta->errores();';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function insertar(' . str_replace("'", '', $tabla) . ' $obj)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $sql = "";';
            $_class .= PHP_EOL;
            $_class .= '        return $this->conecta->sql_query($sql);';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function modificar(' . str_replace("'", '', $tabla) . ' $obj)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $sql = "";';
            $_class .= PHP_EOL;
            $_class .= '        return $this->conecta->sql_query($sql);';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function eliminar(' . str_replace("'", '', $tabla) . ' $obj)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $sql = "";';
            $_class .= PHP_EOL;
            $_class .= '        return $this->conecta->sql_query($sql);';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '}';
            fwrite($ar, $_class);
            fclose($ar);
        }

        break;
    case 'B':

        $_class = '';
        $nom_archivo = BASE_MAIN_PATH . "src" . DIRECTORY_SEPARATOR . "bo" . DIRECTORY_SEPARATOR . 'bo_' . str_replace("'", '', $tabla) . ".php";
        if (!is_file($nom_archivo)) {
            $ar = fopen($nom_archivo, "w") or die("NO SE PUEDE UBICAR LA CARPETA A PROCESAR");
            $_class .= '<?php' . PHP_EOL;
            $_class .= "require_once dirname(__DIR__) . '/dao/dao_" . str_replace("'", '', $tabla) . ".php';" . PHP_EOL;
            $_class .= 'class bo_' . str_replace("'", '', $tabla) . '' . PHP_EOL;
            $_class .= '{' . PHP_EOL;
            $_class .= '    private $dao;' . PHP_EOL;
            $_class .= PHP_EOL;
            $_class .= '    function __construct()' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $this->dao = new dao_' . str_replace("'", '', $tabla) . '();';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function control(' . str_replace("'", '', $tabla) . ' $obj, $opc)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        switch($opc){';
            $_class .= PHP_EOL;
            $_class .= '        case "I":';
            $_class .= PHP_EOL;
            $_class .= '            return $this->dao->insertar($obj);';
            $_class .= PHP_EOL;
            $_class .= '            break;';
            $_class .= PHP_EOL;
            $_class .= '        case "U":';
            $_class .= PHP_EOL;
            $_class .= '            return $this->dao->modificar($obj);';
            $_class .= PHP_EOL;
            $_class .= '            break;';
            $_class .= PHP_EOL;
            $_class .= '        case "E":';
            $_class .= PHP_EOL;
            $_class .= '            return $this->dao->eliminar($obj);';
            $_class .= PHP_EOL;
            $_class .= '            break;';
            $_class .= PHP_EOL;
            $_class .= '        }';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function errores()' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        return $this->dao->errores();';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function listar(' . str_replace("'", '', $tabla) . ' $obj = null)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $sql = "";';
            $_class .= PHP_EOL;
            $_class .= '        return $this->dao->consulta($sql);';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '    public function listarID(' . str_replace("'", '', $tabla) . ' $obj = null)' . PHP_EOL;
            $_class .= '    {' . PHP_EOL;
            $_class .= '        $sql = "";';
            $_class .= PHP_EOL;
            $_class .= '        return $this->dao->consulta($sql);';
            $_class .= PHP_EOL;
            $_class .= '    }' . PHP_EOL . PHP_EOL;
            $_class .= '}';
            fwrite($ar, $_class);
            fclose($ar);
        }

        break;
}

echo '0';
