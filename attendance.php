<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'make':
        $response = array();
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $status = $_POST['att_status'];
            $student = $_POST['student_id'];
            $lect_id = $_POST['lecturer_id'];
            $module = $_POST['module_id'];
            $academic= $_POST['acad_year'];
            $att_day = $_POST['att_day']; 

            if($object->checkForAttRedundance($module, $student, $att_day)==0){
                if($status!='' && $student!='' && $lect_id!='' && $module!='' && $academic!='' && $att_day){
                    if($object->makeAttendance($status, $student, $lect_id, $module, $academic, $att_day)==1) {
                        $response['success'] = true;
                        $response['message'] = "Attendance is successful!";
                        echo json_encode($response);
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Attendance making has failed!";
                        echo json_encode($response);
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Some fields are empty!";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Attendance already done!";
                echo json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Server error!";
            echo json_encode($response);
        }
        break;


        case 'view':
        $response = array();
        if($object->countAttendance() > 0) {
            $stmt = $object->viewAttendanceDetails();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response["counts"] = $object->countAttendance();
                $response["attendance"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = "0";
            $response["counts"] = $object->countAttendance();
            $response['message'] = "No data found!";
            echo json_encode($response);
        }
        break;





        // Default shit
        default:
        echo "Invalid operation is called";
    }
}


// Out of Switch case:


// View modules by lecturer
if(isset($_GET['modlect'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['modlect'];
        
        if($object->countModuleByLecturer($id) > 0) {
            $stmt = $object->viewModuleByLecturer($id);

            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response['status'] = "fetched";
                $response["counts"] = $object->countModuleByLecturer($id);
                $response["modulelects"][] = $row;
            }

            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->countModuleByLecturer($id);
            $response['message'] = "No data with ".$id." id found!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Server error!";
        echo json_encode($response);
    }
}



if(isset($_GET['deletemod'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['deletemod'];
        
        if($id!='' && ($object->countModule($id)>0)){
            if($object->deleteModule($id)==1){
                $object->deleteModule($id);
                $response['success'] = true;
                $response["message"] = "Deleted successfully!";
                echo json_encode($response);
            } else {
                $response['success'] = false;
                $response["message"] = "You cannot delete this record!";
                echo json_encode($response);                
            }
        } else {
            $response['success'] = false;
            $response["message"] = "Failed to delete!";
            echo json_encode($response);
        }
    } else {
        echo "Server error!";
    }
}


// get me with neat url

if(isset($_GET['updatemod'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['updatemod'];
        $name = $_POST['module_name'];
        $code = $_POST['module_code'];
        $lect_id = $_POST['lecturer_id'];

        if($name!='' && $code!='' && $lect_id!=''){
            if($id!='' && ($object->countModule($id)>0) && $object->checkModuleExistence($code)==0){
                $object->updateModule($id, $name, $code, $lect_id);
                $response['success'] = true;
                $response["message"] = "Updation is successful";
                echo json_encode($response);
            } else {
                $response['success'] = false;
                $response["message"] = "Id to update is not found!";
                echo json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response["message"] = "Failed to update!";
            echo json_encode($response);
        }
    } else {
        echo "Server error!";
    }
}

?>