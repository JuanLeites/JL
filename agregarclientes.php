<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["cedula"]) && isset($_POST["fechanac"]) && isset($_POST["contacto"])) {
        if ($_POST["nombre"] != "" && $_POST["cedula"] != "" && $_POST["fechanac"] != "") {
            if ($_POST["rut"] != "") { //si see ingresó un rut lo cargará
                mysqli_query($basededatos, 'INSERT INTO Cliente (Cédula, Nombre, Fecha_de_Nacimiento, Contacto,RUT) VALUES ("' . $_POST["cedula"] . '","' . $_POST["nombre"] . '","' . $_POST["fechanac"] . '","' . $_POST["contacto"] . '","' . $_POST["rut"] . '");');
                header("Location:agregarclientes.php?opcion=clienteconrutregistrado");
                die();
            } else { //si no se ingresa un rut carga todos menos el rut(esto para que cargue su valor por defecto ("no tiene"))
                mysqli_query($basededatos, 'INSERT INTO Cliente (Cédula, Nombre, Fecha_de_Nacimiento, Contacto) VALUES ("' . $_POST["cedula"] . '","' . $_POST["nombre"] . '","' . $_POST["fechanac"] . '","' . $_POST["contacto"] . '");');
                header("Location:agregarclientes.php?opcion=clienteregistrado");
                die();
            }
        } else {
            $opcion = "datosincompletos";
            $nombre = $_POST["nombre"];
            $cedula = $_POST["cedula"];
            $fechanac = $_POST["fechanac"];
            $contacto = $_POST["contacto"];
        }
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal 
    ?>

    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="imagenes/icons/modclientes.png" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Agregar Cliente</h1>
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="nombre" name="nombre" id="nombre" <?php if (isset($nombre)) {
                                                                                echo "value='" . $nombre . "'";
                                                                            } ?>>

        <label for="cedula">Cédula</label>
        <input type="number" placeholder="Cedula" name="cedula" id="cedula" min="1000000" max="99999999" <?php if (isset($cedula)) {
                                                                                                                echo "value='" . $cedula . "'";
                                                                                                            } ?>>

        <label for="fechanac">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac" max="2019-12-31" min="1940-12-31" <?php if (isset($fechanac)) {
                                                                                                echo "value='" . $fechanac . "'";
                                                                                            } ?>>

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto" <?php if (isset($contacto)) {
                                                                                    echo "value='" . $contacto . "'";
                                                                                } ?>>

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" name="rut" id="rut">

        <input type="submit" value="Agregar">

    </form>
    <?php include_once("barralateral.html") ?>
</body>

</html>
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
if (isset($opcion)) {
    switch ($opcion) {
        case 'datosincompletos';
            mostraralerta("Debe de completar todos los datos", $colorfondo, $colorprincipal);
            break;
    }
}else if(isset($_GET["opcion"])){
    switch ($_GET["opcion"]) {
        case 'clienteconrutregistrado';
            mostraraviso("Cliente con RUT registrado con éxito", $colorfondo, $colorprincipal);
            break;
        case 'clienteregistrado';
            mostraraviso("Cliente registrado con éxito", $colorfondo, $colorprincipal);
            break;
    }
}
?>