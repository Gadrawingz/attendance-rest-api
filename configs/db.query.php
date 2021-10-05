<?php
include('connection.php');

class Query extends DBConnection {
	
	public function __construct() {
		$obj = new DBConnection;
		$this->conLink= $obj->connect();
	}

	// Made with love under Donnekt.inc & gadrawingz repo

	public function registerStaffMember($fn, $ln, $em, $ph, $gd, $rl, $ps) {
		$sql= "INSERT INTO staff(firstname, lastname, email, telephone, gender, staff_role, password) VALUES ('$fn', '$ln', '$em', '$ph', '$gd', '$rl', '$ps')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function checkStaffLogin($email, $pass) {
		$sql = "SELECT COUNT(*) FROM staff WHERE email='$email' AND password='$pass' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function checkStaffExistence($email, $phone) {
		$sql = "SELECT COUNT(*) FROM staff WHERE email='$email' OR telephone='$phone' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function staffLogin($email, $pass) {
		$sql = "SELECT * FROM staff WHERE email='$email' AND password='$pass' ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}


	public function viewStaffMembers() {
		$sql= "SELECT * FROM staff ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function viewStaffMember($staff_id) {
		$sql = " SELECT * FROM staff WHERE staff_id =? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$staff_id]);
		return $stmt;
	}

	public function updateStaffMember($id, $fn, $ln, $em, $ph, $gd, $rl, $ps) {
		$sql="UPDATE staff SET firstname='$fn', lastname='$ln', email='$em', telephone='$ph', gender='$gd', staff_role='$rl', password='$ps' WHERE staff_id='$id' ";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;			
	}

	public function deleteStaffMember($id) {
		$sql= "DELETE FROM staff WHERE staff_id='$id' ";
		$query = $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	public function countStaffMember($id) {
		$sql = "SELECT COUNT(*) FROM staff WHERE staff_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countStaffMembers() {
		$sql = "SELECT COUNT(*) FROM staff ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	} 


	/*****************************************
	 * READY-MADE/SIMPLIFIED API FOR SH**
	 * DEVELEPED AT DONNEKT/GADRAWINGZ
	 * COPYRIGHT @DONNEKT 2021 SEPTEMBER
	 * ***************************************/

	public function registerDepartment($name, $caption) {
		$sql= "INSERT INTO department(dept_name, dept_caption) VALUES ('$name', '$caption')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
	}


	public function viewDepartments() {
		$sql= "SELECT * FROM department ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function viewDepartment($id) {
		$sql = "SELECT * FROM department WHERE dept_id =? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function updateDepartment($id, $name, $caption) {
		$sql="UPDATE department SET dept_name='$name', dept_caption='$caption' WHERE dept_id='$id' ";
		$query= $this->conLink->prepare($sql);
		$query->execute(); 			
	}

	public function deleteDepartment($id) {
		$sql= "DELETE FROM department WHERE dept_id='$id' ";
		$query = $this->conLink->prepare($sql);
		$query->execute();
	}

	// COUNTZ
	public function checkDeptExistence($name) {
		$sql = "SELECT COUNT(*) FROM department WHERE dept_name='$name' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countDepartment($id) {
		$sql = "SELECT COUNT(*) FROM department WHERE dept_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countDepartments() {
		$sql = "SELECT COUNT(*) FROM department ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}



	/*****************************************
	 * READY-MADE/SIMPLIFIED API FOR SH**
	 * DEVELEPED AT DONNEKT/GADRAWINGZ
	 * COPYRIGHT @DONNEKT 2021 SEPTEMBER
	 * ***************************************/

	public function registerClassroom($name, $level, $dept_id) {
		$sql= "INSERT INTO class(class_name, class_level, dept_id) VALUES ('$name', '$level', '$dept_id')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 
	}

	public function viewClassrooms() {
		$sql= "SELECT * FROM class ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function viewClassroom($id) {
		$sql = "SELECT * FROM class WHERE class_id =? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function viewClassGroup($id) {
		$sql = "SELECT * FROM class WHERE class_id =? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function updateClassroom($id, $name, $level, $dept_id) {
		$sql="UPDATE class SET class_name='$name', class_level='$level', dept_id='$dept_id' WHERE class_id='$id' ";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 			
	}

	public function deleteClassroom($id) {
		$sql= "DELETE FROM class WHERE class_id='$id' ";
		$query = $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	// COUNTZ
	public function checkClassExistence($name) {
		$sql = "SELECT COUNT(*) FROM class WHERE class_name='$name' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countClassGroup($id) {
		$sql = "SELECT COUNT(*) FROM class WHERE class_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countClassroom($id) {
		$sql = "SELECT COUNT(*) FROM class WHERE class_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countClassrooms() {
		$sql = "SELECT COUNT(*) FROM class ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}




	/*****************************************
	 * READY-MADE/SIMPLIFIED API FOR SH**
	 * DEVELEPED AT DONNEKT/GADRAWINGZ
	 * COPYRIGHT @DONNEKT 2021 SEPTEMBER
	 * ***************************************/

	public function registerStudent($fn, $ln, $rg, $em, $ph, $gd, $ci) {
		$sql= "INSERT INTO student(firstname, lastname, reg_number, email, telephone, gender, class_id) VALUES ('$fn', '$ln', '$rg', '$em', '$ph', '$gd', '$ci')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 
	}

	public function viewStudents() {
		$sql= "SELECT * FROM student ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function viewStudent($id) {
		$sql = "SELECT * FROM student WHERE student_id=? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function updateStudent($id, $fn, $ln, $rg, $em, $ph, $gd, $ci) {
		$sql="UPDATE student SET firstname='$fn', lastname='$ln', reg_number='$rg', email='$em', telephone='$ph', gender='$gd', class_id='$ci' WHERE student_id='$id' ";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 			
	}

	public function deleteStudent($id) {
		$sql= "DELETE FROM student WHERE student_id='$id' ";
		$query = $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	// COUNTZ
	public function checkStudentExistence($email, $phone, $regno) {
		$sql = "SELECT COUNT(*) FROM student WHERE email='$email' OR reg_number='$regno' OR telephone='$phone' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countStudent($id) {
		$sql = "SELECT COUNT(*) FROM student WHERE student_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countStudents() {
		$sql = "SELECT COUNT(*) FROM student ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	} 




	/*****************************************
	 * READY-MADE/SIMPLIFIED API FOR SH**
	 * DEVELEPED AT DONNEKT/GADRAWINGZ
	 * COPYRIGHT @DONNEKT 2021 SEPTEMBER
	 * ***************************************/

	public function registerModule($name, $code, $dept_id, $lect_id) {
		$sql= "INSERT INTO module(module_name, module_code, dept_id, lecturer_id) VALUES ('$name', '$code', '$dept_id', '$lect_id')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 
	}

	public function viewModules() {
		$sql= "SELECT * FROM module ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function viewModule($id) {
		$sql = "SELECT * FROM module WHERE module_id=? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function updateModule($id, $name, $code, $dept_id, $lect_id) {
		$sql="UPDATE module SET module_name='$name', module_code='$code', dept_id='$dept_id', lecturer_id='$lect_id' WHERE module_id='$id' ";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 			
	}

	public function deleteModule($id) {
		$sql= "DELETE FROM module WHERE module_id='$id' ";
		$query = $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count;
	}

	// COUNTZ
	public function checkModuleExistence($code) {
		$sql = "SELECT COUNT(*) FROM module WHERE module_code='$code' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function checkAssignedModule($code, $lect_id) {
		$sql = "SELECT COUNT(*) FROM module WHERE module_code='$code' AND lecturer_id='$lect_id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countModule($id) {
		$sql = "SELECT COUNT(*) FROM module WHERE module_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countModules() {
		$sql = "SELECT COUNT(*) FROM module ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	} 






}
?>