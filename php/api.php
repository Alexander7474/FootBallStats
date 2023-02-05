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
        $query = querySelectMaker("table_joueur",$stat); //création de la requête
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
        $query = querySelectMaker("table_equipe",$stat).'WHERE Equipe = "'.$equipe.'"'; //création de la requête
        $result = resultQuery($query);
        return $result[0];
    }

    /**
     * Retourne toutes les teams de la CDM
     * 
     * @return array   $result     Toutes les équipes
     */
    function getAllTeams(){
        $query = querySelectMaker("table_equipe",['Equipe']);
        $result = resultQuery($query);
        return remakeArray($result);
    }

    /**
     * Retourne tout les joueurs de la CDM
     * 
     * @return array   $result     Tout les joueurs
     */
    function getAllPlayers(){
        $query = querySelectMaker("table_joueur",['Joueur']);
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
        $query = querySelectMaker('table_joueur',['Joueur']).'WHERE Equipe = "'.$equipe.'"';
        $result = resultQuery($query);
        return remakeArray($result);
    }

    /**
     * Retourne tous les matchs à jouer
     * 
     * @return array   $result     tableau des matchs à jouer
     */
    function getAllMatchToPlay(){
        $query = querySelectMaker("table_match_non_joue");
        $result = resultQuery($query);
        return $result;
    }

    /**
     * Permet d'ajouter un utilisateur dans la table users
     * 
     * @param   string  $username pseudo de l'utilisateur
     * @param   string  $userPass     mot de pass de l'utilisateur
     * @param   string  $userEmail    email de l'utilisateur
     * @param   string  $name     prénom de l'utilisateur
     * @param   string  $userSurname  nom de l'utilisateur
     * @param   string  $date         date de naissance de l'utlisateur
     */
    function addUser($username,$pass,$email,$name,$surname,$date){
        global $db;
        $pass = sha1($pass);
        $query = "INSERT INTO table_utilisateurs(pseudo, mdp, email, nom, prenom, naissance)
        VALUE(:username, :password, :email, :name, :surname, :birthday)"; 
        try{
            $q = $db->prepare($query);
            $q->execute([
                ':username'=>$username, 
                ':password'=>$pass, 
                ':email'=>$email, 
                ':name'=>$name, 
                ':surname'=>$surname, 
                ':birthday'=>$date
            ]);
        }catch(PDOException $e){
            echo $e;
        }
    }

    /**
     * Retourne les données d'un utilisateur selon un email ou un username
     * 
     * @param string $user   email ou username
     * 
     * @return array
     */
    function userData($user){
        if (!strpos($user, "@")) {
            $query = querySelectMaker("table_utilisateurs") . "WHERE pseudo ='" . $user . "'";
        }else{
            $query = querySelectMaker("table_utilisateurs")."WHERE email ='".$user."'";
        }
        $result = resultQuery($query);
        if (count($result) > 0){
            return $result[0];
        }else{
            return [];
        }
    }

    /**
     * Retourne True si un utilisateur exist et False si non selon un 
     * email ou un username renvoyé
     * 
     * @param string $user   email ou username
     * 
     * @return bool
     */
    function userExist($user){
        $userdata = userData($user);
        if (count($userdata) > 0){
            return True;
        }else{
            return False;
        }
    }

?>