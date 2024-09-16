<?php
include("../chequeodelogin.php");
include("../coneccionBD.php");



if ($_SERVER["REQUEST_METHOD"] == "POST") { //arriba asi lo ingresa apenas cargue la pagina si el formulario fue enviado
    if($_FILES["foto"]["tmp_name"] != ""){//si se selecciona una foto en el input type file
        @unlink("../IMAGENESSOFTWARE/".$_POST["rutavieja"]);//borra la foto anterior si es que la encuentra, sino da error pero lo escondemos con un arroba
        move_uploaded_file($_FILES['foto']['tmp_name'], '../IMAGENESSOFTWARE/' . $_FILES['foto']['name']);//carga la nueva foto en la carpeta
        mysqli_query($basededatos, 'UPDATE `producto` SET `imagen`="'.$_FILES['foto']['name'].'",`Nombre` = "' . $_POST["nombre"] . '", `Precio_Neto` = "' . $_POST["precio"] . '", `Código_de_Barras` = "' . $_POST["codbarras"] . '", `Descripción` = "' . $_POST["descripcion"] . '", `Marca` = "' . $_POST["marca"] . '", `Cantidad_minima_aviso` = "' . $_POST["cantidadaviso"] . '", `ID_IVA` = "' . $_POST["ID_IVA"] . '", `ID_UNIDAD` = "' . $_POST["ID_UNIDAD"] . '", `ID_CATEGORIA` = "' . $_POST["ID_CATEGORIA"] . '" WHERE `producto`.`ID_Producto` =' . $_GET["id"]);
        echo "<script>alert('Producto actualizado, con foto actualiazda')</script>";
    }else{
        mysqli_query($basededatos, 'UPDATE `producto` SET `Nombre` = "' . $_POST["nombre"] . '", `Precio_Neto` = "' . $_POST["precio"] . '", `Código_de_Barras` = "' . $_POST["codbarras"] . '", `Descripción` = "' . $_POST["descripcion"] . '", `Marca` = "' . $_POST["marca"] . '", `Cantidad_minima_aviso` = "' . $_POST["cantidadaviso"] . '", `ID_IVA` = "' . $_POST["ID_IVA"] . '", `ID_UNIDAD` = "' . $_POST["ID_UNIDAD"] . '", `ID_CATEGORIA` = "' . $_POST["ID_CATEGORIA"] . '" WHERE `producto`.`ID_Producto` =' . $_GET["id"]);
        echo "<script>alert('Producto actualizado')</script>";
    }

}

$ivas =  mysqli_query($basededatos, 'SELECT * FROM iva ');
$categorias = mysqli_query($basededatos, 'SELECT * FROM categoría ');
$medidas = mysqli_query($basededatos, 'SELECT * FROM medida ');

if (isset($_GET["id"])) {
    $consultaproducto = mysqli_query($basededatos, 'SELECT * FROM producto WHERE ID_PRODUCTO=' . $_GET["id"]);
    $producto = mysqli_fetch_assoc($consultaproducto);
} else {
    header("Location:productos.php");
}



?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../imagenes/icons/modproductos.png" type="image/x-icon">
</head>

<body>
    <form method="POST" class="formularios" enctype="multipart/form-data">
        <h1>Modificar un Producto</h1>
        <div class="contenedordesubcontenedores">
            <div class="subcontenedores">
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Nombre" name="nombre" id="nombre" value="<?php echo $producto['Nombre']; ?>">

                <label for="precio">Precio Neto</label>
                <input type="float" placeholder="Precio Neto" name="precio" id="precio" value="<?php echo $producto['Precio_Neto']; ?>">

                <label for="codbarras">Código de Barras</label>
                <input type="number" placeholder="codigo de barras" name="codbarras" id="codbarras" value="<?php echo $producto['Código_de_Barras']; ?>">

                <label for="descripcion">Descripción</label>
                <input type="text" placeholder="descripcion" name="descripcion" id="descripcion" value="<?php echo $producto['Descripción']; ?>">

                <label for="marca">Marca</label>
                <input type="text" placeholder="marca" name="marca" id="marca" value="<?php echo $producto['Marca']; ?>">
            </div>

            <div class="subcontenedores">
                <label for="cantidad">Cantidad</label>
                <input type="number" placeholder="cantidad" name="cantidad" id="cantidad" value="<?php echo $producto['Cantidad']; ?>">

                <label for="cantidadaviso">Cantidad de Aviso</label>
                <input type="number" placeholder="cantidad de aviso" name="cantidadaviso" id="cantidadaviso" value="<?php echo $producto['Cantidad_minima_aviso']; ?>">

                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*"><!-- le establecemos un value con el nombre de la foto que ya tenia cargada -->
                <input type="text" name="rutavieja" value="<?php echo $producto['imagen']; ?>" style="display:none"><!-- creamos este elemento para pasarle la ruta de la foto vieja por formulario -->


                <label for="iva">IVA</label>
                <select id="iva" name="ID_IVA" value="<?php echo $producto['ID_IVA']; ?>">
                    <?php foreach ($ivas as $iva) {
                        if ($iva['ID_IVA'] == $producto['ID_IVA']) {
                            echo "<option selected value='" . $iva['ID_IVA'] . "'>" . $iva['Tipo'] . "</option>";
                        } else {
                            echo "<option value='" . $iva['ID_IVA'] . "'>" . $iva['Tipo'] . "</option>";
                        }
                    } ?>
                </select>

                <label for="medida">Unidad de Medida</label>
                <select id="medida" name="ID_UNIDAD" value="<?php echo $producto['ID_UNIDAD']; ?>">
                    <?php foreach ($medidas as $medida) {
                        if ($medida['ID_UNIDAD'] == $producto['ID_UNIDAD']) {
                            echo "<option selected value='" . $medida['ID_UNIDAD'] . "'>" . $medida['Unidad'] . "</option>";
                        } else {
                            echo "<option value='" . $medida['ID_UNIDAD'] . "'>" . $medida['Unidad'] . "</option>";
                        }
                    } ?>
                </select>

                <label for="categoria">Categoría</label>
                <select id="categoria" name="ID_CATEGORIA" value="<?php echo $producto['ID_CATEGORIA']; ?>">
                    <?php foreach ($categorias as $categoria) {
                        if ($categoria['ID_CATEGORIA'] == $producto['ID_CATEGORIA']) {
                            echo "<option selected value='" . $categoria['ID_CATEGORIA'] . "'>" . $categoria['Título'] . "</option>";
                        } else {
                            echo "<option value='" . $categoria['ID_CATEGORIA'] . "'>" . $categoria['Título'] . "</option>";
                        }
                    } ?>
                </select>
            </div>
        </div>

        <input type="submit" value="Actualizar">
    </form>
    <a href="../productos.php" id="reg">regresar</a>
</body>

</html>