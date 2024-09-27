<?php
include("coneccionBD.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["usuario"] != "" && $_POST["contraseña"] != "") { // si contienen texto
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        $consultausuarios = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario = "' . $usuario . '" AND contraseña = "' . $contraseña . '"');
        if (mysqli_num_rows($consultausuarios) == 1) { //chequeamos que haya un solo valor(un usuario con ese user y esa contraseña)
            $_SESSION["usuario"] = $usuario;
            $_SESSION["contraseña"] = $contraseña; //si hay las setea a varables de sesion
            foreach ($consultausuarios as $usuario) {
                foreach ($usuario as $indice => $dato) {
                    if ($indice == "Nombre") {
                        $_SESSION["nombre"] = $dato;
                    }
                    if ($indice == "Foto_Perfil") {
                        $_SESSION["fotoperf"] = $dato;
                    }
                    if ($indice == "Fecha_Nacimiento") {
                        $_SESSION["fecha_nacimiento"] = $dato;
                    }
                }
            }
        } else {
            if (isset($_SESSION["intentos"])) { //chequea que intentos este seteada
                if ($_SESSION["intentos"] <= 0) {
                    $_SESSION["bloq"] = 1;
                    header("Location:index.php?causa=bloq"); //vuelve al index con con la variable de sesion bloq y con la variable causa que avisará que esta bloqueado
                } else { //sino es menor o igual a 0
                    $_SESSION["intentos"] = $_SESSION["intentos"] - 1; // restamos 1 y volvemos a index con la variabla causa seteada en err
                    header("Location:index.php?causa=err");
                }
            } else {
                $_SESSION["intentos"] = 2;
                header("Location:index.php?causa=err");
            }
        }
    } else {
        header("Location:index.php?causa=textovacio");
    }
} else { //SI NO ESTAN seteadas por post 
    if (!isset($_SESSION["usuario"]) && !isset($_SESSION["contraseña"])) {
        header("Location:index.php?causa=nolog");
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
    <link rel="stylesheet" href="css/style.css">
    <?php include("css/colorespersonalizados.php"); ?>
    <link rel="shortcut icon" href="imagenes/LUPF.svg" type="image/x-icon">
</head>

<body>
    <main>
        <div class="contenedordetitulos">
            <h1>Bienvenid@ <?php echo $_SESSION["nombre"]; ?></h1>
            <h2 id="titulo_con_fecha"></h2>
        </div>

        <div class="contenedoresenmenuprincipal">
            <div class="contenedordecumpleañeros">
            </div>
            <div class="contenedordeproductos">
                <h2>Productos con poco Stock</h2>
            </div>
        </div>
    </main>
    <?php include("barralateral.html") ?>
</body>
<script type="module">
    import {
        actualizarfecha,
        cargarclientesdecumpleaños,
        cargarproductosconpocostock
    } from "./js/funciones.js"


    window.onload = () => {

        actualizarfecha("<?php echo $_SESSION["fecha_nacimiento"]; ?>");
        cargarclientesdecumpleaños()
        cargarproductosconpocostock()
        setInterval(() => {
            actualizarfecha("<?php echo $_SESSION["fecha_nacimiento"]; ?>");
            cargarclientesdecumpleaños()
            cargarproductosconpocostock()
        }, 2000);
    }
</script>

</html>