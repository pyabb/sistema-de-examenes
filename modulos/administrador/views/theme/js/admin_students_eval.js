$(window).ready(function(){

	start_app_evaluations();

});


function start_app_evaluations(){

	let admin = new Admin();

	admin.urlFile = "modulos/administrador/controllers/ajax/evaluated_students_controller.php";	
	
	admin.pageMsg = $("#page-msg");

	//data table
	main.dataTable(params = {
				instObject:admin,
			 	table: '#students-table',
			 	tableFilter: "#students-table_filter",
			 	newTableFilter: "#admin-table_filter",
			 	tfInput: "#students-table_filter label input", 
			 	tfLabel: "#students-table_filter label",
			 	searchTxt: "#search-txt",
			 	searchForm: "#search-form"

			 });
	
}
