<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");
if(isset($_GET["id"])){
    $consultacliente = mysqli_query($basededatos,'SELECT * FROM cliente WHERE ID_CLIENTE='.$_GET["id"]);
    $cliente = mysqli_fetch_assoc($consultacliente);//obtenemos un array asociativo de la consulta(un array con indices iguales a la base de datos)
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //al presionar boton actualizar
    echo "<script>alert('cliente actualizado')</script>";
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
<?php include("../barralateral.html") ?>
    <form method="POST" class="conenedordeagregador">
        <h1>Modificar Cliente</h1>
        <input type="text" placeholder="nombre" name="nombre" value="<?php echo $cliente["Nombre"] ?>">

        <input type="number" placeholder="Cedula" name="cedula" value="<?php echo $cliente["Cédula"] ?>">

        <p>Fecha de nacimiento:</p>
        <input type="date" name="fechanac" value="<?php echo $cliente["Fecha_de_Nacimiento"] ?>">
        <input placeholder="Deuda" type="number" name="deuda" value="<?php echo $cliente["Deuda"] ?>">
        <input type="number" placeholder="contacto" name="contacto" value="<?php echo $cliente["Contacto"] ?>">
        <input type="number" placeholder="RUT" name="rut" <?php echo $cliente["RUT"] ?>>
        <input type="submit" value="Actualizar">
    </form>
</body>
</html>