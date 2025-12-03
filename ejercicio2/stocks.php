<?php
require_once('funcionDB.php');
// aquí cargo la tabla base
$tabla = getStocks();
try {
    if (isset($_POST['compra'])) {
        $producto = $_POST['producto'];
        $tienda = $_POST['tienda'];
        $sqlUpdate = "update stock set unidades = unidades+1 where producto = ?  AND tienda = ?;";
        $stmt = $dwes->prepare($sqlUpdate);
        $stmt->bindParam(1, $producto);
        $stmt->bindParam(2, $tienda);

        $stmt->execute();
        // vuelvo a llamar a la función para que la tabla 
        // se muestre correctamente sin hacer refresh
        $tabla = getStocks();
    }
} catch (PDOException $e) {
    echo "Error al actualizar la compra: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <table border="1">
        <tr>
            <th>Nombre Producto</th>
            <th>Código de tienda</th>
            <th>Nombre de la tienda</th>
            <th>Unidades del producto</th>
            <th>Acción</th>
        </tr>
        <?php
        if ($tabla) {
            while ($fila = $tabla->fetch()) {
                echo "<tr>";
                echo "<td>" . $fila['nombre_corto'] . "</td>";
                echo "<td>" . $fila['tienda'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['unidades'] . "</td>";
                echo "<td>";
                if ($fila['unidades'] < 6) {

                    echo "<form action='stocks.php' method='post'>";
                    echo "<label for=''></label>";
                    echo "<input type='hidden' name='producto' value=" . $fila['producto'] . ">";
                    echo "<input type='hidden' name='tienda' value=" . $fila['tienda'] . ">";
                    echo "<button type='submit' name='compra'>compra</button>";
                    echo "</form>";
                }
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>


</body>

</html>