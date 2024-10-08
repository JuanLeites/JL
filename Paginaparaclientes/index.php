<?php
try {
    $basededatos = mysqli_connect("localhost", "funcionario", "funcionario2024") or die("error al conectar con base de datos"); //accedemos a la BD en la variable basededatos
    mysqli_select_db($basededatos, "mana") or die("error al seleccionar la base de datos");
} catch (throwable $error) {
    echo 'error: ' . $error->getMessage();
}


$categorias = mysqli_query($basededatos, 'SELECT * FROM categoría ORDER BY Título');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL MANÁ</title>
    <link rel="shortcut icon" href="../imagenes/JL.svg" type="image/x-icon">

    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="content-wrapper">
        <header>
            <h1>Productos Disponibles en "el maná"</h1>
            <div class="menu">
                <input type="text" id="buscador" placeholder="Buscar Productos..." onkeyup="filtrarproductos()">

                <select id="filtrodecategoria" onchange="filtrarporcategoria()">
                    <option value="all">Todas las Categorías</option>
                    <?php foreach ($categorias as $categoria) {
                        echo "<option value='" . $categoria['Título'] . "'>" . $categoria['Título'] . "</option>";
                    } ?>
                </select>


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
            </div>
        </header>

        <section class="contenedordeproductos">

        </section>
    </div>

    <footer>
        <p>Juan Leites 2024 &copy; - <a href="about us.html">About us</a> </p>
    </footer>
    <script src="script.js"></script>
</body>

</html>