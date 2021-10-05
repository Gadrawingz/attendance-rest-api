<?php

if($_SERVER['REQUEST_METHOD']=='POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];


    $con = mysqli_connect('localhost', 'id17618255_southapi_user', 'SouthApiDb@21', 'id17618255_southapi_db');

    $sql= "INSERT INTO staffs(firstname, lastname, telephone, email, password, gender) VALUES('$firstname', '$lastname', '$telephone', '$email', '$password', '$gender')";

    if(mysqli_query($con, $sql)) {
        echo "SUCCESS!";
    } else {
        echo "CAN NOT!";
    }
} else {
    echo "error";
}

?>