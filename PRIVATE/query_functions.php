<?php 
/***************************	residents table	**************************************/
function generate_resident_id() {
	//str_pad(1,4,'0',STR_PAD_LEFT);
	global $conn;
	$id = date('ym') . "00000";
	$sql = "SELECT resident_id FROM residents WHERE "; 
	$sql .= "resident_id LIKE '" . date('ym') . "%' ";
	$sql .= "ORDER BY resident_id DESC LIMIT 1 ";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0) {
		$resident = mysqli_fetch_assoc($result);
		$id = substr($resident['resident_id'],4) + 1;
		$id = date('ym') . str_pad($id,5,'0',STR_PAD_LEFT);
	}
	return $id;
}
function retrieve_last_resident_id() {
	global $conn;
	$id = date('ym') . "00000";
	$sql = "SELECT resident_id FROM residents WHERE "; 
	$sql .= "resident_id LIKE '" . date('ym') . "%' ";
	$sql .= "ORDER BY resident_id DESC LIMIT 1 ";
	$result = mysqli_query($conn,$sql);
	$resident = mysqli_fetch_assoc($result);
	$last_id = $resident['resident_id'];
	return $last_id;
}
function insert_resident($resident) {
	global $conn;
	$sql = "INSERT INTO residents(resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status_id,place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date) ";
	$sql .= "VALUES(";
	$sql .= "'". generate_resident_id() ."', ";
	$sql .= "'". db_escape($conn, $resident['last_name']) ."', ";
	$sql .= "'". db_escape($conn, $resident['first_name']) ."', ";
	$sql .= "'". db_escape($conn, $resident['middle_name']) ."', ";
	$sql .= "'". db_escape($conn, $resident['date_of_birth']) ."', ";
	$sql .= "'". db_escape($conn, $resident['sex']) ."', ";
	$sql .= "'". db_escape($conn, $resident['civil_status_id']) ."', ";
	$sql .= "'". db_escape($conn, $resident['place_of_birth']) ."', ";
	$sql .= "'". db_escape($conn, $resident['citizenship']) ."', ";
	$sql .= "'". db_escape($conn, $resident['address']) ."', ";
	$sql .= "'". db_escape($conn, $resident['resident_since']) ."', ";
	$sql .= "'". db_escape($conn, $resident['occupation']) ."', ";
	$sql .= "'". db_escape($conn, $resident['salary_per_month']) ."', ";
	$sql .= "NOW())";
	$result = mysqli_query($conn,$sql);
	return $result;
}

function retrieve_all_residents($option=[]) {
	global $conn;
	$sql = "SELECT resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date 
	FROM residents INNER JOIN civil_status
	ON residents.civil_status_id = civil_status.civil_status_id 
	WHERE residents.is_deleted = false
	ORDER BY registration_date DESC, resident_id DESC ";
	if(isset($option['offset'])) {
		$sql .= "LIMIT ". $option['offset'] . ", 10";
	}
	$result = mysqli_query($conn,$sql);
	$residents = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $residents;
}
function search_residents($keyword) {
	global $conn;
	$sql = "SELECT resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date ";
	$sql .= "FROM residents INNER JOIN civil_status ";
	$sql .= "ON residents.civil_status_id = civil_status.civil_status_id ";	
	$sql .= "WHERE (last_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR first_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR middle_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%') ";
	$sql .= "AND residents.is_deleted = false ";
	$sql .= "ORDER BY registration_date DESC ";
	$result = mysqli_query($conn,$sql);
	$residents = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $residents;
}
function search_residents_available($keyword) {
	global $conn;
	$sql = "SELECT resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date ";
	$sql .= "FROM residents INNER JOIN civil_status ";
	$sql .= "ON residents.civil_status_id = civil_status.civil_status_id ";	
	$sql .= "WHERE (last_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR first_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR middle_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%') ";
	$sql .= "AND residents.is_deleted = false ";
	$sql .= "AND residents.resident_id NOT IN(SELECT resident_id FROM house_hold_resident INNER JOIN households ON households.house_hold_id = house_hold_resident.house_hold_id  WHERE house_hold_resident.is_deleted = false AND households.is_deleted = false) ";
	$sql .= "ORDER BY registration_date DESC ";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	$residents = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $residents;
}

