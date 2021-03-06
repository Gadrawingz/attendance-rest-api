<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'register':
        $response = array();
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $name = $_POST['class_name'];
            $level = $_POST['class_level'];
            $dept_id = $_POST['dept_id'];

            if($object->checkClassExistence($name)==0){
                if($name!='' && $level!='' && $dept_id!=''){
                    if($object->registerClassroom($name, $level, $dept_id)==1) {
                        $response['success'] = true;
                         $response['status'] = "ok";
                        $response['message'] = "New classroom is added!";
                        echo json_encode($response);
                    } else {
                        $response['success'] = false;
                         $response['status'] = "no";
                        $response['message'] = "Class can't be saved!";
                        echo json_encode($response);
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Some fields are empty!";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "This classroom exists!";
                echo json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Server error!";
            echo json_encode($response);
        }
        break;





        case 'mkgroup':
        $response = array();
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $module_id= $_POST['module_id'];
            $class_id =  $_POST['class_id'];

            if($object->countClassGroup($module_id, $class_id)==0){
                if($module_id!='' && $class_id!=''){
                    if($object->createClassGroup($module_id, $class_id)==1) {
                        $response['success'] = true;
                        $response['status'] = "ok";
                        $response['message'] = "New row is added!";
                        echo json_encode($response);
                    } else {
                        $response['success'] = false;
                         $response['status'] = "no";
                        $response['message'] = "Data can't be saved!";
                        echo json_encode($response);
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = "Some fields are empty!";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "Data does exist!";
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
        if($object->countClassrooms() > 0) {
            $stmt = $object->viewClassrooms();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response["counts"] = $object->countClassrooms();
                $response["classrooms"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response['status'] = "fetched";
            $response["counts"] = $object->countClassrooms();
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

if(isset($_GET['viewclass'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['viewclass'];
        
        if($object->countClassGroup($id) > 0) {
            $stmt = $object->viewClassGroup($id);
            $row = $stmt->FETCH(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response['status'] = "fetched";
            $response["counts"] = $object->countClassGroup($id);
            $response["classroom"][] = $row;
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->countClassGroup($id);
            $response['message'] = "No data with ".$id." id found!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Server error!";
        echo json_encode($response);
    }
}


/*if(isset($_GET['classbymod'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['classbymod'];
        
        if($object->countClassGroup($id) > 0) {
            $stmt = $object->createClassGroup($id);
            $row = $stmt->FETCH(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response['status'] = "fetched";
            $response["counts"] = $object->countClassGroup($id);
            $response["module"][] = $row;
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["counts"] = $object->countClassGroup($id);
            $response['message'] = "No data with ".$id." id found!";
            echo json_encode($response);
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Server error!";
        echo json_encode($response);
    }
}*/



if(isset($_GET['deleteclass'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['deleteclass'];
        
        if($id!='' && ($object->countClassroom($id)>0)){
            if($object->deleteClassroom($id)==1){
                $object->deleteClassroom($id);
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

if(isset($_GET['updateclass'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['updateclass'];
        $name = $_POST['class_name'];
        $level = $_POST['class_level'];
        $dept_id = $_POST['dept_id'];

        if($name!='' && $level!='' && $dept_id!=''){
            if($id!='' && ($object->countClassroom($id)>0) && $object->checkClassExistence($name)==0){
                $object->updateClassroom($id, $name, $level, $dept_id);
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