<?php


namespace clasesPadre;

use clasesTipo\Texto;
use clasesTipo\Numero;
use clasesTipo\Seleccion;

class Formulario
{

    private $valores = array();
    private $esValida = true;

    public function __construct($post){
        
        //Si no tenemos post, inicializo cada valor como null para no tener problemas.
        //Si tenemos post, inicializo cada valor con el valor del post. (Ese Jorge ahi!)
        $nombre = isset($post['nombre']) ? $post['nombre'] : null; // TEXTO
        $resena = isset($post['reseña']) ? $post['reseña'] : null;  // TEXTO
        $valoracion = isset($post['valoracion']) ? $post['valoracion'] : null; // NÚMERO
        $numeros = isset($post['numeros']) ? $post['numeros'] : null; // NÚMERO

        //Estructura del formulario.
        array_push($this->valores, new Texto       ($nombre,"nombre", Texto::LONG_NOMBRE));
        array_push($this->valores, new Texto       ($resena, "reseña", Texto::LONG_DESCRIPCION));
        array_push($this->valores, new Numero      ($valoracion, "valoracion", Numero::TYPE_RANGE, Numero::MIN_DEFAULT_0, Numero::MAX_5));
        array_push($this->valores, new Numero      ($numeros, "numeros", Numero::TYPE_NUMBER, Numero::MIN_DEFAULT_0, Numero::MAX_5));
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


        $file = 'bbdd.txt';

        // Open the file to get existing content
        $current = file_get_contents($file);

        // Append a new series to the file
        $current .= "<tr>";
        foreach ($post as $key => $value) {
                if ($key != 'generos' && $key != 'submit') {
                    $current .= "<td>" . $value . "</td>\n";
                } else {
                    $current .= "<td>";
                    foreach ($post['generos'] as $genero) {
                        $current .= $genero . " ";
                    }
                    $current .= "</td>";
                }
        }

        $current .= "</tr>";
        // Write the contents back to the file
        file_put_contents($file, $current);

    }



}


?>