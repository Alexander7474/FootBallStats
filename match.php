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
    <?php
    if (isset($_POST['start_match_day'])) {
      echo 'starting the day<br>';
      start();
    }
    ?>
    <form method="post">
      <input type="submit" name="start_match_day" value="Démarrer jour de match!">
    </form>
</body>
</html>