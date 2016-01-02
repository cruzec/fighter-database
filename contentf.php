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
    <li role="presentation"><a href="teamf.php">Fight Teams</a></li>
    <li role="presentation"><a href="addf.php">Add Fighter</a></li>
    <li role="presentation"><a href="searchf.php">Search Fighters</a></li>
  </ul>
</div>

<div id="update_content"></div>

</body>
</html>