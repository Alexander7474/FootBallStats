<?php

include "api.php";

if (isset($_POST["buttonregister"])){

    extract($_POST);

    if(!empty($username) && !empty($password) && !empty($email) && !empty($name) && !empty($surname) && !empty($date)){
        
        if(!userExist($username) && !userExist($email)){
            addUser($username,$password,$email,$name,$surname,$date);
        }else{
            echo "Email ou username déjà utilisé existant";
        }
    
    }
}
?>
<form method="post">
    <input type="text" placeholder="nom d'utilisateur" name="username" id="register"><br>
    <input type="password" placeholder="mot de passe" name="password" id="register"><br>
    <input type="email" placeholder="email" name="email" id="register"><br>
    <input type="text" placeholder="prénom" name="name" id="register"><br>
    <input type="text" placeholder="nom" name="surname" id="register"><br>
    <input type="text" placeholder="date naissance" name="date" id="register"><br>
    <input class="button_under" type="submit" name="buttonregister" id="register" value="Inscription">
</form>