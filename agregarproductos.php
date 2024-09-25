<?php
include("/LUPF/chequeodelogin.php");
include("/LUPF/coneccionBD.php");
include("/LUPF/funciones.php");

$ivas =  mysqli_query($basededatos, 'SELECT * FROM iva ');
$categorias = mysqli_query($basededatos, 'SELECT * FROM categoría ');
$medidas = mysqli_query($basededatos, 'SELECT * FROM medida ');

if (!file_exists("/LUPF/IMAGENESSOFTWARE")) {
    mkdir("/LUPF/IMAGENESSOFTWARE");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["precio"]) && isset($_POST["codbarras"]) && isset($_POST["descripcion"]) && isset($_POST["marca"]) && isset($_POST["cantidad"]) && isset($_POST["cantidadaviso"]) && isset($_FILES["foto"]) && isset($_POST["ID_IVA"]) && isset($_POST["ID_UNIDAD"]) && isset($_POST["ID_CATEGORIA"])) {
        if ($_FILES['foto']["name"]!="") { //chequeamos que se haya seteado una foto
            if (!file_exists('IMAGENESSOFTWARE/' . $_FILES['foto']['name'])) { //sino existe una imagen con ese nombre la guarda y carga la base de datos.
                mysqli_query($basededatos, 'INSERT INTO producto (Nombre,Precio_Neto,Código_de_Barras,Descripción,Marca,Cantidad,Cantidad_minima_aviso,imagen,ID_IVA,ID_UNIDAD,ID_CATEGORIA) VALUES ("' . $_POST["nombre"] . '","' . $_POST["precio"] . '","' . $_POST["codbarras"] . '","' . $_POST["descripcion"] . '","' . $_POST["marca"] . '","' . $_POST["cantidad"] . '","' . $_POST["cantidadaviso"] . '","' . "IMAGENESSOFTWARE/" . $_FILES["foto"]["name"] . '","'  . $_POST["ID_IVA"] . '","' . $_POST["ID_UNIDAD"] . '","' . $_POST["ID_CATEGORIA"] . '");');
                move_uploaded_file($_FILES['foto']['tmp_name'], 'IMAGENESSOFTWARE/' . $_FILES['foto']['name']);
                $opcion = "Productoregistrado";
            } else { //si llegase a existir imagen con ese nombre le pone el codigo de barras a la imagen y la carga asi.
                mysqli_query($basededatos, 'INSERT INTO producto (Nombre,Precio_Neto,Código_de_Barras,Descripción,Marca,Cantidad,Cantidad_minima_aviso,imagen,ID_IVA,ID_UNIDAD,ID_CATEGORIA) VALUES ("' . $_POST["nombre"] . '","' . $_POST["precio"] . '","' . $_POST["codbarras"] . '","' . $_POST["descripcion"] . '","' . $_POST["marca"] . '","' . $_POST["cantidad"] . '","' . $_POST["cantidadaviso"] . '","' . "IMAGENESSOFTWARE/" . $_POST["codbarras"] . $_FILES["foto"]["name"] . '","'  . $_POST["ID_IVA"] . '","' . $_POST["ID_UNIDAD"] . '","' . $_POST["ID_CATEGORIA"] . '");');
                move_uploaded_file($_FILES['foto']['tmp_name'], 'IMAGENESSOFTWARE/' . $_POST["codbarras"] . $_FILES['foto']['name']);
                $opcion = "Productoregistrado";
            }
        } else { //sino se seteo la foto
            if (isset($_POST["enlacedefoto"]) && $_POST["enlacedefoto"] != "") { //comprobamos que se haya seteado un enlace de foto
                mysqli_query($basededatos, 'INSERT INTO producto (Nombre,Precio_Neto,Código_de_Barras,Descripción,Marca,Cantidad,Cantidad_minima_aviso,imagen,ID_IVA,ID_UNIDAD,ID_CATEGORIA) VALUES ("' . $_POST["nombre"] . '","' . $_POST["precio"] . '","' . $_POST["codbarras"] . '","' . $_POST["descripcion"] . '","' . $_POST["marca"] . '","' . $_POST["cantidad"] . '","' . $_POST["cantidadaviso"] . '","' . $_POST["enlacedefoto"] . '","'  . $_POST["ID_IVA"] . '","' . $_POST["ID_UNIDAD"] . '","' . $_POST["ID_CATEGORIA"] . '");');
                $opcion = "Productoregistrado";
            } else {
                $opcion = "ingresefotooenlace";
                $nombre = $_POST["nombre"];
                $precio = $_POST["precio"];
                $codbarras= $_POST["codbarras"];
                $descripcion = $_POST["descripcion"];
                $marca = $_POST["marca"];
                $cantidad = $_POST["cantidad"];
                $cantidadaviso = $_POST["cantidadaviso"];
            }
        }
    } else {
        $opcion = "datosnoseteados";
    }
} else {
    $opcion = "";
}




