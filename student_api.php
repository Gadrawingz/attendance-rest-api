<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'register':
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $fn = $_POST['firstname'];
            $ln = $_POST['lastname'];
            $rg = $_POST['reg_number'];
            $em = $_POST['email'];
            $ph = $_POST['telephone'];
            $gd = $_POST['gender'];
            $ci = $_POST['class_id'];

            if($object->checkStudentExistence($em, $ph, $rg)==0){
                if($fn!='' && $ln!='' && $em!='' && $ph!='' && $gd!='' && $rg!='' && $ci!=''){
                    if($object->registerStudent($fn, $ln, $rg, $em, $ph, $gd, $ci)=='1') {
                        $response['success'] = true;
                        $response['message'] = "Student (".$fn.") is registered!";
                        echo json_encode($response);
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Cannot save student to database!";
                        echo json_encode($response);
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Some fields are empty";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Sorry, (".$fn.") is already registered!";
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
        if($object->countStudents() > 0) {
            $stmt = $object->viewStudents();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response['status'] = "fetched";
                $response["counts"] = $object->countStudents();
                $response["students"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = "0";
            $response["counts"] = $object->countStudents();
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

if(isset($_GET['viewstud'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['viewstud'];
        
        if($object->countStudent($id) > 0) {
            $stmt = $object->viewStudent($id);
            $row = $stmt->FETCH(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response["student"][] = $row;
            $response['status'] = "fetched";
            $response["counts"] = $object->viewStudent($id);
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->viewStudent($id);
            $response['message'] = "No data with ".$id." id found!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Server error!";
        echo json_encode($response);
    }
}


// Student class
if(isset($_GET['studclass'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['studclass'];
        
        if($object->countStudentByClass($id) > 0) {
            $stmt = $object->viewStudentByClass($id);
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response['status'] = "fetched";
                $response["counts"] = $object->countStudentByClass($id);
                $response["studclasses"][] = $row;
            }
            echo json_encode($response);

        } else {
            $response['success'] = false;
            $response["counts"] = $object->countStudentByClass($id);
            $response['message'] = "No data with ".$id." id found!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Server error!";
        echo json_encode($response);
    }
}


if(isset($_GET['deletestud'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['deletestud'];
        
        if($id!='' && ($object->countStudent($id)>0)){
            if($object->deleteStudent($id)==1){
                $object->deleteStudent($id);
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

if(isset($_GET['updatestud'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {
        $id = $_GET['updatestud'];   
        $fn = $_POST['firstname'];
        $ln = $_POST['lastname'];
        $rg = $_POST['reg_number'];
        $em = $_POST['email'];
        $ph = $_POST['telephone'];
        $gd = $_POST['gender'];
        $ci = $_POST['class_id'];

        if($fn!='' && $ln!='' && $em!='' && $ph!='' && $gd!='' && $rg!='' && $ci!=''){
            if($object->checkStudentExistence($em, $ph, $rg)==0){
                $object->updateStudent($id, $fn, $ln, $rg, $em, $ph, $gd, $ci);
                $response['success'] = true;
                $response["message"] = "Updation is successful";
                echo json_encode($response);
            } else {
                $response['success'] = false;
                $response["message"] = "Email, Phone or RegNumber have been used!";
                echo json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response["message"] = "Failed to update!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response["message"] = "Server error!";
        echo json_encode($response);
    }
}

?>