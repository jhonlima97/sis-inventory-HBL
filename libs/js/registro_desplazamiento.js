$(document).ready(function () {
  CargarSelectAreasProv();
  CargarSelectAreasAsig();
  CargarSelectTipoBien();
  obtenerUltimoCodigo();
  obtenerResponsable();
  obtenerResponsableAsignada();

  // Evento de cambio para el combo de área proveniente
  $("#select_area_prov").on("change", function () {
    validarAreas();
    obtenerResponsable();
  });

  // Evento de cambio para el combo de área asignada
  $("#select_area_asig").on("change", function () {
    validarAreas();
    obtenerResponsableAsignada();
  });
});


//nuevo codigo de desplazamiento
function obtenerUltimoCodigo() {
  var txtCod = document.getElementById("txt_cod");

  // Verifica si el elemento con el ID "txt_cod" existe
  if (!txtCod) {
    console.error("El elemento con ID 'txt_cod' no se encontró.");
    return;
  }

  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Cuando la solicitud AJAX se completa con éxito
      txtCod.value = this.responseText;
    }
  };

  // Especifica la ruta al controlador PHP
  xhttp.open("GET", "../controllers/reportes/codigo_desplazamiento.php", true);
  xhttp.send();
}

function CargarSelectAreasProv() {
  $("#select_area_prov").load(
    "../controllers/equipos/CargarSelectAreasProv.php"
  );
}

function CargarSelectAreasAsig() {
  $("#select_area_asig").load(
    "../controllers/equipos/CargarSelectAreasAsig.php"
  );
}

function CargarSelectTipoBien() {
  //$("#select_bien").load("../controllers/reportes/cargar_tipo_bien.php");

  $.ajax({
    url: '../controllers/reportes/cargar_tipo_bien.php',
    type: 'GET',
    success: function(data) {
        // Iterar sobre los datos recibidos y generar las opciones del menú desplegable
        var select = $('#select_bien');
        select.empty(); // Limpiar opciones existentes
        $.each(data, function(index, tipoBien) {
            select.append($('<option></option>').attr('value', tipoBien.id).text(tipoBien.nombre));
        });
    },
    error: function(xhr, status, error) {
        console.error('Error al cargar tipos de bien:', error);
        // Opcional: mostrar un mensaje de error al usuario
    }
});
}

function obtenerResponsableAsignada() {
  var selectArea = document.getElementById("select_area_asig");

  // Verifica si el elemento con el ID "select_area_prov" existe
  if (!selectArea) {
    console.error("El elemento con ID 'select_area_asig' no se encontró.");
    return;
  }

  // Verifica si hay opciones en el elemento select
  if (selectArea.options.length === 0) {
    console.warn("El elemento select no tiene opciones.");
    return;
  }

  var selectedArea = selectArea.options[selectArea.selectedIndex].text;

  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Cuando la solicitud AJAX se completa con éxito
      document.getElementById("select_resp_asig").value = this.responseText;
    }
  };

  // Especifica la ruta al controlador PHP
  xhttp.open(
    "GET",
    "../controllers/reportes/responsable_area.php?nom_area=" +
      encodeURIComponent(selectedArea),
    true
  );
  xhttp.send();
}

function obtenerResponsable() {
  //obtener responsable proveniente
  var selectArea = document.getElementById("select_area_prov");

  // Verifica si el elemento con el ID "select_area_prov" existe
  if (!selectArea) {
    console.error("El elemento con ID 'select_area_prov' no se encontró.");
    return;
  }

  // Verifica si hay opciones en el elemento select
  if (selectArea.options.length === 0) {
    console.warn("El elemento select no tiene opciones.");
    return;
  }

  // Obtén el texto de la opción seleccionada
  var selectedArea = selectArea.options[selectArea.selectedIndex].text;

  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Cuando la solicitud AJAX se completa con éxito
      document.getElementById("select_resp").value = this.responseText;
    }
  };

  // Especifica la ruta al controlador PHP
  xhttp.open(
    "GET",
    "../controllers/reportes/responsable_area.php?nom_area=" +
      encodeURIComponent(selectedArea),
    true
  );
  xhttp.send();
}

// Función para validar si las áreas seleccionadas son iguales
function validarAreas() {
  var areaProv = $("#select_area_prov").val();
  var areaAsig = $("#select_area_asig").val();

  // Verificar si ambas áreas son iguales
  if (areaProv === areaAsig) {
    Swal.fire({
      title: "Advertencia",
      text: "No puedes seleccionar la misma área.",
      icon: "warning",
    });

    // Puedes deshabilitar el botón de enviar o realizar otra acción según tu necesidad
    // Ejemplo: $('#btnEnviar').prop('disabled', true);

    var primeraOpcionAsig = $("#select_area_asig option:first").val();

    // Establecer el valor del combo de área asignada al valor de la primera opción
    $("#select_area_asig").val(primeraOpcionAsig);
    $("#select_resp_asig").val("");
  } else {
    // Si las áreas no son iguales, puedes habilitar el botón de enviar si estaba deshabilitado
    // Ejemplo: $('#btnEnviar').prop('disabled', false);
  }
}

