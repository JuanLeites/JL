<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    mysqli_query($basededatos, 'UPDATE `Sorteo` SET `Premio` = "' . $_POST["premio"] . '", `Cantidad` = "' . $_POST["cantidad"] . '" WHERE `Sorteo`.`ID_SORTEO` = ' . $_GET["id"]);
    $opcion="sorteomodificado";

} else {
    $opcion = "";
}

if (isset($_GET["id"])) {
    $consultasorteo = mysqli_query($basededatos, 'SELECT * FROM Sorteo WHERE ID_SORTEO=' . $_GET["id"]);
    $sorteo = mysqli_fetch_assoc($consultasorteo); //obtenemos un array asociativo de la consulta(un array con indices iguales a la base de datos sirve unicamente cuando obtenemos una fila sola)
} else {
    header("Location:sorteos.php");
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Sorteo</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal 
    ?>
    <link rel="shortcut icon" href="imagenes/icons/sorteo.png" type="image/x-icon">


    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
    
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Modificar Sorteo</h1>
        <label for="Premio">Premio</label>
        <input type="text" placeholder="Premio" name="premio" id="Premio" value="<?php echo $sorteo['Premio']; ?>" required>

        <label for="cantidad">Cantidad</label>
        <input type="number" placeholder="cantidad" name="cantidad" id="cantidad" value="<?php echo $sorteo['Cantidad']; ?>" min="1" required>

        <input type="submit" value="Actualizar">

    </form>
    <a href="sorteos.php" id="reg">regresar</a>
</body>

</html>
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {; //las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
    case 'sorteomodificado';
        mostraraviso("sorteo modificado con éxito", $colorfondo, $colorprincipal);
        break;
}
?>