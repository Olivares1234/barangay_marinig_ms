function Resident(id,lastName,firstName,middleName,dateOfBirth,sex,civilStatus,placeOfBirth,
	citizenship,address,residentSince,occupation,salary,registrationDate) {
	var _id = id;
	var _lastName = lastName;
	var _firstName = firstName;
	var _middleName = middleName;
	var _dateOfBirth = dateOfBirth;
	var _sex = sex;
	var _civilStatus = civilStatus;
	var _placeOfBirth = placeOfBirth;
	var _citizenship = citizenship;
	var _address = address;
	var _residentSince = residentSince;
	var _occupation = occupation;
	var _salary = salary;
	var _registrationDate = registrationDate;


	//getters
	this.getId = function() { return _id; };
	this.getLastName = function() { return _lastName; };
	this.getFirstName = function() { return _firstName; };
	this.getMiddleName = function() { return _middleName; };
	this.getDateOfBirth = function() { return _dateOfBirth; };
	this.getSex = function() { 
		var sex = "";
		if(_sex == "0") {
			sex = "Male";
		} else if(_sex == "1") {
			sex = "Female";
		}
		return sex;
	};

	this.getCivilStatus = function() { return _civilStatus; };
	this.getPlaceOfBirth = function() { return _placeOfBirth; };
	this.getCitizenship = function() { return _citizenship; };
	this.getAddress = function() { return _address; };
	this.getResidentSince = function() { return _residentSince; };
	this.getOccupation = function() { return _occupation };
	this.getSalary = function() { return _salary; };
	this.getRegistrationDate = function() { return _registrationDate; };

	//setters
	this.setId = function(id) { _id = id; };
	this.setLastName = function(lastName) { _lastName = lastName; };
	this.setFirstName = function(firstName) { _firstName = firstName; };
	this.setMiddleName = function(middleName) { _middleName = middleName; };
	this.setDateOfBirth = function(dateOfBirth) { _dateOfBirth = dateOfBirth; };
	this.setSex = function(sex) { _sex = sex; };
	this.setCivilStatus = function(civilStatus) { _civilStatus = civilStatus; };
	this.setPlaceOfBirth = function(placeOfBirth) { _placeOfBirth = placeOfBirth; };
	this.setCitizenship = function(citizenship) { _citizenship = citizenship; };
	this.setAddress = function(address) { _address = address; };
	this.setResidentSince = function(residentSince) { _residentSince = residentSince; };
	this.setOccupation = function(occupation) { _occupation = occupation; };
	this.setSalary = function(salary) { _salary = salary; };
	this.setRegistrationDate = function(registrationDate) { _registrationDate = registrationDate; };

}

Resident.prototype = new Table();

Resident.prototype.ParseJSON = function(jsonData) {
	var listResident = [];
	for(var index = 0; index < jsonData.length; index++) {
		var resident = new Resident();
		resident.setId(jsonData[index].resident_id);
		resident.setLastName(jsonData[index].last_name);
		resident.setFirstName(jsonData[index].first_name);
		resident.setMiddleName(jsonData[index].middle_name);
		resident.setDateOfBirth(jsonData[index].date_of_birth);
		resident.setSex(jsonData[index].sex);
		resident.setCivilStatus(jsonData[index].civil_status);
		resident.setPlaceOfBirth(jsonData[index].place_of_birth);
		resident.setCitizenship(jsonData[index].citizenship);
		resident.setAddress(jsonData[index].address);
		resident.setResidentSince(jsonData[index].resident_since);
		resident.setOccupation(jsonData[index].occupation);
		resident.setSalary(jsonData[index].salary_per_month);
		resident.setRegistrationDate(jsonData[index].registration_date);
		listResident.push(resident);
	}
	return listResident;
}
Resident.prototype.GetFullName = function() {
	return this.getLastName() + ", " + this.getFirstName() + " " + this.getMiddleName();
}
Resident.prototype.ComputeAge = function() {
	return Math.floor((new Date() - new Date(this.getDateOfBirth())) /1000/60/60/24/365);
}
Resident.prototype.Insert = function(tblElement,actions = this.NewTD()) {
	
	var details = [this.getId(),this.GetFullName(),this.getAddress(),this.getSex(),
	this.ComputeAge(),this.getCivilStatus(),this.getCitizenship()];

	this.NewTR(tblElement,details,actions);
}