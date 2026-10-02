<?php
header("Content-type: application/octet-stream;");
header("Content-Disposition: attachment; filename=Reporte.xls");
header("Pragma: no-cache");
header("Expires: 0");
echo "\xEF\xBB\xBF";
echo $_REQUEST['expTabla'];