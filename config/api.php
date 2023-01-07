<?php

    /**
     * Connection à la base de donné
     *
     * @param  string  $host    Host de la db
     * @param  string  $name    Nom de la db   
     * @param  string  $user    User d'acces de la db
     * @param  string  $pass    Password de la db
     * 
     * @return object  $db      Object db pour faire les requêtes vers la db
     */
    function dbConnect($host,$name,$user,$pass=''){

        //données de connection a la db
        define('HOST',$host);
        define('DB_NAME',$name);
        define('USER',$user);
        define('PASS',$pass);

        try{
            $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch(PDOException $e){
            echo $e;
        }
    }

    //Connection à la db
    $db = dbConnect('localhost','foot_stat','root');

    /**
     * Retourne les stats selon l'ID du joueur renseigné.
     * 
     * @param  int     $playerID   ID du joueur demandé
     * @param  array   $stat       Stat du joueur que la fonction doit renvoyer, laisser vide pour tous envoyer
     * 
     * @return array   $result     Résultat de la requête
     */
    function getPlayerStat($playerID,$stat=[]) {
        global $db;//recupération de la db en global
        if (empty($stat)){ //si $stat vide renvoyer toute les stats du joueur
            try{
                $q = $db->prepare("SELECT * FROM stat_full WHERE ID = :ID");
                $q->execute(['ID' => $playerID]);
                $result = $q->fetch();
                return $result;
            } catch(PDOException $e) {
                echo "ID joueur introuvable";
            }
        } else{ //si $stat non vide on créé la requête en fonction des stats demandé
            try{
                $query = "SELECT "; //debut de requête pour ensuite la fabriquer avec les args de $stat
                foreach($stat as $x) {
                    if (array_search($x,$stat)+1 < count($stat)){
                        $query = $query.$x.",";
                    }else{
                        $query = $query.$x; // si de la list d'args pas de virgule
                    }
                }
                $query = $query." FROM stat_full WHERE ID = ".$playerID;
                $q = $db->prepare($query);
                $q->execute();
                $result = $q->fetch();
                return $result;
            } catch(PDOException $e) {
                echo "ID joueur ou stats joueur introuvable";
            }
        }
    }

?>