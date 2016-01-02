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

<!-- Navigation bar -->
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

<!-- Buttons for each page in the site -->
<div class="col-sm-4 col-sm-offset-1">
  <ul class="nav nav-pills">
    <!-- <li role="presentation" class="active"><a href="#">Home</a></li> -->
    <li role="presentation"><a href="rosterf.php">Full UFC Roster</a></li>
    <li role="presentation"><a href="classf.php">Weight Classes</a></li>
    <li role="presentation"><a href="countryf.php">Countries</a></li>
    <li role="presentation"><a href="teamf.php">Fight Teams</a></li>
    <li role="presentation"><a href="addf.php">Add Fighter</a></li>
    <li role="presentation" class="active"><a href="searchf.php">Search Fighters</a></li>
  </ul>

  <div>
    <form method="post" action="searchf.php" name="content_form" id="content_form">
      <h3>Search by fighter name</h3>
      <fieldset>
        <input type="text" name="search" id="search" size="25" /><br />
        <button id="add" name="add" type="submit">Search</button>
      </fieldset>
    </form>
  </div>
</div>

<div id="full_roster"></div>

<?php

echo "<div class='col-sm-3 col-sm-offset-1'>";

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


$search_input = $mysqli->real_escape_string($_POST['search']);

// Query for searching by user input
$search_query = "SELECT f.id, f.first_name, f.last_name, d.name AS dname, h.name AS hname, t.name AS tname, f.height, f.reach, f.wins, f.losses
                          FROM fighter AS f
                          LEFT JOIN division d ON (f.did = d.id) 
                          LEFT JOIN hometown h ON (f.hid = h.id) 
                          LEFT JOIN team t ON (f.tid = t.id) 
                          WHERE f.first_name LIKE '$search_input'
                          OR f.last_name LIKE '$search_input'";

$search = $mysqli->query($search_query);

if($result = $search) {
  if($count = $result->num_rows) {
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    
    echo "<table border='1'><br />";
    echo "<h3>Fighters</h3>";

    foreach($rows as $row) {
      // Checks if the fighter is a champ
      $check_champ = $mysqli->query("SELECT f.id
                                     FROM fighter AS f
                                     LEFT JOIN division d ON (f.did=d.id)
                                     WHERE d.cid='".$row['id']."'");

      echo "<pre><code>";
      // echo "<p>", $row['id'], "</p>", "</ br>";
      if($check_champ->num_rows > 0) {
          echo "<p>CHAMPION</p></ br>";
      }

      // Prints out each fighter according to the search
      echo "<b>", $row['first_name'], " ", $row['last_name'], "</b>", "</ br>";
      echo "<p>", "Division: ", $row['dname'], "</p>", "</ br>";
      echo "<p>", "Team: ", $row['tname'], "</p>", "</ br>";
      echo "<p>", "Hometown: ", $row['hname'], "</p>", "</ br>";
      echo "<p>", "Height: ", $row['height'], " inches", "</p>", "</ br>";
      echo "<p>", "Reach: ", $row['reach'], " inches", "</p>", "</ br>";
      echo "<p>", "Record: ", $row['wins'], "-", $row['losses'], "</p>", "</ br>";

      // Delete button for each fighter
      echo '<form action="searchf.php" method="POST">
            <button id="deletion" name="deletion" value=' .$row['id']. '>Delete fighter</button>
            </form>';

      // Query for checking who the fighter has already fought
      $fought = $mysqli->query("SELECT f.id, f.first_name, f.last_name
                                FROM fighter AS f
                                LEFT JOIN fought fo ON (f.id = fo.opponent_id) 
                                WHERE fo.fighter_id='".$row['id']."'");

      if($result = $fought) {
        if($count = $result->num_rows) {
          $lines = $result->fetch_all(MYSQLI_ASSOC);

          echo "<p><b>Fought:</b></p>";

          echo "<form method='post' action='rosterf.php' name='content_form' id='content_form'>
          <select name='not_fought' id='not_fought'>";

          // Prints out each opponent of the fighter as a dropdown list
          foreach($lines as $line) {
            echo '<option value="' .$row['id']. ", " .$line['id']. '">' .$line['first_name']. " " .$line['last_name']. '</option>';
            // echo '<option value="{'arr':"' .$row['id']. "," .$line['id'].  '}">' .$line['first_name']. " " .$line['last_name']. '</option>';
          }

          echo "</select>";
          echo "</form>";
        }
      }

      echo "</code></pre>";
    }
  }
}

echo "</div>";

?>

</body>
</html>