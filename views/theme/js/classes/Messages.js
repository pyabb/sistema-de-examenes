class Messages{

	constructor(){

	}

	success_msg(msg = ""){

		return "<div class='alert alert-success'>"+msg+"</div>";

	}

	info_msg(msg = ""){

		return "<div class='alert alert-info'>"+msg+"</div>";

	}

	warning_msg(msg = ""){

		return "<div class='alert alert-warning'>"+msg+"</div>";

	}

	danger_msg(msg = ""){

		return "<div class='alert alert-danger'>"+msg+"</div>";

	}

	msg_type(msgType = "", $msg = ""){

		switch(msgType){

			case'done':

				return this.done_msg($msg);

			break;
			case'no-data':

				return this.info_msg($msg);
			
			break;
			case'warning':
			
				return this.warning_msg($msg);

			break;
			case'error':
			
				return this.danger_msg($msg);

			break;
			default:

				return this.danger_msg("Tipo de mensage desconocido");
			
			break;

		}
	}	

}