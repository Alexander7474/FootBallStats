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
    <?php include "php/navigation.php"; ?>
    <?php
    if (isset($_GET['team'])){
        try{
            $team = urldecode($_GET['team']);
            $TeamStat = getTeamStat($team);
            $TeamsCompo = getAllPlayersInTeam($team);
            ?>
            <h1>Equipe: <?php echo $TeamStat['Equipe']; ?>
            <h2>Stat: <br> <?php echoStat($TeamStat);?></h2><br>
            <h2>Joueurs: <br><?php            
            foreach ($TeamsCompo as $j => $name) {
                echoPlayerLink($name);
                ?><br><?php
            }
            ?></h2>
            <?php
        }catch(Exception $e){
            echo $e;
        }
    }else{
        echo "<h1>erreur 404 pas d'equipe trouvé</h1>";
    }
    ?>
</body>
  
</html>