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
        $re = 100-($classement['classement_fifa']*1.2);
        $rs = $re/1.4;
        $power = rand($rs,$re);
        echo "$name classement=".$classement['classement_fifa']." re=$re rs=$rs power=$power<br>";
        $team_power[$name] = $power;
    }
    $team_power = shuffle_assoc($team_power);
    echo "team power create<br>";

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
    echo "day ready<br>";

}

function next_round(){
    print_r(getAllMatchToPlay());
}

function clearMatch(){
    global $db;
    $query = "DELETE FROM table_match_non_joue";
    try{
        $q = $db->prepare($query);
        $q->execute();
    }catch(PDOException $e){
        echo $e;
    }
    echo "all match played clear<br>";
}

function clearDay(){
    global $db;
    $query = "DELETE FROM table_match_non_joue; DELETE FROM table_match_power; DELETE FROM table_match_joue";
    try{
        $q = $db->prepare($query);
        $q->execute();
    }catch(PDOException $e){
        echo $e;
    }
    echo "day clear<br>";
}

function nextRound(){
    global $db;
    $loosers = [];
    $winners = [];
    $winner = "";
    $looser = "";
    $powers = getTable("table_match_power");
    $npowers = [];
    foreach($powers as $p => $power){
        $npowers[$power[0]] = $power[1];
    }
    $powers = $npowers;
    $matchs = getTable("table_match_non_joue");
    foreach($matchs as $m => $match){
        $score_team_1 = floor(rand(0,$powers[$match["equipe1"]])/15);
        $score_team_2 = floor(rand(0,$powers[$match["equipe2"]])/15);
        if ($score_team_1>$score_team_2){
            $score = strval($score_team_1) . "-" . strval($score_team_2);
            $query = "INSERT INTO table_match_joue(equipe1,  equipe2, score) VALUE(:equipe1, :equipe2, :score)";
            array_push($winners, $match['equipe1']);$winner = $match['equipe1'];
            array_push($loosers, $match['equipe2']);$looser = $match['equipe2'];
        }elseif($score_team_2>$score_team_1){
            $score = strval($score_team_2) . "-" . strval($score_team_1);
            $query = "INSERT INTO table_match_joue(equipe1,  equipe2, score) VALUE(:equipe1, :equipe2, :score)";
            array_push($winners, $match['equipe2']);$winner = $match['equipe2'];
            array_push($loosers, $match['equipe1']);$looser = $match['equipe1'];
        }else{
            $score_team_1+=1;
            $score = strval($score_team_1) . "-" . strval($score_team_2);
            $query = "INSERT INTO table_match_joue(equipe1,  equipe2, score) VALUE(:equipe1, :equipe2, :score)";
            array_push($winners, $match['equipe1']);$winner = $match['equipe1'];
            array_push($loosers, $match['equipe2']);$looser = $match['equipe2'];
        }
        echo "match: ".$match['equipe1']."/".$match['equipe2']."<br>";
        echo "$score_team_1-$score_team_2<br>";
        try{
            $q = $db->prepare($query);
            $q->execute([
                ':equipe1'=>$winner, 
                ':equipe2'=>$looser,
                ':score'=>$score
            ]);
        }catch(PDOException $e){
            echo $e;
        }

    }
    clearMatch();
    echo "all match play<br>";
    $team_add = [];
    foreach($winners as $w => $team){
        array_push($team_add, $team);
        if (count($team_add) > 1) {
            $query = "INSERT INTO table_match_non_joue(equipe1, equipe2) VALUE(:equipe1, :equipe2)";
            try {
                $q = $db->prepare($query);
                $q->execute([
                    ':equipe1' => $team_add[0],
                    ':equipe2' => $team_add[1]
                ]);
            } catch (PDOException $e) {
                echo $e;
            }
            $team_add = [];
        }
    }
    echo "new round ready to play<br>";
    if (count($winners) == 2){echo "finale";}
}

?>