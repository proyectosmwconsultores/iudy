<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/repositorio/tecnickcom/tcpdf/tcpdf.php';

$fontFile = __DIR__ . '/repositorio/tecnickcom/tcpdf/fonts/Gabriola.ttf';

echo "Ruta fuente: " . $fontFile . "<br>";

if (!file_exists($fontFile)) {
    die("NO EXISTE el archivo TTF");
}

if (!is_readable($fontFile)) {
    die("El archivo TTF NO tiene permisos de lectura");
}

echo "Peso fuente: " . filesize($fontFile) . " bytes<br>";

$fontname = TCPDF_FONTS::addTTFfont(
    $fontFile,
    'TrueTypeUnicode',
    '',
    32
);

if (!$fontname) {
    die("No se pudo registrar la fuente. Revisa permisos en la carpeta tcpdf/fonts/");
}

echo "Fuente registrada como: " . $fontname;