<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'register':
        $response = array();
        if($_SERVER['REQUEST_METHOD']=='POST') {
            $name = $_POST['dept_name'];
            $caption = $_POST['dept_caption'];

            if($object->checkDeptExistence($name)==0){
                if($name!='' && $caption!=''){
                    $object->registerDepartment($name, $caption);
                    $response['success'] = true;
                    $response['message'] = "New department is added!";
                    echo json_encode($response);
                } else {
                    $response['success'] = false;
                    $response['message'] = "Some fields are empty!";
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = "This department exists!";
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
        if($object->countDepartments() > 0) {
            $stmt = $object->viewDepartments();
            while($row = $stmt->FETCH(PDO::FETCH_ASSOC)) {
                $response['success'] = true;
                $response["departments"][] = $row;
            }
            echo json_encode($response);
        } else {
            $response['success'] = false;
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

// get me like this: department/view/2
if(isset($_GET['viewdept'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['viewdept'];
        
        if($object->countDepartment($id) > 0) {
            $stmt = $object->viewDepartment($id);
            $row = $stmt->FETCH(PDO::FETCH_ASSOC);
            $response['success'] = true;
            $response["department"][] = $row;
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
}


// get me like this: department/delete/2
if(isset($_GET['deletedept'])) {
    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['deletedept'];
        
        if($id!='' && ($object->countDepartment($id)>0)){
            $object->deleteDepartment($id);
            $response['success'] = true;
            $response["message"] = "Deleted successfully!";
            echo json_encode($response);
        } else {
            $response['success'] = false;
            $response["message"] = "Failed to delete!";
            echo json_encode($response);
        }
    } else {
        echo "Server error!";
    }
}


// get me like this: department/update/2
if(isset($_GET['updatedept'])) {

    $response = array();
    if($_SERVER['REQUEST_METHOD']) {    
        $id = $_GET['updatedept'];
        $name = $_POST['dept_name'];
        $caption = $_POST['dept_caption'];

        if($name!='' && $caption!=''){
            $object->updateDepartment($id, $name, $caption);
            $response['success'] = true;
            $response["message"] = "Updation is successful";
            echo json_encode($response);
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