<!DOCTYPE html>
<html>
      
<head>
    <title>
        FootStat
    </title>
      
    <!-- linking the stylesheet(CSS) -->
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>
  
<body>

    <?php include "php/navigation.php"; ?>
      
    <!-- input tag -->
    <form action=# method="get">
        <input id="searchbar" onkeyup="search_joueur()" type="text"
            name="recherche" placeholder="Rechercher...">
        <button type="submit">Rechercher</button>
    </form>
    <form method="get">
        <input id="changeMode" type="submit" name="mode" value="team">
        <input id="changeMode" type="submit" name="mode" value="player">
    </form>
      
    <!-- ordered list -->
    <ol id='list'>
        <?php include "php/recherche.php"; ?>
    </ol>
      
    <!-- linking javascript -->
    <script src="js/find.js"></script>
</body>
  
</html>