<?php


namespace clasesMain;

use clasesCampo\Texto;
use clasesCampo\Numero;
use clasesCampo\Multiple;

class Formulario
{

    private $valores = array();
    //private $esValida = true;

    public function __construct($post){
        //Si no tenemos post, inicializo cada valor como null para no tener problemas.
        //Si tenemos post, inicializo cada valor con el valor del post. (Ese Jorge ahi!)
        $nombre = isset($post['nombre']) ? $post['nombre'] : null; // TEXTO
        $resena = isset($post['reseña']) ? $post['reseña'] : null;  // TEXTO
        $valoracion = isset($post['valoracion']) ? $post['valoracion'] : null; // NÚMERO
        $vecesVista = isset($post['vecesVista']) ? $post['vecesVista'] : null; // NÚMERO
        $generos = isset($post['generos']) ? $post['generos'] : null; // MÚLTIPLE
        $emision = isset($post['emision']) ? $post['emision'] : null; // MÚLTIPLE
        $plataforma = isset($post['plataforma']) ? $post['plataforma'] : null; // MÚLTIPLE


        //Estructura del formulario.
        array_push($this->valores, new Texto       ($nombre,"nombre", Texto::LONG_NOMBRE));
        array_push($this->valores, new Texto       ($resena, "reseña", Texto::LONG_DESCRIPCION));
        array_push($this->valores, new Numero      ($valoracion, "valoracion", Numero::TYPE_RANGE, Numero::MIN_DEFAULT_0, Numero::MAX_10));
        array_push($this->valores, new Numero      ($vecesVista, "vecesVista", Numero::TYPE_NUMBER, Numero::MIN_DEFAULT_0, Numero::MAX_10));
        array_push($this->valores, new Multiple    ($generos, "generos", Multiple::TYPE_CHECKBOX, ["Comedia", "Terror", "Misterio", "Suspense", "Acción", "Otros"]));
        array_push($this->valores, new Multiple    ($emision, "emision", Multiple::TYPE_RADIO, ["Sí", "No"]));
        array_push($this->valores, new Multiple    ($plataforma, "plataforma", Multiple::TYPE_SELECT, ["Netflix","HBO","Piratilla","Otros"]));
    }

    public function getValores() { return $this->valores; }

    public function validarGlobal(){
        //valida SOLAMENTE SI SE HA ENVIADO EL FORMULARIO
        //así en la primera carga de la página no sale ningún error
        if (isset($_POST['submit'])) { 
            $val = true; //de serie la validación es true
            foreach ($this->valores as $valor) {
                if (!$valor->validar($valor->getValor())) {
                    $val = false; //si SOLAMENTE UN valor no ha sido validado, la validación devuelve false
                }
            }
            return $val;
        }
    }
    
    //pintar todo el formulario
    public function pintarGlobal(){
        echo "<form action='index.php' method='post' class='formulario'>";
        foreach ($this->valores as $valor) {
            echo "<div class='elemento'>";
            $valor->pintar();
            echo "</div>";
        }
        echo "<div class='elemento'><input type='submit' name='submit' value='Enviar' class='submit'></div></form>";
    }

    //guardado en BD
    public function guardar($post){

        // Path to the "DB"
        $file = 'bbdd.txt';

        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new series to the file
        foreach ($post as $key => $value) {
            //GUARDA TODOS LOS PARÁMETROS MENOS EL SUBMIT (botón submit)
            if ($key != 'submit' ) {
                //si no es checkbox (no es un array, recibe una opción)
                if (!is_array($value)) {
                    $current .= $value . ";";
                //si es checkbox (es un array, recibe varias opciones)
                } else {
                    foreach ($post['generos'] as $genero) {
                        $current .= $genero." ";
                    }
                    $current .= ";";
                }
            } 
        }
        $current .= "\n";

        // Write the contents back to the file
        file_put_contents($file, $current);

    }



}


?>