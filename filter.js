/*function drawTable(userId){
	let tableBody = document.getElementById('tbody');

	let formData = new FormData();
  	formData.append("user", userId);
	let xhr = new XMLHttpRequest();
	xhr.overrideMimeType("application/json");
	xhr.open("POST", 'index.php', true);
	xhr.onload = function() {
		response = xhr.responseText;
		let obj = JSON.parse(response);
		let amounts = '';
	 	for (const month in obj){
			amounts += '<tr><td>'+ month + '</td><td>' + obj[month] + '</td></tr>';
	 	}
		tableBody.innerHTML = amounts;
	 };
	 xhr.send(formData);	 
}*/



window.addEventListener('load', function(){

	let fields = document.querySelectorAll('input[type=text]');
    let buttons = document.querySelectorAll('input[type=button]');
    let select = document.querySelector('select');
    

	select.addEventListener('change', function(){
	    let type = select.options[select.selectedIndex].value;
        hideElements(type);
	});

    function hideElements(type){
        var r = new RegExp(type);
        for(i = 0; i < fields.length; i++){
            parent = fields[i].parentElement;
            if(r.test(fields[i].getAttribute('name'))){
                parent.style.display = "";
            }
            else {
                parent.style.display = "none";
            }
        }

        for(i = 0; i < buttons.length; i++){
            parent = buttons[i].parentElement;
            if(r.test(buttons[i].getAttribute('name'))){
                parent.style.display = "";
            }
            else {
                parent.style.display = "none";
            }
        }
    }

});