<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me olvidé la contraseña</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <form method="post">
  <div class="contenedor">
    <input type="email" placeholder="ingrece email" name="dest">
    <input type="submit" value="enviar codigo al correo" name="enviar">
    <input type="text" name="codigo" placeholder="ingrese código de 6 digitos">
    <input type="submit" value="siguiente" name="validar">
 </form>
 </div>
<?php
session_start();
//para esta funcion use chat gpt, no la entiendo muy bien(entiendo poco)
function generarCodigo() {
    // Obtiene el tiempo actual en segundos desde la época Unix
    $tiempoActual = time();
    
    // Divide el tiempo actual por 180 segundos (3 minutos) y redondea hacia abajo
    $intervalo = floor($tiempoActual / 180);
    
    // Usa el intervalo como semilla para rand()
    srand($intervalo);
    
    // Genera un número aleatorio de 6 dígitos
    return rand(100000, 999999);
}

if (isset($_POST['enviar'])) {
    if (!empty($_POST['dest'])){
    $codigo = generarCodigo(); // Llama a la función y almacena el código generado
    $_SESSION['codigo'] = $codigo;// las variables se usan para evaluar mas tarde
    $_SESSION['codigo_generado'] = time();
  
     $dest = $_POST['dest']; 
    $asunto = "Código para recuperación de contraseña";
    $msj = "Tu código es: ".$codigo." Este código cambiará en 3 minutos.";
    $header = "From: lupfdesarrollodesoftware@gmail.com\r\n";  
    $header .= "Reply-To: lupfdesarrollodesoftware@gmail.com\r\n";
    $header .= "X-Mailer: PHP/" . phpversion();

    $mail = @mail($dest, $asunto, $msj, $header);//envio de mail
    if ($mail) {
       echo "<h4>Código enviado</h4>";
    } else {
       echo "<h4>Error al enviar el código</h4>";
    }
    }else{
      echo "correo no ingresado";
    }
}

if (isset($_POST['validar'])) {
    if (isset($_SESSION['codigo']) && isset($_SESSION['codigo_generado'])) {
        $codigoIngresado = $_POST['codigo'];
        $codigoGenerado = $_SESSION['codigo'];
        $tiempoGenerado = $_SESSION['codigo_generado'];
        $tiempoActual = time();
     
        
        if ($codigoIngresado == $codigoGenerado) {//evalua que el codigo ingresado en el campo de texto y el de la variable sean iguales
            if (($tiempoActual - $tiempoGenerado) <= 180) {//evalua que el tiempo actual menos el tiempo cuando se genero el codigo sea menor o igual a 180 para corroborar no hayan pasado 3 min
                echo "<h4>Código correcto</h4>"."tu contraseña es:";//aca deberia extraer la contra de la bd y mostrarla.
            } else {
                echo "<h4>Código expirado</h4>";//si el tiempo supera los 3 min
            }
        } else {
            echo "<h4>código  incorrecto</h4>";
        }
    } else {
        echo "<h4>No se ha generado un código</h4>";
    }
}
?>
</body>
</html>
