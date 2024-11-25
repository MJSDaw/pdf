<?php
    class MiPDFLib extends MiPDF implements iAlmacenable {
        private const EXTENSION = '.pdf';
    
        public function generaDoc() {
            $pdf = new TCPDF();
            $pdf->AddPage();
            $pdf->SetFont($this->tipoLetra, '', $this->tamano);
            $pdf->Write(0, $this->titulo, '', 0, $this->alineacion, true);
            $pdf->Write(0, $this->contenido);
            return $pdf;
        }
        public function almacenaDoc($ruta) {
            $pdf = $this->generaDoc();
            $pdf->Output($ruta . self::EXTENSION, 'F');
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