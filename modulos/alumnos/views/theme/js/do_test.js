$(document).ready(function(){
	
	start_app();	

});

let app = null;

function start_app(){

	console.log("Hello");

	let questionsList = $("#questions-list");
	let pageItems = $(".question-itemWrap");

	let paginator = new Paginator2({
		pageItems:pageItems,
		totalItems: 10,
		itemsWrap:$("#questions-wrap"),
		totalRecords:$("#questions-number").val(),
		idObjectPage:$("#idTest").val(),
		urlFile:"modulos/alumnos/controllers/ajax/do_test_controller.php",
		paginateAction: function(ini){

			questionsList.attr("start", ini+1);
		
		}

	});

	app = {
		now: new Date(),
		hours:$("#hours"),
		minuts:$("#minuts"),
		timeVal:$("#time-val"),
		timer:0
	};

	app.timer = setInterval(get_exam_time, 1000);	
	
}

function get_exam_time(){

	let now = new Date();

	if(now.getMinutes() != app.now.getMinutes()){

		let hours = app.hours;
		let minuts = app.minuts;
		let timeVal = app.timeVal;

		timeVal = timeVal.val();//tiempo de expiracion

	    let getExamTime = timeVal - (now.getTime() / 1000);//obtere el tiempo del examen 
	    
	    let toMinuts = getExamTime / 60;//convertir a minutos
	    
	    //horas
	    let toHours = toMinuts / 60;//convertir a horas
	    
	    //dar formato correcto a las horas
	   	let n = Math.round(toHours) - toHours;

	   	let toHoursR = "";

	   if(n > 0.5){

	   		toHoursR = Math.round(toHours); 

	   }else{

	   		toHoursR = Math.floor(toHours); 

	   }

	   if( toHoursR < 1 ) {

            toHoursR = "00";

        }else if ( toHoursR < 10 ){

            toHoursR = "0" + toHoursR;

        }else{

        }
	    
	    //minutos    
	    let getMinuts = (toHours - toHoursR) * 60;//convertir a minutos
	    
	    let a = getMinuts;

	    let c = getMinuts - Math.round(getMinuts);//obtener los decimales de los minutos
	    
	    if(c > 0.5){
	    	
	    	//redondear los minutos a su numero proximo
	    	getMinuts = Math.round(getMinuts);
	    
	    }else{
	    	
	    	//redondear los minutos a su valor anterior y sumar uno para mantener el minuto en curso
	    	getMinuts = Math.floor(getMinuts) + 1;
	    
	    }


	   if( getMinuts < 1 ) {

	   		//colocar doble 00 cuando los minutos llegan a 0
            getMinuts = "00";

        }else if ( getMinuts < 10 ){

        	//agregar un cero cuando los minutos son menores a 10
            getMinuts = "0" + getMinuts;

        }else{

        	if(getMinuts == 60 ){

        		//para que muestre el minuto 59 una ves que cambia la hora
        		getMinuts = 60 - 1;
        	}

        }

        if(toHoursR == "00" && (a > 4.98 && a < 5)){

        	console.log("05 minutes");
        	 alert("Le quedan 5 minutos para finalizar el examen. Es momento de comenzar a enviar sus respuestas. De lo contrario no se guardaran");
        
        }

        if(toHoursR == "00" && getMinuts == "00"){
        
        	clearInterval(app.timer);

        	alert("El tiempo del examen ha terminado");

        	location.href = "alumno.php";

        }

		hours.html(toHoursR);
		minuts.html(getMinuts);

	}

}