function Buscar_Bien() {
  var tipoBien = $("#select_bien").val(); // Obtén el valor seleccionado del combo box

  if (tipoBien === '0') {
    // Verificar que se haya seleccionado un tipo de bien
    Swal.fire({
      title: "Advertencia",
      text: "Por favor, elija un Tipo de bien antes de buscar.",
      icon: "warning",
    });
    return; // Sale de la función si no se seleccionó un tipo de bien válido
  }

  var codPatrimonial = $("#txt_cod_patrimonial").val(); // Obtén el código patrimonial ingresado por el usuario

  if (!codPatrimonial) {
    Swal.fire({
      title: "Advertencia",
      text: "Por favor, ingrese código patrimonial a buscar",
      icon: "warning",
    });
    return;
  }

  // Realiza la solicitud AJAX
  $.ajax({
    type: "POST",
    url: "../controllers/reportes/buscar_bien_patrimonial.php",
    data: { tipoBien: tipoBien, codPatrimonial: codPatrimonial },
    success: function (data) {
      var datos = JSON.parse(data);

      if (datos === null || datos.length === 0) {
        // Verifica si se encontraron datos o no, No se encontraron datos, muestra una alerta
        Swal.fire({
          title: "Error",
          text: "No se encontraron resultados para el código patrimonial proporcionado.",
          icon: "error",
        });
        $("#txt_marca").val("");
        $("#txt_modelo").val("");
        $("#txt_serie").val("");
      } else {
        // Verifica el estado del producto
        if (datos.estado && datos.estado.toLowerCase() === "malo") {
          // Si el estado es "malo", muestra una alerta
          Swal.fire({
            title: "Advertencia",
            text: "El equipo está dado de baja.",
            icon: "warning",
          });

          $("#txt_marca").val("");
          $("#txt_modelo").val("");
          $("#txt_serie").val("");
        } else {
          // Actualiza los campos del formulario con los datos obtenidos
          $("#txt_marca").val(datos.marca);
          $("#txt_modelo").val(datos.modelo);
          $("#txt_serie").val(datos.serie);
        }
      }
    },
    error: function () {
      alert("Error al buscar el bien.");
    },
  });
}

/*function AgregarEquipo() {
  var tipoBien = $("#select_bien").val();
  var codPatrimonial = $("#txt_cod_patrimonial").val();
  var marca = $("#txt_marca").val();
  var modelo = $("#txt_modelo").val();
  var serie = $("#txt_serie").val();

  // Verificar que al menos uno de los campos de marca, modelo o serie tenga un valor
  if (marca === "" && modelo === "" && serie === "") {
    Swal.fire("Error", "Debe buscar un bien antes de agregarlo", "error");
    return;
  }

  // Verificar si el código patrimonial ya existe en la tabla
  var existeCodPatrimonial = false;
  $("#equipos-table tbody tr").each(function () {
    var codPatrimonialTabla = $(this).find("td:eq(1)").text();
    if (codPatrimonial === codPatrimonialTabla) {
      existeCodPatrimonial = true;
      return false; // Salir del bucle each si se encuentra un duplicado
    }
  });

  if (existeCodPatrimonial) {
    Swal.fire("Error", "Este equipo ya fue agregado", "error");
    //$('#txt_cod_patrimonial').val("");
    //$('#select_bien').val(""); // Establece el valor del select como una cadena vacía
    $("#txt_marca").val("");
    $("#txt_modelo").val("");
    $("#txt_serie").val("");
    return;
  }

  var html = `<tr>
                <td>${tipoBien}</td>
                <td>${codPatrimonial}</td>
                <td>${marca}</td>
                <td>${modelo}</td>
                <td>${serie}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="EliminarEquipo(this)"><i class="fas fa-trash"></i></button></td>
            </tr>`;

  $("#equipos-table tbody").append(html);

  // Limpiar el valor del input de modelo
  $("#txt_marca").val("");
  $("#txt_modelo").val("");
  $("#txt_serie").val("");
  $("#txt_cod_patrimonial").val("");
}*/

