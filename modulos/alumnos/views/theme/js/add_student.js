colegio.addEvent(window,'load', start_app);

let student = null;

// JavaScript Document

function start_app(){

	let studentObject = {
						searchCoursesBtn: colegio.getById('search-coursesBtn'), 
						listCoursesBtn: colegio.getById('list-coursesBtn'),
						modalFormAdd: colegio.getById('modal-add'),
						openAddBtn: colegio.getById('open-addStudent'),
						closeAddBtn: colegio.getById('close-modalAdd'),
						modalFormSet: colegio.getById("modal-set"),
						openSetBtn: colegio.getByClass('open-setStudent'),
						dataFormSet: colegio.getByClass("dataSet"),
						closeSetBtn: colegio.getById('close-modalSet'),
						msgPage:colegio.getById("msg-page"),
						msgForm:"",						
						getValue: function(control){
							return control.value;
						},
						openMenu(menu = null){
	
							if(menu.style.display == 'block'){	
								
								menu.style.display='none';
							
							}else{

								hide_menu();

								menu.style.display='block';

							}

						},
						file:"modulos/alumnos/controllers/ajax/student_controller.php",
						idStudent:""};

	student = studentObject;


	colegio.addEvent(student.searchCoursesBtn, "click", function(){

		student.openMenu(student.listCoursesBtn);

	});

	colegio.addEvent(student.openAddBtn, "click", open_form);

	colegio.addEvent(student.closeAddBtn, "click", open_form);

	colegio.empty(student.openSetBtn, function(){
		
		colegio.loop({objectRef:student.openSetBtn, fn:function(objectRef){
			
			colegio.addEvent(objectRef, "click", open_form);

		}});	
	
	});

	colegio.empty(student.closeSetBtn, function(){

		colegio.addEvent(student.closeSetBtn, "click", open_form);	

	});
	
}

function open_form(e){

	let target = e.target;

	switch(target.id){

		case "open-addStudent":

			colegio.openModal(student.modalFormAdd);

		break;
		case "close-modalAdd":

			colegio.openModal(student.modalFormAdd);

		break;
		case "open-setStudent":

			student.msgPage.innerHTML = "";

			colegio.openModal(student.modalFormSet);

			student.idStudent = target.value;

			student.msgForm = colegio.getById("msg-formSet");

			//boton editar alumno
			let setBtn = colegio.getById("set-student");

			colegio.addEvent(setBtn, "click", set_student);

			let dataSend = {request:"getDataStudent", idStudent:target.value};
			
			colegio.ajax.send_data({method:"post", 
									file:student.file, 
									functionName:function(data){
										console.log(data);
										if(data.status == true){

											if(data.data.status == "done"){
												
												console.log(data.data.notice);

												let d = data.data.data;

												let dataStudent = [ 
														           d.alumno, 
														           d.fechaNacimiento, 
														           d.matricula, 
														           d.idCourse,
														           d.apellido, 
														           d.telefono, 
														           d.expediente,
														           d.idClassRoom];

												let dataForm = colegio.getByClass("dataSet");

												if(colegio.empty(dataForm)){

													let counter = 0;
													
													colegio.loop({objectRef: dataForm, fn:function(objectRef){

														objectRef.value = dataStudent[counter];

														counter++;

													}});

												}else{

													console.log("Error al cargar datos en formulario");

												}

											}else{
												
												student.msgForm.innerHTML = colegio.msg.info(data.data.notice);
											
											}

										}else{

											console.log("Error en ajax"+data.status);
										
										}
									}, 
									data:"request="+ JSON.stringify(dataSend)

								});

		break;
		case "close-modalSet":

			colegio.openModal(student.modalFormSet);

		break;
		default:

			console.log("Id no identificado");
		
		break;

	}
	

}

function set_student(e){

	e.preventDefault();

	let dataForm = student.dataFormSet;

	if(colegio.empty(dataForm)){

		let dataSend = {request:"setStudent", 
						nombre:dataForm[0].value, 
			            fechaNacimiento:dataForm[1].value, 
			            matricula:dataForm[2].value, 
			            id_curso:dataForm[3].value,
			            apellido:dataForm[4].value, 
			            telefono:dataForm[5].value, 
			            expediente:dataForm[6].value,
			            id_salon:dataForm[7].value, 
			            idStudent: student.idStudent};
			
		console.log(dataSend);
		colegio.ajax.send_data({method:"post", 
								file:student.file, 
								functionName:function(data){
									
									if(data.status == true){

										if(data.data.status == "done"){
											
											let d = data.data;

											student.msgPage.innerHTML = colegio.msg.success(d.notice);

											colegio.openModal(student.modalFormSet);

										}else{
											
											student.msgPage.innerHTML = colegio.msg.info(data.data.notice);

											colegio.openModal(student.modalFormSet);
										
										}

									}else{

										console.log("Error en ajax"+data.status);
									
									}
								}, 
								data:"request="+ JSON.stringify(dataSend)

							});		

	}else{

		console.log("Error al obtener los datos del formulario editar estudiante");
	}

}