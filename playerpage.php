<!DOCTYPE html>
<html>
      
<head>
    <title>
        PlayerStat
    </title>
      
    <!-- linking the stylesheet(CSS) -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php 
    include "php/api.php";
    include "php/function.php";
    ?>
</head>
  
<body>
    <?php
    include "php/navigation.php";
    ?>
    <?php
    if (isset($_GET['player'])){
        try{
            $PlayerStat = getPlayerStat(urldecode($_GET['player']));
            $image = searchImage($PlayerStat['Joueur']." fut card", 5, "google");
            ?>
            <h1>Joueur: <?php echo $PlayerStat['Joueur']; ?>
            <br>
            <img src=<?php echo $image[1]['uri'];?> alt="encrypted-tbn0.gstatic.com"> 
            <br>
            <h2>Stat: <br> <?php echoStat($PlayerStat);?></h2>
            <?php
        }catch(Exception $e){
            echo $e;
        }
    }else{
        echo '<h1>erreur 404 pas de joueur trouvé</h1>';
    }
    ?>
</body>
  
</html>