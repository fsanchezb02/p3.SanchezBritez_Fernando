<?php
require_once('conexion.php');
$reusltadoFamilia = null;
$resultadoTabla = null;
$sqlFamilia = "select cod, nombre from familia";
$resultadoFamilia = $dwes->query($sqlFamilia);
$resultadoFamilia->execute();
try {
    if (isset($_POST['familia']) && isset($_POST['enviar'])) {

        $familia = $_POST['familia'];
        $sqlTabla = "SELECT producto.cod, producto.nombre_corto, producto.pvp FROM producto JOIN familia ON producto.familia = familia.cod  WHERE familia.nombre = ?";
        $resultadoTabla = $dwes->prepare($sqlTabla);
        $resultadoTabla->bindParam(1, $familia);
        $resultadoTabla->execute();
    }
} catch (PDOException $e) {
    echo "Error al insertar la compra: " . $e->getMessage();
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
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="familia">Familia:</label>
        <select name="familia">
            <?php
            while ($fila = $resultadoFamilia->fetch()) {
                echo "<option value='" . $fila['nombre'] . "'>" . $fila['nombre'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="enviar">Mostrar productos</button>
    </form>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>PVP</th>
        </tr>
        <?php
        if ($resultadoTabla) {
            while ($fila = $resultadoTabla->fetch()) {
                echo "<tr>";
                echo "<td>" . $fila['nombre_corto'] . "</td>";
                echo "<td>" . number_format($fila['pvp'], 2, ",", ".") . " euros." . "</td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>

</html>