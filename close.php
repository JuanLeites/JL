<?php 
session_start();
if(isset($_SESSION["user"])&&isset($_SESSION["pass"])){
    session_destroy();
    header("Location:index.php?causa=sesioncerrada");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Que mirás bobo</title>
</head>
<link rel="stylesheet" href="css/style.css">
<link rel="shortcut icon" href="imagenes/qmiras.jpeg" type="image/x-icon">
<style>
    body{
        align-items: center;
        display: flex;
        flex-direction: column;
    }
    iframe{
        border-radius: 15px;
        
    }
</style>
<body class="a">
    <div class="conte">
    <h1>que miras bobo</h1>
    </div>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/Gqnx36dR5Xk?si=B0igWKApRvaLkChM" title="YouTube video player"autoplay frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
</body>
</html>