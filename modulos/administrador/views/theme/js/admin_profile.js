$(window).ready(function(){
	
	start_app();	

});

function start_app(){

	let admin = new Admin();

	admin.change_data();

	admin.change_password();

}

