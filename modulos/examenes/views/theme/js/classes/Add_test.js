class Add_test{
	
	constructor(){

		this.urlFile = "modulos/examenes/controllers/ajax/test_controller.php";
		this.ajaxMsg = $("#ajax-msg");
		this.idTest = "";
		
		this.upContainerForm = $(".up-containerForm");
		this.testTableContainer = $("#table-container");
		this.modal = null;

		this.dataConfig = null;
		this.saveConfigBtn = null;
		
		//botones de modal borrar
		this.delTestConfirm = null;

	}

	table_btns(){

		this.statusBtn = $(".status-btn");
		test.test_status_btn();

		this.updateTestBtn = $(".update-testBtn");
		test.update_test_btn();

		this.delTestBtn = $(".del-testBtn");
		test.del_test_btn();

		this.configTestBtn = $(".config-testBtn");
		test.config_test_btn();
	
	}

	show_loaded_form(container = "", data = ""){

		container.html(data.data);

		let setTestWrap = $("#update-testWrap");//contenedor de formulario. biene por ajax
		
		setTestWrap.toggle("slow");

	}

	hide_loaded_form(container = ""){
		
		let setTestWrap = $("#update-testWrap");
		
		setTestWrap.toggle("slow");
				
	}

	test_status_btn(){

		let test = this;
		
		this.statusBtn.click(function(){
			
				let dataBtn = this.value.split("||");//extraer valores del btn

				let idTest = dataBtn[0];
				let status = dataBtn[1];

				let container = $("#status-btn"+idTest);

					let dataJson = {
									request:"updateTestStatus",
									status:status,
									idTest:idTest
								};

					$.ajax({
							
						url:test.urlFile,
						data:dataJson,
						type: "post",
						beforeSend: function(data){
							
							console.log("wait...");

						},
						success:function(dataAjax = ""){

							let data = dataAjax;

							data = JSON.parse(data);
							
							if(data.status == "done"){

								console.log(data.notice);

								if(data.data == 1){

									container.val(idTest+"||"+1);//cambiar valores en btn
									container.html("Activo");//cambiar texto en btn
									main.changeClass(container, 
										             "Inactivo", 
										             "Activo");//cambiar clases
									
								}else{

									container.val(idTest+"||"+0);
									container.html("Inactivo");
									main.changeClass(container, 
										             "Activo", 
										             "Inactivo");
							
								}

								test.ajaxMsg.html(main.msg.success_msg(data.notice)); 

							}else{
							
							
								console.log(data.status+" - "+data.notice);
								container.html(main.msg.msg_type(data.status, data.notice));
								
							}

						},
						error: function(data){
							
							console.log("Error actualizar el estado del examen - "+data.status+" - "+data.statusText);
						
						}
						
					});



		});

	}

	update_test_btn(){
	
		let test = this;

		/*variable de apollo para abrir o cerrar formulario
		la condicion para abrir es que esta vacio el contenedor de formulario,
		pero en ocaciones tendra un msg, entonces, con la variable openForm ayudamos
		a que reconosca que ya no hay formulario abiero y abra el formulario correspondiente
		nuevamente*/
		let openForm = false;

		this.updateTestBtn.click(function(){

			let idTest = this.value;

			let container = $("#up-containerForm"+idTest);

			if(container.html() == '' || openForm == false){

				test.upContainerForm.html("");

				let dataJson = {
								request:"getUpdateTestForm",
								idTest:idTest
							};

				$.ajax({
						
					url:test.urlFile,
					data:dataJson,
					type: "post",
					beforeSend: function(){

						console.log("wait...");

					},
					success:function(dataAjax = ""){

						let data = dataAjax;

						data = JSON.parse(data);
						

						if(data.status == "done"){

							console.log(data.notice);

							test.show_loaded_form(container, data);

							openForm  = true;

							let updateTestForm = $("#update-testForm");//form para actualizar nombre del examen

							updateTestForm.submit(function(e){

								e.preventDefault();

								let testName = $("#upTestName").val();//extraer nombre 

								let dataJson = {
												request:"updateTestName",
												testName:testName,
												idTest:idTest
												};

								$.ajax({
						
									url:test.urlFile,
									data:dataJson,
									type: "post",
									beforeSend: function(data){

										console.log("wait...");

									},
									success:function(dataAjax){

										let data = JSON.parse(dataAjax);

										console.log(data.notice);

										let testNameTxt = $("#test-name"+idTest);//contenedor del nombre del examen

										testNameTxt.html(data.data);//cargar nuevo nombre

										if(data.status == "done"){

											container.html(main.msg.success_msg(data.notice));

										}else{

											container.html(main.msg.msg_type(data.status, data.notice));

										}

										openForm = false;
									
									},
									error:function(data){

										console.log("Error al actualizar el nombre del examen - "+data.status+" - "+data.statusText);

									}

								});

							});

						}else{
						
							if(data.status == "error"){

								console.log(data.status+" - "+data.notice);

								container.html(main.msg.info_msg(data.notice));

							}
						
						}

					},
					error: function(data){
						
						console.log("Error al cargar formulario - "+data.status+" - "+data.statusText);
					
					}
					
				});

			}else{

				test.hide_loaded_form(container);

			}

		});

	}

	del_test_btn(){

		let test = this; 

		this.delTestBtn.click(function(e){

			let btn = e.target;

			test.delBtn = btn;

			test.idTest = btn.value;

			let testName = $("#test-name"+test.idTest).html();//extraer el nombre del examen

			test.modal = $("#del-testModal");

			main.show_modal(test.modal);

			$("#modal-testName").html(testName);//colocar el nombre del examen

			test.delTestConfirm = $("#del-testConfirm");

			test.del_test();

		});		

	}

	del_test(){

		//borrar examen

		let test = this;

		test.delTestConfirm.off("click");

		test.delTestConfirm.click(function(e){
								
				let idTest = test.idTest;

				let dataJson = {
								request:"delTest",
								idTest:idTest,
							   };

				$.ajax({
				
					url:test.urlFile,
					data:dataJson,
					type: "post",
					beforeSend: function(){

						console.log("wait...");

					},
					success:function(data = ""){
						
						data = JSON.parse(data);
						
						if(data.status == "done"){

							console.log(data.notice);
						
							test.dataTable.row(test.delBtn.parentNode.parentNode.parentNode).remove().draw();

							main.hide_modal(test.modal);

							test.table_btns();
							
							test.ajaxMsg.html(main.msg.success_msg(data.notice));									

						}else{
						
							console.log(data.status+" - "+data.notice);

							test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

						}

					},
					error: function(data){

						console.log("Error al borrar la pregunta - "+data.status+" - "+data.statusText);
					
					}
				
				});

		});

	}

	config_test_btn(){

		let test = this; 

		this.configTestBtn.click(function(e){

			let btn = e.target;

			test.idTest = btn.value;

			//let testName = $("#test-name"+test.idTest).html();//extraer el nombre del examen

			test.modal = $("#config-testModal");

			main.show_modal(test.modal);//abrir modal

			test.saveConfigBtn = $("#save-configBtn");

			test.config_test();

			let dataJson = {
				request: "getConfigTestData",
				idTest:test.idTest
			}

			test.dataConfig = $(".data-config");

			test.dataConfig.each(function(){

				this.value="";
			});

			$.ajax({
				
					url:test.urlFile,
					data:dataJson,
					type: "post",
					beforeSend: function(){

						console.log("wait...");

					},
					success:function(data = ""){
			
						data = JSON.parse(data);
						
						if(data.status == "done"){

							console.log(data.notice);

							test.dataConfig[0].value = data.data.hourAp;
							test.dataConfig[1].value = data.data.dateAp;
							test.dataConfig[2].value = data.data.hourEx;
							test.dataConfig[3].value = data.data.dateEx;
							test.dataConfig[4].value = data.data.promMin;
				
						}else{
						
							console.log(data.status+" - "+data.notice);

						}

					},
					error: function(data){

						console.log("Error al borrar la pregunta - "+data.status+" - "+data.statusText);
					
					}
				
				});


			//$("#modal-testName").html(testName);//colocar el nombre del examen
			

		});		

	}

	config_test(){

		//configurar examen

		let test = this;

		test.saveConfigBtn.off("click");

		test.saveConfigBtn.click(function(e){
								
				let idTest = test.idTest;

				let dataJson = {
								request:"updateTestConfig",
								hourAp:test.dataConfig[0].value,
							    dateAp:test.dataConfig[1].value,
								hourEx:test.dataConfig[2].value,
								dateEx:test.dataConfig[3].value,
								promMin:test.dataConfig[4].value,
								idTest:idTest
							   };
	
				$.ajax({
				
					url:test.urlFile,
					data:dataJson,
					type: "post",
					beforeSend: function(data){

						console.log("wait...");

					},
					success:function(data = ""){
						
						data = JSON.parse(data);
						
						if(data.status == "done"){

							console.log(data.notice);
						
							main.hide_modal(test.modal);

							test.ajaxMsg.html(main.msg.success_msg(data.notice));									

							let testDate = $("#test-dateApli"+idTest);

							testDate.html(dataJson.dateAp+" / "+dataJson.hourAp);

						}else{
						
							console.log(data.status+" - "+data.notice);

							test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

						}

					},
					error: function(data){

						console.log("Error al borrar la pregunta - "+data.status+" - "+data.statusText);
					
					}
				
				});

		});

	}

}