?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="/LUPF/css/style.css">
    <?php include("/LUPF/css/colorespersonalizados.php"); //este archivo contiene las variables $colorfondo,$colorprincipal  ?>

    <script src="/LUPF/LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/LUPF/LIBRERIAS/sweetalert/sweetalert2.css">

    <link rel="shortcut icon" href="/LUPF/imagenes/icons/modproductos.png" type="image/x-icon">
</head>

<body>

    <form method="POST" class="formularios" enctype="multipart/form-data">
        <h1>Agregar Producto</h1>

        <div class="contenedordesubcontenedores"><!-- CONTIENE DOS SUBCONTENEDORES, es para ordenar en dos filas -->
            <div class="subcontenedores"><!-- CONTIENE los inputs, es para ordenarlos con estilo -->
                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Nombre" name="nombre" id="nombre" required <?php if(isset($nombre)){echo "value='".$nombre."'"; }  ?>>

                <label for="precio">Precio Neto</label>
                <input type="float" placeholder="Precio Neto" name="precio" id="precio" required <?php if(isset($precio)){echo "value='".$precio."'"; }  ?>>

                <label for="codbarras">Código de Barras</label>
                <input type="number" placeholder="codigo de barras" name="codbarras" id="codbarras" <?php if(isset($codbarras)){echo "value='".$codbarras."'"; }  ?>>

                <label for="descripcion">Descripción</label>
                <input type="text" placeholder="descripción" name="descripcion" id="descripcion" required <?php if(isset($descripcion)){echo "value='".$descripcion."'"; }  ?>>

                <label for="marca">Marca</label>
                <input type="text" placeholder="marca" name="marca" id="marca" <?php if(isset($marca)){echo "value='".$marca."'"; }  ?>>

                <label for="cantidad">Cantidad</label>
                <input type="number" placeholder="cantidad" name="cantidad" id="cantidad" required <?php if(isset($cantidad)){echo "value='".$cantidad."'"; }  ?>>
            </div>

            <div class="subcontenedores">
                <label for="cantidadaviso">Cantidad de Aviso</label>
                <input type="number" placeholder="cantidad de aviso" name="cantidadaviso" id="cantidadaviso" required <?php if(isset($cantidadaviso)){echo "value='".$cantidadaviso."'"; }  ?>>

                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*">

                <label for="enlacedefoto">Enlace de Foto</label>
                <input type="url" name="enlacedefoto" id="enlacedefoto" placeholder="Ingrese el enlace de una foto">

                <label for="iva">IVA</label>
                <select id="iva" name="ID_IVA" required>
                    <option value="">iva</option>
                    <?php foreach ($ivas as $iva) {
                        echo "<option value='" . $iva['ID_IVA'] . "'>" . $iva['Tipo'] . "</option>";
                    } ?>
                </select>

                <label for="medida">Unidad de Medida</label>
                <select id="medida" name="ID_UNIDAD" required>
                    <option value="">unidad de medida</option>
                    <?php foreach ($medidas as $medida) {
                        echo "<option value='" . $medida['ID_UNIDAD'] . "'>" . $medida['Unidad'] . "</option>";
                    } ?>
                </select>

                <label for="categoria">Categoría</label>
                <select id="categoria" name="ID_CATEGORIA" required>
                    <option value="">categoria</option>
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
<?php
// esto lo debemos hacer luego de cargar el html porque la funcion mostraraviso() y mostraravisoconfoto() hace un echo a la funcion de la libreria "Sweetalert" la cual requiere que se cargue el html para funcionar;
//las variables $colorfondo,$colorprincipal salen del archivo "colorespersonalizados.php"
switch ($opcion) {
    case 'Productoregistrado';
        mostraraviso("Producto registrado con éxito", $colorfondo, $colorprincipal);
        break;
    case 'ingresefotooenlace';
        mostraralerta("Debe ingresar una foto o el enlace de una foto", $colorfondo, $colorprincipal);
        break;
    case 'datosnoseteados';
        mostraralerta("Datos no seteados", $colorfondo, $colorprincipal);
        break;
}
?>