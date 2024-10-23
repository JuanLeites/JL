var fondo = "black"//establecemos fondo por defecto en negro



  var inputdefechadeinicio = document.querySelector(".fechainicio");
  var inputdefechadefinal = document.querySelector(".fechafinal");
  
  var canvas1 = document.getElementById('grafica1').getContext('2d');
  var canvas2 = document.getElementById('grafica2').getContext('2d');
  var canvas3 = document.getElementById('grafica3').getContext('2d');
  var canvas4 = document.getElementById('grafica4').getContext('2d');
  


//establecemos 4 objetos graficas y le pasamos datos vacios
var grafica1 = new Chart(canvas1, {//establecemos el objeto chart con datos por defecto 
  type: 'line',//tipo de gráfica
  data: {//datos por defecto (Vacíos )
    labels: [''],
    datasets: [{
      label: 'Número de compras', // label es la etiqueta
      data: [""], // le establecemos los datos en vacio 
      borderColor: '#36A2EB',
      backgroundColor: [
        'rgba(255, 99, 132, 0.9)',
        'rgba(255, 159, 64, 0.9)',
        'rgba(255, 205, 86, 0.9)',
        'rgba(75, 192, 192, 0.9)',
        'rgba(54, 162, 235, 0.9)',
        'rgba(153, 102, 255, 0.9)',
        'rgba(201, 203, 207, 0.9)'
      ]
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      tooltip: {
        bodyColor: "gold",
      }, legend: {
        labels: {
          color: fondo,
        }
      },
      title: {
        display: true,
        text: 'Clientes más frecuentes',
        color: fondo,
        font: {
          size: 20
        },
        padding: {
          top: 10,
          bottom: 30
        }
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          color: fondo
        }
      },
      x: {
        ticks: {
          color: fondo
        }
      }
    },
  }
});



grafica2 = new Chart(canvas2, {
  type: 'doughnut',
  data: {
    labels: [''],
    datasets: [{
      label: 'Cantidad de productos',
      data: [],
      borderColor: '#36A2EB',
      backgroundColor: [
        'rgba(255, 99, 132, 0.9)',
        'rgba(255, 159, 64, 0.9)',
        'rgba(255, 205, 86, 0.9)',
        'rgba(75, 192, 192, 0.9)',
        'rgba(54, 162, 235, 0.9)',
        'rgba(153, 102, 255, 0.9)',
        'rgba(201, 203, 207, 0.9)'
      ]
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      tooltip: {
        bodyColor: "gold",
      }, legend: {
        labels: {
          color: fondo,
        }
      },
      title: {
        display: true, // Muestra el título
        text: 'Productos más vendidos', // Texto del título
        color: fondo,
        font: {
          size: 20 // Tamaño de la fuente del título
        },
        padding: {
          top: 10,
          bottom: 30
        }
      },
    },scales: {
      y: {
        beginAtZero: true,
        ticks: {
          color: fondo
        }
      },
      x: {
        ticks: {
          color: fondo
        }
      }
    }
  }
});


grafica3 = new Chart(canvas3, {
  type: 'bar',
  data: {
    labels: [''],
    datasets: [{
      label: 'Se vendió',
      data: [],
      borderColor: 'green',
      backgroundColor: [
        'rgba(255, 99, 132, 0.9)',
        'rgba(255, 159, 64, 0.9)',
        'rgba(255, 205, 86, 0.9)',
        'rgba(75, 192, 192, 0.9)',
        'rgba(54, 162, 235, 0.9)',
        'rgba(153, 102, 255, 0.9)',
        'rgba(201, 203, 207, 0.9)'
      ]
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      tooltip: {
        bodyColor: "gold",
      }, legend: {
        labels: {
          color: fondo,
        }
      },
      title: {
        display: true,
        text: 'Ventas por fecha',
        color: fondo,
        font: {
          size: 20
        },
        padding: {
          top: 10,
          bottom: 30
        }
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          color: fondo
        }
      },
      x: {
        ticks: {
          color: fondo
        }
      }
    },
  }
});
grafica4 = new Chart(canvas4, {
  type: 'pie',
  data: {
    labels: [''],
    datasets: [{
      label: 'Cantidad',
      data: [],
      borderColor: fondo,
      backgroundColor: [
        'rgba(255, 99, 132, 0.9)',
        'rgba(255, 159, 64, 0.9)',
        'rgba(255, 205, 86, 0.9)',
        'rgba(75, 192, 192, 0.9)',
        'rgba(54, 162, 235, 0.9)',
        'rgba(153, 102, 255, 0.9)',
        'rgba(201, 203, 207, 0.9)'
      ]
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      tooltip: {
        bodyColor: "gold",
      }, legend: {
        labels: {
          color: fondo,
        }
      },
      title: {
        display: true,
        text: 'Categorías más vendidas',
        color: fondo,
        font: {
          size: 20
        },
        padding: {
          top: 10,
          bottom: 30
        }
      },
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          color: fondo
        }
      },
      x: {
        ticks: {
          color: fondo
        }
      }
    },
  }
});

establecercolor(grafica1);
establecercolor(grafica2);
establecercolor(grafica3);
establecercolor(grafica4);
obtenercolores(grafica3)


