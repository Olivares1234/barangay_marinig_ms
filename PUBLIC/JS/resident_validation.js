//dom
var txtName,dateOfBirth,txtPlaceOfBirth,txtAddress,dateResidentSince,txtReligion,
	txtOccupation,txtSalary;
txtName = document.getElementById("residentName").getElementsByTagName("input");
dateOfBirth = document.getElementById("dateOfBirth");
txtPlaceOfBirth = document.getElementById("txtPlaceOfBirth");
txtAddress = document.getElementById("txtAddress");
dateResidentSince = document.getElementById("dateResidentSince");
txtCitizenship = document.getElementById("txtCitizenship");
txtOccupation = document.getElementById("txtOccupation");
txtSalary = document.getElementById("txtSalary");

//errorMessage
var error,errLName,errFName,errMName,errDateOfBirth,errPlaceOfBirth,errAddress,errResidentSince,
	errReligion,errOccupation,errSalary;
error = document.getElementsByClassName("error");
errLName = document.getElementById("errLName");
errFName = document.getElementById("errFName");
errMName = document.getElementById("errMName");
errDateOfBirth = document.getElementById("errDateOfBirth");
errPlaceOfBirth = document.getElementById("errPlaceOfBirth");
errAddress = document.getElementById("errAddress");
errResidentSince = document.getElementById("errResidentSince");
errCitizenship = document.getElementById("errCitizenship");
errOccupation = document.getElementById("errOccupation");
errSalary = document.getElementById("errSalary");


function ValidateResidentInfo() {
	var valid = true;

	clearErrorMessage();

	//last name
	if(txtName[0].value == "") {
		errLName.innerHTML = "Last Name cannot be blank.";
		valid = false;
	} else if(txtName[0].value.length > 35) {
		errLName.innerHTML = "Last Name characters max length is 35.";
		txtName[0].focus();
		valid = false;
	}
	//first name
	if(txtName[1].value == "") {
		errFName.innerHTML = "First Name cannot be blank.";
		valid =  false;
	} else if(txtName[1].value.length > 35) {
		errFName.innerHTML = "First Name characters max length is 35.";
		valid = false;
	}
	//middle name
	if(txtName[2].value == "") {
		errMName.innerHTML = "Middle Name cannot be blank.";
		valid =  false;
	} else if(txtName[2].value.length > 35) {
		errMName.innerHTML = "Middle Name characters max length is 35.";
		valid = false;
	}

	//date of birth
	if(dateOfBirth.value == "") {
		errDateOfBirth.innerHTML = "Please Select Date of Birth.";
		valid = false;
	}
	//place of birth
	if(txtPlaceOfBirth.value == "") {
		errPlaceOfBirth.innerHTML = "Place of birth cannot be blank.";
		valid = false;
	} else if(txtPlaceOfBirth.value.length > 100) {
		errPlaceOfBirth.innerHTML = "Place of birth characters max length is 100.";
		valid = false;
	}
	//address
	if(txtAddress.value == "") {
		errAddress.innerHTML = "Address cannot be blank.";
	}else if(txtAddress.value.length > 100) {
		errAddress.innerHTML = "Address characters max length is 100.";
		valid = false;
	}
	//resident since
	if(dateResidentSince.value == "") {
		errResidentSince.innerHTML = "Please select a date.";
		valid = false;
	}
	//citizenship
	if(txtCitizenship.value == "") {
		errCitizenship.innerHTML = "Citizenship cannot be blank";
		valid = false;
	} else if(txtCitizenship.value.length > 45) {
		errCitizenship.innerHTML = "Citizenship characters max length is 45.";
		valid = false;
	}
	//occupation
	if(txtOccupation.value == "") {
		errOccupation.innerHTML = "Occupation cannot be blank.";
		valid = false;
	} else if(txtOccupation.value.length > 50) {
		errOccupation.innerHTML = "occupation characters max length is 50.";
		valid = false;
	}
	//salary
	// if(txtSalary.value != "") {
	// 	if(parseFloat(txtSalary.value) <= 0) {
	// 		errSalary.innerHTML = "Salary is not valid.";
	// 	}
	// }
	if(txtSalary.value == "" || parseFloat(txtSalary.value) <= 0) {
		errSalary.innerHTML = "Salary is not valid.";
		valid = false;
	}
	if(!valid) {
		alert("There is an error in the input fieds. Please fix to continue the submission of form.");
	}
	return valid;
}

function clearErrorMessage() {
	for(var index = 0; index < error.length; index++) {
		error[index].innerHTML = "";
	}
}