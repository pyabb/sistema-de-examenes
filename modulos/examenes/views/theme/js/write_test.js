$(window).ready(function(){

	start_write_test();

});

let test = null;

function start_write_test(){ 

	let genObject = new  Test();

	test = genObject;

	test.add_instructions();

	test.add_question();

	//botones 
	test.test_btns(test);

}