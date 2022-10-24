<?php 
	
	trait Status{

		public function status_query($status = "", $notice = "", $data = ""){

			if (!isset($status)) {
				$status = "";
			}
			
			if (!isset($notice)) {
				$notice = "";
			}

			if (!isset($data)) {
				$data = "";	
			}

			return array("status" => $status, "notice" => $notice, "data" => $data);

		}

		public function swicth_status_query($status = "", 
											$succesNotice = "", 
											$infoNotice = "", 
											$errorNotice = "", 
											$data = ""){

			if (!isset($status)) {
				$status = "";
			}
			
			if (!isset($sucessNotice)) {
				$successNotice = "";
			}

			if (!isset($infoNotice)) {
				$infoNotice = "";
			}

			if (!isset($errorNotice)) {
				$errorNotice = "";
			}

			if (!isset($data)) {
				$data = "";	
			}

			switch($status){

				case"done":
				
					$notice = $successNotice;

				break;
				case"no-data":
				
					$notice = $infoNotice;

				break;
				case"error":
				
					$notice = $errorNotice;

				break;

				default:
				
					$notice = "No se reconoce el status".$status;

				break;

			}

			return array("status" => $status, "notice" => $notice, "data" => $data);

		}

		public function status_operation($status = "", $msg = ""){

			if (!isset($status)){
				$status = "";
			}
			
			if (!isset($msg)){
				$msg = "";
			}

			return array("status" => $status, "msg" => $msg);

		}

	}

?>