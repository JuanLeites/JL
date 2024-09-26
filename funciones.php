<?php
//al utilizar funciones hay que incluir archivos de la libreria:"sweetalert";   "<script src="../LIBRERIAS/sweetalert/sweetalert2.min.js"></script><link rel="stylesheet" href="../LIBRERIAS/sweetalert/sweetalert2.css">"
echo '<script src="/LUPF/LIBRERIAS/sweetalert/sweetalert2.min.js"></script>
<link rel="stylesheet" href="/LUPF/LIBRERIAS/sweetalert/sweetalert2.css">';

function mostraraviso($titulo, $colorfondo, $colortexto){
  if ($colorfondo == "") {
    $colorfondo = "#001F47";
  }
  if ($colortexto=="") {
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
function mostraravisoconfoto($titulo, $colorfondo, $colortexto,$foto){
  if ($colorfondo == "") {
    $colorfondo = "#001F47";
  }
  if ($colortexto=="") {
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
              timer: 3000,
              timerProgressBar: true,
                imageUrl: "'.$foto.'",
  imageWidth: 300,
  imageHeight: 300,
  imageAlt: "Imagen de Perfil"
          });
          </script>';
}
function mostraralerta($titulo, $colorfondo, $colortexto){
  if ($colorfondo == "") {
    $colorfondo = "#001F47";
  }
  if ($colortexto=="") {
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
              timer: 2800,
              timerProgressBar: true,
          });
          </script>';
}
//