function AgregarEquipo() {
  var tipoBienId = $("#select_bien").val(); // Obtén el ID del tipo de bien seleccionado
  var tipoBienNombre = $("#select_bien option:selected").text(); // Obtén el nombre del tipo de bien seleccionado
  var codPatrimonial = $("#txt_cod_patrimonial").val();
  var marca = $("#txt_marca").val();
  var modelo = $("#txt_modelo").val();
  var serie = $("#txt_serie").val();

  // Verificar que al menos uno de los campos de marca, modelo o serie tenga un valor
  if (marca === "" && modelo === "" && serie === "") {
    Swal.fire("Error", "Debe buscar un bien antes de agregarlo", "error");
    return;
  }

  // Verificar si el código patrimonial ya existe en la tabla
  var existeCodPatrimonial = false;
  $("#equipos-table tbody tr").each(function () {
    var codPatrimonialTabla = $(this).find("td:eq(1)").text();
    if (codPatrimonial === codPatrimonialTabla) {
      existeCodPatrimonial = true;
      return false; // Salir del bucle each si se encuentra un duplicado
    }
  });

  if (existeCodPatrimonial) {
    Swal.fire("Error", "Este equipo ya fue agregado", "error");
    $("#txt_marca").val("");
    $("#txt_modelo").val("");
    $("#txt_serie").val("");
    return;
  }

  // Construir la fila HTML con el nombre y el ID del tipo de bien oculto
  var html = `<tr>
                <td class="tipo-bien-id" style="display:none">${tipoBienId}</td>
                <td>${tipoBienNombre}</td>
                <td>${codPatrimonial}</td>
                <td>${marca}</td>
                <td>${modelo}</td>
                <td>${serie}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="EliminarEquipo(this)"><i class="fas fa-trash"></i></button></td>
            </tr>`;

  $("#equipos-table tbody").append(html);

  // Limpiar el valor del input de modelo
  $("#txt_marca").val("");
  $("#txt_modelo").val("");
  $("#txt_serie").val("");
  $("#txt_cod_patrimonial").val("");
}



function EliminarEquipo(button) {
  $(button).closest("tr").remove();
}

function Registrar_Asignacion() {
  let motivo = document.getElementById("select_motivo").value;
  let area_prov = document.getElementById("select_area_prov").value;
  let resp_prov = document.getElementById("select_resp").value;
  let area_asig = document.getElementById("select_area_asig").value;
  let resp_asig = document.getElementById("select_resp_asig").value;
  let fecha = document.getElementById("fecha").value;

  console.log("Motivo:", motivo);
  console.log("Área Proveniente:", area_prov);
  console.log("Responsable Proveniente:", resp_prov);
  console.log("Área Asignada:", area_asig);
  console.log("Responsable Asignado:", resp_asig);
  console.log("Fecha:", fecha);

  // Obtener los detalles de los equipos
  let detallesEquipos = [];
  $("#equipos-table tbody tr").each(function () {
    let tipo_bien = $(this).find("td:eq(1)").text();
    let cod_patrimonial = $(this).find("td:eq(2)").text();
    let marca = $(this).find("td:eq(3)").text();
    let modelo = $(this).find("td:eq(4)").text();
    let serie = $(this).find("td:eq(5)").text();
    detallesEquipos.push({
      tipo_bien: tipo_bien,
      cod_patrimonial: cod_patrimonial,
      marca: marca,
      modelo: modelo,
      serie: serie,
    });
  });

  console.log("Detalles de Equipos:", detallesEquipos);

  // Realizar validaciones
  if (
    motivo === "" ||
    area_asig === "" ||
    resp_asig === "" ||
    fecha === "" ||
    area_prov === "" ||
    resp_prov === ""
  ) {
    Swal.fire("Error", "Complete los campos requeridos", "error");
    return;
  }

  // Verificar si hay al menos un equipo
  if (detallesEquipos.length === 0) {
    Swal.fire(
      "Error",
      "Debe agregar al menos un equipo antes de registrar",
      "error"
    );
    return;
  }

  $.ajax({
    url: "../controllers/reportes/registrar_desplazamiento.php",
    type: "POST",
    data: {
      motivo: motivo,
      area_prov: area_prov,
      responsable_prov: resp_prov,
      area_asig: area_asig,
      responsable_asig: resp_asig,
      fecha: fecha,
      detalles_equipos: detallesEquipos,
    },
  }).done(function (resp) {
    console.log("Respuesta del servidor:", resp);

    if (resp.status === "Success") {
      Swal.fire(
        "Mensaje de Confirmación",
        "Desplazamiento registrado",
        "success"
      ).then((value) => {
        window.location.href = "../views/index.php?view=desplazamientos";
      });
      // Aquí puedes realizar otras acciones después de un registro exitoso
    } else {
      Swal.fire({
        title: "Error",
        text: "Ocurrió un error en el registro",
        icon: "error",
      });
    }
  });
}


  
