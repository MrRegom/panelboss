<?php
require_once __DIR__ . '/includes/bootstrap.php';
use App\Services\AuthService;
AuthService::check();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentación API | CajaYa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f8fafc; font-family: 'Inter', sans-serif; }
        .card { background: #1e293b; border: 1px solid #334155; }
        code { color: #38bdf8; background: #0f172a; padding: 2px 4px; border-radius: 4px; }
        pre { background: #0f172a; padding: 15px; border-radius: 8px; border: 1px solid #334155; }
        .endpoint { color: #22c55e; font-weight: bold; }
    </style>
</head>
<body class="p-5">
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body p-5">
                <h1 class="fw-bold mb-4">📘 Documentación API CajaYa</h1>
                <p class="text-muted">Guía de integración para el catálogo de productos.</p>
                
                <hr class="border-secondary my-5">

                <h3 class="mb-3">1. Listado de Productos</h3>
                <p>Retorna el catálogo completo en formato JSON.</p>
                <div class="mb-3">
                    <span class="badge bg-success me-2">GET</span>
                    <code>https://panel.cajaya.cl/api/catalog/list.php</code>
                </div>
                
                <h5 class="mt-4">Parámetros requeridos:</h5>
                <ul>
                    <li><code>license_key</code>: Tu clave de activación (Ej: <code>DEVELOPER-TEST</code>)</li>
                </ul>

                <h5 class="mt-4">Ejemplo de Respuesta:</h5>
                <pre>{
  "success": true,
  "data": [
    {
      "barcode": "780123456789",
      "name": "Producto Ejemplo",
      "category_name": "Aseo",
      "image_url": "https://panel.cajaya.cl/api/catalog/image.php?barcode=780..."
    }
  ]
}</pre>

                <hr class="border-secondary my-5">

                <h3 class="mb-3">2. Obtener Imagen</h3>
                <p>Devuelve el archivo binario de la imagen directamente.</p>
                <div class="mb-3">
                    <span class="badge bg-success me-2">GET</span>
                    <code>https://panel.cajaya.cl/api/catalog/image.php</code>
                </div>
                <ul>
                    <li><code>barcode</code>: Código de barras del producto.</li>
                    <li><code>license_key</code>: Tu clave de activación.</li>
                </ul>

                <div class="alert alert-info mt-5 bg-info bg-opacity-10 border-info border-opacity-25 text-info">
                    <strong>Nota:</strong> Esta documentación es privada y requiere sesión activa en el panel.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
