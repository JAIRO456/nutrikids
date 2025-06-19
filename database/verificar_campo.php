<?php
require_once('conex.php');
$conex = new Database;
$con = $conex->conectar();

try {
    // Verificar si el campo archivo existe
    $sql = "DESCRIBE pedidos";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $campos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Estructura de la tabla pedidos:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Llave</th><th>Default</th><th>Extra</th></tr>";
    
    $campo_archivo_existe = false;
    foreach ($campos as $campo) {
        echo "<tr>";
        echo "<td>" . $campo['Field'] . "</td>";
        echo "<td>" . $campo['Type'] . "</td>";
        echo "<td>" . $campo['Null'] . "</td>";
        echo "<td>" . $campo['Key'] . "</td>";
        echo "<td>" . $campo['Default'] . "</td>";
        echo "<td>" . $campo['Extra'] . "</td>";
        echo "</tr>";
        
        if ($campo['Field'] == 'archivo') {
            $campo_archivo_existe = true;
        }
    }
    echo "</table>";
    
    if ($campo_archivo_existe) {
        echo "<p style='color: green;'>✅ El campo 'archivo' ya existe en la tabla pedidos.</p>";
    } else {
        echo "<p style='color: red;'>❌ El campo 'archivo' NO existe en la tabla pedidos.</p>";
        echo "<p>Ejecutando comando para agregar el campo...</p>";
        
        // Agregar el campo
        $sql_add = "ALTER TABLE pedidos ADD COLUMN archivo VARCHAR(255) NULL AFTER id_estado";
        $con->exec($sql_add);
        echo "<p style='color: green;'>✅ Campo 'archivo' agregado exitosamente.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<p><a href='../acudiente/asignacion.php'>Volver a asignación</a></p>";
?> 