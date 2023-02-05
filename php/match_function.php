<?php
include "api.php";
include "function.php";

function shuffle_assoc($my_array){
    $keys = array_keys($my_array);
    shuffle($keys);
    foreach($keys as $key) {
        $new[$key] = $my_array[$key];
    }
    $my_array = $new;
    return $my_array;
}

function start(){
    global $db;
    $team = getAllTeams();
    $team_power = []; //creation du tableau power 
    foreach($team as $t => $name){
        $classement = getTeamStat($name,['classement_fifa']);
        $r = 100-$classement['classement_fifa'];
        $power = rand(10,$r);
        $team_power[$name] = $power;
    }
    $team_power = shuffle_assoc($team_power);
    echoArray($team_power);

    $n = [];
    foreach($team_power as $team => $power){
        //--------------------ajout dans la table power---------------
        $query = "INSERT INTO table_match_power(equipe, power) VALUE(:equipe, :power)";
        try{
            $q = $db->prepare($query);
            $q->execute([
                ':equipe'=>$team, 
                ':power'=>$power
            ]);
        }catch(PDOException $e){
            echo $e;
        }
        //---------------------ajout dans la table de match a joue----  
        array_push($n,$team);
        if(count($n) > 1){
            echoArray($n);
            $query = "INSERT INTO table_match_non_joue(equipe1,  equipe2) VALUE(:equipe1, :equipe2)";
            try{
                $q = $db->prepare($query);
                $q->execute([
                    ':equipe1'=>$n[0], 
                    ':equipe2'=>$n[1]
                ]);
            }catch(PDOException $e){
                echo $e;
            }
            $n=[];
        }
    }

}

function clear_match_day(){
    $requete = "DELETE FROM table_match_non_joue; DELETE FROM table_match_power";
    resultQuery($requete); 

}

?>