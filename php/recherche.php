<?php
    
    include "api.php";
    include "function.php";

    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == "team") {
            $Team_Array = getAllTeams();
            echo "entrer votre recherche<br>";
            echo "Il y a " . sizeof($Team_Array) . " teams<br>";
            foreach ($Team_Array as $j => $name) {
                ?><li id="search" class='search'><?php echoTeamLink($name); ?></li><?php
            }
        } elseif ($_GET['mode'] == "player") {
            $Player_Array = getAllPlayers();
            echo "entrer votre recherche<br>";
            echo "Il y a " . sizeof($Player_Array) . " joueurs<br>";
            foreach ($Player_Array as $j => $name) {
                ?><li id="search" class='search'><?php echoPlayerLink($name); ?></li><?php
            }
        }
    }

?>
