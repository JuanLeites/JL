<?php
//al utilizar funciones hay que incluir archivos de la libreria:"sweetalert";   "<script src="../LIBRERIAS/sweetalert/sweetalert2.min.js"></script><link rel="stylesheet" href="../LIBRERIAS/sweetalert/sweetalert2.css">"
function mostraraviso($titulo, $colorfondo, $colortexto)
{
  if ($colorfondo == "") {
    $colorfondo = "#001F47";
  }
  if ($colortexto == "") {
    $colortexto = "#4DBF38";
  }

  echo '<script>
          Swal.fire({
              position:"center",
              title: "' . $titulo . '",
              icon: "success",
              background: "' . $colorfondo . '",
              color:"' . $colortexto . '",
              customClass: {
                popup: "alertaconbordes"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
              },
              toast:true,
              showConfirmButton: false,
              timer: 2400,
              timerProgressBar: true,
          });
          </script>';
}
function mostraravisoconfoto($titulo, $colorfondo, $colortexto, $foto)
{
  if ($colorfondo == "") {
    $colorfondo = "#001F47";
  }
  if ($colortexto == "") {
    $colortexto = "#4DBF38";
  }
  echo '<script>
          Swal.fire({
              position:"center",
              title: "' . $titulo . '",
              icon: "success",
              background: "' . $colorfondo . '",
              color:"' . $colortexto . '",
              customClass: {
                popup: "alertaconbordes"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
              },
              toast:true,
              showConfirmButton: false,
              timer: 4000,
              timerProgressBar: true,
                imageUrl: "' . $foto . '",
  imageWidth: 300,
  imageHeight: 300,
  imageAlt: "Imagen de Perfil"
          });
          </script>';
}
function mostraralerta($titulo, $colorfondo, $colortexto)
{
  if ($colorfondo == "") {
    $colorfondo = "#001F47";
  }
  if ($colortexto == "") {
    $colortexto = "#4DBF38";
  }

  echo '<script>
          Swal.fire({
              position:"center",
              title: "' . $titulo . '",
              icon: "warning",
              background: "' . $colorfondo . '",
              color:"' . $colortexto . '",
              customClass: {
                popup: "alertaconbordes"  // Añadimos una clase personalizada para poder mostrar bordes ya que la alerta no lo permite
              },
              toast:true,
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
          });
          </script>';
}
function enviarcodigoparareestablecer($nombre, $codigo, $destino)
{
  //esta función deberia de mandar el codigo por correo al destino
  $contenido = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Correo de Recuperación</title>
</head>
<body style="margin: 0; padding: 0; background-color: #001F47; font-family: Arial, sans-serif; color: white;">
    <div style="max-width: 600px; margin: 20px auto; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);">
        <div style="background-color: #80D12A; padding: 20px; text-align: center; font-size: 28px; font-weight: bold; border-bottom: 3px solid #4DBF38;">
            Código de Recuperación
        </div>
        <div style="background-color: #4DBF38; padding: 30px; line-height: 1.6;">
            <p>Hola ' . $nombre . ',</p>
            <p>Para recuperar tu cuenta, utiliza el siguiente código:</p>
            <h2 style="font-size: 36px; font-weight: bold; color: #001F47;">' . $codigo . '</h2>
            <p>Si no solicitaste este código, ignora este mensaje.</p>
        </div>
    </div>
</body>
</html>';
$asunto = "Correo de Recuperación";

$encabezado  = "MIME-Version:1.0\n";
$encabezado .= "Content-type: text/html; charset=utf-8\n";
$encabezado .= "From: Maná <smtp@elmana.site>\n";
$encabezado .= "X-Sender: <smtp@elmana.site>\n";
$encabezado .= "Replay-to: smtp@elmana.site\n";
$encabezado .= "Return-path: smtp@elmana.site\n";
$encabezado .= "X-Mailer: PHP\n";
$encabezado .= "X-Priority: 1\n";

$encabezado .= "List-unsuscribe: <https://www.elmana.site/unsuscribe.php>\n";
$encabezado .= "List-Unsuscribe-Post: List-Unsuscribe=One-Click\n";

mail($destino, $asunto, $contenido, $encabezado);
  echo "<script>alert('Se enviará el código " . $codigo . " a " . $nombre . " con el correo " . $destino . " ')</script>";
}
function generarcodigo($cantidad)
{ //devuelve un numero con la cantidad de caracteres que fue pasada por parametro
  $codigo = "";
  for ($i = 0; $i < $cantidad; $i++) {
    $codigo .= rand(0, 9);
  }
  return $codigo;
}
