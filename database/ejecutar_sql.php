<?php
require_once('conex.php');
$conex = new Database;
$con = $conex->conectar();

try {
    // Agregar campo archivo a la tabla pedidos
    $sql = "ALTER TABLE pedidos ADD COLUMN archivo VARCHAR(255) NULL AFTER id_estado";
    $con->exec($sql);
    echo "Campo 'archivo' agregado exitosamente a la tabla pedidos.<br>";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "El campo 'archivo' ya existe en la tabla pedidos.<br>";
    } else {
        echo "Error: " . $e->getMessage() . "<br>";
    }
}

echo "Proceso completado.";
?> 