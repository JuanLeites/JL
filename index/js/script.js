window.onload = function(){
    var contra = document.querySelector('#contraseña')
      var ver = document.getElementById('ver')
  
      ver.addEventListener('click', function(){
          if(contra.type == 'password'){
              contra.setAttribute('type', 'text')
              ver.setAttribute('src','imagenes/ojoabierto.png')
          }else{
              contra.setAttribute('type', 'password')
              ver.setAttribute('src','imagenes/ojoacerrado.png')
          }
      })
  }