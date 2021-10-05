<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'make':
        $response = array();
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $name = $_POST['module_name'];
            $code = $_POST['module_code'];
            $dept_id = $_POST['dept_id'];
            $lect_id = $_POST['lecturer_id'];

            if($object->checkModuleExistence($code)==0){
                if($name!='' && $code!='' && $dept_id!='' && $lect_id!=''){
                    if($object->registerModule($name, $code, $dept_id, $lect_id)==1) {
                        if($object->checkAssignedModule($code, $lect_id)==0) {
                            $response['success'] = true;
                            $response['message'] = "Module ".$name." is added!";
                            echo json_encode($response);
                        } else {
                            $response['success'] = false;
                            $response['message'] = "Module added (no duplication)!";
                            echo json_encode($response);
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Module can't be saved!";
                        echo json_encode($response);
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Some fields are empty!";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "This module's already in database!";
                echo json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Server error!";
            echo json_encode($response);
        }
        break;





/*        case 'view':
        $response = array();
        if($object->countModules() > 0) {
            $stmt = $object->viewModules();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response["modules"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response['message'] = "No data found!";
            echo json_encode($response);
        }
        break;*/



        // Default shit
        default:
        echo "Invalid operation is called";
    }
}



// Out of Switch case:

/*if(isset($_GET['viewmod'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['viewmod'];
        
        if($object->countModule($id) > 0) {
            $stmt = $object->viewModule($id);
            $row = $stmt->FETCH(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response["module"][] = $row;
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response['message'] = "No data with ".$id." id found!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Server error!";
        echo json_encode($response);
    }
}*/


/*if(isset($_GET['deletemod'])) {
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
}*/


// get me with neat url

/*if(isset($_GET['updatemod'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['updatemod'];
        $name = $_POST['module_name'];
        $code = $_POST['module_code'];
        $dept_id = $_POST['dept_id'];
        $lect_id = $_POST['lecturer_id'];

        if($name!='' && $code!='' && $dept_id!='' && $lect_id!=''){
            if($id!='' && ($object->countModule($id)>0) && $object->checkModuleExistence($code)==0){
                $object->updateModule($id, $name, $code, $dept_id, $lect_id);
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
}*/

?>