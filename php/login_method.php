<?php

include "api.php";

if (isset($_POST["buttonregister"])){
    extract($_POST);

    if(!empty($username) && !empty($password) && !empty($email) && !empty($name) && !empty($surname) && !empty($date)){
        addUser($username,$password,$email,$name,$surname,$date);
    }
}
?>