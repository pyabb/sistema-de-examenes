$(window).ready(function(){

	start_app_evaluations();

});


function start_app_evaluations(){

	//data table
	main.dataTable(params = {
			 	table: '#test-table',
			 	tableFilter: "#test-table_filter",
			 	newTableFilter: "#admin-table_filter",
			 	tfInput: "#test-table_filter label input", 
			 	tfLabel: "#test-table_filter label",
			 	searchTxt: "#search-txt",
			 	searchForm: "#search-form"

			 });
	
}
