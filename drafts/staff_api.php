<?php   

require_once 'configs/connection.php';  
$response = array();  
  
if(isset($_GET['apicall'])) {

    switch($_GET['apicall']){

        case 'register':
        if(isTheseParametersAvailable(array('firstname', 'lastname', 'telephone', 'email','password','gender'))) {  
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $telephone = $_POST['telephone'];
            $email = $_POST['email'];
            $password = $_POST['password'];  
            $gender = $_POST['gender'];

            $stmt = $conn->prepare("SELECT id FROM staffs WHERE username = ? OR email = ?");
            $stmt->bind_param("ss", $username, $email);  
            $stmt->execute();
            $stmt->store_result();

            if($stmt->num_rows > 0){ 
                $response['error'] = true;
                $response['message'] = 'Staff member already in!';
                $stmt->close();
            }  else {
                $stmt = $conn->prepare("INSERT INTO staffs (firstname, lastname, telephone, email, password, gender) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssss", $firstname, $lastname, $telephone, $email, $password, $gender);

                if($stmt->execute()) {
                    $stmt = $conn->prepare("SELECT id, id, firstname, lastname, telephone, email, gender FROM staffs WHERE firstname = ?");
                    $stmt->bind_param("s",$firstname);
                    $stmt->execute();
                    $stmt->bind_result($userid, $id, $firstname, $lastname, $telephone, $email, $gender);
                    $stmt->fetch();

                    $user = array( 
                        'id'=>$id,
                        'firstname'=>$firstname, 
                        'lastname'=>$lastname, 
                        'telephone'=>$telephone, 
                        'email'=>$email, 
                        'gender'=>$gender 
                    );

                    $stmt->close();
                    $response['error'] = false; 
                    $response['message'] = 'User registered successfully'; 
                    $response['user'] = $user; 
                }
            }
        }  else {
            $response['error'] = true;   
            $response['message'] = 'required parameters are not available';   
        }  

        break;   

        case 'login':  
        if(isTheseParametersAvailable(array('username', 'password'))){  
            $username = $_POST['username'];  
            $password = md5($_POST['password']);   
            $stmt = $conn->prepare("SELECT id, username, email, gender FROM staffs WHERE username = ? AND password = ?");  
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
                $response['message'] = 'Login successful';   
                $response['user'] = $user;   
            }  else {  
                $response['error'] = false;   
                $response['message'] = 'Invalid username or password';  
            }
        }  

        break;   

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