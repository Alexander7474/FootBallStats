<?php
include "db_connect.php";
global $db;

fucntion getPlayerStat($playerID,$stat){
    if ($stat == "*"){
        $q = $db->prepare("SELECT * FROM stat_full WHERE ID = :ID");
        $q->execute(['ID' => $playerID]);
        $result = $q->fetch();
        echo $result;
    }
}