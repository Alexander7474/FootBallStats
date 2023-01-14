<?php

    /**
     * Connection à la base de donné
     *
     * @param  string  $host    Host de la db
     * @param  string  $name    Nom de la db   
     * @param  string  $user    User d'acces de la db
     * @param  string  $pass    Password de la db
     * 
     * @return (object,null)$db Object db pour faire les requêtes vers la db
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

    return null;
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
     * @return  array  $result     Résultats de la requête
     */
    function resultQuery($query){
        global $db; //recupération de la db en global
        try{
            $q = $db->prepare($query);
            $q->execute();
            $result = $q->fetchAll();
            return $result;
        }catch(PDOException $e){
            echo $e;
        }
        return [];
    }

    /**
     * Retourne un tableau propre avec les résultats d'une requête
     * 
     * @param   array    $result     Array de la requête
     * 
     * @return  array    $nArray     Array propre pour l'exploitation
     */
    function remakeArray($result){
        $nArray = [];
        foreach($result as $r => $ar){
            $x = 0;
            foreach ($ar as $t => $c){
                if ($x == 0){array_push($nArray,$c);$x+=1;} //creation du tableau en enlevant les doublons
            }
        }
        return $nArray;
    }

    /**
     * Retourne les stats selon l'ID ou le nom du joueur renseigné.
     * 
     * @param  int     $player     identifiant du joueur demandé
     * @param  array   $stat       Stat du joueur que la fonction doit renvoyer, laisser vide pour tous envoyer
     * 
     * @return array   $result     Résultat de la requête
     */
    function getPlayerStat($player,$stat=[]) {
        $query = querySelectMaker("stat_full",$stat); //création de la requête
        if (gettype($player) == 'integer'){
            $query = $query.'WHERE ID = "'.$player.'"';
        } else{
            $query = $query.'WHERE Joueur = "'.$player.'"';
        }
        $result = resultQuery($query);
        return $result[0];
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
        $query = querySelectMaker("stat_croise",$stat).'WHERE Equipe = "'.$equipe.'"'; //création de la requête
        $result = resultQuery($query);
        return $result[0];
    }

    /**
     * Retourne toutes les teams de la CDM
     * 
     * @return array   $result     Toutes les équipes
     */
    function getAllTeams(){
        $query = querySelectMaker("stat_croise",['Equipe']);
        $result = resultQuery($query);
        return remakeArray($result);
    }

    /**
     * Retourne tout les joueurs de la CDM
     * 
     * @return array   $result     Tout les joueurs
     */
    function getAllPlayers(){
        $query = querySelectMaker("stat_full",['Joueur']);
        $result = resultQuery($query);
        return remakeArray($result);
    }

    /**
     * Retourne tous les joueurs d'une équipe
     * 
     * @param  string  $equipe     Nom de l'équipe demandé
     * 
     * @return array   $result     Tous les joueurs l'équipe demandé
     */
    function getAllPlayersInTeam($equipe){
        $query = querySelectMaker('stat_full',['Joueur']).'WHERE Equipe = "'.$equipe.'"';
        $result = resultQuery($query);
        return remakeArray($result);
    }

    /**
     * 
     */
    function addUser($userNickname,$userPass,$userEmail,$userName,$userSurname,$date){
        global $db;
        $userPass = sha1($userPass);
        $query = 'INSERT INTO UserTable VALUES ("'.$userNickname.'","'.$userPass.'","'.$userEmail.'","'.$userName.'","'.$userSurname.'","'.$date.'")';
        try{
            $q = $db->prepare($query);
            $q->execute();
        }catch(PDOException $e){
            echo $e;
        }
    }

?>