$(window).ready(function(){
	
	start_app();	

});

function start_app(){

	let paginator = new PageItemsPaginator({
		totalItems:4,
		itemsWrap:$("#test-wrapRow"),
		totalRecords:$("#test-number").val(),
		urlFile:"modulos/alumnos/controllers/ajax/done_test_controller.php"
	});

}



