<?php

include "api.php";

if (isset($_POST["buttonregister"])){
    extract($_POST);
    if(!empty($login) && !empty($password) && !empty($email) && !empty($nom) && !empty($prenom) && !empty($date)){
        addUser($login,$password,$email,$nom,$prenom,$date);
    }
}
?>