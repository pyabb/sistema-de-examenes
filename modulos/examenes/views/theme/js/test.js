$(window).ready(function(){

	start_app_test();

});

let test = null;

function start_app_test(){

	let genObject = new  Add_test();

	test = genObject;

	test.table_btns();

	//data table
	main.dataTable(params = {
			 	instObject:test,
			 	table: '#test-table',
			 	tableFilter: "#test-table_filter",
			 	newTableFilter: "#admin-table_filter",
			 	tfInput: "#test-table_filter label input", 
			 	tfLabel: "#test-table_filter label",
			 	searchTxt: "#search-txt",
			 	searchForm: "#search-form"

			 });
	
}
