<?php
include("coneccionBD.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["usuario"] != "" && $_POST["contraseña"] != "") { // si contienen texto
        $usuarioingresado = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        $consultausuarios = mysqli_query($basededatos, 'SELECT * FROM Usuario WHERE usuario = "' . $usuarioingresado . '"');
        if (mysqli_num_rows($consultausuarios) == 1) { //chequemos que exista un usuario con ese nombre de usuario
            $usuario = mysqli_fetch_assoc($consultausuarios);
            if (password_verify($contraseña, $usuario["Contraseña"])) { //la variable contraseña obtiene la contraseña que ingresó el usuario y "$usuario["Contraseña"]" obtiene la contraseña encriptada, la funcion password_veryfy() verifica que esté correcta la contraseña
                $_SESSION["usuario"] = $usuarioingresado;
                $_SESSION["nombre"] = $usuario["Nombre"];
                $_SESSION["fotoperf"] = $usuario["Foto_Perfil"];
                $_SESSION["fecha_nacimiento"] = $usuario["Fecha_Nacimiento"];
            } else {
                if (isset($_SESSION["intentosdisponibles"])) { //chequea que intentos este seteada
                    if ($_SESSION["intentosdisponibles"] <= 0) {// si intentos en
                        $_SESSION["bloq"] = 1;
                        header("Location:index.php?causa=bloq"); //vuelve al index con con la variable de sesion bloq y con la variable causa que avisará que esta bloqueado
                    } else { //sino es menor o igual a 0
                        $_SESSION["intentosdisponibles"] -= 1; // restamos 1 y volvemos a index con la variabla causa seteada en err
                        header("Location:index.php?causa=err");
                    }
                } else {
                    $_SESSION["intentosdisponibles"] = 2;
                    header("Location:index.php?causa=err");
                }
            }
        } else {
            header("Location:index.php?causa=usuarioinexistente");
        }
    } else {
        header("Location:index.php?causa=textovacio");
    }
} else { //SI NO ESTAN seteadas por post 
    if (!isset($_SESSION["usuario"])) {
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
    <link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">

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