$(window).ready(function(){
	
	start_app();	

});

function start_app(){

	let student = new Student();

	student.change_data();

	student.change_password();

}

