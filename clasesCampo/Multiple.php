<?php

namespace clasesCampo;

class Multiple extends Atipo
{
    private $arr = [];
    private $tipo;

    public const TYPE_CHECKBOX = 0;
    public const TYPE_SELECT = 1;
    public const TYPE_RADIO = 2;

    public function __construct($valor, $name, $tipo, $arr){
        parent::__construct($valor,$name);
        $this->tipo = $tipo;
        foreach ($arr as $atributo){
            array_push($this->arr, $atributo);
        }
    }

    public function getTipo() { return $this->tipo; }

    public function validarEspecifico($value){
        $esValido = true;
        //si es string, es SELECT o RADIO
        if (is_string($value)){
            //el select devuelve un único String, comprobamos que ese String devuelto esté en el array con el que se inicializó
            if (in_array($value, $this->arr)) {
                $esValido = true;
                $this->error = "";
            }else{
                $esValido = false;
                $this->error = "¡No modifiques los valores de la lista!";
            }
            return $esValido;
        //si es array, es CHECKBOX
        }else {
            //si uno de los valores del checkbox no es válido, la validación devuelve false
            foreach ($value as $valor) {
                if (!(in_array($valor, $this->arr)))
                    $esValido = false;
            }
            $esValido ? $this->error = "" : $this->error = "¡No modifiques los valores del checkbox!";
            return $esValido;
        }
    }


    public function pintar(){
        echo "<div>";

        //print CHECKBOX
        if ($this->tipo == self::TYPE_CHECKBOX) {
            echo "<h4 class='tituloCampo'>".$this->getName()."</h4>";
            $checked ="";
            foreach ($this->arr as $value) {
                //por cada input checkbox, comprueba que el valor NO ESTÉ MARCADO
                if(!empty($this->getValor()))
                    //si no lo está, no lo marca, si lo está lo marca (check)
                    (in_array($value, $this->getValor())) ? $checked = "checked" : $checked = "";

                echo "<label for='".$value."'>$value</label> <input type='checkbox' id='$value' name='".$this->getName()."[]' value='$value' $checked >";
            }
        //print SELECT
        }else if($this->tipo == self::TYPE_SELECT){
            echo "<label for='".$this->getName()."'>".$this->getName().":</label><br>";
            echo "<select id='".$this->getName()."' name='".$this->getName()."'>";
            $selected = "";
            foreach ($this->arr as $value) {
                //comprueba que esté seleccionado y lo deja seleccionado si lo estaba
                ($this->getValor() == $value) ? $selected = "selected" : $selected = "";
                echo "<option value='$value' $selected > $value </option>";
            }
            echo '</select>';
        //print RADIO
        }else{
            echo "<h4 class='tituloCampo'>".$this->getName()."</h4>";
            $checked ="";
            foreach ($this->arr as $value) {
                //comprueba que esté seleccionado y lo deja seleccionado si lo estaba
                ($this->getValor() == $value) ? $checked = "checked" : $checked = "";
                echo "<input type='radio' id='$value' name='".$this->getName()."' value='$value' $checked>";
                echo "<label for='$value'>$value</label><br>";
            }
        }

        echo "</div>";
        //error personalizado impreso debajo del div
        $this->imprimirError();
    }
}

?>