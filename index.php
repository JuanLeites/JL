<!DOCTYPE html>
<<<<<<< Updated upstream
<html lang="en">

=======
<html lang="es">
>>>>>>> Stashed changes
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<link rel="stylesheet" href="/LUPF/style.css">

<body>

    <form method="POST" action="MENU.php">
        <div class="contenedor">

            <div>
                <input type="text" name="usuario" placeholder="usuario"></input>
            </div>
            <div>
                <input type="password" name="contraseña" id="contraseña" placeholder="contraseña"><img id='ver' src="imagenes/ojoabierto.png">
            </div>
            <?php
            if (isset($_GET['error'])) {
                $intentos = 5;
                $intentos = $intentos - 1;
                echo "<h9> contraseña o usuario incorrectos </h9>";
            }
            ?>
            <div>
                <p href="meolvide.php">¿Has olvidado tu contraseña?</p>
                <input type="checkbox" placeholder="recordar">
            </div>
            <input type="submit" value="Iniciar Sesión"></input>

        </div>
    </form>
    <script src="js/script.js"> </script>
</body>

</html>