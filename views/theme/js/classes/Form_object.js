class Form_object{

	constructor(){

		this.variable = null;

		this.boxContent = new Box_content();

		this.msg = new Messages();

		this.valContainer = $("#val-container");

		this.pageMsg  = $("#page-messagesAjax");
		
	}

	set_msg_control(paramFormControl = null, paramMsg = ""){

		var formControl = paramFormControl;
		var msg = paramMsg;

		formControl.setCustomValidity(msg);

	}

	empty_data(data = null){

		let status = true;

		if(data.val() == ""){

			status = false;

		}
	
		return status;

	}

	is_number(data = null){

		let status = true;
		
		if(isNaN(data)){

			status = false;
		
		}

		return status;

	}

	is_telephone(data = null){

		let status = true;

		return status;

	}

	is_cellphone(data = null){

		let status = true;

		return status;

	}

	is_email(data = null){

		let status = true;

		return status;

	}

	is_date(data = null){

		let status = true;

		return status;

	}

	/*prevent_default(formObject, formName, fnName){
        pendiente
		//let formnName = formName;
		//let fnName = fnName;

		formObject.formName.on("submit", function(e){

			e.preventDefault(); 

			formObject.fnName();	

		});

	}*/

	reset_form(params = {"divMessages": null, "dataForm": null}){

		let divMessages = params.divMessages;
		
		let dataForm = params.dataForm;

		this.boxContent.set_div($(divMessages), "");

		this.no_format_validity_form_control(2, dataForm);

	
	}

	//abrir modal
	open_modal(modal = null){

		modal.modal({
			keyboard:true,
			focus:true,
			show:true
		});

	}

	//cerrar modal
	close_modal(modal = null){

		modal.modal("hide");

	}

	get_btns_close_modal(params = {"topBtn":null, "bottomBtn":null, "modal":null, "divMessages":null, "dataForm":null}){
		
		let paramsReset = {"divMessages": params.divMessages, "dataForm": params.dataForm};

		var formMethods = this;

		let boxContent	= this.boxContent;
			
		params.topBtn.click(function(){
		
			formMethods.reset_form(paramsReset);

			boxContent.set_status_bar("close-modal");

		});

		params.bottomBtn.click(function(){
		
			formMethods.reset_form(paramsReset);

			boxContent.set_status_bar("close-modal");

		});

		params.modal.click(function(e){
		
			if(e.target.id == "modal-formCreate"){
				
				formMethods.reset_form(paramsReset);
				
				boxContent.set_status_bar("close-modal");

			}

		});


	}

	set_divs_status_done(params = {"status":"", "notice":"", "table":null, "dataTable":"", "messages":""}){

		this.boxContent.set_status_bar(params.status+" / "+params.notice);

		if(params.table != null && params.table != ""){
			
			this.boxContent.set_div(params.table, params.dataTable);
		
		}

		this.boxContent.set_div(this.pageMsg, this.msg.success_msg(params.messages));

		//console.log(params.notice);

	}

	no_format_validity_form_control(noFormControls = null, formControl = null){

		var status = true;

		if(formControl == null || noFormControls == null){

			status = false;

		}else{
			
			if(noFormControls == 1){

				formControl.val("");
				formControl.css({"border":"", "box-shadow":"none"});

			}else if (noFormControls > 1){

				formControl.each(function(){
		
					$(this).css({"border":"",  "box-shadow":"none"});
					$(this).val("");

				});

			}else{

				status = false;

			}

		}
		
		console.log("quit-format-control-done");

		return status;	

	}

	validity_format_control(params = {"formControl":null, "isValid":null}){

		let formControl = params.formControl;
		let isValid = params.isValid;

		var status = false;

		if(formControl == null || isValid  == null){

			console.log("missing-parameters-in-validity-format-control");

		}else{
			
		
			switch(isValid){

				case true:
		
					$(formControl).css({"border":"solid 1px green", "box-shadow":"0px 0px 10px green"});

					this.set_msg_control(formControl[0], "");

					status = true;

				break;

				case false:
					
					$(formControl).css({"border":"solid 1px tomato", "box-shadow":"0px 0px 10px tomato"});


				break;
				default:

					console.log("Error in isValid");
				
				break;

			}

		}
		
		console.log("format-form-control-done");

		return status;

	}

	select_search_option(valContainer){

		if(searchControl != null && searchControl.val() != ""){
			
			valContainer.val(searchControl.val());		

		}else if(searchControl != null && idCategory != ""){

			valContainer.val(idCategory);

		}else{


			consolor.error("Error on select search option, valContainer:"+valContainer+"searchControl:"+searchControl+", idGropus:"+idGropus);

		}

	}

	empty_data(params = {format:false, formControl:null}){

		var statusValidity = true;

		if(params.format == "undefined" || params.formControl == "undefined"){

			statusValidity = false
		
		}else{

			if(params.formControl.length != undefined){

				let status = [];

				if(params.format == true){

					for(let i=0; i<params.formControl.length; i++ ){

						if(params.formControl[i].value == ""){

							status[i] = this.validity_format_control({"formControl":params.formControl[i], "isValid":false});

						}else{

							status[i] = this.validity_format_control({"formControl":params.formControl[i], "isValid":true});

						}

					}

				}else{

					for( let i=0; i<params.formControl.length; i++ ){

						if(params.formControl[i].value == ""){

							status[i] = false;

						}else{

							status[i] = true;
						
						}

					}

				}

				for(let i=0; i < status.length; i++ ){
							
					if(status[i] == false){

						statusValidity = false;

						break;

					}

				}

			}else{

				if(params.format == true){

					statusValidity = this.validity_format_control({"formControl":formControl, "isValid":true});

					if(params.formControl.value == ""){

						statusValidity = this.validity_format_control({"formControl":formControl, "isValid":false});

					}

				}else{

					if(params.formControl.value == ""){

						statusValidity = false

					}

				}

			}

			console.log("verify-empty-values-done");

		}

		return statusValidity;
		
	}

	

	clean_form_control(formControl = null){

		if(formControl == null){

			console.log("missing params on clean form control");

		}else{
			
			if(formControl[0] == undefined){

				formControl.value = "";

			}else{

				for(let i = 0; i < formControl.length; i++){

					formControl[i].value = "";
				
				};

			}

		}

		return status;	

	}

}