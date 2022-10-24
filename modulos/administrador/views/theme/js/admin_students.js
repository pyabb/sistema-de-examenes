$(window).ready(function(){
	
	start_app();	

});

function start_app(){

	let student = new Student();

	student.urlFile = "modulos/administrador/controllers/ajax/admin_student_controller.php";

	//data table
	get_dataTable(student);


}

function get_dataTable(student = null){

	$('#admin-studentTable').DataTable({
		searching:true,
		initComplete:function(){
	
			$("#admin-studentTable_filter").detach().appendTo("#admin-table_filter");
	
		},
		language:{
			//search:""
		    "sProcessing":     "Procesando...",
		    "sLengthMenu":     "Mostrar _MENU_ registros",
		    "sZeroRecords":    "No se encontraron resultados",
		    "sEmptyTable":     "Ningún dato disponible en esta tabla",
		    "sInfo":           "Mostrando registros",
		    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
		    "sInfoFiltered":   "(filtrando registros)",
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
	
	let astflinput = $("#admin-studentTable_filter label input");
	astflinput.addClass("form-control");
	astflinput.attr("id", "search-txt")
	astflinput.attr("aria-describedby", "basic-addon1");
	
	let tableFilter = $("#admin-studentTable_filter label");
	tableFilter.addClass("input-group");
	tableFilter.html(tableFilter.html()+'<button type="submit" class="btn search-btn fas fa-search" id="search-btn"></button>');

	student.dataTable = $('#admin-studentTable').DataTable();
	
	let searchTxt = $("#search-txt");

	$("#search-form").submit(function(e){
		
		e.preventDefault();
		
		student.dataTable.search(searchTxt.val()).draw();
	
	});

}