function retrieve_resident($id) {
	global $conn;
	$sql = "SELECT resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date 
	FROM residents INNER JOIN civil_status
	ON residents.civil_status_id = civil_status.civil_status_id 
	WHERE resident_id='" . db_escape($conn,$id). "'";
	$result = mysqli_query($conn, $sql);
	$resident = mysqli_fetch_assoc($result);
	return $resident;
}
function delete_resident($id) {
	global $conn;
	$sql = "UPDATE residents SET is_deleted = true WHERE resident_id = '". db_escape($conn, $id) ."'";
	$result = mysqli_query($conn, $sql);

	return true;
}
function update_resident($resident){
	global $conn;

	$sql = "UPDATE residents SET ";
	$sql .= "last_name = '". db_escape($conn, $resident['last_name']) ."', ";
	$sql .= "first_name = '". db_escape($conn, $resident['first_name']) ."', ";
	$sql .= "middle_name = '". db_escape($conn, $resident['middle_name']) ."', ";
	$sql .= "date_of_birth = '". db_escape($conn, $resident['date_of_birth']) ."', ";
	$sql .= "sex = '". db_escape($conn, $resident['sex']) ."', ";
	$sql .= "civil_status_id = '". db_escape($conn, $resident['civil_status_id']) ."', ";
	$sql .= "place_of_birth = '". db_escape($conn, $resident['place_of_birth']) ."', ";
	$sql .= "citizenship = '". db_escape($conn, $resident['citizenship']) ."', ";
	$sql .= "address = '". db_escape($conn, $resident['address']) ."', ";
	$sql .= "resident_since = '". db_escape($conn, $resident['resident_since']) ."', ";
	$sql .= "occupation = '". db_escape($conn, $resident['occupation']) ."', ";
	$sql .= "salary_per_month = '". db_escape($conn, $resident['salary_per_month']) ."' ";
	$sql .= "WHERE resident_id = '". db_escape($conn,$resident['resident_id']) ."' ";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	return $result;
}

