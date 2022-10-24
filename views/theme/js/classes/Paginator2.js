class Paginator2{

	//se usa para la lista de preguntas del examen
	
	constructor(params={

		pageItems:null,
		totalItems: 0,
		itemsWrap:null,
		totalRecords:0,
		idObjectPage:0,
		urlFile:"",
		paginateAction:null

	}){

		//config
		this.pageItems = params.pageItems;
		this.totalItems = params.totalItems;//total de items a mostrar
		this.itemsWrap = params.itemsWrap;//contenedor de items
		this.paginateAction = params.paginateAction;
	
		this.totalRecords = params.totalRecords;//total de registros en la bd
		this.idObjectPage = params.idObjectPage;
		this.urlFile = params.urlFile;//url para ajax
		
		//propiedades
		this.totalPages = 0;//total de paginas que se generaran a partir del numero de registros
		this.pageNumber = 0;
		this.counter = 0;
		this.itemsVisibles = [];//array para los items que estan visibles 

		this.start();

	}

	start(){

		let paginator = this;

		//obtener el total de paginas
		let mod = this.totalRecords%this.totalItems;
		let div = this.totalRecords/this.totalItems;
			
		if(mod == 0){

			this.totalPages = div;

		}else{

			let n = Math.floor(div);

			this.totalPages = n+1;

		}

		let items = paginator.pageItems;//items a paginar

		items.css("display", "none");//ocultando items a paginar

		for(let i = 0 ; i < items.length ; i ++){

			if(i < paginator.totalItems){

				//mostrar solo los items necesarios
				items[i].style.display =  "list-item";

				paginator.itemsVisibles[paginator.counter] = items[i];

				paginator.counter++; 
					
			}

		}
	
		let pagePag = $("#page-paginator");
       
	    pagePag.bootpag({
		    total: paginator.totalPages,
		    maxVisible: 5,
		    firstLastUse: true,
    		first: '<span aria-hidden="true">&larr;</span>',
    		last: '<span aria-hidden="true">&rarr;</span>'
		}).on("page", function(e, num){
 		 		
 		});

 		paginator.page_btn(pagePag[0].children[0].children);

	}

	page_btn(btn = null){
		
		let paginator = this;
		let c = 0;

		//agregar clases a los botones
		//$(btn[0]).addClass("page-item");
		//$(btn[0].children).addClass("page-link");
		//$(btn[btn.length-1]).addClass("page-item");
		//$(btn[btn.length-1].children).addClass("page-link");
	
		for(let i=0; i<btn.length;i++){
			
			//agregar clases a los botones para que tengan formato
			$(btn[i]).addClass("page-item");
			$(btn[i].children).addClass("page-link");

			if(i == 0){

				$(btn[i]).click(function(e){
				
					if(paginator.pageNumber != 0){

						paginator.pageNumber = 0;

						paginator.show_items_required(paginator.pageNumber);

					}
					
				});

			}else if(i == 1){

				$(btn[i]).click(function(e){
				
					if(paginator.pageNumber != 0){

						paginator.pageNumber = paginator.pageNumber - paginator.totalItems;

						paginator.show_items_required(paginator.pageNumber);

					}
					
				});

			}else if(i == btn.length-2){
				
				$(btn[i] ).click(function(){
					
					let n = paginator.pageNumber + paginator.totalItems;
					
					if(n < paginator.totalRecords){

						paginator.pageNumber = paginator.pageNumber + paginator.totalItems;

						paginator.show_items_required(paginator.pageNumber);

					}

				});

			}else if(i == btn.length-1){

				//ultimo boton flecha
				$(btn[i]).click(function(e){

					console.log(paginator.pageNumber);
					
					if(paginator.pageNumber < paginator.totalRecords){

						let d = paginator.totalRecords / paginator.totalItems;
						let m = paginator.totalRecords % paginator.totalItems;
							
						if(m == 0 ){

							d = d - 0.1;
						}
						
						d =  Math.floor(d);

						paginator.pageNumber = 	d * paginator.totalItems;
						
						console.log(paginator.pageNumber);	
						paginator.show_items_required(paginator.pageNumber);
						
					}
					
				});

			}else{

				btn[i].id = c;

				$(btn[i]).click(function(e){

					let btn = e.target.parentNode;

					paginator.pageNumber = parseInt(btn.id);

					console.log(paginator.pageNumber);

					paginator.show_items_required(paginator.pageNumber);					

				});

				c= c+paginator.totalItems;
				
			}
	
		}		

	}

	show_items_required(ini = 0){

		let paginator = this;

		for(let i =0; i < paginator.itemsVisibles.length; i++){

			paginator.itemsVisibles[i].style.display = "none";

		}

		let c = 1;

		paginator.counter = 0;

		if( paginator.paginateAction !=null ) paginator.paginateAction(ini);

		for(let i =ini; c <= paginator.totalItems; i++){
				
			if(paginator.pageItems[i]){

				paginator.pageItems[i].style.display = "list-item";

				paginator.itemsVisibles[paginator.counter] = paginator.pageItems[i];

				paginator.counter++;

			}				

			c++;
		
		}		

		

	}

}