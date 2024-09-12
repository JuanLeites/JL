<?php
include("chequeodelogin.php");
include("coneccionBD.php");
$ivas =  mysqli_query($basededatos, 'SELECT * FROM iva ');
$categorias = mysqli_query($basededatos, 'SELECT * FROM categoría ');
$medidas = mysqli_query($basededatos, 'SELECT * FROM medida ');

if (!file_exists("IMAGENESSOFTWARE")) {
    mkdir("IMAGENESSOFTWARE");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["precio"]) && isset($_POST["codbarras"]) && isset($_POST["descripcion"]) && isset($_POST["marca"]) && isset($_POST["cantidad"]) && isset($_POST["cantidadaviso"]) && isset($_FILES["foto"]) && isset($_POST["ID_IVA"]) && isset($_POST["ID_UNIDAD"]) && isset($_POST["ID_CATEGORIA"])) {
        // if ($_POST["nombre"] != "" && $_POST["precio"] != "" && $_POST["codbarras"] != "" && $_POST["descripcion"] != "" && $_POST["marca"] != "" && $_POST["cantidad"] != "" && $_POST["cantidadaviso"] != "" && $_POST["ID_CATEGORIA"] != "" && $_POST["ID_IVA"] != "" && $_POST["ID_UNIDAD"] != "" &&  $_FILES["foto"]["tmp_name"] != "") {
        if (!file_exists('IMAGENESSOFTWARE/' . $_FILES['foto']['name'])) { //sino existe una imagen con ese nombre la guarda y carga la base de datos.
            mysqli_query($basededatos, 'INSERT INTO producto (Nombre,Precio_Neto,Código_de_Barras,Descripción,Marca,Cantidad,Cantidad_minima_aviso,imagen,ID_IVA,ID_UNIDAD,ID_CATEGORIA) VALUES ("' . $_POST["nombre"] . '","' . $_POST["precio"] . '","' . $_POST["codbarras"] . '","' . $_POST["descripcion"] . '","' . $_POST["marca"] . '","' . $_POST["cantidad"] . '","' . $_POST["cantidadaviso"] . '","' . $_FILES["foto"]["name"] . '","'  . $_POST["ID_IVA"] . '","' . $_POST["ID_UNIDAD"] . '","' . $_POST["ID_CATEGORIA"] . '");');
            move_uploaded_file($_FILES['foto']['tmp_name'], 'IMAGENESSOFTWARE/' . $_FILES['foto']['name']);
            echo "<script>alert('Producto Registrado')</script>";
        } else { //si llegase a existir imagen con ese nombre le pone el codigo de barras a la imagen y la carga asi.
            mysqli_query($basededatos, 'INSERT INTO producto (Nombre,Precio_Neto,Código_de_Barras,Descripción,Marca,Cantidad,Cantidad_minima_aviso,imagen,ID_IVA,ID_UNIDAD,ID_CATEGORIA) VALUES ("' . $_POST["nombre"] . '","' . $_POST["precio"] . '","' . $_POST["codbarras"] . '","' . $_POST["descripcion"] . '","' . $_POST["marca"] . '","' . $_POST["cantidad"] . '","' . $_POST["cantidadaviso"] . '","' . $_POST["codbarras"] . $_FILES["foto"]["name"] . '","'  . $_POST["ID_IVA"] . '","' . $_POST["ID_UNIDAD"] . '","' . $_POST["ID_CATEGORIA"] . '");');
            move_uploaded_file($_FILES['foto']['tmp_name'], 'IMAGENESSOFTWARE/' . $_POST["codbarras"] . $_FILES['foto']['name']);
            echo "<script>alert('Producto Registrado')</script>";
        }
        ////     echo "<script>alert('debe ingresar datos')</script>";
        //  }
    } else {
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

    <form method="POST" class="formularios" enctype="multipart/form-data">
        <h1>Agregar un Producto</h1>

        <div class="contenedordesubcontenedores"><!-- CONTIENE DOS SUBCONTENEDORES, es para ordenar en dos filas -->
            <div class="subcontenedores"><!-- CONTIENE los inputs, es para ordenarlos con estilo -->
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Nombre" name="nombre" id="nombre">

                <label for="precio">Precio Neto</label>
                <input type="float" placeholder="Precio Neto" name="precio" id="precio">

                <label for="codbarras">Código de Barras</label>
                <input type="number" placeholder="codigo de barras" name="codbarras" id="codbarras">

                <label for="descripcion">Descripción</label>
                <input type="text" placeholder="descripcion" name="descripcion" id="descripcion">

                <label for="marca">Marca</label>
                <input type="text" placeholder="marca" name="marca" id="marca">

                <label for="cantidad">Cantidad</label>
                <input type="number" placeholder="cantidad" name="cantidad" id="cantidad">
            </div>

            <div class="subcontenedores">
                <label for="cantidadaviso">Cantidad de Aviso</label>
                <input type="number" placeholder="cantidad de aviso" name="cantidadaviso" id="cantidadaviso">

                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto">

                <label for="iva">IVA</label>
                <select id="iva" name="ID_IVA" required>
                    <option>iva</option>
                    <?php foreach ($ivas as $iva) {
                        echo "<option value='" . $iva['ID_IVA'] . "'>" . $iva['Tipo'] . "</option>";
                    } ?>
                </select>

                <label for="medida">Unidad de Medida</label>
                <select id="medida" name="ID_UNIDAD" required>
                    <option>unidad de medida</option>
                    <?php foreach ($medidas as $medida) {
                        echo "<option value='" . $medida['ID_UNIDAD'] . "'>" . $medida['Unidad'] . "</option>";
                    } ?>
                </select>

                <label for="categoria">Categoría</label>
                <select id="categoria" name="ID_CATEGORIA" required>
                    <option>categoria</option>
                    <?php foreach ($categorias as $categoria) {
                        echo "<option value='" . $categoria['ID_CATEGORIA'] . "'>" . $categoria['Título'] . "</option>";
                    } ?>
                </select>
            </div>
        </div>

        <input type="submit" value="agregar">
    </form>

    <?php include("barralateral.html") ?>
</body>

</html>