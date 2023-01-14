<!DOCTYPE html>
<html>
      
<head>
    <title>
        FootStat
    </title>
      
    <!-- linking the stylesheet(CSS) -->
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>
  
<body>

    <?php 
    include "php/navigation.php";
    include "php/login_method.php";
    ?>

    <form method="post">
        <input type="text" placeholder="identifiant" name="login" id="register"><br>
        <input type="password" placeholder="mot de passe" name="password" id="register"><br>
        <input type="email" placeholder="email" name="email" id="register"><br>
        <input type="text" placeholder="nom" name="nom" id="register"><br>
        <input type="text" placeholder="prénom" name="prenom" id="register"><br>
        <input type="text" placeholder="date naissance" name="date" id="register"><br>
        <input class="button_under" type="submit" name="buttonregister" id="register" value="Inscription">
    </form>
      
</body>
  
</html>