class Validator{

	constructor(){

	}

	empty_json(params = ""){

		var statusValidity = true;

		if(params == ""){

			console.log("missing params");
			
			statusValidity = false;

		}else{


			let status = [];

			let c = 0;

			Object.keys(params).forEach(function(key){
			
				if(params[key] == ""){

					status[c] = false;

				}else{

					status[c] = true;
				
				}

				c++;
			
			});
			console.log(status);
			for(let i=0; i < status.length; i++ ){
							
				if(status[i] == false){

					statusValidity = false;

					break;

				}

			}
			
		}
		console.log(statusValidity);

		return statusValidity;
		
	}

}