function tablasDatos(pagina) {
  if (pagina == 'cartas') {
    url = './datos/tablaCartas.php';
    columnas =[
      { "data": "fecha"},
      { "data": "identificador"},
      { "data": "asunto"},
      { "data": "palabrasclave"},
    // { "data": "emisor", "render": function(data){return data.nombre;}},
    ];
  }
  $('.tabla-ppal').DataTable({
    "ajax": {
        "url": url,
        "cache": true,
         dataSrc: ''
      },
    "columns": columnas,
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
