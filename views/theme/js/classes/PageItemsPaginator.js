class PageItemsPaginator{

	constructor(params={
		totalItems: 0,
		itemsWrap:null,
		totalRecords:0,
		idObjectPage:0,
		urlFile:""
	}){

		//config
		this.totalItems = params.totalItems;//total de items a mostrar
		this.itemsWrap = params.itemsWrap;//contenedor de items
	
		this.totalRecords = params.totalRecords;//total de registros en la bd
		this.idObjectPage = params.idObjectPage;
		this.urlFile = params.urlFile;//url para ajax
		
		//propiedades
		this.totalPages = 0;//total de paginas que se generaran a partir del numero de registros
		this.pageNumber = 0;

		this.start_paginator();

	}

	start_paginator(){

		let paginator = this;

		let mod = this.totalRecords%this.totalItems;
		let div = this.totalRecords/this.totalItems;
			
		if(mod == 0){

			this.totalPages = div;

		}else{

			let n = Math.floor(div);

			this.totalPages = n+1;

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

		$(btn[0]).addClass("page-item");
		$(btn[0].children).addClass("page-link");
		$(btn[btn.length-1]).addClass("page-item");
		$(btn[btn.length-1].children).addClass("page-link");
	
		for(let i=0; i<btn.length;i++){

			//comenzar desde 2 por que en este indice comienzan los items de numeros 
			//se resta 2 por los ultimos botones next y last
			
			$(btn[i]).addClass("page-item");
			$(btn[i].children).addClass("page-link");

			if(i == 0){

				$(btn[i]).click(function(e){
				
					if(paginator.pageNumber != 0){

						paginator.pageNumber = 0;

						paginator.page({
							page:paginator.pageNumber
						});

					}
					
				});

			}else if(i == 1){

				$(btn[i]).click(function(e){
				
					if(paginator.pageNumber != 0){

						paginator.pageNumber = paginator.pageNumber - paginator.totalItems;

						paginator.page({
							page:paginator.pageNumber
						});

					}
					
				});

			}else if(i == btn.length-2){
				
				$(btn[i] ).click(function(){
					
					let n = paginator.pageNumber + paginator.totalItems;
					
					if(n < paginator.totalRecords){

						paginator.pageNumber = paginator.pageNumber + paginator.totalItems;

						paginator.page({
							page:paginator.pageNumber
						});

					}

				});

			}else if(i == btn.length-1){

				$(btn[i]).click(function(e){
				
					if(paginator.pageNumber < paginator.totalRecords){

						paginator.pageNumber = 	(Math.floor(paginator.totalRecords / paginator.totalItems))*paginator.totalItems;
						
						paginator.page({
							page:paginator.pageNumber
						});

					}
					
				});

			}else{

				btn[i].id = c;

				$(btn[i]).click(function(e){

					let btn = e.target.parentNode;

					paginator.pageNumber = parseInt(btn.id);

					paginator.page({
						page:paginator.pageNumber
					});
					

				});

				c= c+paginator.totalItems;
				
			}
	
		}		

	}

	page(params = {
		page:0
	}){

		let paginator = this;

		if(params.page == 0){
		
			params.page = "";
		
		}
				
		let dataJson = {
	        	request:"page-test",
	        	page:params.page,
	        	totalItems:paginator.totalItems,
	        	idObjectPage:paginator.idObjectPage
	        };	    
	
		$.ajax({
			url:paginator.urlFile,
			data:dataJson,
			type:"post",
			beforeSensd: function(data){

				console.log("loading...");
			
			},
			success: function(data){
	
				data = JSON.parse(data);
				
				paginator.itemsWrap.html(data.data);

			},
			error: function(data){

				console.log("Error: "+ data);

			}
		});
	}

}

