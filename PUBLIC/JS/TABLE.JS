function Table() { }

Table.prototype.NewTD = function(text) {
	var newTD = document.createElement("td");
	var textNode = document.createTextNode(text);
	newTD.appendChild(textNode);
	return newTD;
}
// Table.prototype.NewButton = function(button) {

// }
Table.prototype.NewAction = function(name,link,type) {
	var a = document.createElement("a");
	var textNode = document.createTextNode(name);
	a.appendChild(textNode);
	a.setAttribute("href",link);
	a.classList.add("btn");
	a.classList.add("btn-sm");
	a.classList.add(type);
	return a;
}
Table.prototype.NewButton= function(name,classList,callBack) {
	var btn = document.createElement("button");
	var textNode = document.createTextNode(name);
	btn.appendChild(textNode);
	classList = classList.split(" ");
	for (var index = 0; index < classList.length; index++) {
		btn.classList.add(classList[index]);
	}
	btn.addEventListener("click", function() {
		callBack(this);
	});
	return btn;
}
Table.prototype.CreateActionTD = function(actions) {
	var td = document.createElement("td");
	for(var index = 0; index < actions.length;index++) {
		td.appendChild(actions[index]);
	}
	return td;
}	
Table.prototype.NewTR = function(tblElement,details,actions) {
	var newTR = document.createElement("tr");
	for(var index = 0; index < details.length;index++) {
		newTR.appendChild(this.NewTD(details[index]));
	}
	newTR.appendChild(actions);
	newTR.setAttribute("id",details[0]);
	tblElement.appendChild(newTR);
}