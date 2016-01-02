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
    <li role="presentation" class="active"><a href="rosterf.php">Full UFC Roster</a></li>
    <li role="presentation"><a href="classf.php">Weight Classes</a></li>
    <li role="presentation"><a href="countryf.php">Countries</a></li>
    <li role="presentation"><a href="teamf.php">Fight Teams</a></li>
    <li role="presentation"><a href="addf.php">Add Fighter</a></li>
    <li role="presentation"><a href="searchf.php">Search Fighters</a></li>
  </ul>
</div>

<div id="update_roster"></div>

<?php


$roster = $mysqli->query("SELECT f.id, f.first_name, f.last_name, d.name AS dname, h.name AS hname, t.name AS tname, f.height, f.reach, f.wins, f.losses
                          FROM fighter AS f
                          LEFT JOIN division d ON (f.did = d.id) 
                          LEFT JOIN hometown h ON (f.hid = h.id) 
                          LEFT JOIN team t ON (f.tid = t.id) 
                          ORDER BY f.first_name, f.last_name;");

echo "<div class='col-sm-3 col-sm-offset-1'>";

if($result = $roster) {
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
      echo "<p>", "Division: ", $row['dname'], "</p>", "</ br>";
      echo "<p>", "Team: ", $row['tname'], "</p>", "</ br>";
      echo "<p>", "Hometown: ", $row['hname'], "</p>", "</ br>";
      echo "<p>", "Height: ", $row['height'], " inches", "</p>", "</ br>";
      echo "<p>", "Reach: ", $row['reach'], " inches", "</p>", "</ br>";
      echo "<p>", "Record: ", $row['wins'], "-", $row['losses'], "</p>", "</ br>";

      echo '<form action="rosterf.php" method="POST">
            <button id="deletion" name="deletion" value=' .$row['id']. '>Delete fighter</button>
            </form>';

      $not_fought = $mysqli->query("SELECT f.id, f.first_name, f.last_name
                                    FROM fighter AS f
                                    WHERE f.id NOT IN (SELECT f.id
                                    FROM fighter AS f
                                    LEFT JOIN fought fo ON (f.id = fo.opponent_id) 
                                    WHERE fo.fighter_id='".$row['id']."')
                                    AND f.id<>'".$row['id']."'");


      if($result = $not_fought) {
        if($count = $result->num_rows) {
          $lines = $result->fetch_all(MYSQLI_ASSOC);

          echo "<form method='post' action='rosterf.php' name='content_form' id='content_form'>
          <select name='not_fought' id='not_fought'>";

          foreach($lines as $line) {
            echo '<option value="' .$row['id']. ", " .$line['id']. '">' .$line['first_name']. " " .$line['last_name']. '</option>';
            // echo '<option value="{'arr':"' .$row['id']. "," .$line['id'].  '}">' .$line['first_name']. " " .$line['last_name']. '</option>';
          }

          echo "</select>";
          echo "<button id='opponent' name='opponent' type='submit'>Add to fought list</button>";
          echo "</form>";
        }
      }

      echo "</code></pre>";
    }
  }

  $to_delete = $mysqli->real_escape_string($_POST['deletion']);

  if(isset($_POST['deletion'])) {
    if($_POST['deletion'] == $to_delete) {
      $mysqli->query("DELETE from fighter WHERE id='$to_delete'");
    }
  } 

  $raw_string = $mysqli->real_escape_string($_POST['not_fought']);
//  $refined_string = implode(', ', raw_string);

  $id_array = explode(', ', $raw_string);

  if(isset($_POST['not_fought'])) {
    $mysqli->query("INSERT INTO fought (fighter_id, opponent_id)
                    VALUES ('$id_array[0]', '$id_array[1]')");
  
    $mysqli->query("INSERT INTO fought (fighter_id, opponent_id)
                    VALUES ('$id_array[1]', '$id_array[0]')");
  } 

  $result->free();
  echo "</table>";
}

echo "</div>";

?>

</body>
</html>