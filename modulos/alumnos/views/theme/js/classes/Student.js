class Student{

	constructor(){

		this.pageMsg = $("#page-msg");
		this.changeDataMsg = $("#chnage-dataMsg");
		this.changePassMsg = $("#change-passMsg");
		this.changeDataForm = $("#set-studentForm");
		this.changePasswordForm = $("#change-passwordForm");		
		this.tableWrap = $("#table-wrap");
		this.setFormContainer = $(".set-formContainer");
		this.delStudentConfirm = null;		
		this.setFormContainerId = null;
		this.idStudent = "";
		this.modal = null;
		this.dataTable = null;

		this.urlFile = "modulos/alumnos/controllers/ajax/student_profile_controller.php";

		this.table_btns();

	}

	table_btns(){

		this.resetPassBtn = $('.reset-passBtn');
		this.openUpdateFormBtn = $('.open-updateFormBtn');
		this.delStudentBtn = $('.del-studentBtn');
		this.updateStatusBtn = $('.update-statusBtn');

		this.reset_pass();

		this.update_status();

		this.open_update_form();
		
		this.delete_studentBtn();

	}

	add_student(){

	}

	reset_pass(){

		let student = this;

		student.resetPassBtn.click(function(e){
			
			e.preventDefault();

			let btn = e.target;

			let idStudent = $(btn).val();

			let dataJson = {
							request:"resetPass",
							idStudent:idStudent,
				        	};

			$.ajax({
								
				url:student.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(){

					console.log("wait...");

				},
				success:function(data = ""){
				
					data = JSON.parse(data);
					
					if(data.status == "done"){

						console.log(data.notice);

						student.pageMsg.html(main.msg.success_msg(data.notice));

						let setForm = $("#set-formContainer"+idStudent);
						
					}else{					
						
						console.log(data.status+" - "+data.notice);

						student.pageMsg.html(main.msg.msg_type(data.status, data.notice));

					}

				},
				error: function(data){
					
					console.log("Error al resetear password - "+data.status+" - "+data.statusText);
				
				}
				
			});
							
		});

	}


	update_status(){

		let student = this;

		student.updateStatusBtn.click(function(e){
			
			e.preventDefault();

			let btn = e.target;

			let valueBtn = $(btn).val().split("||");

			let idStudent = valueBtn[0]; 
			let status = valueBtn[1]; 

			let dataJson = {
							request:"updateStatus",
							idStudent:idStudent,
				            status:status
				        	};

			$.ajax({
								
				url:student.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(){

					console.log("wait...");

				},
				success:function(data = ""){
				
					data = JSON.parse(data);
					
					if(data.status == "done"){

						console.log(data.notice);

						student.pageMsg.html(main.msg.success_msg(data.notice));

						$(btn).val(idStudent+"||"+data.data);

						student.change_status_btn(idStudent, data.data);
						
					}else{

						console.log(data.status+" - "+data.notice);

						student.pageMsg.html(main.msg.info_msg(data.notice));					

					}

				},
				error: function(data){
					console.log(data);
					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});
							
		});

	}

	change_status_btn(idStudent = "", status = ""){

		let btnStatus = $("#update-statusBtn"+idStudent);

		if(status == "1"){

			btnStatus.html("Activo");
			main.changeClass(btnStatus, "Inactivo", "Activo");

		}else{

			btnStatus.html("Inactivo");
			main.changeClass(btnStatus, "Activo", "Inactivo");

		}

	}

	open_update_form(){

		let student = this;
	
		student.openUpdateFormBtn.click(function(e){
			
			e.preventDefault();

			let btn = e.target;

			let idStudent = $(btn).val();

			let container = $("#set-formContainer"+idStudent);//contenedor especifico de alumno

			student.setFormContainerId = container;

			if(container.html() == ""){

				student.setFormContainer.html("");//limpiar todos los contenedores

				let dataJson = {
							request:"getSetForm",
							idStudent:idStudent,
				            status:status
				        	};
		
				$.ajax({
									
					url:student.urlFile,
					data:dataJson,
					type: "post",
					beforeSend: function(){

						console.log("wait...");

					},
					success:function(data = ""){
							
						data = JSON.parse(data);
						
						if(data.status == "done"){

							console.log(data.notice);

							container.html(data.data);

							let setFormWrap = $("#set-formWrap");//contenedor de formulario. biene por ajax
							
							setFormWrap.toggle("slow")

							student.update_student(idStudent);//boton para editar datos del alumno

						}else{
						
							console.log(data.status+" - "+data.notice);

							student.pageMsg.html(main.msg.msg_type(data.status, data.notice));						

						}

					},
					error: function(data){
						
						console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
					
					}
					
				});

			}else{

				let setFormWrap = $("#set-formWrap");//contenedor de formulario. biene por ajax
				setFormWrap.toggle("slow");
				container.html("");
			}
							
		});

	}

	update_student(idStudent = ""){

		let student = this;

		$("#set-studentForm").submit(function(e){

			e.preventDefault();

			let dataSet = $(".dataSet");

			let dataJson = {
							request:"updateStudent",
							idStudent:idStudent,
				            user:(dataSet[0]).value,
				            name:dataSet[1].value,
				            apellidos:dataSet[2].value
				        	};

			$.ajax({
									
					url:student.urlFile,
					data:dataJson,
					type: "post",
					beforeSend: function(){

						console.log("wait...");

					},
					success:function(data = ""){

						data = JSON.parse(data);
						
						if(data.status == "done"){
							
							console.log(data.notice);

							student.pageMsg.html(main.msg.success_msg(data.notice));

							let studentData = $(".student-dataTd"+idStudent);
						
							studentData[0].innerText = data.data.user;
							studentData[1].innerText = data.data.apellidos+" "+data.data.name;

							let setFormWrap = $("#set-formWrap");//contenedor de formulario. biene por ajax
							
							setFormWrap.toggle("slow");
							
							student.setFormContainerId.html("");				
								
						}else{
						

							console.log(data.status+" - "+data.notice);

							student.pageMsg.html(main.msg.msg_type(data.status, data.notice));
						
						}

					},
					error: function(data){
						
						console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
					
					}
					
				});	

		});

	}

	delete_studentBtn(){

		let student = this; 

		student.delStudentBtn.click(function(e){

			let btn = e.target;
			student.delBtn = btn;

			student.idStudent = btn.value;

			let studentName = $("#student-dataTd"+student.idStudent).html();//extraer el nombre del alumno

			student.modal = $("#del-modal");

			main.show_modal(student.modal);
		
			$("#student-nameDel").html("<strong>"+studentName+"</strong>");//colocar el nombre del alumno

			student.delStudentConfirm = $("#del-confirm");

			student.delete_student();

		});		

	}

	delete_student(){

		let student = this;

		student.delStudentConfirm.off("click");

		student.delStudentConfirm.click(function(e){

			e.preventDefault();

			let dataJson = {
							request:"delStudent",
							idStudent:student.idStudent
				        	};

			$.ajax({
								
				url:student.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(){

					console.log("wait...");

				},
				success:function(data = ""){
					
					data = JSON.parse(data);
						
					if(data.status == "done"){

						student.pageMsg.html(main.msg.success_msg(data.notice));

						student.dataTable.row(student.delBtn.parentNode.parentNode).remove().draw();
						
						main.hide_modal(student.modal);

						student.table_btns();
						
					}else{
					
						
						console.log(data.status+" - "+data.notice);

						student.pageMsg.html(main.msg.msg_type(data.status, data.notice));
					
					}

				},
				error: function(data){
				
					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});
							
		});

	}

	change_data(){

		let student = this;

		this.changeDataForm.submit(function(e){
			
			e.preventDefault();

			let dataJson = {
							request:"updateDataStudent",
							user:$("#user").val(),
				            name:$("#name").val(),
				            apellidos:$("#apellidos").val()
				        	};
				       
			$.ajax({
								
				url:student.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(data){
				
					console.log("wait...");

				},
				success:function(data = ""){
				
					data = JSON.parse(data);
					
					if(data.status == "done"){

						console.log(data.notice);

						student.changeDataMsg.html(main.msg.success_msg(data.notice));

					}else{
					
						console.log(data.status+" - "+data.notice);

						student.changeDataMsg.html(main.msg.msg_type(data.status, data.notice));

					}

				},
				error: function(data){
				
					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});
							
		});

	}

	change_password(){

		let student = this;

		student.changePasswordForm.submit(function(e){
			
			e.preventDefault();

			let dataJson = {
							request:"updatePassword",
							password:$("#password").val(),
				            passwordConfirm:$("#confirm-pass").val()
				        	};
				       
			$.ajax({
								
				url:student.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(data){
					
					console.log("wait...");

				},
				success:function(data = ""){
			
					data = JSON.parse(data);
					
					if(data.status == "done"){
						
						console.log(data.notice);

						student.changePassMsg.html(main.msg.success_msg(data.notice));

					}else{
						
						console.log(data.status+" - "+data.notice);

						student.changePassMsg.html(main.msg.msg_type(data.status, data.notice));
					
					}

				},
				error: function(data){
					
					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});

							
		});

	}

}
