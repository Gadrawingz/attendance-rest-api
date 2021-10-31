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

	public function viewLecturers() {
		$sql= "SELECT * FROM staff WHERE staff_role='LECTURER' ";
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

	public function countLecturers() {
		$sql = "SELECT COUNT(*) FROM staff WHERE staff_role='LECTURER' ";
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

	public function viewDepartmentByName($name) {
		$sql = "SELECT * FROM department WHERE dept_name =? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$name]);
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

	public function countDepartmentByName($name) {
		$sql = "SELECT COUNT(*) FROM department WHERE dept_name='$name' ";
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
		$sql= "SELECT cl.class_id, cl.class_name, cl.class_level, cl.dept_id, dp.dept_name, dp.dept_caption FROM class cl JOIN department dp ON cl.dept_id=dp.dept_id ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function viewClassroom($id) {
		$sql = "SELECT cl.class_id, cl.class_name, cl.class_level, cl.dept_id, dp.dept_name, dp.dept_caption FROM class cl JOIN department dp ON cl.dept_id=dp.dept_id WHERE class_id =? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function viewClassGroup($id) {
		$sql = "SELECT cl.class_id, cl.class_name, cl.class_level, cl.dept_id, dp.dept_name, dp.dept_caption FROM class cl JOIN department dp ON cl.dept_id=dp.dept_id WHERE class_id =? ";
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

	public function viewStudentByClass($id) {
		$sql = "SELECT * FROM student WHERE class_id=? ORDER BY student_id ASC";
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

	public function countStudentByClass($id) {
		$sql = "SELECT COUNT(*) FROM student WHERE class_id='$id' ";
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

	public function registerModule($name, $code, $lect_id) {
		$sql= "INSERT INTO module(module_name, module_code, lecturer_id) VALUES ('$name', '$code', '$lect_id')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 
	}

	public function viewModules() {
		$sql= "SELECT md.module_id, md.module_name, md.module_code, st.staff_id AS lecturer_id, st.firstname, st.lastname, st.telephone, st.email, st.staff_role FROM module md JOIN staff st ON st.staff_id=md.lecturer_id ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	// View single module
	public function viewModule($id) {
		$sql = "SELECT md.module_id, md.module_name, md.module_code, st.staff_id AS lecturer_id, st.firstname, st.lastname, st.telephone, st.email, st.staff_role FROM module md JOIN staff st ON st.staff_id=md.lecturer_id WHERE module_id=? ";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function viewModuleByLecturer($id) {
		$sql = "SELECT md.module_id, md.module_name, md.module_code, st.staff_id AS lecturer_id, st.firstname, st.lastname, st.telephone, st.email, st.staff_role FROM module md JOIN staff st ON st.staff_id=md.lecturer_id WHERE lecturer_id=?";
		$stmt= $this->conLink->prepare($sql);
		$stmt->execute([$id]);
		return $stmt;
	}

	public function updateModule($id, $name, $code, $lect_id) {
		$sql="UPDATE module SET module_name='$name', module_code='$code', lecturer_id='$lect_id' WHERE module_id='$id' ";
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

	public function checkForTooMuchAssigning($lecturer) {
		$sql = "SELECT COUNT(*) FROM module WHERE lecturer_id='$lecturer' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function checkAssignedModule($code, $lect_id) {
		$sql = "SELECT COUNT(*) FROM module WHERE module_code='$code' AND lecturer_id='$lect_id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countModuleByLecturer($id) {
		$sql = "SELECT COUNT(*) FROM module WHERE lecturer_id='$id' ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countModuleByDept($id) {
		$sql = "SELECT COUNT(*) FROM module WHERE dept_id='$id' ";
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

	/*****************************************
	 * READY-MADE/SIMPLIFIED API FOR SH**
	 * DEVELEPED AT DONNEKT/GADRAWINGZ
	 * COPYRIGHT @DONNEKT 2021 SEPTEMBER
	 * ***************************************/

	public function makeAttendance($status, $student, $lect_id, $module, $academic, $day) {
		$sql= "INSERT INTO `attendance`(`att_status`, `student_id`, `lecturer_id`, `module_id`, `acad_year`, `att_day`) VALUES ('$status', '$student', '$lect_id', '$module', '$academic', '$day')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 
	}

	public function viewAttendanceDetails() {
		$sql= "SELECT * FROM attendance ";
		$stmt=$this->conLink->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function checkForAttRedundance($module, $student, $att_day) {
		$sql = "SELECT COUNT(*) FROM attendance WHERE (module_id='$module' AND student_id='$student' AND att_day='$att_day')";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}

	public function countAttendance() {
		$sql = "SELECT COUNT(*) FROM attendance ";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}



	// Misc
	public function createClassGroup($module_id, $class_id) {
		$sql= "INSERT INTO classign (`module_id`, `class_id`) VALUES ('$module_id', '$class_id')";
		$query= $this->conLink->prepare($sql);
		$query->execute();
		$count= $query->rowCount();
		return $count; 
	}

	public function countClassGroup($module_id, $class_id) {
		$sql= "SELECT COUNT(*) FROM classign WHERE module_id='$module_id' AND class_id='$class_id'";
		$stmt= $this->conLink->query($sql)->fetchColumn();
		return $stmt;
	}


}
?>