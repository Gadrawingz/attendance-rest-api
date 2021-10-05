<?php

$con = mysqli_connect('localhost', 'root', '', 'attendance_db');
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 //Getting values 
 $username = $_POST['email'];
 $password = $_POST['password'];
 
 //Creating sql query
 $sql = "SELECT * FROM `staff` WHERE email='".$username."' AND password='".$password."'";
 
 //executing query
 $result = mysqli_query($con,$sql);
 
 //fetching result
 $check = mysqli_fetch_array($result);
 
 //if we got some result 
 if(isset($check)){
 //displaying success 
 //echo "success";
  $sqli = "SELECT `staff_id`, `firstname`, `lastname`, `email`, `password` FROM `staff` WHERE email='".$username."' AND password='".$password."'";

   $resulti = mysqli_query($con,$sqli);
   while($row=mysqli_fetch_assoc($resulti)){
     $data=array();
	 $name["success"]=false;
   $data=$name+$row;
      echo json_encode($data);
   }
 }else{
 //displaying failure
 echo "failure";
 }
 mysqli_close($con);

}
?>