<?php
include("chequeodelogin.php");
include("coneccionBD.php");
include("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (isset($_POST["premio"]) && isset($_POST["cantidad"])) {
    if ($_POST["premio"] != "" && $_POST["cantidad"]!="") {
        mysqli_query($basededatos, 'INSERT INTO sorteo (Premio, Cantidad) VALUES ("' . $_POST["premio"] . '" , "' . $_POST["cantidad"].'");');
        $opcion="sorteorealizado";
    } else {
        $opcion="datosincompletos";
    }
} else {
    echo $opcion="datosnoseteados";
}
}else{
    $opcion="";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear un sorteo</title>
    <link rel="stylesheet" href="css/style.css">

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <?php include("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  ?>

    <link rel="shortcut icon" href="imagenes/icons/sorteo.png" type="image/x-icon">

</head>

<body>

    <form method="POST" class="formularios">
        <h1>Crear un Sorteo</h1>
            <div class="subcontenedores">
                <label for="premio">Premio</label>
                <input type="text" placeholder="Premio" name="premio" id="premio">

                <label for="cantidad">Cantidad</label>
                <input type="number" min="1" placeholder="Cantidad" name="cantidad" id="cantidad">

        <input type="submit" value="Crear Sorteo">
    </form>
    </div>
    <?php include("barralateral.html") ?>
</body>

</html>

<?php 

// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {
    case 'sorteorealizado';
        mostraraviso("Sorteo Creado con éxito", $colorfondo, $colorprincipal);
        break;
    case 'datosincompletos';
        mostraralerta("Debes de completar todos los campos", $colorfondo, $colorprincipal);
        break;
    case 'datosnoseteados';
        mostraralerta("Los datos no fueron seteados", $colorfondo, $colorprincipal);
        break;
}
?>