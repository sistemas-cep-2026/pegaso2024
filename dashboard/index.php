<?php
$data_pagina_dash = $bo_modulo_pagina->asignado_pagina_dashboard($id_dash);
$data_pagina_dash = $data_pagina_dash[0] ?? [];

$mod_carpeta = trim((string)($data_pagina_dash['mod_carpeta'] ?? ''));
$mod_carpeta = str_replace('\\', '/', $mod_carpeta);
$mod_carpeta = trim($mod_carpeta, '/');

$base_dir = __DIR__;
$index_path = $base_dir . '/' . ($mod_carpeta ? $mod_carpeta . '/' : '') . 'index.php';

if (!is_file($index_path)) {
    $index_path = dirname(__DIR__) . '/paginas/404.php';
}
require_once $index_path;

$js_fs = $base_dir . '/js/j' . str_replace('/', '', $mod_carpeta) . '.js';
$url_js = (is_file($js_fs)) ? ('dashboard/js/j' . str_replace('/', '', $mod_carpeta) . '.js') : '';
