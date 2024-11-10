<?php
try {
    $basededatos = mysqli_connect("localhost", "clientes", "clientes2024") or die("error al conectar con base de datos"); //accedemos a la BD en la variable basededatos
    mysqli_select_db($basededatos, "mana") or die("error al seleccionar la base de datos");
} catch (throwable $error) {
    echo 'error: ' . $error->getMessage();
}


$categorias = mysqli_query($basededatos, 'SELECT * FROM Categoría ORDER BY Título');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimarket Maná</title>
    <link rel="shortcut icon" href="../imagenes/JL.svg" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <style>
        <?php

        $configuraciondecolores = mysqli_fetch_assoc(mysqli_query($basededatos, 'SELECT Color_Principal,Color_Secundario,Color_Fondo FROM configuración;'));

        $colorprincipal = $configuraciondecolores["Color_Principal"];
        $colorsecundario = $configuraciondecolores["Color_Secundario"];
        $colorfondo = $configuraciondecolores["Color_Fondo"];
        //las variables $colorfondo, $colorprincipal salen de este archivo
        ?> :root {
            --color-principal: <?php echo $colorprincipal ?>;
            --color-secundario: <?php echo $colorsecundario ?>;
            --color-fondo: <?php echo $colorfondo ?>;
        }
    </style>
    <script src="script.js"></script>
</head>

<body>
    <header>
        <h1>Productos Disponibles en "Minimarket Maná"</h1>
        <div class="menu">
            <div class="contenedordeinputs">
                <input type="search" id="buscador" placeholder="Buscar Productos..." onkeyup="cargarproductosparavender(this.value,1)">
                <input type="button" class="boton" value="Regargar" onclick="document.querySelector('#buscador').value='',cargarproductosparavender('',<?php echo isset($_GET['pagina']) ?  $_GET['pagina'] :  1; /*condicional en una sola linea si está seteado pagina lo imprime y sino imprimirá 1*/ ?>);" >
            </div>
        </div>
    </header>

    <section class="contenedordeproductos">
    </section>
    <div class="controlesdepaginas">
        <?php
        if (isset($_GET["pagina"]) && ($_GET["pagina"] > 1)) {
            echo "<a class='botonesdepaginacion' href='index.php?pagina=" . ($_GET["pagina"] - 1) . "'>Anterior</a>";
        }
        if (isset($_GET["pagina"])) {
            if ($_GET["pagina"] != "ultima") {
                echo "<a class='botonesdepaginacion botonsiguiente' href='index.php?pagina=" . ($_GET["pagina"] + 1) . "'>Siguiente</a>";
            }
        } else {
            echo "<a class='botonesdepaginacion botonsiguiente' href='index.php?pagina=2'>Siguiente</a>";
        }


        ?>
    </div>
    <footer>
        <p>Minimarket Maná 2024 &copy; - <a href="about us.html">Desarrollado por Juan Leites</a> </p>
    </footer>
</body>
<?php
if (isset($_GET["pagina"])) {
    echo '<script>
    window.onload = () => {
        cargarproductosparavender("",' . $_GET["pagina"] . ')
    }</script>';
} else {
    echo '<script>
window.onload = () => {
    cargarproductosparavender("",1)
}</script>';
}


?>

</html>