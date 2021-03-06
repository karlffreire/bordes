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

function cargaPaises(callback,ponvalores){
  $.ajax({
    url: './datos/cargaPaises.php',
    success: function(response){
        if (response) {
          callback(response,ponvalores);
        }
        else{
          alert('Error cargando los paises');
        }
      }
  });
}

function ponSelPais(resultado,ponvalores = false){
  if (ponvalores) {
    ponSelecPais(resultado).done(ponValPais());
  }
  else {
    ponSelecPais(resultado);
  }
}

function ponSelecPais(datos){
  var r = $.Deferred();
  $('.selec-pais').select2({
    data:datos
  })
  return r;
}

function coloreaToponimos (data) {
 if (data.idnomenclator == 2) {
    return $('<span class="hgis">'+data.text+' (HGIS-indias)</span>');
  }
  else if (data.idnomenclator == 1){
    return $('<span class="geonames">'+data.text+' ( Geonames)</span>');
  }
};

function toponimoSeleccionado (data) {
 if (data.idnomenclator == 2) {
    return $('<span class="hgis">'+data.text+' (<a href="https://www.hgis-indias.net/dokuwiki/doku.php?id=gazetteer:'+data.idexterno+'" target="_blank">Ver en HGIS-indias</a>)</span>');
  }
  else if (data.idnomenclator == 1){
    return $('<span class="geonames">'+data.text+' (<a href="http://www.geonames.org/'+data.idexterno+'" target="_blank">Ver en geonames</a>)</span>');
  }
};

function habToponimo(origen,idsel){
	var campo = document.getElementById(idsel);
	campo.disabled = false;
	ponSelecTopo(origen,idsel);
}

function ponSelecTopo(origen,idsel){
	var idpais = document.getElementById(origen.id).value;
	$("#"+idsel).select2({
		minimumInputLength: 3,
    templateResult: coloreaToponimos,
    templateSelection: toponimoSeleccionado,
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
  else if (pagina == 'propiedades' || pagina == 'objetos') {
    cargaObjetos(ponSelObjetos);
  }
  else if (pagina == 'menciones') {
    cargaPersonas(ponSelPersonas);
  }
  else if (pagina == 'acontecimientosdescritos') {
    cargaAcontecimientos(ponSelAcontecimientos);
  }
}

function cargaAcontecimientos(callback){
  $.ajax({
    url: './datos/cargaAcontecimientos.php',
    success: function(response){
        if (response) {
          callback(response);
        }
        else{
          alert('Error cargando acontecimientos');
        }
      }
  });
}

function ponSelAcontecimientos(resultado){
    $('.selec-acont').select2({
    data:resultado
  });
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


function cargaLugares(callback,ponvalores=false){
  $.ajax({
    url: './datos/cargaLugares.php',
    success: function(response){
        if (response) {
          callback(response,ponvalores);
        }
        else{
          alert('Error cargando lugares');
        }
      }
  });
}

function ponSelLugares(resultado,ponvalores){
  if (ponvalores) {
    ponSelecLugares(resultado).done(ponValLugares());
  }
  else{
    ponSelecLugares(resultado);
  }
}

function ponSelecLugares(datos){
  var r = $.Deferred();
  for (var i = 0; i < datos.length; i++) {
    $(".selec-lugares").append(new Option(datos[i].text, datos[i].id));
  }
  return r;
}

function habLugarNuevo(existente,nuevo){
  $('#'+existente).remove();
  $('#'+nuevo).removeClass('hidden');
}

function cargaPersonas(callback,ponvalores=false){
  $.ajax({
    url: './datos/cargaPersonas.php',
    success: function(response){
        if (response) {
          callback(response,ponvalores);
        }
        else{
          alert('Error cargando personas');
        }
      }
  });
}

function ponSelPersonas(resultado,ponvalores){
  if (ponvalores) {
    ponSelecPersonas(resultado).done(ponValPersonas());
  }
  else{
    ponSelecPersonas(resultado);
  }
}


function ponSelecPersonas(resultado){
    var r = $.Deferred();
    $('.selec-persona').select2({
    data:resultado
  });
  return r;
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

function ponSelHonraDecoro(){
    honra =
      [
       {
         "id": "Mujer",
         "text": "Mujer"
       },
       {
         "id": "Hombre",
         "text": "Hombre"
       },
       {
         "id": "Vestimenta",
         "text": "Vestimenta"
       },{
         "id": "Nobleza",
         "text": "Nobleza"
       },{
         "id": "Escritura",
         "text": "Escritura"
       },{
         "id": "Negocios",
         "text": "Negocios"
       }
     ]
    ;
    $('.sel-honra').select2({
    data:honra
  });
}

function ponSelConsejosViaje(){
    consejos =
      [
       {
         "id": "Robo",
         "text": "Robo"
       },
       {
         "id": "Violencia",
         "text": "Violencia"
       },
       {
         "id": "Vestimenta",
         "text": "Vestimenta"
       },{
         "id": "Mujer",
         "text": "Mujer"
       },{
         "id": "Acompañamiento",
         "text": "Acompañamiento"
       },{
         "id": "Peligro naufragio",
         "text": "Peligro naufragio"
       }
     ]
    ;
    $('.sel-consejos').select2({
    data:consejos
  });
}

function ponSortable(iddiv){
  $('#'+iddiv).sortable();
}

function habBoton(iddiv){
  $('#'+iddiv).attr('disabled',false);
}

function deshabBoton(iddiv){
  $('#'+iddiv).attr('disabled',true);
}

function validaNuevaPersona(){
   var formulario = document.forms["form-persona"];
   console.log(formulario);
}

function selTipoHomonimia(){
  var tipohom = $('#tipohomonimia').val();
  if (tipohom == 'Apodo') {
    deshabBoton('apellidos');
  }
  else {
    habBoton('apellidos');
  }
}
