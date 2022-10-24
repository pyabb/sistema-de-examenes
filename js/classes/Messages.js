class Messages{

	constructor(){

	}

	success_msg(msg = ""){

		return "<div class='alert-success'>"+msg+"</div>";

	}

	info_msg(msg = ""){

		return "<div class='alert-info'>"+msg+"</div>";

	}

	warning_msg(msg = ""){

		return "<div class='alert-warning'>"+msg+"</div>";

	}

	danger_msg(msg = ""){

		return "<div class='alert-danger'>"+msg+"</div>";

	}	

}