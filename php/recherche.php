<?php
    
    include "api.php";
    include "function.php";

    $Player_Array = getAllPlayers();

    if (isset($_GET['recherche'])){
        if($_GET['recherche'] != null){
            echoArray(getPlayerStat($_GET['recherche']));
        }
    }else{
        echo "entrer votre recherche<br>";
        $joueurs = getAllPlayers();
        echo "Il y a ".sizeof($joueurs)." joueurs";
        foreach($joueurs as $j => $name){
            echo "<li class='joueur'>$name</li>";
        }
    }
?>
