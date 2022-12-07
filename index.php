<?php
//autoload 
spl_autoload_register(function ($class) {

    $classPath = realpath("./");
    $file = str_replace('\\', '/', $class);
    $include = "$classPath/${file}.php";
    require($include);

});

// ----------------------------------------------
//Herramientas para debugging!
echo "Valores añadidos al post: ";
print_r($_POST); 
echo ("<hr>"); 
// ----------------------------------------------

$serie = new clasesPadre\Formulario($_POST);

if ($serie->validarGlobal()) {
    //importante guardar la lista del objeto y no $_POST, para guardar solamente valores de los input
    //y así evitar guardar "Enviar" del input submit
    $serie->guardar($serie->getValores); //hacer guardar; que guarde los valores en un archivo de texto.
    header("Location: tablaSeries.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Estilos -->
    <link rel="stylesheet" href="styles/index.css">
    <title>SerieLog</title>
</head>

<div class="formulario-wrapper">
<h1>Introduce los datos de tu serie</h1>

    <?php $serie->pintarGlobal(); ?>

    <a href="tablaSeries.php">Ver series registradas</a>

</div>
</body>

</html>