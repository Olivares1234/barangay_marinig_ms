function Blotter(id, description, complainantName, respondentName, staffName, dateReport, violation) {
	var _id  = id;
	var _description = description;
	var _complainantName = complainantName;
	var _respondentName = respondentName;
	var _staffName = staffName;
	var _dateReport = dateReport;
	var _violation = violation;

	//getters
	this.getId = function() {
		return _id;
	};
	this.getDescription = function() {
		return _description;
	};
	this.getComplainantName = function() {
		return _complainantName;
	};
	this.getRespondentName = function() {
		return _respondentName;
	};
	this.getStaffName = function() {
		return _staffName;
	};
	this.getDateReport = function() {
		return _dateReport;
	};
	this.getViolation = function() {
		return _violation;
	};

	//setters
	this.setId = function(id) {
		return _id = id;
	};
	this.setDescription = function(description) {
		_description = description;
	};
	this.setComplainantName = function(complainantName) {
		_complainantName = complainantName;
	};
	this.setRespondentName = function(respondentName) {
		_respondentName = respondentName;
	};
	this.setStaffName = function(staffName) {
		_staffName = staffName;
	};
	this.setDateReport = function(dateReport) {
		_dateReport = dateReport;
	};
	this.setViolation = function(violation) {
		_violation = violation;
	}

}

Blotter.prototype = new Table();

Blotter.prototype.ParseJSON = function(jsonData) {
	var blotters = [];
	for(var index = 0; index < jsonData.length; index++) {
		var blotter = new Blotter();
		blotter.setId(jsonData[index].blotter_id);
		blotter.setDescription(jsonData[index].description);
		blotter.setComplainantName(jsonData[index].complainant_name);
		blotter.setRespondentName(jsonData[index].respondent_name);
		blotter.setStaffName(jsonData[index].staff);
		blotter.setDateReport(jsonData[index].date_report);
		blotter.setViolation(jsonData[index].violation);
		blotters.push(blotter);
	}
	return blotters;
}
Blotter.prototype.Insert = function(tblElement,actions = this.NewTD()) {
	
	var details = [this.getId(),this.getDescription(),this.getComplainantName(),this.getRespondentName(),
	this.getViolation(),this.getStaffName(),this.getDateReport()];

	this.NewTR(tblElement,details,actions);
}