<?php
    require_once "iAlmacenable.php";
    require_once "MiPDF.php";
    require_once "MiFPDF.php";
    $pdf = new MiFPDF("Mi Título", "Este es el contenido del PDF.");
    $pdf->almacenaDoc("mi_documento");
    $pdf->devuelveDoc();
?>