<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<link rel="stylesheet" href="style.css">

<body>

    <form method="POST" action="MENU.php">
        <div class="contenedor">

            <input type="text" name="usuario" placeholder="usuario"></input>
            <input type="password" name="contraseña" placeholder="contraseña"> </input>
            <?php
            $intentos = 5;
            if (isset($_GET['error'])) {
                $intentos = $intentos - 1;
                echo "<h9> contraseña o usuario incorrectos </h9>";
            }
            ?>
            <input type="submit" value="Iniciar Sesión"></input>
            <p src="meolvide.php">¿Has olvidado tu contraseña?</p>
        </div>
    </form>
</body>

</html>