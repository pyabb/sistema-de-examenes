class Admin{
		
	constructor(){

		this.changeDataMsg = $("#change-dataMsg");
		this.changePassMsg = $("#change-passMsg");

		this.userData =  $('.user-data');
		this.saveChangesBtn =  $('#save-changes');
		this.changeDataForm =  $('#change-dataForm');
		this.changePasswordForm =  $('#change-passwordForm');
		this.dataPassword =  $('.data-password');
		this.changePassword =  $("#change-password");						
		this.urlFile = "modulos/administrador/controllers/ajax/admin_profile_controller.php";
		this.delBtn = null;
		this.idStudent = "";
		this.idTest = "";
		this.pageMsg = null;

		this.table_btns();

	}

	table_btns(){

		this.delStudentBtn = $('.del-studentBtn');
		
		this.delete_studentBtn();

	}

	change_data(){

		let admin = this;

		this.changeDataForm.submit(function(e){
			
			e.preventDefault();

			//datos de perfil
			let dataJson = {
							request:"updateDataAdmin",
							user:$("#user").val(),
				            name:$("#name").val()
				        	};
				       
			$.ajax({
								
				url:admin.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(){

					console.log("wait...");

				},
				success:function(data = ""){
		
					data = JSON.parse(data);
					
					if(data.status == "done"){

						console.log(data.notice);

						admin.changeDataMsg.html(main.msg.success_msg(data.notice));

					}else{
						
						console.log(data.status+" - "+data.notice);

						admin.changeDataMsg.html(main.msg.msg_type(data.status, data.notice));
	
					}

				},
				error: function(data){

					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});
							
		});

	}

	change_password(){

		let admin = this;

		admin.changePasswordForm.submit(function(e){
			
			e.preventDefault();

			let dataJson = {
							request:"updatePassword",
							password:$("#password").val(),
				            passwordConfirm:$("#confirm-pass").val()
				        	};
				       
			$.ajax({
								
				url:admin.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(data){
			
					console.log("wait...");

				},
				success:function(data){

					data = JSON.parse(data);
					
					if(data.status == "done"){

						console.log(data.notice);

						admin.changePassMsg.html(main.msg.success_msg(data.notice));

					}else{
						
						console.log(data.status+" - "+data.notice);
						console.log(data.status);

						admin.changePassMsg.html(main.msg.msg_type(data.status, data.notice));
					
					}

				},
				error: function(data){
					
					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});

							
		});

	}

	delete_studentBtn(){

		let admin = this; 

		admin.delStudentBtn.click(function(e){

			let btn = e.target;

			admin.delBtnPress = btn;
			
			admin.delBtn = btn.value.split("||");

			admin.idStudent = admin.delBtn[1];
			admin.idTest = admin.delBtn[0];

			let studentName = $("#td-name"+admin.idStudent).html();//extraer el nombre del alumno
		
			$("#student-nameDel").html(studentName);//colocar el nombre del alumno

			admin.modal = $("#del-modal");

			main.show_modal(admin.modal);
		
			admin.delStudentConfirm = $("#del-confirm");

			admin.delete_student();

		});		

	}

	delete_student(){

		let admin = this;

		admin.delStudentConfirm.off("click");

		admin.delStudentConfirm.click(function(e){

			e.preventDefault();

			let dataJson = {
							request:"delStudentEr",
							idStudent:admin.idStudent,
							idTest:admin.idTest
				        	};
				        	
			$.ajax({
								
				url:admin.urlFile,
				data:dataJson,
				type: "post",
				beforeSend: function(){

					console.log("wait...");

				},
				success:function(data = ""){
	
					data = JSON.parse(data);
						
					if(data.status == "done"){

						admin.pageMsg.html(main.msg.success_msg(data.notice));
						
						admin.dataTable.row(admin.delBtnPress.parentNode.parentNode).remove().draw();
						
						main.hide_modal(admin.modal);

						admin.table_btns();
						
					}else{
					
						console.log(data.status+" - "+data.notice);

						admin.pageMsg.html(main.msg.msg_type(data.status, data.notice));
					
					}

				},
				error: function(data){
				
					console.log("Error al actualizar datos - "+data.status+" - "+data.statusText);
				
				}
				
			});
							
		});

	}

}