function obtenercolores(grafica) { // obtiene los colores principal y del fondo y los setea en el fondo de la gráfica, queda bien unicamente en las de "bar"
  // Hacemos la consulta a la API
  const colores = new XMLHttpRequest();
  colores.open('GET', 'apis/apidecolores.php');
  colores.send();

  colores.onload = function () {
    // Obtenemos los datos en formato JSON
    const datos = JSON.parse(this.responseText);
    const colorPrincipal = datos.color_principal;
    const colorSecundario = datos.color_secundario;
    const colorFondo = datos.color_fondo;

    // Mostrar los colores obtenidos
    console.log('Color Principal:', colorPrincipal);
    console.log('Color Fondo:', colorFondo);

    // Generar y mostrar distintos gradientes en la consola
    grafica.data.datasets[0].backgroundColor = [colorPrincipal,colorFondo]
    
  };
}


//funcion que llaama a las 4 funciones que actualizan cada gráfica
function actualizargraficas(fechainicio, fechafinal) {
  actualizargrafica1(fechainicio, fechafinal)
  actualizargrafica2(fechainicio, fechafinal)
  actualizargrafica3(fechainicio, fechafinal)
  actualizargrafica4(fechainicio, fechafinal)
}

function establecercolor(grafica) { // esta funcion unicamente lo que hace es setearle el color de todos los colores modificables al objeto chart.js pasado por parametro
  const colores = new XMLHttpRequest();
  colores.open('GET', 'apis/apidecolores.php');
  colores.send();

  colores.onload = function () {
    const datos = JSON.parse(this.responseText);
    let fondo = datos.color_fondo; // Obtenemos el color de fondo de la respuesta

    // Actualizamos las propiedades del gráfico con el nuevo color
    grafica.options.plugins.legend.labels.color = fondo;
    grafica.options.plugins.title.color = fondo;
    grafica.options.scales.y.ticks.color = fondo;
    grafica.options.scales.x.ticks.color = fondo;
    grafica.data.datasets[0].borderColor = fondo;

    // Actualizamos el gráfico para reflejar los cambios
    grafica.update();
  }
}




//funciones que actualizan cada gráfica individualmente
function actualizargrafica1(fechainicio, fechafinal) {
  const clientesmasfrecuentes = new XMLHttpRequest();
  clientesmasfrecuentes.open('GET', 'apis/apiresumen.php?fecha_inicio=' + fechainicio + "&fecha_final=" + fechafinal + "&tipo=clientesmasfrecuentes");
  clientesmasfrecuentes.send()
  clientesmasfrecuentes.onload = function () {
    const datos1 = JSON.parse(this.responseText);
    grafica1.data.datasets[0].data = datos1[0].reverse(); //donde datos[0] obtiene el array con las cantidades de productos mas vendidos -- .reverse para que de vuelta los dos arrays y los muestre de forma creciente
    grafica1.data.labels = datos1[1].reverse(); // y datos[1] obtiene un array con los nombre++
    grafica1.update();
  }
}

function actualizargrafica2(fechainicio, fechafinal) {
  const productosmasvendidos = new XMLHttpRequest();
  productosmasvendidos.open('GET', 'apis/apiresumen.php?fecha_inicio=' + fechainicio + "&fecha_final=" + fechafinal + "&tipo=productosmasvendidos");
  productosmasvendidos.send()
  productosmasvendidos.onload = function () {
    const datos2 = JSON.parse(this.responseText);
    grafica2.data.datasets[0].data = datos2[0]; //donde datos[0] obtiene el array con la cantidad de veces que vino el cliente
    grafica2.data.labels = datos2[1] // y datos[1] obtiene un array con los nombres y las cedulas
    grafica2.update();

  }
}

function actualizargrafica3(fechainicio, fechafinal) {
  const cantidaddeventas = new XMLHttpRequest();
  cantidaddeventas.open('GET', 'apis/apiresumen.php?fecha_inicio=' + fechainicio + "&fecha_final=" + fechafinal + "&tipo=cantidaddeventas");
  cantidaddeventas.send()
  cantidaddeventas.onload = function () {
    const datos3 = JSON.parse(this.responseText);
    grafica3.data.datasets[0].data = datos3[1]; //donde datos[0] obtiene el array con la cantidad de veces que vino el cliente
    grafica3.data.labels = datos3[0] // y datos[1] obtiene un array con los nombres y las cedulas
    grafica3.update();
  }
}

function actualizargrafica4(fechainicio, fechafinal) {
  const apis = new XMLHttpRequest();
  apis.open('GET', 'apis/apiresumen.php?fecha_inicio=' + fechainicio + "&fecha_final=" + fechafinal + "&tipo=categorias");
  apis.send()
  apis.onload = function () {
    const datos4 = JSON.parse(this.responseText);
    grafica4.data.datasets[0].data = datos4[0]; //donde datos[0] obtiene el array con la cantidad de veces que vino el cliente
    grafica4.data.labels = datos4[1] // y datos[1] obtiene un array con los nombres y las cedulas
    grafica4.update();

  }
}

window.onload = () => {

  actualizargraficas(inputdefechadeinicio.value, inputdefechadefinal.value);

  inputdefechadeinicio.addEventListener("change", () => {
    actualizargraficas(inputdefechadeinicio.value, inputdefechadefinal.value);
  })

  inputdefechadefinal.addEventListener("change", () => {
    actualizargraficas(inputdefechadeinicio.value, inputdefechadefinal.value);
  })

}