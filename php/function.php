<?php

    /**
     * Affiche un tableau donné
     * 
     * @param  array   $array    Tableau à afficher
     */
    function echoArray($array){
        foreach($array as $a => $r){
            echo "$a = $r <br>";
        }
    }

?>