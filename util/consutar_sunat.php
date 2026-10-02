<?php
header('Content-Type: application/json');

if (!isset($_POST['ruc']) || empty($_POST['ruc'])) {
    echo json_encode(['success' => false, 'message' => 'RUC no proporcionado']);
    exit;
}

$ruc = trim($_POST['ruc']);

if (!preg_match('/^[0-9]{11}$/', $ruc)) {
    echo json_encode(['success' => false, 'message' => 'RUC inválido']);
    exit;
}

try {
    // Consulta directa a SUNAT (puede cambiar)
    $url = "https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias";
    
    $data = [
        'accion' => 'consPorRuc',
        'nroRuc' => $ruc
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200 && $html) {
        // Parsear HTML (básico - puede necesitar ajustes)
        preg_match('/<td[^>]*class="[^"]*bgn[^"]*"[^>]*>(.*?)<\/td>/si', $html, $razonSocial);
        preg_match('/<td[^>]*colspan="3"[^>]*>(.*?)<\/td>/si', $html, $direccion);
        
        $razonSocial = isset($razonSocial[1]) ? trim(strip_tags($razonSocial[1])) : '';
        $direccion = isset($direccion[1]) ? trim(strip_tags($direccion[1])) : '';
        
        if ($razonSocial) {
            echo json_encode([
                'success' => true,
                'data' => [
                    'razonSocial' => $razonSocial,
                    'direccion' => $direccion,
                    'estado' => 'ACTIVO',
                    'condicion' => 'HABIDO'
                ]
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró el RUC'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al conectar con SUNAT'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>