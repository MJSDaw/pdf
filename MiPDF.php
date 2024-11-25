<?php
    abstract class MiPDF {
        protected $titulo;
        protected $contenido;
        protected $tipoLetra;
        protected $tamano;
        protected $alineacion;

        public function __construct($titulo = "", $contenido = "", $tipoLetra = "Arial", $tamano = 12, $alineacion = "L") {
            $this->titulo = $titulo;
            $this->contenido = $contenido;
            $this->tipoLetra = $tipoLetra;
            $this->tamano = $tamano;
            $this->alineacion = $alineacion;
        }
        public function getTitulo() {
            return $this->titulo;
        }
        public function setTitulo($titulo) {
            $this->titulo = $titulo;
        }
        public function getContenido() {
            return $this->contenido;
        }
        public function setContenido($contenido) {
            $this->contenido = $contenido;
        }
        public function getTipoLetra() {
            return $this->tipoLetra;
        }
        public function setTipoLetra($tipoLetra) {
            $this->tipoLetra = $tipoLetra;
        }
        public function getTamano() {
            return $this->tamano;
        }
        public function setTamano($tamano) {
            $this->tamano = $tamano;
        }
        public function getAlineacion() {
            return $this->alineacion;
        }
        public function setAlineacion($alineacion) {
            $this->alineacion = $alineacion;
        }
        abstract public function generaDoc();
        abstract public function almacenaDoc($ruta);
        abstract public function devuelveDoc();
    }
?>