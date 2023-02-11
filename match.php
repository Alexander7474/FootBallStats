<!DOCTYPE html>
<html>
<head>
  <title>Simulation Button</title>
<!-- linking the stylesheet(CSS) -->
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php include 'php/navigation.php';?>
    <?php include "php/match_function.php";?>
    <form method="post">
      <input type="submit" name="start_match_day" value="Démarrer jour de match!">
      <input type="submit" name="next_round" value="Prochain round!">
      <input type="submit" name="clear_day" value="Fin de la journée!">
    </form>
    <?php
    if (isset($_POST['start_match_day'])) {
      echo 'starting the day<br>';
      start();
    }
    if (isset($_POST['next_round'])) {
      echo 'starting the next round<br>';
      nextRound();
    }
    if (isset($_POST['clear_day'])){
      echo "clearing the day<br>";
      clearDay();
    }
    ?>
</body>
</html>