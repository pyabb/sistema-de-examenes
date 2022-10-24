<?php

	trait Messages{

    	public static function status_notice($status = "", 
    		                                 $notice =  ""){

      		if($status == "" ){
				
				$message = "<div class='alert alert-warning'>
								Falta status
							</div>";      		

      		}else{

	      		switch($status){

	      			case"done":

	      				$message = Messages::success_msg($notice);
	      			
	      			break;
	      			case"no-data":

	      				$message = Messages::info_msg($notice);

	      			break;
	      			break;
	      			case"error":

	      				$message = Messages::danger_msg($notice);

	      			break;
	      			default:
						
	      				$message = Messages::danger_msg("Invalid status");

	      			break;
	      		
	      		}

	      	}	

      		return $message; 

    	}

    	public static function server_message($message){

			return "<div style='font-size:200%;'>
						<strong>$message</strong>
					</div>";

    	}

    	public static function success_msg($message){

			return "<div class='alert alert-success'>	
						$message						
					</div>";
					
    	}

    	public static function warning_msg($message){

			return "<div class='alert alert-warning'>	
						$message						
					</div>";
					
    	}

    	public static function danger_msg($message){

			return "<div class='alert alert-danger'>	
						$message						
					</div>";
					
    	}

    	public static function info_msg($message){

			return "<div class='alert alert-info'>	
						$message						
					</div>";
					
    	}


	}


?>