function retrieve_civil_status() {
	global $conn;
	$sql = "SELECT civil_status_id, description FROM civil_status WHERE is_deleted = false";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function count_residents() {
	global $conn;
	$sql = "SELECT COUNT(resident_id) as 'count' FROM residents WHERE is_deleted = false";
	$result = mysqli_query($conn,$sql);
	$residents = mysqli_fetch_assoc($result);
	return $residents['count'];
}
function retrieve_all_positions() {
	global $conn;
	$sql = "select * FROM positions WHERE description != 'Administrator' ";
	$result = mysqli_query($conn,$sql);
	return $result;
}
/*****************************       staffs table             ********************************/
function insert_staff($staff) {
	global $conn;
	$sql = "INSERT INTO staffs(staff_id,resident_id,position_id,date_hired,username,password,contact_no) ";
	$sql .= "VALUES( ";
	$sql .= "'". db_escape($conn,generate_staff_id()) ."', ";
	$sql .= "'". db_escape($conn,$staff['resident_id']) ."', ";
	$sql .= "'". db_escape($conn,$staff['position_id']) ."', ";
	$sql .= "'". date("Y-m-d") ."', ";
	$sql .= "'". db_escape($conn,$staff['username']) ."', ";
	$sql .= "'". db_escape($conn,password_hash($staff['password'],PASSWORD_DEFAULT)) ."', ";
	$sql .= "'". db_escape($conn,$staff['contact_no']) ."') ";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function generate_staff_id() {
	global $conn;
	$id = 'STF'.date('ym') . "01";
	$sql = "SELECT staff_id FROM staffs WHERE "; 
	$sql .= "staff_id LIKE '" . 'STF'. date('ym') . "%' ";
	$sql .= "ORDER BY staff_id DESC LIMIT 1 ";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0) {
		$staff = mysqli_fetch_assoc($result);
		$id = substr($staff['staff_id'],7) + 1;
		$id = 'STF' . date('ym') . str_pad($id,2,'0',STR_PAD_LEFT);
	}
	return $id;
}
function retrieve_last_staff_id() {
	global $conn;
	$id = date('ym') . "00000";
	$sql = "SELECT staff_id FROM staffs WHERE is_deleted = false ORDER BY staff_id DESC LIMIT 1 ";
	$result = mysqli_query($conn,$sql);
	$staff = mysqli_fetch_assoc($result);
	$last_id = $staff['staff_id'];
	return $last_id;
}
function retrieve_all_staffs() {
	global $conn;
	$sql = "SELECT staffs.staff_id, positions.description as 'position',staffs.date_hired,staffs.contact_no ,residents.resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date 
	FROM (((residents INNER JOIN civil_status
	ON residents.civil_status_id = civil_status.civil_status_id)
	INNER JOIN staffs ON staffs.resident_id = residents.resident_id)
	INNER JOIN positions ON staffs.position_id = positions.position_id) WHERE staffs.is_deleted = false";
	$result = mysqli_query($conn,$sql);
	$staffs = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $staffs;
}
function retrieve_staff($id) {
	global $conn;
	$sql = "SELECT staffs.staff_id, positions.description as 'position',staffs.username,staffs.date_hired,staffs.contact_no ,residents.resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date 
	FROM (((residents INNER JOIN civil_status
	ON residents.civil_status_id = civil_status.civil_status_id)
	INNER JOIN staffs ON staffs.resident_id = residents.resident_id)
	INNER JOIN positions ON staffs.position_id = positions.position_id) WHERE staffs.is_deleted = false ";
	$sql .= "AND staffs.staff_id = '". db_escape($conn,$id) ."' ";
	$result = mysqli_query($conn,$sql);
	$staff = mysqli_fetch_assoc($result);
	return $staff;
}
function delete_staff($id) {
	global $conn;
	$sql = "UPDATE staffs SET is_deleted = true WHERE staff_id = '". db_escape($conn, $id) ."'";
	$result = mysqli_query($conn, $sql);

	return true;
}
function auth_staff($username,$password) {
	global $conn;
	$sql = "SELECT staffs.staff_id, positions.description as 'position',staffs.password,staffs.resident_id, CONCAT(residents.last_name, ', ',residents.first_name, ' ',residents.middle_name) AS 'name' ";
	$sql .= "FROM ((staffs INNER JOIN positions ";
	$sql .= "ON staffs.position_id = positions.position_id) ";
	$sql .= "INNER JOIN residents ON residents.resident_id = staffs.resident_id) ";
	$sql .= "WHERE staffs.username = ";
	$sql .= "'". db_escape($conn,$username) . "' ";
	$sql .= "AND staffs.is_deleted = false ";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	$staff = mysqli_fetch_assoc($result);
	$success = password_verify($password,$staff['password']);

	if($success) {
		return $staff;
	} else {
		return false;
	}
}
function update_staff($staff) {
	global $conn;
	$sql = "UPDATE staffs SET position_id = '". db_escape($conn,$staff['position_id']) ."',";
	$sql .= "contact_no = '". db_escape($conn,$staff['contact_no']) ."' ";
	$sql .= "WHERE staff_id = '". db_escape($conn,$staff['staff_id']) ."'";
	echo $sql;
	$result = mysqli_query($conn, $sql);

	return true;
}
function update_account($account) {
	global $conn;
	$sql = "UPDATE staffs SET username = '". db_escape($conn,$account['username']) ."',";
	$sql .= "password = '". db_escape($conn,password_hash($account['password'],PASSWORD_DEFAULT)) ."' ";
	$sql .= "WHERE staff_id = '". db_escape($conn,$account['staff_id']) ."'";
	echo $sql;
	$result = mysqli_query($conn, $sql);

	return true;
}
function search_staffs($keyword) {
	global $conn;
	$sql = "SELECT staffs.staff_id, positions.description as 'position',staffs.username,staffs.date_hired,staffs.contact_no ,staffs.resident_id,last_name,first_name,middle_name,date_of_birth,sex,civil_status.description as 'civil_status',place_of_birth,citizenship,address,resident_since,occupation,salary_per_month,registration_date ";
	$sql .= "FROM (((residents INNER JOIN civil_status ";
	$sql .= "ON residents.civil_status_id = civil_status.civil_status_id) ";
	$sql .= "INNER JOIN staffs ON staffs.resident_id = residents.resident_id) ";
	$sql .= "INNER JOIN positions ON staffs.position_id = positions.position_id) ";	
	$sql .= "WHERE (last_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR first_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR middle_name LIKE ";
	$sql .= "'%". db_escape($conn,$keyword) ."%') ";
	$sql .= "AND (residents.is_deleted = false AND staffs.is_deleted = false) ";
	$sql .= "ORDER BY registration_date DESC ";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	$residents = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $residents;
}
function count_staffs() {
	global $conn;
	$sql = "SELECT COUNT(staff_id) AS 'count' FROM staffs WHERE staffs.is_deleted = false ";
	$result = mysqli_query($conn,$sql);
	$staffs = mysqli_fetch_assoc($result);
	return $staffs['count'];
}

/*****************************      BLOTTERS             ***************************************/

function insert_violation($description)
{
	global $conn;
	$sql ="INSERT INTO violations(description) VALUES('$description')";
	$result = mysqli_query($conn,$sql);
}

function retrieve_violation_by_id($id)
{
	global $conn;
	$sql = "SELECT * FROM violations WHERE violation_id = $id";
	$result = mysqli_query($conn,$sql);

	return mysqli_fetch_assoc($result);
}

function update_violation($id,$description)
{
	global $conn;
	$sql = "UPDATE violations SET description='$description' WHERE violation_id = $id";
	$result = mysqli_query($conn,$sql);
}

function retrieve_all_violations() {
	global $conn;
	$sql = "SELECT * FROM violations WHERE is_deleted = false";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function generate_blotter_id() {
	global $conn;
	$new_id = "BR".date("ym") . "0001";
	$sql = "SELECT blotter_id FROM blotter_reports WHERE blotter_id LIKE ";
	$sql .= "'BR". date("ym") ."%' ";
	$sql .= "ORDER BY blotter_id DESC LIMIT 1 ";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0) {
		$blotter = mysqli_fetch_assoc($result);
		$new_id = substr($blotter['blotter_id'],6) + 1;
		$new_id = "BR".date("ym") . str_pad($new_id,4,'0',STR_PAD_LEFT);
	}
	return $new_id;
}
function insert_blotter($blotter) {
	global $conn;
	$sql = "INSERT INTO blotter_reports(blotter_id,description,violation_id,complainant_name,respondent_name,date_report,staff_id) ";
	$sql .= "VALUES( ";
	$sql .= "'". generate_blotter_id() ."', ";
	$sql .= "'". db_escape($conn,$blotter['description']) ."', ";
	$sql .= "'". db_escape($conn,$blotter['violation_id']) ."', ";
	$sql .= "'". db_escape($conn,$blotter['complainant_name']) ."', ";
	$sql .= "'". db_escape($conn,$blotter['respondent_name']) ."', ";
	$sql .= "NOW(), ";
	$sql .= "'". db_escape($conn,$blotter['staff_id']) ."') ";
	$result = mysqli_query($conn,$sql);
	return $result;
}

function retrieve_all_blotters() {
	global $conn;
	$sql = "SELECT blotter_id, blotter_reports.description AS 'description', violations.description AS 'violation', complainant_name, date_report, respondent_name, CONCAT(residents.last_name, ', ' ,residents.first_name, ' ',residents.middle_name) AS staff ";
	$sql .= "FROM (((blotter_reports INNER JOIN violations ";
	$sql .= "ON blotter_reports.violation_id = violations.violation_id) ";
	$sql .= "INNER JOIN staffs ON staffs.staff_id = blotter_reports.staff_id) ";
	$sql .= "INNER JOIN residents ON residents.resident_id = staffs.resident_id) ";
	$sql .= "ORDER BY date_report DESC, blotter_id DESC ";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	$blotters = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $blotters;
}
function retrieve_blotter($id) {
	global $conn;
	$sql = "SELECT blotter_id, blotter_reports.description AS 'description', violations.description AS 'violation', complainant_name, date_report, respondent_name, CONCAT(residents.last_name, ', ' ,residents.first_name, ' ',residents.middle_name) AS staff ";
	$sql .= "FROM (((blotter_reports INNER JOIN violations ";
	$sql .= "ON blotter_reports.violation_id = violations.violation_id) ";
	$sql .= "INNER JOIN staffs ON staffs.staff_id = blotter_reports.staff_id) ";
	$sql .= "INNER JOIN residents ON residents.resident_id = staffs.resident_id) ";
	$sql .= "WHERE blotter_id = '". db_escape($conn,$id) ."' ";
	$sql .= "ORDER BY date_report DESC ";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	$blotter = mysqli_fetch_assoc($result);
	return $blotter;
}
function retrieve_last_blotter_id() {
	global $conn;
	$sql = "SELECT blotter_id FROM blotter_reports ORDER BY blotter_id DESC LIMIT 1";
	$result = mysqli_query($conn,$sql);
	$blotter = mysqli_fetch_assoc($result);
	$last_id = $blotter['blotter_id'];
	return $last_id;
}
function update_blotter($blotter) {
	global $conn;
	$sql = "UPDATE blotter_reports SET ";
	$sql .= "description = '". db_escape($conn,$blotter['description']) ."', ";
	$sql .= "violation_id = '". db_escape($conn,$blotter['violation_id']) ."', ";
	$sql .= "complainant_name = '". db_escape($conn,$blotter['complainant_name']) ."', ";
	$sql .= "respondent_name = '". db_escape($conn,$blotter['respondent_name']) ."' ";
	$sql .= "WHERE blotter_id = '". db_escape($conn,$blotter['blotter_id']) ."' ";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function search_blotter($keyword) {
	global $conn;
	$sql = "SELECT blotter_id, blotter_reports.description AS 'description', violations.description AS 'violation', complainant_name, date_report, respondent_name, CONCAT(residents.last_name, ', ' ,residents.first_name, ' ',residents.middle_name) AS staff ";
	$sql .= "FROM (((blotter_reports INNER JOIN violations ";
	$sql .= "ON blotter_reports.violation_id = violations.violation_id) ";
	$sql .= "INNER JOIN staffs ON staffs.staff_id = blotter_reports.staff_id) ";
	$sql .= "INNER JOIN residents ON residents.resident_id = staffs.resident_id) ";
	$sql .= "WHERE blotter_reports.description LIKE '%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR respondent_name LIKE '%". db_escape($conn,$keyword) ."%' ";
	$sql .= "OR complainant_name LIKE '%". db_escape($conn,$keyword) ."%' ";
	$sql .= "ORDER BY date_report DESC ";
	$result = mysqli_query($conn,$sql);
	$blotter = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $blotter;
}
function insert_resident_blotter($blotter_id,$resident_id) {
	global $conn;
	$sql = "INSERT INTO resident_blotter(blotter_id, resident_id) VALUES('$blotter_id','$resident_id')";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function retrieve_resident_blotter($blotter_id) {
	global $conn;
	$sql = "SELECT blotter_id,residents.resident_id,CONCAT(last_name, ', ', first_name, ' ',middle_name) AS 'name',address,sex ";
	$sql .= "FROM resident_blotter INNER JOIN residents ";
	$sql .= "ON resident_blotter.resident_id = residents.resident_id ";
	$sql .= "WHERE blotter_id = '$blotter_id' ";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function insert_household($household) {
	global $conn;
	$sql = "INSERT INTO households(house_number,address) VALUES('$household[house_number]','$household[address]')";
	$result = mysqli_query($conn,$sql);
	return $result;
}
// function retrieve_household($id) {
// 	global $conn;
// 	$sql = "SELECT * FROM households WHERE house_hold_id = $id";
// 	$result = mysqli_query($conn,$sql);
// 	$household = mysqli_fetch_assoc($result);
// 	return $household;
// }
function insert_member($member) {
	global $conn;
	$sql = "INSERT INTO house_hold_resident(resident_id,house_hold_id,role_in_the_family) VALUES('$member[resident_id]','$member[house_hold_id]','$member[role_in_the_family]')";
	//echo $sql;
	$result = mysqli_query($conn,$sql);
	return $result;
}
function retrieve_members($house_hold_id) {
	global $conn;
	$sql = "SELECT residents.resident_id,CONCAT(last_name, ', ', first_name, ' ',middle_name) AS 'name', sex,date_of_birth,occupation,salary_per_month,role_in_the_family ";
	$sql .= "FROM house_hold_resident INNER JOIN residents ";
	$sql .= "ON house_hold_resident.resident_id = residents.resident_id ";
	$sql .= "WHERE house_hold_id = $house_hold_id AND house_hold_resident.is_deleted = false";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function remove_members($resident_id,$house_hold_id) {
	global $conn;
	$sql = "UPDATE house_hold_resident SET is_deleted = true WHERE resident_id = '$resident_id' AND house_hold_id = $house_hold_id ";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function retrieve_households() {
	global $conn;
	$sql = "SELECT households.house_hold_id,house_number,address, COUNT(house_hold_resident.resident_id) AS 'total_members'
			FROM households LEFT JOIN house_hold_resident
			ON households.house_hold_id = house_hold_resident.house_hold_id AND house_hold_resident.is_deleted = 'false' WHERE households.is_deleted = 'false'
			GROUP BY households.house_hold_id";
	$result = mysqli_query($conn,$sql);
	$households = mysqli_fetch_all($result,MYSQLI_ASSOC);
	return $households;
}
function retrieve_household($id) {
	global $conn;
	$sql = "SELECT households.house_hold_id,house_number,address, COUNT(house_hold_resident.resident_id) AS 'total_members'
			FROM households LEFT JOIN house_hold_resident
			ON households.house_hold_id = house_hold_resident.house_hold_id AND house_hold_resident.is_deleted = 'false' WHERE households.house_hold_id = $id AND households.is_deleted = 'false'
			GROUP BY households.house_hold_id";
	$result = mysqli_query($conn,$sql);
	$households = mysqli_fetch_assoc($result);
	return $households;
}
function delete_households($id) {
	global $conn;
	$sql = "UPDATE households SET is_deleted = true WHERE house_hold_id = '". db_escape($conn, $id) ."'";
	$result = mysqli_query($conn, $sql);

	return true;
}
function update_households($household){
	global $conn;
	$sql = "UPDATE households SET house_number = '$household[house_number]', address = '$household[address]' WHERE house_hold_id = '$household[house_hold_id]'";
	$result = mysqli_query($conn, $sql);
	//echo $sql;

	return $result;
}
function retrieve_barangay_captain() {
	global $conn;
	$sql = "SELECT resident_official_id, residents.resident_id,CONCAT(residents.last_name, ', ', residents.first_name, ' ', residents.middle_name) AS 'name', residents.sex,
official_positions.description AS 'position'
FROM ((resident_official INNER JOIN residents ON residents.resident_id = resident_official.resident_id)
INNER JOIN official_positions ON resident_official.official_position_id = official_positions.official_position_id)
WHERE official_positions.description = 'Barangay Captain'";
	$result = mysqli_query($conn,$sql); 
	$brgy_captain = mysqli_fetch_assoc($result);
	return $brgy_captain;
}
function retrieve_councilors() {
		global $conn;
	$sql = "SELECT resident_official_id, residents.resident_id,CONCAT(residents.last_name, ', ', residents.first_name, ' ', residents.middle_name) AS 'name', residents.sex,
official_positions.description AS 'position'
FROM ((resident_official INNER JOIN residents ON residents.resident_id = resident_official.resident_id)
INNER JOIN official_positions ON resident_official.official_position_id = official_positions.official_position_id)
WHERE official_positions.description = 'Councilor'";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function retrieve_official($id) {
	global $conn;
		$sql = "SELECT resident_official_id, residents.resident_id,residents.address,CONCAT(residents.last_name, ', ', residents.first_name, ' ', residents.middle_name) AS 'name', residents.sex,
official_positions.description AS 'position'
FROM ((resident_official INNER JOIN residents ON residents.resident_id = resident_official.resident_id)
INNER JOIN official_positions ON resident_official.official_position_id = official_positions.official_position_id)
WHERE resident_official_id = " . $id;
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_assoc($result);
}
function update_official($official) {
	global $conn;
	$sql = "UPDATE resident_official SET resident_id = '". $official['resident_id'] ."' WHERE resident_official_id = '". $official['resident_official_id'] ."'";
	$result = mysqli_query($conn,$sql);
}
function insert_business($business) {
	global $conn;
	$sql = "INSERT INTO business_permit(resident_id,business_description,date_issued,business_address,purok) ";
	$sql .= "VALUES('$business[resident_id]','$business[business_description]',NOW(),'$business[business_address]',$business[purok] )";
	mysqli_query($conn,$sql);

}
function retrieve_business($id) {
	global $conn;
	$sql = "SELECT business_permit_id,business_description,date_issued,business_address,purok,UPPER(CONCAT(last_name, ', ',first_name, ' ',middle_name)) AS 'owner_name' FROM business_permit INNER JOIN residents ON business_permit.resident_id = residents.resident_id WHERE business_permit_id = " . $id;
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_assoc($result);
}
function retrieve_all_business() {
	global $conn;
	$sql = "SELECT business_permit_id,business_description,date_issued,business_address,purok,UPPER(CONCAT(last_name, ', ',first_name, ' ',middle_name)) AS 'owner_name' FROM business_permit INNER JOIN residents ON business_permit.resident_id = residents.resident_id";
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
function search_business($keyword) {
	global $conn;
	$sql = "SELECT business_permit_id,business_description,date_issued,business_address,purok,UPPER(CONCAT(last_name, ', ',first_name, ' ',middle_name)) AS 'owner_name' FROM business_permit INNER JOIN residents ON business_permit.resident_id = residents.resident_id ";
	$sql .= "WHERE residents.last_name LIKE '%". $keyword . "%' ";
	$sql .= "OR residents.first_name LIKE '%". $keyword . "%' ";
	$sql .= "OR residents.middle_name LIKE '%". $keyword . "%' ";
	$sql .= "OR business_description LIKE '%". $keyword . "%' ";
	$sql .= "OR purok LIKE '%". $keyword . "%' ";
	$sql .= "OR business_address LIKE '%". $keyword . "%' ";
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
function checkRecord($resident_id) {
	global $conn;
	$hasRecord = false;
	$sql = "SELECT resident_id FROM resident_blotter WHERE resident_id = '". $resident_id ."'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result) > 0) {
		$hasRecord = true;
	}
	return $hasRecord;
}
function getRecord($resident_id) {
	global $conn;
	$hasRecord = false;
	$sql = "SELECT blotter_id FROM resident_blotter WHERE resident_id = '". $resident_id ."'";
	$result = mysqli_query($conn,$sql);
	return $result;
}
function insert_barangay_clearance($brgy_clearance) {
	global $conn;
	$sql = "INSERT INTO barangay_clearance(resident_id,purpose,date_issued) VALUES('$brgy_clearance[resident_id]','$brgy_clearance[purpose]',NOW())";
	mysqli_query($conn,$sql);
}
function retrieve_clearance($id) {
	global $conn;
	$sql = "SELECT * FROM barangay_clearance WHERE barangay_clearance_id = '". $id ."'";
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_assoc($result);
}
function retrieve_clearances() {
	global $conn;
	$sql = "SELECT * FROM barangay_clearance INNER JOIN residents ON residents.resident_id = barangay_clearance.resident_id";
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
function search_clearance($keyword) {
	global $conn;
	$sql = "SELECT * FROM barangay_clearance INNER JOIN residents ON residents.resident_id = barangay_clearance.resident_id ";
	$sql .= "WHERE residents.first_name LIKE '%". $keyword ."%' ";
	$sql .= "OR residents.last_name LIKE '%". $keyword ."%' ";
	$sql .= "OR residents.middle_name LIKE '%". $keyword ."%' ";
	$result = mysqli_query($conn,$sql);
	return mysqli_fetch_all($result,MYSQLI_ASSOC);
}
?>