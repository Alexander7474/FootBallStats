<?php
    
    include "api.php";
    include "function.php";

    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == "team") {
            $Team_Array = getAllTeams();
            echo "entrer votre recherche<br>";
            echo "Il y a " . sizeof($Team_Array) . " teams";
            foreach ($Team_Array as $j => $name) {
                echo "<li class='joueur'>$name</li>";
            }
        } elseif ($_GET['mode'] == "player") {
            $Player_Array = getAllPlayers();
            echo "entrer votre recherche<br>";
            echo "Il y a " . sizeof($Player_Array) . " joueurs";
            foreach ($Player_Array as $j => $name) {
                echo "<li class='joueur'>$name</li>";
            }
        }
    }
    if (isset($_GET['recherche'])){
        if($_GET['recherche'] != null){
            echoArray(getTeamStat($_GET['recherche']));
            echoArray(getPlayerStat($_GET['recherche']));
        }
    }

?>
