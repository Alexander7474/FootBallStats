<!DOCTYPE html>
<html lang="en">

    <head>
        <?php 
        include "api/api.php";
        include "php/function.php";
        ?>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>FootBall data finder</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
    <h1>Search the Content with Search Bar</h1>
        <div class="top">
            <form method="GET">
                <div class="tableBar">
                    <div class="tableDivision">
                        <input type="text" name="recherche" placeholder="Rechercher" required>
                    </div>
                    <div class="tableDivision" id="myID">
                        <button type="submit">
                            <div id="myCircle"></div>
                            <span></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        if (isset($_GET['recherche'])){
            $result = getAllPlayersInTeam($_GET['recherche']);
            foreach ($result as $playerN => $player){
                echo "$playerN = $player <br>";
            }
        }else{
            echo "entrer votre recherche";
        }
        ?>
    </body>

</html>