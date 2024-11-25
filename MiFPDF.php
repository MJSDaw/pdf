<?php
    require_once "libs/fpdf186/fpdf.php";
    class MiFPDF extends MiPDF implements iAlmacenable {
        private const EXTENSION = '.pdf';
    
        public function generaDoc() {
            // Implementación con la librería FPDF
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont($this->tipoLetra, '', $this->tamano);
            $pdf->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', $this->titulo), 0, 1, $this->alineacion);
            $pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', $this->contenido));
            return $pdf;
        }
    
        public function almacenaDoc($ruta) {
            $pdf = $this->generaDoc();
            $pdf->Output('F', $ruta . self::EXTENSION);
        }
    
        public function devuelveDoc() {
            $pdf = $this->generaDoc();
            $pdf->Output('I');
        }
    
        public function guardaEnDisco($ruta) {
            $this->almacenaDoc($ruta);
        }
    }
?>