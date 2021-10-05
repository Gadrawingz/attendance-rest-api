<?php   

require_once 'configs/connection.php';  
$response = array();  
  
if(isset($_GET['apicall'])) {
    switch($_GET['apicall']) {

        case 'register':
        if(isTheseParametersAvailable(array('firstname', 'lastname', 'email', 'telephone', 'staff_role', 'password', 'reg_date'))) {

            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $phone = $_POST['telephone'];
            $role = $_POST['staff_role'];
            $password = ($_POST['password']);  
            $reg_date = $_POST['reg_date'];

            $stmt= $conn->prepare("SELECT staff_id FROM staff WHERE telephone = ? OR email = ?");
            $stmt->bind_param("ss", $phone, $email);  
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0){ 
                $response['error'] = true;
                $response['message'] = 'This Staff member\'s already in!';
                $stmt->close();
            }  else {
                $stmt = $conn->prepare("INSERT INTO staff (firstname, lastname, email, telephone, staff_role, password, reg_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssss", $firstname, $lastname, $email, $telephone, $role, $password, $reg_date);

                if($stmt->execute()) {
                    $stmt = $conn->prepare("SELECT staff_id, staff_id, firstname, lastname, email, telephone, staff_role, password, reg_date FROM staff WHERE email = ?");
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $stmt->bind_result($staff_id, $s_id, $firstname, $lastname, $email, $telephone, $staff_role, $password, $reg_date);
                    $stmt->fetch();

                    $staff = array( 
                        'staff_id'=>$s_id,
                        'firstname'=>$username, 
                        'lastname'=>$lastname, 
                        'email'=>$email, 
                        'telephone'=>$telephone, 
                        'staff_role'=>$staff_role, 
                        'password'=>$password, 
                        'reg_date'=>$reg_date, 
                    );

                    $stmt->close();
                    $response['error'] = false; 
                    $response['message'] = 'Staff member is registered!'; 
                    $response['staff'] = $staff; 
                    
                }
            }
        }  else {
            $response['error'] = true;   
            $response['message'] = 'Required parameters are not available';   
        }  

        break;   

        /*case 'login':  
        if(isTheseParametersAvailable(array('username', 'password'))){  
            $username = $_POST['username'];  
            $password = md5($_POST['password']);   
            $stmt = $conn->prepare("SELECT id, username, email, gender FROM users WHERE username = ? AND password = ?");  
            $stmt->bind_param("ss",$username, $password);  
            $stmt->execute();  
            $stmt->store_result();  
            if($stmt->num_rows > 0){  
                $stmt->bind_result($id, $username, $email, $gender);  
                $stmt->fetch();  

                $user = array(  
                    'id'=>$id,   
                    'username'=>$username,   
                    'email'=>$email,  
                    'gender'=>$gender  
                );  

                $response['error'] = false;   
                $response['message'] = 'Login successfull';   
                $response['user'] = $user;   
            }  else {  
                $response['error'] = false;   
                $response['message'] = 'Invalid username or password';  
            }
        }  

        break;   */

        default:   
        $response['error'] = true;   
        $response['message'] = 'Invalid Operation Called';  

    }  
}  else {  
    $response['error'] = true;   
    $response['message'] = 'Invalid API Call';  

}  

echo json_encode($response);  


function isTheseParametersAvailable($params){  
    foreach($params as $param){  
        if(!isset($_POST[$param])){  
            return false;
        }  
    }  
    return true;   
}

?>