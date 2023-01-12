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
            $PlayerStat = getPlayerStat(urldecode($_GET['player']));
            ?>
            <h1>Joueur: <?php echo $PlayerStat['Joueur']; ?>
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