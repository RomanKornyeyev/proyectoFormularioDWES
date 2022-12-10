<?php

namespace clasesCampo;

class Numero extends Atipo {

    private $tipo;
    private $min;
    private $max;

    public const TYPE_RANGE="range";
    public const TYPE_NUMBER="number";

    public const MIN_DEFAULT_0=0;
    public const MAX_5=5;
    public const MAX_10=10;
    public const MAX_15=15;

    public function __construct($valor,$name,$tipo,$min,$max) {
        parent::__construct($valor,$name);
        $this->tipo = $tipo;
        $this->min = $min;
        $this->max = $max;
    }

    function validarEspecifico ($valor) {
        if ($valor>=$this->min && $valor<=$this->max){
            return true;
        }else{
            $this->error="Fuera del rango permitido, debe estar entre $this->min y $this->max (ambos incluidos).";
            return false;
        }   
    }

    function pintar() {
        echo "<label for='$this->name'>$this->name</label>";
        echo "<input type='$this->tipo' name='$this->name' min='$this->min' max='$this->max' value='$this->valor' placeholder='$this->min - $this->max'>";
        $this->imprimirError();
    }
}
?>