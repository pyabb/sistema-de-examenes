
let main = {
			 loaderWrap:"<div class='loader-wrap'><img src='/EMN v2/app/img/loader.gif' title='loader'></div>",
			 msg: new Messages(),
			 changeClass:function(target = "", 
			 	                  oldClass = "", 
			 	                  newClass = ""){

			 	target.removeClass(oldClass);
			 	target.addClass(newClass);

			 },
			 show_modal(modal = ""){

				modal.modal("show");

			 },
			 hide_modal(modal = ""){

				modal.modal("hide");

			 },dataTable: function(params = {
			 	instObject:null,
			 	table: null,
			 	tableFilter: null,
			 	newTableFilter: null,
			 	tfInput: null, 
			 	tfLabel: null,
			 	searchTxt: null,
			 	searchForm: null

			 }){

			 	let t = $(params.table).DataTable({
					searching:true,
					initComplete:function(){
				
						$(params.tableFilter).detach().appendTo(params.newTableFilter);
				
					},
					language:{
						//search:""
					    "sProcessing":     "Procesando...",
					    "sLengthMenu":     "Mostrar _MENU_ registros",
					    "sZeroRecords":    "No se encontraron resultados",
					    "sEmptyTable":     "Ningún dato disponible en esta tabla",
					    "sInfo":           "Mostrando registros",
					    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
					    "sInfoFiltered":   "(filtrado registros)",
					    "sInfoPostFix":    "",
					    "sSearch":         "",
					    "sUrl":            "",
					    "sInfoThousands":  ",",
					    "sLoadingRecords": "Cargando...",
					    "oPaginate": {
					        "sFirst":    "Primero",
					        "sLast":     "Último",
					        "sNext":     "Siguiente",
					        "sPrevious": "Anterior"
					    },
					    "oAria": {
					        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
					        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
					    }
					    
					}
				
				});	
				
				let tflinput = $(params.tfInput);
				tflinput.addClass("form-control");
				tflinput.attr("id", "search-txt")
				tflinput.attr("aria-describedby", "basic-addon1");
				
				let tableFilter = $(params.tfLabel);
				tableFilter.addClass("input-group");
				tableFilter.html(tableFilter.html()+'<button type="submit" class="btn search-btn fas fa-search" id="search-btn"></button>');

				let dataTable = t;
				
				if( params.instObject != null ) params.instObject.dataTable = t;

				let searchTxt = $(params.searchTxt);

				$(params.searchForm).submit(function(e){
					
					e.preventDefault();
					
					dataTable.search(searchTxt.val()).draw();
				
				});

			 }

		};