//inputs
var txtSelectedId = document.getElementById("txtSelectedId");
var txtContact = document.getElementById("txtContact");
var txtUser = document.getElementById("txtUser");
var txtPassword = document.getElementById("txtPassword");
var txtConfirm = document.getElementById("txtConfirm");

//error message
var errors = document.getElementsByClassName("error");
var errSelected = document.getElementById("errSelected");
var errContact = document.getElementById("errContact");
var errUser = document.getElementById("errUser");
var errPassword = document.getElementById("errPassword");
var errConfirm = document.getElementById("errConfirm");

function validateStaff() {
	var valid = true;
	clearErrors();
	if(txtSelectedId.value == "no selected") {
		errSelected.innerHTML = "Please select a resident.";
		valid = false;
	}
	//contact no
	if(txtContact.value.length != 11) {
		errContact.innerHTML = "Please enter a valid contact number.";
		valid = false;
	} else if(txtContact.value == "") {
		errContact.innerHTML = "Please enter a valid contact number.";
		valid = false;
	}
	//username
	if(txtUser.value == "") {
		errUser.innerHTML = "Username cannot be blank.";
		valid = false;
	} else if(txtUser.value.length > 20 || txtUser.value.length < 5) {
		errUser.innerHTML = "Username characters length must be between 5 and 20.";
		valid = false;
	}
	//password
	if(txtPassword.value == "") {
		errPassword.innerHTML = "Password cannot be blank";
	} else if(txtPassword.value.length > 20 || txtPassword.value.length < 5) {
		errPassword.innerHTML = "Password characters length must be between 5 and 20.";
		valid = false;
	}
	//confirm
	if(txtPassword.value != txtConfirm.value) {
		errConfirm.innerHTML = "Password and confirm password doesn't match.";
		valid = false;
	}
	if(!valid) {
		alert("There is an error in the input fieds. Please fix to continue the submission of form.");

	}
	return valid;
}
function clearErrors() {
	for(var index = 0; index < errors.length; index++) {
		errors[index].innerHTML = "";
	}
}