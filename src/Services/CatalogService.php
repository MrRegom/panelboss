<?php

namespace App\Services;

use App\Repositories\MasterProductRepository;
use Exception;

/**
 * CatalogService — Lógica de negocio para el Catálogo Elite
 * Maneja la optimización de imágenes y reglas de catálogo.
 */
class CatalogService
{
    private $repository;
    private $storagePath;

    public function __construct()
    {
        $this->repository = new MasterProductRepository();
        // Definimos la ruta de almacenamiento base
        $this->storagePath = dirname(__DIR__, 2) . '/public/storage/products';
        
        // Asegurar que existan los directorios
        if (!is_dir($this->storagePath . '/originals')) {
            mkdir($this->storagePath . '/originals', 0755, true);
        }
        if (!is_dir($this->storagePath . '/webp')) {
            mkdir($this->storagePath . '/webp', 0755, true);
        }
    }

    /**
     * Procesa una imagen subida, la convierte a WebP y la vincula al producto
     */
    public function processProductImage(string $barcode, string $tempImagePath): string
    {
        if (!file_exists($tempImagePath)) {
            throw new Exception("El archivo temporal de imagen no existe.");
        }

        $extension = pathinfo($tempImagePath, PATHINFO_EXTENSION);
        $filename = $barcode . '.webp';
        
        // Si no hay GD, simplemente copiamos el archivo original con su extensión real
        if (!function_exists('imagecreatefromjpeg')) {
            $filename = $barcode . '.' . $extension;
            $destination = $this->storagePath . '/webp/' . $filename;
            copy($tempImagePath, $destination);
            return 'storage/products/webp/' . $filename;
        }

        $destination = $this->storagePath . '/webp/' . $filename;
        // Detectar tipo de imagen y cargarla
        $info = getimagesize($tempImagePath);
        if (!$info) throw new Exception("Formato de imagen no válido.");

        switch ($info[2]) {
            case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($tempImagePath); break;
            case IMAGETYPE_PNG:  $image = imagecreatefrompng($tempImagePath); break;
            case IMAGETYPE_WEBP: $image = imagecreatefromwebp($tempImagePath); break;
            default: throw new Exception("Formato no soportado (usar JPG, PNG o WebP).");
        }

        // Redimensionar si es muy grande (Max 800px para la App)
        $width = imagesx($image);
        $height = imagesy($image);
        $maxSize = 800;

        if ($width > $maxSize || $height > $maxSize) {
            $ratio = $width / $height;
            if ($ratio > 1) {
                $newWidth = $maxSize;
                $newHeight = $maxSize / $ratio;
            } else {
                $newWidth = $maxSize * $ratio;
                $newHeight = $maxSize;
            }
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Mantener transparencia si es necesario
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            
            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $image = $newImage;
        }

        // Guardar como WebP optimizado (Calidad 80)
        imagewebp($image, $destination, 80);
        imagedestroy($image);

        // Retornar la ruta relativa para la base de datos
        return 'storage/products/webp/' . $filename;
    }

    /**
     * Registra un nuevo producto con su imagen procesada
     */
    public function createProduct(array $data, ?string $tempFile = null): bool
    {
        if ($tempFile) {
            $data['image_path'] = $this->processProductImage($data['barcode'], $tempFile);
        }
        
        return $this->repository->save($data);
    }

    /**
     * Obtiene los datos del producto para la API de la App
     */
    public function getProductForApp(string $barcode): ?array
    {
        $product = $this->repository->getByBarcode($barcode);
        if (!$product) return null;

        // Estructura limpia para la App móvil
        return [
            'ean'    => $product['barcode'],
            'nombre' => $product['name'],
            'marca'  => $product['brand'],
            'foto'   => $product['image_path'] ? 'https://' . $_SERVER['HTTP_HOST'] . '/' . $product['image_path'] : null
        ];
    }
}
