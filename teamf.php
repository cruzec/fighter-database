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
    <li role="presentation"><a href="classf.php">Weight Classes</a></li>
    <li role="presentation"><a href="countryf.php">Countries</a></li>
    <li role="presentation" class="active"><a href="teamf.php">Fight Teams</a></li>
    <li role="presentation"><a href="addf.php">Add Fighter</a></li>
    <li role="presentation"><a href="searchf.php">Search Fighters</a></li>
  </ul>

<div id="update_team"></div>

<?php

$all_teams = $mysqli->query("SELECT t.name
                              FROM team AS t
                              WHERE t.name<>''");

if($result = $all_teams) {
  if($count = $result->num_rows) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    echo "<form method='post' action='teamf.php' name='content_form' id='content_form'>
    <h3>Select by fight team</h3>
    <select name='team' id='team'>";

    echo "<option value=null>Select one</option>";

    foreach($rows as $row) {
      echo '<option value="' .$row['name']. '">' .$row['name']. '</option>';

    }

    echo "</select>";
    echo "<button id='add' name='add' type='submit'>Show fighters</button>";
    echo "</form>";
  }
}

echo "</div>";

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

$check_team = $mysqli->query("SELECT f.id, f.first_name, f.last_name, f.wins, f.losses
                              FROM fighter AS f
                              LEFT JOIN team t ON (f.tid=t.id) 
                              WHERE t.name='".$team."' AND t.name<>'';");

echo "<div class='col-sm-3 col-sm-offset-1'>";

if($check_team->num_rows > 0) {
  if($result = $check_team) {
    if($count = $result->num_rows) {
      $rows = $result->fetch_all(MYSQLI_ASSOC);
      
      echo "<table border='1'><br />";
      echo "<h3>Fighters</h3>";

      foreach($rows as $row) {
        echo "<pre><code>";
        // echo "<p>", $row['id'], "</p>", "</ br>";
        echo "<b>", $row['first_name'], " ", $row['last_name'], "</b>", "</ br>";
        echo "<p>", "Record: ", $row['wins'], "-", $row['losses'], "</p>", "</ br>";
        echo "</code></pre>";
      }
    }

    $result->free();
    echo "</table>";
  }
}

echo "</div>";

?>

</body>
</html>