function styleChange()
{
	let sval = document.rentalCar.style.value;
	let makeDrop = document.getElementById('bmake');
	let modelDrop = document.getElementById('bmodel');
	let contents = "";
	if(sval == "4Door")
	{
		contents = '<option value="" disabled="true" selected="true">Make</option><option value="Benz">Mercedes Benz</option><option value="BMW">BMW</option><option value="VW">VW</option>';
		makeDrop.innerHTML = contents;
		modelDrop.innerHTML = "";
	}
	else if(sval == "2Door")
	{
		contents = '<option value="" disabled="true" selected="true">Make</option><option value="Pasta">Pastaghini</option><option value="Dodge">Dodge</option>';
		makeDrop.innerHTML = contents;
		modelDrop.innerHTML = "";
	}
	else if(sval == "SUV")
	{
		contents = '<option value="" disabled="true" selected="true">Make</option><option value="Toyota">Toyota</option><option value="Cadillac">Cadillac</option>';
		makeDrop.innerHTML = contents;
		modelDrop.innerHTML = "";
	}
	else
	{
	}
	calcPrice();
}
function makeChange()
{
	let sval = document.rentalCar.make.value;
	let modelDrop = document.getElementById('bmodel');
	let contents = "";
	if(sval == "Benz")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="C">C Class</option><option value="A">A Class</option>';
		modelDrop.innerHTML = contents;
	}
	else if(sval == "BMW")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="M3">M3</option><option value="X5">X5</option>';
		modelDrop.innerHTML = contents;
	}
	else if(sval == "VW")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="Beep">Beep Beep</option>';
		modelDrop.innerHTML = contents;
	}
	else if(sval == "Dodge")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="Charger">Charger</option><option value="Hellcat">Hellcat</option>';
		modelDrop.innerHTML = contents;
	}
	else if(sval == "Pasta")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="Banana">Spaghetti Car Banana</option>';
		modelDrop.innerHTML = contents;
	}
	else if(sval == "Toyota")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="Rav4">Rav4</option><option value="Sienna">Sienna</option>';
		modelDrop.innerHTML = contents;
	}
	else if(sval == "Cadillac")
	{
		contents = '<option value="" disabled="true" selected="true">Model</option><option value="Escalade">Escalade</option>';
		modelDrop.innerHTML = contents;
	}
	else
	{
	}
	calcPrice();
}
function calcPrice()
{
	let sval = document.rentalCar.model.value;
	let price = "$0";
	if(sval == "C" || sval == "M3" || sval == "Escalade" || sval == "Charger")
	{
		price = "$1,000";
	}
	else if(sval == "A" || sval == "X5" || sval == "Sienna" || sval == "Beep")
	{
		price = "$800";
	}
	else if(sval == "Rav4")
	{
		price = "$500";
	}
	else if(sval == "Hellcat" || sval == "Banana")
	{
		price = "$2,000";
	}
	else
	{
		price = "$0";
	}
	document.getElementById('cost').innerHTML = price;
	document.rentalCar.cost.value = price;
}