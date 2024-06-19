<?php
include("coneccionBD.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["usuario"] != "" && $_POST["contraseña"] != "") { // si contienen texto
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        $consultausuarios = mysqli_query($basededatos, 'SELECT * FROM usuario WHERE usuario = "' . $usuario . '" AND contraseña = "' . $contraseña . '"');
        if (mysqli_num_rows($consultausuarios) == 1) { //chequeamos que haya un solo valor(un usuario con ese user y esa contraseña)
            $_SESSION["user"] = strtolower($usuario);
            $_SESSION["pass"] = strtolower($contraseña); //si hay las setea a varables de sesion
            foreach ($consultausuarios as $usuario) {
                foreach ($usuario as $indice => $dato) {
                    if ($indice == "nombre") {
                        $_SESSION["nombre"] = $dato;
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
    if (!isset($_SESSION["user"]) && !isset($_SESSION["pass"])) {
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
</head>

<body>
    <?php include("barralateral.html") ?>
    <main>
    <h1>Bienvenido <?php echo $_SESSION["nombre"]; ?></h1>
    <h2 id="titulo_con_fecha"></h2>
    </main>

</body>
<script>
    window.onload = ()=>{
        var hoy = new Date(Date.now())
        var titulo = document.querySelector("#titulo_con_fecha")
        titulo.innerHTML="Hoy es "+hoy
    }

</script>
</html>