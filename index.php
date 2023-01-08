<!DOCTYPE html>
<html lang="en">

    <head>
        <?php include 'api/api.php'; ?>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>FootBall data finder</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>
        <?php $_GET["something"] = ""; ?>
    <h1>Search the Content with Search Bar</h1>
        <div class="top">
            <form method="GET" action="#">
                <div class="tableBar">
                    <div class="tableDivision">
                        <input type="text" name="something" placeholder="Rechercher" required>
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
        $team = getAllPlayerInTeam("France");
        foreach ($team as $x => $r){
            echo "$r = $x <br>";
        }
        ?>
    </body>

</html>