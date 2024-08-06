<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
if (isset($_GET["id"])) {
    $consultacliente = mysqli_query($basededatos, 'SELECT * FROM cliente WHERE ID_CLIENTE=' . $_GET["id"]);
    $cliente = mysqli_fetch_assoc($consultacliente); //obtenemos un array asociativo de la consulta(un array con indices iguales a la base de datos)
} else {
    header("Location:clientes.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //al presionar boton actualizar
    echo "<script>alert('Cliente actualizado')</script>";
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cliente</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <form method="POST" class="conenedordeagregador">
        <h1>Modificar Cliente</h1>
        <label for="nombre">Nombre</label>
        <input type="text" placeholder="nombre" name="nombre" id="nombre" value="<?php echo $cliente['Nombre']; ?>">

        <label for="cedula">Cédula</label>
        <input type="number" placeholder="Cedula" name="cedula" id="cedula" value="<?php echo $cliente['Cédula']; ?>">

        <label for="fechanac">Fecha de Nacimiento</label>
        <input type="date" name="fechanac" id="fechanac" value="<?php echo $cliente['Fecha_de_Nacimiento']; ?>">

        <label for="deuda">Deuda</label>
        <input placeholder="Deuda" type="number" name="deuda" id="deuda" value="<?php echo $cliente['Deuda']; ?>">

        <label for="contacto">Contacto</label>
        <input type="number" placeholder="contacto" name="contacto" id="contacto" value="<?php echo $cliente['Contacto']; ?>">

        <label for="rut">RUT</label>
        <input type="number" placeholder="RUT" name="rut" id="rut" value="<?php echo $cliente['RUT']; ?>">

        <input type="submit" value="Actualizar">

    </form>
    <a href="../clientes.php" id="reg">regresar</a>
</body>

</html>