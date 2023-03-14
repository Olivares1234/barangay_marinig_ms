function Staff(id,lastName,firstName,middleName,dateOfBirth,sex,civilStatus,placeOfBirth,
	citizenship,address,residentSince,occupation,salary,registrationDate) {
	Resident.call(this,id,lastName,firstName,middleName,dateOfBirth,sex,civilStatus,placeOfBirth,
	citizenship,address,residentSince,occupation,salary,registrationDate);
	var _id = "";
	var _position = "";
	var _dateHired = "";
	var _contactNo = "";

	//getters
	this.getStaffId = function() {
		return _id;
	}
	this.getPosition = function() {
		return _position;
	}
	this.getDateHired = function() {
		return _dateHired;
	}
	this.getContactNo = function() {
		return _contactNo;
	}
	//setters
	this.setStaffId = function(id) {
		_id = id;
	}
	this.setPosition = function(position) {
		_position = position;
	}
	this.setDateHired = function(dateHired) {
		_dateHired = dateHired;
	}
	this.setContactNo = function(contactNo) {
		_contactNo = contactNo;
	}

}
Staff.prototype = new Resident();
// Staff.prototype.ParseJSON = function(jsonData) {
// 	var staffList = [];
// 	// Person.prototype.ParseJSON.call(this);
// 	for(var index = 0; index < jsonData.length; index++) {
// 		var staff = new Staff();
// 		Resident.prototype.ParseJSON.call(staff,jsonData);
// 		staff.setStaffId(jsonData[index].staff_id);
// 		staff.setPosition(jsonData[index].position);
// 		staff.setDateHired(jsonData[index].date_hired);
// 		staff.setContactNo(jsonData[index].contact_no);
// 		staffList.push(staff);
// 	}
// 	return staffList;
// }
Staff.prototype.ParseJSON = function(jsonData) {
	var listStaff = [];
		
	for(var index = 0; index < jsonData.length; index++) {
		var staff = new Staff();
		staff.setId(jsonData[index].resident_id);
		staff.setLastName(jsonData[index].last_name);
		staff.setFirstName(jsonData[index].first_name);
		staff.setMiddleName(jsonData[index].middle_name);
		staff.setDateOfBirth(jsonData[index].date_of_birth);
		staff.setSex(jsonData[index].sex);
		staff.setCivilStatus(jsonData[index].civil_status);
		staff.setPlaceOfBirth(jsonData[index].place_of_birth);
		staff.setCitizenship(jsonData[index].citizenship);
		staff.setAddress(jsonData[index].address);
		staff.setResidentSince(jsonData[index].resident_since);
		staff.setOccupation(jsonData[index].occupation);
		staff.setSalary(jsonData[index].salary_per_month);
		staff.setRegistrationDate(jsonData[index].registration_date);
		staff.setStaffId(jsonData[index].staff_id);
		staff.setPosition(jsonData[index].position);
		staff.setDateHired(jsonData[index].date_hired);
		staff.setContactNo(jsonData[index].contact_no);
		listStaff.push(staff);
	}
	return listStaff;
	
}
Resident.prototype.Insert = function(tblElement,actions = this.NewTD()) {
	
	var details = [this.getStaffId(),this.GetFullName(),this.getAddress(),this.getSex(),
	this.ComputeAge(),this.getPosition(),this.getDateHired()];

	this.NewTR(tblElement,details,actions);
}