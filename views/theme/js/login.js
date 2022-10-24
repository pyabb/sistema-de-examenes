$(window).ready(function(){

	start_login();

});

function start_login(){

	let typeUser = $("#typeUser");
	let addLink = $("#addLink");

	typeUser.change(function(){

		if(typeUser.val() == "alumn"){

			addLink.css("display", "block");

		}else{
			
			addLink.css("display", "none");

		}

	});

}
