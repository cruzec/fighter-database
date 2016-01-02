<?php 

include "basef.php"; 

?>

<!DOCTYPE html PUBLIC>
<html> 
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CS340 Final Project</title>

        <!-- Bootswatch Flatly CSS template -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
<body> 

<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="contentf.php">UFC</a>
    </div>
  </div>
</div>

<div class="wide">
    <div class="col-xs-5 line"><hr></div>
    <div class="col-xs-2 logo">Logo</div>
    <div class="col-xs-5 line"><hr></div>
</div>

<br><br><br><br><br><br>

<div class="col-sm-4 col-sm-offset-1">
  <ul class="nav nav-pills">
    <!-- <li role="presentation" class="active"><a href="#">Home</a></li> -->
    <li role="presentation"><a href="rosterf.php">Full UFC Roster</a></li>
    <li role="presentation" class="active"><a href="classf.php">Weight Classes</a></li>
    <li role="presentation"><a href="countryf.php">Countries</a></li>
    <li role="presentation"><a href="teamf.php">Fight Teams</a></li>
    <li role="presentation"><a href="addf.php">Add Fighter</a></li>
    <li role="presentation"><a href="searchf.php">Search Fighters</a></li>
  </ul>

  <div>
  <form method="post" action="classf.php" name="content_form" id="content_form">
    <h3>Select by weightclass</h3>
    <select name="weight" id="weight">
          <option value="Select">Select one</option>
          <option value="Strawweight">Strawweight</option>
          <option value="Flyweight">Flyweight</option>
          <option value="Bantamweight">Bantamweight</option>
          <option value="Featherweight">Featherweight</option>
          <option value="Lightweight">Lightweight</option>
          <option value="Welterweight">Welterweight</option>
          <option value="Middleweight">Middleweight</option>
          <option value="Light Heavyweight">Light Heavyweight</option>
          <option value="Heavyweight">Heavyweight</option>
    </select>
    <button id="add" name="add" type="submit">Show fighters</button>
  </form>
  </div>
</div>

<div id="update_class"></div>

<?php

$first_name = $mysqli->real_escape_string($_POST['first_name']);
$last_name = $mysqli->real_escape_string($_POST['last_name']);
$weight = $mysqli->real_escape_string($_POST['weight']);
$wins = $mysqli->real_escape_string($_POST['wins']);
$losses = $mysqli->real_escape_string($_POST['losses']);
$height = $mysqli->real_escape_string($_POST['height']);
$reach = $mysqli->real_escape_string($_POST['reach']);
$team = $mysqli->real_escape_string($_POST['team']);
$hometown = $mysqli->real_escape_string($_POST['hometown']);
$country = $mysqli->real_escape_string($_POST['country']);

$check_class = $mysqli->query("SELECT f.id, f.first_name, f.last_name, f.wins, f.losses
                              FROM fighter AS f
                              LEFT JOIN division d ON (f.did=d.id) 
                              WHERE d.name='".$weight."';");

echo "<div class='col-sm-3 col-sm-offset-1'>";

if($check_class->num_rows > 0) {
  if($result = $check_class) {
    if($count = $result->num_rows) {
      $rows = $result->fetch_all(MYSQLI_ASSOC);
      
      echo "<table border='1'><br />";
      echo "<h3>Fighters</h3>";

      foreach($rows as $row) {

        $check_champ = $mysqli->query("SELECT f.id
                                       FROM fighter AS f
                                       LEFT JOIN division d ON (f.did=d.id)
                                       WHERE d.cid='".$row['id']."'");

        echo "<pre><code>";
        // echo "<p>", $row['id'], "</p>", "</ br>";
        if($check_champ->num_rows > 0) {
          echo "<p>CHAMPION</p></ br>";
        }
        echo "<b>", $row['first_name'], " ", $row['last_name'], "</b>", "</ br>";
        echo "<p>", "Record: ", $row['wins'], "-", $row['losses'], "</p>", "</ br>";
        echo "</code></pre>";
      }
    }

    $result->free();
    echo "</table>";
  }
}

?>

</body>
</html>