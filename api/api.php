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

    //Connection à la db------------remplir les champs-----------------------------------------------------------------//
    $db = dbConnect('localhost','foot_stat','root');
    //-----------------------------------------------------------------------------------------------------------------//

    /**
     * Retourne une requête SELECT prête l'usage
     * 
     * @param   string  $table    Nom de la table
     * @param   array   $columns  colone(s) à récupérer
     * 
     * @return  string  $query    requête final SELECT 
     */
    function querySelectMaker($table,$columns=[]){
        if (empty($columns)){
            $query = "SELECT * FROM $table ";
            return $query;
        } else{
            $query = "SELECT ";
                foreach($columns as $x) {
                    if (array_search($x,$columns)+1 < count($columns)){
                        $query = $query.$x.",";
                    }else{
                        $query = $query.$x;
                    }
                }
            $query = $query." FROM $table ";
            return $query;
        }
    }

    /**
     * Retourne les résultats d'une requête
     * 
     * @param   string  $query      Requête
     * 
     * @return  array   $result     Résultats de la requête
     */
    function resultQuery($query){
        global $db; //recupération de la db en global
        try{
            $q = $db->prepare($query);
            $q->execute();
            $result = $q->fetch();
            return $result;
        }catch(PDOException $e){
            echo $e;
        }
    }

    /**
     * Retourne les stats selon l'ID du joueur renseigné.
     * 
     * @param  int     $playerID   ID du joueur demandé
     * @param  array   $stat       Stat du joueur que la fonction doit renvoyer, laisser vide pour tous envoyer
     * 
     * @return array   $result     Résultat de la requête
     */
    function getPlayerStat($playerID,$stat=[]) {
        $query = querySelectMaker("stat_full",$stat)."WHERE ID = $playerID"; //création de la requête
        return resultQuery($query);
    }

    /**
     * Retourne les stats selon le nom d'une équipe renseigné.
     * 
     * @param  string  $equipe     Nom de l'équipe demandé
     * @param  array   $stat       Stat de l'équipe que la fonction doit renvoyer, laisser vide pour tous envoyer
     * 
     * @return array   $result     Résultat de la requête
     */
    function getTeamStat($equipe,$stat=[]) {
        $query = querySelectMaker("stat_croise",$stat)."WHERE Equipe = '$equipe'"; //création de la requête
        return resultQuery($query);
    }

    $f = getTeamStat("France");
    foreach($f as $x => $t){
        echo "$x = $t <br>";
    }

?>