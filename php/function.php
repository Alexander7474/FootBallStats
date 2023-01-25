<?php

    /**
     * Affiche un tableau donné #fonction de développement
     * 
     * @param  array   $array    Tableau à afficher
     */
    function echoArray($array){
        foreach($array as $a => $r){
            echo "$a = $r <br>";
        }
    }

    /**
     * Affiche des stats
     * 
     * @param  array  $array   Tableau de stats
     */
    function echoStat($array){
        $x = 0;
        foreach($array as $a => $r){
            if ($x%2==0){
                echo "$a = $r <br>";
            }
            $x+=1;
        }
    }

    /**
     * Affiche le nom d'un joueur link sur sa page profil
     * 
     * @param string $name  Nom du joueur
     */
    function echoPlayerLink($name){
        echo "<a id='search' href='http://127.0.0.1/playerpage.php?player=".urlencode($name)."'>$name</a>";
    }

    /**
     * Affiche le nom d'un joueur link sur sa page profil
     * 
     * @param string $name  Nom du joueur
     */
    function echoTeamLink($name){
        echo "<a id='search' href='http://127.0.0.1/teampage.php?team=".urlencode($name)."'>$name</a>";
    }

?>