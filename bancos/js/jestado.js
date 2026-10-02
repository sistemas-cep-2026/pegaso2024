// Este módulo ya no carga los reportes por AJAX: los 3 formularios
// (rep_ec_buscar.php, rep_saldos_buscar.php, rep_cheques_buscar.php)
// envían directo a un <iframe> propio (form target="divReporteXXX"), que
// ya trae su spinner y su propia carga vía cargadorReportes(this) en cada
// iframe. No hace falta ningún JS acá al cargar la página.
