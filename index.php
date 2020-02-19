<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Assignment 06</title>
  <link rel="stylesheet" type="text/css" href="../css/skeleton.css">
</head>
<body>
  <?php
  // Fetching data, putting it in memory, and setting up the variables we need to perform operations on the data.
  $dataFile = file_get_contents('names.txt');
  $rows = explode("\n", $dataFile);
  $firstNames = array();
  $lastNames = array();
  $fullNames = array();
  $firstNamesIndexed = array();
  $lastNamesIndexed = array();
  $specialityUniqueNames = array();
  $uniqueFirstNames = 0;
  $uniqueLastNames = 0;
  $uniqueFullNames = 0;
  
  //Combing through the data, only even rows because those are the rows with names on them.
  for ($i = 0; $i < sizeof($rows); $i += 2) {
    // Parses and stores the first, last and full names in our validated data.
    $rowData = explode(' ', $rows[$i]);
    $lastName = substr($rowData[0],0,-1);
    $firstName = $rowData[1];
    $fullName = $firstName.' '.$lastName;
    
    // This fun bit of code validates the names using regular expressions after removing the Lorem Ipsum after the name.
    if (preg_match('/^[a-zA-Z]+, [a-zA-Z]+/', substr($rows[$i], 0, strpos($rows[$i], '--')))) {
      // If the first or last name haven't been encountered before, add it to the specialty unique names array.
      // This has to be done BEFORE counting the unique first and last names.
      if (!isset($firstNames[$firstName]) or !isset($lastNames[$lastName])) {
        $specialityUniqueNames[] = $fullName;
      }

      // If the first name hasn't been encountered before, increase unique first names counter and add the name to the array.
      // If the first name has been encountered before, increase its usage count.
      if (!isset($firstNames[$firstName])) {
        $firstNames[$firstName] = 1;
        $firstNamesIndexed[] = $firstName;
        $uniqueFirstNames++;
      } else {
        $firstNames[$firstName]++;
      }

      // If the last name hasn't been encountered before, increase unique last names counter and add the name to the array.
      // If the last name has been encountered before, increase its usage count.
      if (!isset($lastNames[$lastName])) {
        $lastNames[$lastName] = 1;
        $lastNamesIndexed[] = $lastName;
        $uniqueLastNames++;
      } else {
        $lastNames[$lastName]++;
      }

      // If the full name hasn't been encountered before, increase unique full names counter and add the name to the array.
      // If the full name has been encountered before, increase its usage count.
      if (!isset($fullNames[$fullName])) {
        $fullNames[$fullName] = 1;
        $uniqueFullNames++;
      } else {
        $fullNames[$fullName]++;
      }
    }    
  }

  // Sort the associative arrays by value, so that we can get the most common names later.
  arsort($lastNames);
  arsort($firstNames);
  
  // Echo the unique counts of first, last and full names.
  echo '<p>The unique count of full names: '.$uniqueFullNames.'</p>';
  echo '<p>The unique count of last names: '.$uniqueLastNames.'</p>';
  echo '<p>The unique count of first names: '.$uniqueFirstNames.'</p>';

  // Echo the ten most common names, which we counted and sorted earlier.
  echo '<p>The ten most common last names are ';
  $i = 0;
  foreach ($lastNames as $key => $value) {
    echo $key.' with '.$value.' occurrences, ';
    if (++$i == 10) break;
  }
  echo '</p>';

  echo '<p>The ten most common first names are ';
  $i = 0;
  foreach ($firstNames as $key => $value) {
    echo $key.' with '.$value.' occurrences, ';
    if (++$i == 10) break;
  }
  echo '</p>';

  // Echo the names, in the order they appear in the data, that are the first full name to use both the first and last name that makes it up.
  echo '<p>A list of 25 speciality unique names: ';
  $i = 0;
  foreach ($specialityUniqueNames as $value) {
    echo $value.', ';
    if (++$i == 25) break;
  }
  echo '</p>';

  // Echo some random names I made up from the unique first and last names that are otherwise not in the unique first names.
  echo '<p>A list of 25 speciality modified names: ';
  $i = 0;
  while ($i < 25) {
    $seed = $i;
    $testName = $firstNamesIndexed[$seed+1].' '.$lastNamesIndexed[$seed+2];
    if (!isset($fullNames[$testName])) {
      echo $testName.', ';
      $i++;
    } else {
      $seed++;
    }
  }
  echo '</p>';
  ?>
</body>
</html>