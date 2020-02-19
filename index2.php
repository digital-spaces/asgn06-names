<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assignment 06</title>
  <link rel="stylesheet" type="text/css" href="../css/skeleton.css">
</head>
<body>
  <h3>Mmm, Data</h3>
  <?php
    include('functions.php');
    $dataFile = file_get_contents('names.txt');
    name_function($dataFile);
  ?>
</body>
</html>