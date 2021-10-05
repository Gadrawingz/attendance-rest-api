<?php
include('configs/db.query.php');
$object = new Query;

if(isset($_GET['call'])) {

    switch($_GET['call']){
        
        case 'login':
        if($_SERVER['REQUEST_METHOD']=='POST') {

            $response = array();
            
            $em = $_POST['email'];
            $ps = $_POST['password'];
            $json = array();

            if($object->checkStaffLogin($em, $ps) > 0) {

                $stmt = $object->staffLogin($em, $ps);
                $row = $stmt->FETCH(PDO::FETCH_ASSOC);
                $response['details'][] = $row;
                echo json_encode($response);
                
            } else {
                $response['success'] = "0";
                $response['message'] = "Login failed, Try again!";
                echo json_encode($response);
            }
        } else {
            echo "Server error!";
        }
        break;




        /*case  'login':

        $em = $_POST['email'];
        $ps = $_POST['password'];
        $response = array();

        // Checking if there is no missing field

        if(empty($em) || empty($ps)) {
            $response['success'] = "0";
            $response['message'] = "Some fields are empty, Try again!";
            echo json_encode($response);
            die();
        }

        $staff_details = array(
            'email' => $em,
            'password' => $ps
        );

        // Deal with db @donnekt
        $success = staffLogin($staff_details);

        if(!empty($success)) {
            $response['success'] = "1";
            $response['message'] = "Login successful!";
            $response['details'] = $success;
            echo json_encode($response);
        } else {
            $response['success'] = "0";
            $response['message'] = "Login failed, Try again!";
            echo json_encode($response);
        }

        function staffLogin($staff_details) {

            $pdo = new PDO("mysql:host=localhost'; dbname='id17618255_southapi_db', 'id17618255_southapi_user','SouthApiDb@21'");

            $array = array();
            $sql = "SELECT * FROM staff WHERE email= :email AND password= :password";
            $stmt= $pdo->prepare($sql);
            $stmt->execute($staff_details);
            $array = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt = null;
            return $array;
        }

        break;*/


        // Default shit
        default:
        echo "Invalid operation is called";
    }
}
?>