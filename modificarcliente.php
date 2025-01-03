<?php
include_once("chequeodelogin.php");
include_once("coneccionBD.php");
include_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["rut"] != "") { //si see ingresó un rut lo cargará
        mysqli_query($basededatos, 'UPDATE `Cliente` SET `Cédula` = "' . $_POST["cedula"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_de_Nacimiento` = "' . $_POST["fechanac"] . '", `Contacto` = "' . $_POST["contacto"] . '", `RUT` = "' . $_POST["rut"] . '" WHERE `ID_CLIENTE` = ' . $_GET["id"]);
        $opcion="clienteconrutactualizado";
    } else { //si no se ingresa un rut carga todos menos el rut(esto para que cargue su valor por defecto ("no tiene"))
        mysqli_query($basededatos, 'UPDATE `Cliente` SET `Cédula` = "' . $_POST["cedula"] . '", `Nombre` = "' . $_POST["nombre"] . '", `Fecha_de_Nacimiento` = "' . $_POST["fechanac"] . '", `Contacto` = "' . $_POST["contacto"] . '",`RUT` = null WHERE `ID_CLIENTE` = ' . $_GET["id"]);
        $opcion="clienteactualizado";
    }
} else {
    $opcion = "";
}

if (isset($_GET["id"])) {
    $consultacliente = mysqli_query($basededatos, 'SELECT * FROM Cliente WHERE ID_CLIENTE=' . $_GET["id"]);
    if (mysqli_num_rows($consultacliente) == 0) {
        header("Location:clientes.php");
        die();
    }
    $cliente = mysqli_fetch_assoc($consultacliente); //obtenemos un array asociativo de la consulta(un array con indices iguales a la base de datos sirve unicamente cuando obtenemos una fila sola)
} else {
    header("Location:clientes.php");
    die();
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include_once("css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal 
    ?>
    <link rel="shortcut icon" href="imagenes/icons/modclientes.png" type="image/x-icon">


    <script src="LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="LIBRERIAS/sweetalert/sweetalert2.css">
    
</head>

<body>
    <form method="POST" class="formularios">
        <h1>Modificar Cliente</h1>
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="nombre" name="nombre" id="nombre" value="<?php echo $cliente['Nombre']; ?>">

        <label for="cedula">Cédula</label>
        <input type="text" placeholder="Cedula" inputmode="numeric" minlength="6" maxlength="9" pattern="[0-9]{6,9}" title="*Debes ingresar una Cédula valida" name="cedula" id="cedula" value="<?php echo $cliente['Cédula']; ?>" min="100000" max="99999999">

        <label for="fechanac">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac" max="2019-12-31" min="1940-12-31" value="<?php echo $cliente['Fecha_de_Nacimiento']; ?>">

        <label for="contacto">Contacto</label>
        <input type="text" placeholder="contacto" name="contacto" id="contacto" value="<?php echo $cliente['Contacto']; ?>">

        <label for="rut">RUT</label>
        <input type="text" placeholder="RUT" inputmode="numeric" minlength="7" maxlength="12" pattern="[0-9]{7,12}" title="*Debes ingresar un RUT valido" name="rut" id="rut"  value="<?php if($cliente['RUT']!="no tiene"){echo $cliente['RUT'];}  ?>">

        <input type="submit" value="Actualizar">

    </form>
    <a href="clientes.php" id="reg">Regresar</a>
</body>

</html>
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {; //las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
    case 'clienteactualizado';
        mostraraviso("cliente modificado con éxito", $colorfondo, $colorprincipal);
        break;
    case 'clienteconrutactualizado';
        mostraraviso("cliente con rut modificado con éxito",$colorfondo,$colorprincipal);
        break;
}
?>