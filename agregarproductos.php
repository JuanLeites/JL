<?php
include("chequeodelogin.php");
include("coneccionBD.php");
$ivas =  mysqli_query($basededatos, 'SELECT * FROM iva ');
$categorias = mysqli_query($basededatos, 'SELECT * FROM categoria ');
//$medida = mysqli_query($basededatos, 'SELECT * FROM medida ');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["precio"]) && isset($_POST["codbarras"]) && isset($_POST["descripcion"]) && isset($_POST["marca"])&&isset($_POST["cantidad"])&&isset($_POST["cantidadaviso"])&&isset($_POST["ID_CATEGORIA"])&&isset($_POST["ID_IVA"])) {
        if ($_POST["nombre"] != "" && $_POST["precio"] != "" && $_POST["codbarras"] != "" && $_POST["descripcion"] != "" && $_POST["marca"] != "" && $_POST["cantidad"] != "" && $_POST["cantidadaviso"] != "" && $_POST["ID_CATEGORIA"] != "" && $_POST["ID_IVA"]!= ""){
            #mysqli_query($basededatos, 'INSERT INTO producto (nombre, cedula, fecha_de_nacimiento, contacto) VALUES ("' . $_POST["nombre"] . '","' . $_POST["precio"] . '","' . $_POST["fechanac"] . '","' . $_POST["contacto"] . '");');
            echo "<script>alert('Producto Redistrado Registrado')</script>";
        }else{
            echo "<script>alert('debe ingresar datos')</script>";
        }
    }else{
        echo "<script>alert('los datos no fueron seteados')</script>";
    }
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agregar productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <form method="POST" class="conenedordeagregador" enctype="multipart/form-data">
        <h1>Agregar un Producto</h1>
        <input type="text" placeholder="Nombre" name="nombre">
        <input tyoe="float" placeholder="Precio Neto" name="precio">
        <input type="number" placeholder="codigo de barras" name="codbarras">
        <input type="text" placeholder="descripcion" name="descripcion">
        <input type="text" placeholder="marca" name="marca">
        <input type="number" placeholder="cantidad" name="cantidad">
        <input type="number" placeholder="cantidad de aviso" name="cantidadaviso">
        <select id="categoria" name="ID_CATEGORIA" required>
            <option>categoria</option>
            <?php foreach($categorias as $categoria){
                echo "<option value='".$categoria['ID_CATEGORIA']."'>".$categoria['titulo']."</option>";
            }?>
        </select>
        <select id="iva" name="ID_IVA" required>
            <option>iva</option>
            <?php foreach($ivas as $iva){
                echo "<option value='".$iva['ID_IVA']."'>".$iva['tipo']."</option>";
            }?>
        </select>
        
        <select id="medida">

        </select>
        <input type="file" name="foto">
        <input type="submit">
    </form>

    <?php include("barralateral.html") ?>
</body>

</html>