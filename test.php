<?php
    $pdf = new MiFPDF("Mi Título", "Este es el contenido del PDF.");
    $pdf->almacenaDoc("mi_documento");
    $pdf->devuelveDoc();
?>