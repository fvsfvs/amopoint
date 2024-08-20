
window.addEventListener('load', function(){

    let paragraphs = document.querySelectorAll('p');
    let select = document.querySelector('select');
    

	select.addEventListener('change', function(){
	    let type = select.options[select.selectedIndex].value;
        hideElements(type);
	});

    function hideElements(type){
        var reg = new RegExp(type);
        for(i = 0; i < paragraphs.length; i++){
            if(paragraphs[i].children.length > 0){
            console.dir(paragraphs[i].children[0].tagName);
            console.dir(paragraphs[i].children[0].getAttribute('name'));
            }
            if(paragraphs[i].children.length > 0 &&  
                paragraphs[i].children[0].getAttribute('name') !== undefined 
                && (paragraphs[i].children[0].tagName == "SELECT" || 
                reg.test(paragraphs[i].children[0].getAttribute('name')))){
                paragraphs[i].style.display = "";
                
            }
            else {
                paragraphs[i].style.display = "none";
            }
        }
    }

});