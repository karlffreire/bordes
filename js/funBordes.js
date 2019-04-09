function paginaTablas() {
    $('.tabla-ppal').DataTable({
    	ordering: false,
    	dom: "<'col-md-2 pull-right'f>" +"<'row'<'col-sm-12'tr>>" +"<'row'<'col-sm-5'i><'col-sm-7'p>>",
    	renderer: "bootstrap",
    	language: {
    		"search": "_INPUT_",
    		"infoEmpty": "",
    		"emptyTable": "No hay datos que mostrar",
        	"searchPlaceholder": "Buscar...",
	    	"paginate": {
	            previous: 'Previo',
	            next:     'Siguiente'
	        },
		    "info": "Mostrando registros _START_ al _END_ de _TOTAL_"
			}
    });
}

function cargaPaises(callback){
  $.ajax({
    url: './datos/cargaPaises.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando los paises');
        }
      }
  });
}

function ponSelPais(resultado){
  ponSelecPais(resultado).done(ponValPais());
}

function ponSelecPais(datos){
  var r = $.Deferred();
  $('.selec-pais').select2({
    data:datos
  })
  return r;
}

function habToponimo(origen,idsel){
	var campo = document.getElementById(idsel);
	campo.disabled = false;
	ponSelecTopo(origen,idsel);
}

function ponSelecTopo(origen,idsel){
	var idpais = document.getElementById(origen.id).value;
	$("#"+idsel).select2({
		minimumInputLength: 3,
		ajax: {
			delay: 450,
			type: 'GET',
			url: "./datos/buscaToponimo.php",
	   		dataType: 'json',
	   		data: function (params) {
            	var consulta = {
                	termino: params.term,
                	pais: idpais
            	};
            	return consulta;
        	},
	       processResults: function (data) {
                return {
                    results: data
                };
            }
        },
		placeholder: "Selecciona topónimo",
		cache: true,
		escapeMarkup: function (markup) { return markup; }
	});
}

function alertaBorrado(url){
    if (confirm("Esto borrará un registro") == true) {
        window.location.href = url;
    } else {

    }
}

function cargaListados(pagina){
  if (pagina == 'cargos') {
    cargaInstituciones(ponSelInstitucion);
  }
  else if (pagina == 'parientes') {
    cargaPersonas(ponSelPersonas);
    cargaParentescos(ponSelParentescos);
  }
  if (pagina == 'propiedades') {
    cargaObjetos(ponSelObjetos);
  }
}

function cargaInstituciones(callback){
  $.ajax({
    url: './datos/cargaInstituciones.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando las instituciones');
        }
      }
  });
}

function ponSelInstitucion(resultado){
    $('.selec-insti').select2({
    data:resultado
  });
}

function cargaPersonas(callback){
  $.ajax({
    url: './datos/cargaPersonas.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando personas');
        }
      }
  });
}

function ponSelPersonas(resultado){
    $('.selec-persona').select2({
    data:resultado
  });
}

function cargaParentescos(callback){
  $.ajax({
    url: './datos/cargaParentescos.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando personas');
        }
      }
  });
}

function ponSelParentescos(resultado){
    $('.selec-parentesco').select2({
    data:resultado
  });
}

function cargaObjetos(callback){
  $.ajax({
    url: './datos/cargaObjetos.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando objetos');
        }
      }
  });
}

function ponSelObjetos(resultado){
    $('.selec-objeto').select2({
    data:resultado
  });
}

function ponSelTramites(){
    tramites =
      [
       {
         "id": "Fe de vida",
         "text": "Fe de vida"
       },
       {
         "id": "Deudas",
         "text": "Deudas"
       },
       {
         "id": "Poderes",
         "text": "Poderes"
       },{
         "id": "Pleitos",
         "text": "Pleitos"
       },{
         "id": "Escrituras",
         "text": "Escrituras"
       },{
         "id": "Herencias",
         "text": "Herencias"
       },{
         "id": "Licencias",
         "text": "Licencias"
       },{
         "id": "Cédulas",
         "text": "Cédulas"
       },{
         "id": "Dote",
         "text": "Dote"
       },{
         "id": "Matrimonio",
         "text": "Matrimonio"
       },{
         "id": "Muerte",
         "text": "Muerte"
       }
     ]
    ;
    $('.sel-tramites').select2({
    data:tramites
  });
}


function cargaLugares(callback){
  $.ajax({
    url: './datos/cargaLugares.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando lugares');
        }
      }
  });
}

function ponSelLugares(resultado){
  ponSelecLugares(resultado).done(ponValLugares());
}

function ponSelecLugares(datos){
  var r = $.Deferred();
  for (var i = 0; i < datos.length; i++) {
    $(".selec-lugares").append(new Option(datos[i].text, datos[i].id));
  }
  return r;
}


function habLugarNuevo(existente,nuevo){
  $('#'+existente).hide();
  $('#'+nuevo).removeClass('hidden');
}
