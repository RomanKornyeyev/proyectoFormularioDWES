<?php
namespace clasesCampo;

class Texto extends Atipo
{
    private $longitud;
    //constantes públicas para poder utilizarse fuera
    public const LONG_NOMBRE = 25;
    public const LONG_DESCRIPCION = 500;
    public const LIMITE_LONG_TEXTAREA = 80; //limite para input tipo texto, desde estos chars es textarea

    public function __construct($valor, $name, $longitud){
        parent::__construct($valor,$name);
        $this->longitud = $longitud;
    }
    
    function validarEspecifico($cadena){
        //letras mayus y minus, números, comas, puntos, exlamaciones e interrogaciones, guiones y barras bajas
        $pattern = "/^[a-zA-Z0-9\s\,\.\¿\?\¡\!\_\-]{1," . $this->longitud . "}$/";

        //si el valor (texto introducido por el user) limpiado con cleanData coincide con el patrón, devuelve true
        //en caso contrario, devuelve false y carga error con el mensaje personalizado
        if (preg_match($pattern, $this->cleanData($cadena))){
            return true;
        }else {
            $this->error = "No se admiten carácteres especiales y el tamaño máximo es de $this->longitud caracteres<br>";
            return false;
        }
    }

    function pintar(){
        //label
        echo "<label for='" . $this->name . "'>" . $this->name . "</label>";
        echo "<br>";

        //si supera LIMITE_LONG_TEXTAREA (80 chars) pinta un textarea, si no, un input tipo texto
        if ($this->longitud >= self::LIMITE_LONG_TEXTAREA) 
            echo "<textarea id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->name...' rows='10' cols='50'>" . $this->valor . "</textarea>";
        else
            echo "<input type='text' id='" . $this->name . "' name='" . $this->name . "' placeholder='$this->name...' value='" . $this->valor . "'>";

        echo "<br>";
        $this->imprimirError();
    }
 
    //limpieza de carácteres especiales HTML para evitar cross-site scripting
    function cleanData($data){
        if (is_string($data)) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        } else {
            return $data;
        }
    }

}

?>