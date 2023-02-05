<form method="post">
    <input type="text" placeholder="username/email" name="idtf" id="login"><br>
    <input type="password" placeholder="mot de passe" name="password" id="login"><br>
    <input class="button_under" type="submit" name="buttonlogin" id="login" value="Connection">
</form>

<a href="../login.php?page=register_page.php">
    <input class="button" type="submit" value="Pas de compte ?">
    <br>
</a>
<?php

include "api.php";

if (isset($_POST["buttonlogin"])){

    extract($_POST);

    if(!empty($idtf) && !empty($password)){
        if(userExist($idtf)){
            $userdata = userData($idtf);
            $hashpass = sha1($password);
            if ($hashpass == $userdata['mdp']){
                echo "connection réussie";
            }else{
                echo "username/email ou mot de passe incorrect !";
            }
        }else{
            echo "username/email ou mot de passe incorrect !";
        }
    
    }
}
?>