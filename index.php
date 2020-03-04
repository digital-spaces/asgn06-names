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
    include("objects.php");
    include('functions.php');

    $dataFile = file_get_contents('names.txt');
    
    $firstNames = new NameType;
    $lastNames = new NameType;
    $fullNames = new NameType;
    $specialityUniqueNames = read_names($dataFile, $firstNames, $lastNames, $fullNames);

    
    // Echo the unique counts of first, last and full names.
    echo '<p><b>The unique count of full names:</b> '.$fullNames->uniqueNames.'</p>';
    echo '<p><b>The unique count of last names:</b> '.$lastNames->uniqueNames.'</p>';
    echo '<p><b>The unique count of first names:</b> '.$firstNames->uniqueNames.'</p>';

    // Echo the ten most common names, which we counted and sorted earlier.
    list_names("The ten most common last names are", $lastNames->getMostCommonNames(), true);

    list_names("The ten most common first names are", $firstNames->getMostCommonNames(), true);

    // Echo the names, in the order they appear in the data, that are the first full name to use both the first and last name that makes it up.
    list_names("A list of 25 speciality unique names:", $specialityUniqueNames, false);

    // Echo some random names I made up from the unique first and last names that are otherwise not in the unique first names array.
    modify_names($firstNames, $lastNames);
  ?>
</body>
</html>