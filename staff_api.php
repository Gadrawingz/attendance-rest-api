<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'register':
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $fn = $_POST['firstname'];
            $ln = $_POST['lastname'];
            $em = $_POST['email'];
            $ph = $_POST['telephone'];
            $gd = $_POST['gender'];
            $rl = $_POST['staff_role'];
            $ps = $_POST['password'];

            if($object->checkStaffExistence($em, $ph)==0){
                if($fn!='' && $ln!='' && $em!='' && $ph!='' && $gd!='' && $rl!='' && $ps!=''){
                    $object->registerStaffMember($fn, $ln, $em, $ph, $gd, $rl, $ps);
                    echo "Registration is successful";
                } else {
                    echo "Some fields are empty";
                }
            } else {
                echo "This staff member exists";
            }
        } else {
            echo "Server error!";
        }
        break;




        case 'login':
        if($_SERVER['REQUEST_METHOD']=='POST') {

            $response = array();
            $em = $_POST['email'];
            $ps = $_POST['password'];

            if(!empty($em) || !empty($ps)) {
                if($object->checkStaffLogin($em, $ps) > 0) {
                    $stmt = $object->staffLogin($em, $ps);
                    $row = $stmt->FETCH(PDO::FETCH_ASSOC);
                    $response['success'] = true;
                    $response['status'] = "ok";
                    $response['message'] = "Login successful!";
                    $response['details'][] = $row;
                    echo json_encode($response);
                } else {
                    $response['success'] = false;
                    $response['error'] = true;
                    $response['message'] = "Invalid email or password. Try again!";
                    echo json_encode($response);
                }

            } else {
                $response['success'] = "0";
                $response['message'] = "Some fields are empty, Try again!";
                echo json_encode($response);
                die();
            }
        } else {
            echo "Server error!";
        }
        break;

        




        case 'view':
        $response = array();
        if($object->countStaffMembers() > 0) {
            $stmt = $object->viewStaffMembers();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response['status'] = "fetched";
                $response["counts"] = $object->countStaffMembers();
                $response["staffs"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->countStaffMembers();
            $response['message'] = "No data found!";
            echo json_encode($response);
        }
        break;



        case 'v_lecturers':
        $response = array();
        if($object->countLecturers() > 0) {
            $stmt = $object->viewLecturers();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response['status'] = "fetched";
                $response["counts"] = $object->countLecturers();
                $response["lecturers"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->countLecturers();
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

if(isset($_GET['viewstaff'])) {
    if($_SERVER['REQUEST_METHOD']) {
        $response = array();    
        $staff_id = $_GET['viewstaff'];
        
        if($object->countStaffMember($staff_id) > 0) {
            $stmt = $object->viewStaffMember($staff_id);
            $row = $stmt->FETCH(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response['status'] = "fetched";
            $response["counts"] = $object->countStaffMember($staff_id);
            $response["staff"][] = $row;
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->countStaffMember($staff_id);
            $response['message'] = "No data with ".$staff_id." found!";
            echo json_encode($response);
        }
    } else {
        echo "Server error!";
    }
}



// get me like this: staff/delete/2
if(isset($_GET['deletestaff'])) {
    if($_SERVER['REQUEST_METHOD']) {
        $response = array();    

        $staff_id = $_GET['deletestaff'];
        
        if($staff_id!='' && ($object->countStaffMember($staff_id)>0)){
            $object->deleteStaffMember($staff_id);
            $response['success'] = "1";
            $response["message"] = "Deleted successfully!";
            echo json_encode($response);
        } else {
            $response['success'] = "0";
            $response["message"] = "Failed to delete!";
            echo json_encode($response);
        }
    } else {
        echo "Server error!";
    }
}


// get me like this: staff/update/2
if(isset($_GET['updatestaff'])) {
    if($_SERVER['REQUEST_METHOD']) {
        $response = array();    

        $staff_id = $_GET['updatestaff'];
        $fn = $_POST['firstname'];
        $ln = $_POST['lastname'];
        $em = $_POST['email'];
        $ph = $_POST['telephone'];
        $gd = $_POST['gender'];
        $rl = $_POST['staff_role'];
        $ps = $_POST['password'];

        if($fn!='' && $ln!='' && $em!='' && $ph!='' && $gd!='' && $rl!='' && $ps!=''){
            $object->updateStaffMember($staff_id, $fn, $ln, $em, $ph, $gd, $rl, $ps);
            $response['success'] = "1";
            $response["message"] = "Updation is successful";
            echo json_encode($response);
        } else {
            $response['success'] = "0";
            $response["message"] = "Failed to update!";
            echo json_encode($response);
        }
    } else {
        echo "Server error!";
    }
}

?>