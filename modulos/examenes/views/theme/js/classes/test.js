class Test{

	constructor(){

		this.urlFile = "modulos/examenes/controllers/ajax/write_questions_controller.php";
		this.idTest = $("#idTest").val();
		this.ajaxMsg = $("#ajax-msg");
		this.idTestVal = "";
		this.idTestQuestion = "";
		this.idTestAns = "";
		this.modal = null;

		this.addInstructions = $("#addInstructions");//btn para abrir formulario para agregar las instrucciones	
		this.sendInstructionsBtn = $("#sendInstructionsBtn");
		this.addInstWrap = $("#add-instructionsWrap");
		this.addInstForm = $("#idInstuctionsForm");
		this.instructionsTxt = $("#instructionsTxt");
		this.instContainer = $("#inst-container");

		this.addQuetion = $("#addQuetion");//btn para abrir formulario para agregar preguntas 
		this.addQuestionWrap = $("#add-questionWrap");	
		this.questionWrap = $("#questions-wrap");
		this.testListWrap = $("#test-listWrap");//contenedor de lista de preguntas
		this.addQuestionForm = $("#idQuestionForm");//formulario para agregar preguntas
		this.questionTxt = $("#questionTxt");//text area para escribir pregunta
		this.addQuestionBtn = $("#addQuestionBtn");
		this.delQuestionBtn = null;//btns para borrar preguntas
		this.upQuestionBtn = null;//btn para actualizar pregunta
		
		this.questionItem = null;//contenedor de la pregunta
	
		
		
		this.addAnswerFormWrap = $(".add-answerFormWrap");//contenedor por pregunta para cargar formularios 
		this.addAnswerBtn = null;//btn para agregar respuesta
		this.upAnswerBtn = null;//btn para actualizar respuesta
		this.delAnswer = null;//btn para borrar respuesta
		this.answerWrap = null;//contenedor de respuestas para cada pregunta
		this.answerItem = null;//contenedor de la respuesta
		this.delTestConfirm = null;//boton del modal para cerrar

	}


	test_btns(){

		this.checkBoxAnswer = $(".check-boxAnswer");
		this.check_box_answer();

		this.delQuestionBtn = $(".del-questionBtn");//btns para borrar preguntas
		this.del_question_btn();

		this.upQuestionBtn = $(".update-questionBtn");//btn para actualizar pregunta
		this.update_question();

		this.addAnswerBtn = $(".add-answerBtn");//btn para agregar respuesta
		this.add_answer();
		
		this.delAnswerBtn = $(".del-answerBtn");//btn para borrar respuesta	
		this.del_answer_btn();

		this.upAnswerBtn = $(".update-answerBtn");//btn para actualizar respuesta
		this.update_answer();

	}

	check_box_answer(){

		let test = this;

		test.checkBoxAnswer.click(function(){
			
			let thisBtn = this; 

			let btn = $(thisBtn).val();
			
			btn = btn.split("||");
			
			let idAnswer = btn[0];
			let idQuestion = btn[1];
			let correct = btn[2];
					
						let dataJson = {
							request:"addCorrectAnswer",
							idTest:test.idTest,
							idQuestion:idQuestion,
							idAnswer:idAnswer,
							correct:correct
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

										$(thisBtn).val(idAnswer+"||"+idQuestion+"||"+data.data);

										let answerItem = $("#answer-item"+idAnswer);
								
										if(data.data== "1"){

											main.changeClass(answerItem,
											             "normal-answer",
											             "correct-answer");

											thisBtn.checked = true;

										}else{

											main.changeClass(answerItem,
											             "correct-answer",
											             "normal-answer");

											thisBtn.checked = false;

										}								

										test.ajaxMsg.html(main.msg.success_msg(data.notice));

									}else{
									
										console.log(data.status+" - "+data.notice);

										test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

									}

								},
								error: function(data){
									
									console.log("Error al registrar la respuesta correcta - "+data.status+" - "+data.statusText);
								
								}
							
						});


			
		});		

	}

	test_btns_answer(){

		this.checkBoxAnswer = $(".check-boxAnswer");
		this.check_box_answer();

		this.delAnswerBtn = $(".del-answerBtn");//btn para borrar respuesta	
		this.del_answer_btn();

		this.upAnswerBtn = $(".update-answerBtn");//btn para actualizar respuesta
		this.update_answer();

	}

	add_instructions(){

		let test = this;

		test.addInstructions.click(function(){

			test.addQuestionWrap.css("display", "none");
					
			test.addInstWrap.toggle("slow", function(e){

					//extraer instrucciones	
					if(this.style.display == "block"){

						let dataJson = {
							request:"getInstructions",
							idTest:test.idTest
						};

						$.ajax({
								
								url:test.urlFile,
								data:dataJson,
								type: "post",
								beforeSend: function(){

									console.log("wait...");

								},
								success:function(data = ""){
									console.log(data);
									
									data = JSON.parse(data);
									
									if(data.status == "done"){

										console.log(data.notice);

										test.instructionsTxt.val(data.data);

									}else{
									
										console.log(data.status+" - "+data.notice);

										test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

									}

								},
								error: function(data){
									
									console.log("Error al enviar instrucciones - "+data.status+" - "+data.statusText);
								
								}
							
						});

					}//style

			});//toggle

		});

		test.addInstForm.submit(function(e){
				
				e.preventDefault();

				let dataJson = {
								request:"addInstructions",
								instructions:test.instructionsTxt.val(), 
								idTest:test.idTest
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

							test.ajaxMsg.html(main.msg.success_msg(data.notice));

							test.instructionsTxt.val("");

							test.addInstWrap.hide();

							test.instContainer.html(data.data);

						}else{
						
							console.log(data.status+" - "+data.notice);

							test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

						}

					},
					error: function(data){
						
						console.log("Error al enviar instrucciones - "+data.status+" - "+data.statusText);
					
					}
				
				});

			});

	}

	add_question(){

		//agregar preguntas

		let test = this;
		
		test.addQuestionBtn.click(function(){

			test.addInstWrap.css("display", "none");
			
			test.addQuestionWrap.toggle("slow");

		});	

		test.addQuestionForm.submit(function(e){
				
				e.preventDefault();

				console.log("guardar");

				let dataJson = {
								request:"addQuestion",
								question:test.questionTxt.val(), 
								idTest:test.idTest
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

							test.ajaxMsg.html(main.msg.success_msg(data.notice));

							test.questionTxt.val("");//borrando pregunta escrita 

							test.addQuestionWrap.hide();

							test.testListWrap.html(data.data);//cargar las preguntas

							//botones
							test.test_btns();

						}else{
						
							console.log(data.status+" - "+data.notice);

							test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

						}

					},
					error: function(data){
					
						console.log("Error al registrar la pregunta - "+data.status+" - "+data.statusText);
					
					}
				
				});

			});

	}

	update_question(){

		//editar pregunta

		let test = this;

		this.upQuestionBtn.each(function(){
			
			$(this).click(function(e){
				
				let btn = e.target;

				let idQuestion = btn.value;

				let dataJson = {
								request:"getUpdateQuestionForm",
								idTest:test.idTest,
								idQuestion:idQuestion
							   };
				let container = $("#addAnswerFormWrap"+idQuestion);
	
				if(container.html() == ''){

					test.addAnswerFormWrap.html("");

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

								//cargar el formulario para editar respuesta

								console.log(data.notice);

								container.html(data.data);	

								test.show_loaded_form(container);

								
								let updateBtn = $("#updateQuestionBtn");
								
								updateBtn.click(function(e){

									e.preventDefault();

									let questionTxt = $("#upQuestionTxt");
									
									let jsonQuestion = {
														request:"updateQuestion",
														question:questionTxt.val(),
														idTest:test.idTest,
														idQuestion:idQuestion,
														};

									//guardar pregunta editada
									$.ajax({
					
										url:test.urlFile,
										data:jsonQuestion,
										type: "post",
										beforeSend: function(){

											console.log("wait...");

										},
										success:function(dataAjax = ""){

											let data = dataAjax;

											data = JSON.parse(data);
											
											if(data.status == "done"){

												console.log(data.notice);

												container.html("");//ocultar el formulario

												//cargar la pregunta editada
												test.questionItem = $("#question-item"+idQuestion);
									
												test.questionItem.html(data.data);

												test.ajaxMsg.html(main.msg.success_msg(data.notice));
											
											}else{
											
												console.log(data.status+" - "+data.notice);

												test.ajaxMsg.html(main.msg.msg_type(data.notice));

											}

										},
										error: function(data){
	
											console.log("Error al actualizar la pregunta - "+data.status+" - "+data.statusText);
										
										}
									
									});//ajax
									
								
								
								});//addBtn click

							}else{
							
								console.log(data.status+" - "+data.notice);
	
								test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

							}

						},
						error: function(data){
							
							console.log("Error al abrir el formulario para actializar pregunta - "+data.status+" - "+data.statusText);
						
						}

					});
			
				}else{

					test.hide_loaded_form(container);

				}

			});//click en boton actualizar pregunta

		});//agregar evento a los botones 

	}

	show_loaded_form(container = ""){

		container.children().toggle("slow");

	}

	hide_loaded_form(container = ""){
		
		container.children().toggle("slow", function(){

			container.html("");
		
		});

	}

	del_question_btn(){

		let test = this; 

		this.delQuestionBtn.click(function(e){

			let btn = e.target;

			test.idTestQuestion = btn.value;

			let name = $("#question-item"+test.idTestQuestion).html();//extraer el nombre del examen
 
			test.modal = $("#del-modal");

			main.show_modal(test.modal);

			$("#del-modalTxt").html(name);//colocar el nombre de lo que se va a borrar

			test.delQuestionConfirm = $("#del-confirm");

			test.del_question();

		});		

	}

	del_question(){

		//borrar pregunta

		let test = this;

			test.delQuestionConfirm.off("click");

			test.delQuestionConfirm.click(function(e){
								
				let btn = e.target;

				let idQuestion = test.idTestQuestion;

				let dataJson = {
								request:"delQuestion",
								idTest:test.idTest,
								idQuestion:idQuestion
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

								test.testListWrap.html(data.data);//cargar las preguntas

								main.hide_modal(test.modal);

								test.test_btns(test);							

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

	add_answer(){

		//agregar respuestas

		let test = this;

		this.addAnswerBtn.each(function(){

			$(this).click(function(e){
								
				let btn = e.target;

				let idQuestion = btn.value;

				let dataJson = {
								request:"getAddAnswerForm",
								idTest:test.idTest,
								idQuestion:idQuestion
							   };

				let container = $("#addAnswerFormWrap"+idQuestion);
						
				if(container.html() == ''){

					test.addAnswerFormWrap.each(function(){
						
						test.hide_loaded_form($(this));
	
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

								//cargar el formulario de guardar respuesta

								container.html(data.data);	

								test.show_loaded_form(container);			
								
								//boton ara agregar respuesta
								let addBtn = $("#addAnwserBtn");
								
								addBtn.click(function(e){

									e.preventDefault();

									let answerTxt = $("#answerTxt");
									
									let jsonAnswer = {
														request:"addAnswer",
														answer:answerTxt.val(),
														idQuestion:idQuestion,
														idTest:test.idTest
													 };

									$.ajax({
					
										url:test.urlFile,
										data:jsonAnswer,
										type: "post",
										beforeSend: function(){

											console.log("wait...");

										},
										success:function(dataAjax = ""){

											let data = dataAjax;

											data = JSON.parse(data);
											
											if(data.status == "done"){

												console.log(data.notice);

												container.html("");//ocultar el formulario

												//cargar la nueva respuesta
												test.answerWrap = $("#answers-wrap"+idQuestion);

												test.answerWrap.html(data.data);

												test.show_loaded_form(container);

												test.ajaxMsg.html(main.msg.success_msg(data.notice));

												test.test_btns_answer();
											
											}else{
											
												console.log(data.status+" - "+data.notice);

												test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

											}

										},
										error: function(data){
										
											console.log("Error al actualizar respuesta - "+data.status+" - "+data.statusText);
										
										}
									
									});//ajax

								});//addBtn click

							}else{
							
								console.log(data.status+" - "+data.notice);

								this.ajaxMsg.html(main.msg.info_msg(data.notice));

							}

						},
						error: function(data){

							console.log("Error al abrir el formulario para actualizar respuesta - "+data.status+" - "+data.statusText);
						
						}
					
					});

				}else{

					test.hide_loaded_form(container);

				}

			});

		});

	}

	update_answer(){

		//editar respuesta

		let test = this;

		this.upAnswerBtn.each(function(){
			
			$(this).click(function(e){
								
				let btn = e.target;

				let btnValue = btn.value.split("||");

				let idAnswer = btnValue[0];

				let idQuestion = btnValue[1];

				let dataJson = {
								request:"getUpdateAnswerForm",
								idTest:test.idTest,
								idQuestion:idQuestion,
								idAnswer:idAnswer
							   };

				let container = $("#addAnswerFormWrap"+idQuestion);

				if(container.html() == ''){

					test.addAnswerFormWrap.html("");

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

								//cargar el formulario para editar respuesta
								
								console.log(data.notice);

								container.html(data.data);

								test.show_loaded_form(container);	
								
								let updateBtn = $("#updateAnswerBtn");
								
								updateBtn.click(function(e){

									e.preventDefault();

									let answerTxt = $("#upAnswerTxt");
									
									let jsonQuestion = {
														request:"updateAnswer",
														answer:answerTxt.val(),
														idTest:test.idTest,
														idQuestion:idQuestion,
														idAnswer:idAnswer
													 };

									//guardar pregunta editada
									$.ajax({
					
										url:test.urlFile,
										data:jsonQuestion,
										type: "post",
										beforeSend: function(){

											console.log("wait...");

										},
										success:function(dataAjax = ""){

											let data = dataAjax;

											data = JSON.parse(data);
											
											if(data.status == "done"){

												console.log(data.notice);

												container.html("");//ocultar el formulario

												//cargar la pregunta editada
												test.answerItem = $("#answer-item"+idAnswer);
									
												test.answerItem.html(data.data);

												test.test_btns_answer();

												test.ajaxMsg.html(main.msg.success_msg(data.notice));												
											
											}else{
											
												console.log(data.status+" - "+data.notice);

												test.ajaxMsg.html(main.msg.msg_type(data.status, data.notice));

											}

										},
										error: function(data){

											console.log("Error al actualizar respuesta - "+data.status+" - "+data.statusText);
										
										}
									
									});//ajax
									
								});//addBtn click

							}else{
							
								console.log(data.status+" - "+data.notice);

								test.ajaxMsg.html(main.msg.info_msg(data.notice));

							}

						},
						error: function(data){

							console.log("Error al abrir el formulario para actualizar respuesta - "+data.status+" - "+data.statusText);
						
						}

					});

				}else{

					test.hide_loaded_form(container);

				}

			});

		});
	}

	del_answer_btn(){

		let test = this; 

		this.delAnswerBtn.click(function(e){

			let btn = e.target;

			test.idTestAns = btn.value;

			//let testName = $("#test-name"+test.idTest).html();//extraer el nombre del examen

			test.modal = $("#del-modal");

			main.show_modal(test.modal);

			//$("#modal-testName").html(testName);//colocar el nombre del examen

			test.delTestConfirm = $("#del-confirm");

			test.del_answer();

		});		

	}

	del_answer(){

		//borrar pregunta

		let test = this;

			test.delTestConfirm.off("click");

			test.delTestConfirm.click(function(e){
								
				let btnValue = test.idTestAns.split("||");

				let idAnswer = btnValue[0];

				let idQuestion = btnValue[1];

				let dataJson = {
								request:"delAnswer",
								idTest:test.idTest,
								idQuestion:idQuestion,
								idAnswer:idAnswer
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

								//cargar la nueva respuesta
								test.answerWrap = $("#answers-wrap"+idQuestion);

								test.answerWrap.html(data.data);

								main.hide_modal(test.modal);

								test.test_btns_answer();							

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

}