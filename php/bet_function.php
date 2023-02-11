<?php

include "api.php";
include "function.php";

function showCoast(){
    $power = getTable("table_match_power");
    if(count($power) < 1){
        echo "Pas d'équipe à parier";
    }else{
        foreach($power as $p => $team){
            echoArray($team);
        }
    }
}
showCoast();
?>