<?php 
session_start();
if(isset($_SESSION["usuario"])){
    session_destroy();
    header("Location:index.php?causa=sesioncerrada");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Que mirás bobo</title>
</head>
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="imagenes/JL.svg" type="image/x-icon">


<style>
    body{
        align-items: center;
        display: flex;
        flex-direction: column;
    }
    iframe{
        border-radius: 15px;
    }
    h1{
        color: #4DBF38;
    } 
</style>
<body class="a">
    <div class="conte">
    <h1>Qué mirs bobo</h1>
    </div>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Gqnx36dR5Xk?si=B0igWKApRvaLkChM" title="YouTube video player"autoplay frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</body>
</html>