<?php
    abstract class MiPDF {
        protected $titulo;
        protected $contenido;
        protected $tipoDeLetra;
        protected $tamano;
        protected $alineacion;

        function __construct(){
            if(func_num_args() === 5){
                $this->titulo = func_get_arg(0);
                $this->contenido = func_get_arg(1);
                $this->tipoDeLetra = func_get_arg(2);
                $this->tamano = func_get_arg(3);
                $this->alineacion = func_get_arg(4);
            } else if(func_num_args() === 0){
                $this->titulo = "";
                $this->contenido = "";
                $this->tipoDeLetra = "";
                $this->tamano = 0;
                $this->alineacion = "";
            } else {
                die("Error: error en el número de argumentos en el constructor.");
            }
        }
        public function getTitulo(){
                return $this->titulo;
        }
        public function setTitulo($titulo){
                $this->titulo = $titulo;
                return $this;
        }
        public function getContenido(){
                return $this->contenido;
        }
        public function setContenido($contenido){
                $this->contenido = $contenido;
                return $this;
        }
        public function getTipoDeLetra(){
                return $this->tipoDeLetra;
        }
        public function setTipoDeLetra($tipoDeLetra){
                $this->tipoDeLetra = $tipoDeLetra;
                return $this;
        }
        public function getTamano(){
                return $this->tamano;
        }
        public function setTamano($tamano){
                $this->tamano = $tamano;
                return $this;
        }
        public function getAlineacion(){
                return $this->alineacion;
        }
        public function setAlineacion($alineacion){
                $this->alineacion = $alineacion;
                return $this;
        }

        function generaDoc(){
            $p = new PDFlib();
            $p->
        }
    }
?>