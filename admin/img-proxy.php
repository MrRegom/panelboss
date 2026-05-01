<?php
/**
 * img-proxy.php — Proxy seguro de imágenes del Catálogo Maestro
 *
 * Sirve imágenes desde directorios fuera del web root de nginx.
 * El web root de panel.cajaya.cl apunta a /admin/, por lo que
 * storage/ e imagenes_productos/ no son accesibles vía URL directa.
 * Este proxy los lee desde el filesystem y los sirve con cabeceras HTTP correctas.
 *
 * Uso: <img src="img-proxy.php?b=7802237001217">
 *
 * @security Solo acepta barcodes numéricos para evitar path traversal.
 */

// Sanitización estricta: solo dígitos (barcode)
$barcode = preg_replace('/[^0-9]/', '', $_GET['b'] ?? '');

if (empty($barcode)) {
    http_response_code(404);
    exit;
}

// Rutas candidatas en orden de prioridad (filesystem, no URL)
$basePath = __DIR__ . '/../';
$candidates = [
    $basePath . 'imagenes_productos/' . $barcode . '.jpg',
    $basePath . 'imagenes_productos/' . $barcode . '.png',
    $basePath . 'storage/products/webp/' . $barcode . '.jpg',
    $basePath . 'storage/products/webp/' . $barcode . '.png',
    $basePath . 'storage/products/webp/' . $barcode . '.webp',
];

foreach ($candidates as $filePath) {
    if (file_exists($filePath) && is_file($filePath)) {
        $ext  = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'png'  => 'image/png',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };

        // Cabeceras HTTP de caché y tipo de contenido
        header('Content-Type: ' . $mime);
        header('Cache-Control: public, max-age=86400'); // 24h de caché
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}

// Si no se encontró ninguna imagen → 404
http_response_code(404);
exit;
