<?php
class Simulation{
    public $inGameTeam=[];
    public $winner=[];
    public $loser=[];
    public $round = 0;

    function __construct($team){
        $this->inGameTeam = $team;
    }

    /**
     * Vérifie les conditions de victoire
     */
    function checkWin(){
        if(count($this->winner) < 2){
            return True;
        }else{
            $this->inGameTeam = $this->winner;
            $this->winner = [];
            return False;
        }
    }

    /**
     * alloue une puissance aléatoire au team
     */
    function allocPower(){
        for($i=0;$i<=count($this->inGameTeam);$i++){
            $this->inGameTeam[$i] = [$this->inGameTeam[$i],rand(10,100)];
        }
    }

    /**
     * Permet de passer au round suivant en determinant l'issue de tous les matchs du round actuelle
     */
    function nextRound(){
        $inMatchTeam = [];
        foreach($this->inGameTeam as $game => $team){
            array_push($inMatchTeam,$team);
            if(count($inMatchTeam) > 1){
                $round1Score = [rand(0,$inMatchTeam[0][1]),rand(0,$inMatchTeam[1][1])];
                $round2Score = [rand(0,$inMatchTeam[0][1]),rand(0,$inMatchTeam[1][1])];
                if($round1Score[0]+$round2Score[0] > $round1Score[1]+$round2Score[1]){
                    array_push($this->winner,$inMatchTeam[0]);
                    array_push($this->loser,$inMatchTeam[1]);
                }elseif($round1Score[0]+$round2Score[0] > $round1Score[1]+$round2Score[1]){
                    array_push($this->winner,$inMatchTeam[1]);
                    array_push($this->loser,$inMatchTeam[0]);
                }else{
                    array_push($this->winner,$inMatchTeam[1]);
                    array_push($this->loser,$inMatchTeam[0]);
                }
                $inMatchTeam = [];
            }
        }

        $this->round+=1;
        if($this->checkWin()){
            echo 'il y a un gagant !';
        }else{
            echo 'passer au round suivant';
        }
    }

}

?>