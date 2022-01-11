var cmsAll = document.getElementsByClassName("cmsText");
var key_ctrl = true;


window.addEventListener("keydown", function(e) {
	if (e.key = "Alt") {
		key_ctrl = false;
	}
}, false);


window.addEventListener("keyup", function(e) {
	if (e.key = "Alt") {
		key_ctrl = true;
	}
}, false);


document.querySelectorAll(".cmsText").forEach(function(cms, index, array) {
	cms.classList.add("selectEditText");
	
	cms.onclick = function() {
		saveText();  											  // zapisz i deaktywuj poprzedni kontent
		if(key_ctrl == true) {
			cms.contentEditable = "true";                 // aktywuj aktualny kontent
		}
		cms.focus();
	} 

})


document.querySelectorAll(".cmsImage").forEach(function(cmsImage) {
		cmsImage.classList.add("selectEditImage")
		cmsImage.onclick = function(e) {
			input = document.createElement('input');
			setAttributes(input, { id: "fileToUpload", type: "file", accept: "image/*", name: "imageFile", onchange: "saveImage(event, '"+e.target.id+"')"});
			input.click();	
		}

})

function setAttributes(el, attrs) {
	Object.keys(attrs).forEach(key => el.setAttribute(key, attrs[key]));
}	

window.onclick = e => {
	if(e.target.className.search("cmsText") != -1) {
		return
	}
	content = document.querySelectorAll('[contenteditable=true]')[0];
	if(content === undefined) {
		return;
	}
	saveText(); 
} 

function saveText(){
	var obj = {};
	content = document.querySelectorAll('[contenteditable=true]')[0];
	if(content === undefined) {
		return;
	}
	content.contentEditable = "false"; 

	obj.id = content.id;
	obj.html = content.innerHTML;

	fetch('/cms/?options=text', {
		method : 'POST',
		headers: {
			'Content-type': 'application/json; charset=UTF-8' },
		body: JSON.stringify(obj)
	})
	.then((res) => res.json())
	.then((data) => resGetOptions(data))
	.catch((error) => console.log(error))
}

function resGetOptions(data){
	console.log(data);
}



function saveImage(e, id) {
	var input = e.target;
	var reader = new FileReader();
	reader.onload = function(){
		var dataURL = reader.result;
		var img = document.getElementById(id);
		img.src = dataURL;
	};
	reader.readAsDataURL(input.files[0]);  
	const fd = new FormData();
	fd.append(e.target.name, input.files[0], input.files[0].name);  
	fd.append("id", id);
	// create the request
	const xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		//	console.log(this.response);
		}
	}
	xhttp.responseType = 'json';
	xhttp.open('POST', 'uploadImage/', true);
	xhttp.send(fd);
};