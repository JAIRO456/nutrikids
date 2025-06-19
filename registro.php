<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "nutrikids2";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("<div class='error'>Error de conexión: " . $conn->connect_error . "</div>");
        }

        function generatePassword() {
            $minusculas = 'abcdefghijklmnopqrstuvwxyz';
            $mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numeros = '0123456789';
            $especiales = '#_-+';
            // $especiales = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    
            $todosCaracteres = $minusculas . $mayusculas . $numeros . $especiales;
    
            $contrasena = $minusculas[rand(0, strlen($minusculas) - 1)];
            $contrasena .= $mayusculas[rand(0, strlen($mayusculas) - 1)];
            $contrasena .= $numeros[rand(0, strlen($numeros) - 1)];
            $contrasena .= $especiales[rand(0, strlen($especiales) - 1)];
    
            for ($i = strlen($contrasena); $i < 8; $i++) {
                $contrasena .= $todosCaracteres[rand(0, strlen($todosCaracteres) - 1)];
            }
    
            return $contrasena;
        }

        // Generar la contraseña antes de encriptarla y mostrarla
        $password_original = generatePassword();

        $documento = $conn->real_escape_string($_POST['documento']);
        $nombre = $conn->real_escape_string($_POST['nombre']);
        $apellido = $conn->real_escape_string($_POST['apellido']);
        $email = $conn->real_escape_string($_POST['email']);
        $telefono = $conn->real_escape_string($_POST['telefono']);
        // Encriptar la misma contraseña generada y mostrada
        $password = password_hash($password_original, PASSWORD_BCRYPT);
        $id_rol = $conn->real_escape_string($_POST['id_rol']);
        $id_estado = $conn->real_escape_string($_POST['id_estado']);
        $imagen = isset($_FILES['imagen']) ? $_FILES['imagen']['name'] : null;

        $sql = "INSERT INTO usuarios (documento, nombre, apellido, email, telefono, password, imagen, id_rol, id_estado) 
                VALUES ('$documento', '$nombre', '$apellido', '$email', '$telefono', '$password', " . ($imagen ? "'$imagen'" : "NULL") . ", '$id_rol', '$id_estado')";

        if ($conn->query($sql) === TRUE) {
            echo "<div class='message'>Registro exitoso:<br>";
            echo "Nombre: $nombre<br>";
            echo "Apellido: $apellido<br>";
            echo "Email: $email<br>";
            echo "Teléfono: $telefono<br>";
            echo "Contraseña: $password_original<br>";
            echo "Imagen: " . ($imagen ? $imagen : "No subida") . "<br>";
            echo "ID Rol: $id_rol<br>";
            echo "ID Estado: $id_estado</div>";
        } else {
            echo "<div class='error'>Error al registrar: " . $conn->error . "</div>";
        }

        $conn->close();
    }
    ?>