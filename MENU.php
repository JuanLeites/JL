<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal</title>
</head>
<body>
<?php
    if ($_POST['usuario'] == "pepe" & $_POST['contraseña'] == "1234") {
        $login = true;
        echo '<link rel="stylesheet" href="style.css">';
    } else {
        $login = false;
        header('Location:index.php?error=1');
    }
    if($login){
        echo '<div class="contenedores"><h1> Pelado pagina</h1> </div>';
    }
    ?>

</body>

</html>