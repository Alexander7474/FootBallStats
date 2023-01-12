<?php
    
    include "api.php";
    include "function.php";

    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == "team") {
            $Team_Array = getAllTeams();
            echo "entrer votre recherche<br>";
            echo "Il y a " . sizeof($Team_Array) . " teams";
            foreach ($Team_Array as $j => $name) {
                echo "<a href='http://127.0.0.1/FootBallStats/teampage.php?team=".urlencode($name)."'><li class='search'>$name</li></a>";;
            }
        } elseif ($_GET['mode'] == "player") {
            $Player_Array = getAllPlayers();
            echo "entrer votre recherche<br>";
            echo "Il y a " . sizeof($Player_Array) . " joueurs";
            foreach ($Player_Array as $j => $name) {
                ?><li class='search'><?php echoPlayerLink($name); ?></li><?php
            }
        }
    }

?>
