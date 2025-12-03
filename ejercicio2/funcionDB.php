<?php
// establezco la conexión con la base de datos
require_once 'conexion.php';

// Funcion getStocks() servirá para cargar los datos
// de la tabla sin tener que 
// hacer refresh o volver a cargar la página
// aun actualizando los datos
function getStocks()
{
    global $dwes;
    try {
        $sql = "select producto.nombre_corto, stock.tienda, tienda.nombre, stock.unidades, stock.producto from producto join stock on producto.cod = stock.producto join tienda on tienda.cod = stock.tienda;";
        $resultado = $dwes->query($sql);
        return $resultado;
    } catch (Exception $e) {
        return "Error al mostrar la tabla: " . $e->getMessage();
    }
}
