<!DOCTYPE html>
<html>
      
<head>
    <title>
        PlayerStat
    </title>
      
    <!-- linking the stylesheet(CSS) -->
    <link rel="stylesheet" type="text/css" href="./style.css">
    <?php 
    include "php/api.php";
    include "php/function.php";
    ?>
</head>
  
<body>
    <?php
    if (isset($_GET['player'])){
        try{
            $PlayerStat = getPlayerStat($_GET['player']);
            echoArray($PlayerStat);
        }catch(Exception $e){
            echo $e;
        }
    }else{
        echo 'erreur 404';
    }
    ?>
</body>
  
</html>