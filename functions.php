<?php
// Fetching data, putting it in memory, and setting up the variables we need to perform operations on the data.
function process_name ($nameArray, $nameVariable, $nameIndexed, $nameCounter) {
  if (!isset($nameArray[$nameVariable])) {
    $nameArray[$nameVariable] = 1;
    $nameIndexed[] = $nameVariable;
    $nameCounter++;
    return [$nameArray, $nameVariable, $nameIndexed, $nameCounter];
  } else {
    $nameArray[$nameVariable]++;
    return [$nameArray, $nameVariable];
  }
}

function list_names ($echo, $array, $isAssoc) {
  echo '<p>'.$echo.'<ul>';
  $i = 0;
  if ($isAssoc) {
    foreach ($array as $key => $value) {
      echo '<li>'.$key.' with '.$value.' occurrences</li>';
      if (++$i == 10) break;
    }
  } else {
    foreach ($array as $value) {
      echo '<li>'.$value.'</li>';
      if (++$i == 25) break;
    }
  }
  echo '</ul></p>';
}

function name_function ($dataFile) {
  // Setting all the variables we'll need. Mostly arrays and counters.
  $rows = explode("\n", $dataFile);
  $firstNames = array();
  $lastNames = array();
  $fullNames = array();
  $firstNamesIndexed = array();
  $lastNamesIndexed = array();
  $fullNamesIndexed = array();
  $specialityUniqueNames = array();
  $uniqueFirstNames = 0;
  $uniqueLastNames = 0;
  $uniqueFullNames = 0;

  // Combing through the data, only even rows because those are the rows with names on them.
  for ($i = 0; $i < sizeof($rows); $i += 2) {
    // Parses and stores the first, last and full names in our validated data.
    $rowData = explode(',', $rows[$i]);
    $lastName = $rowData[0];
    $firstName = substr($rowData[1], 0, strpos($rowData[1], '--'));
    $fullName = $firstName.' '.$lastName;

    // This fun bit of code validates the names using regular expressions after removing the Lorem Ipsum after the name.
    if (preg_match('/^[A-Z][a-zA-Z\'-]+, [A-Z][a-zA-Z\'-]+/', substr($rows[$i], 0, strpos($rows[$i], '--')))) {
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
  echo '<p><b>The unique count of full names:</b> '.$uniqueFullNames.'</p>';
  echo '<p><b>The unique count of last names:</b> '.$uniqueLastNames.'</p>';
  echo '<p><b>The unique count of first names:</b> '.$uniqueFirstNames.'</p>';

  // Echo the ten most common names, which we counted and sorted earlier.
  list_names("The ten most common last names are", $lastNames, true);

  list_names("The ten most common first names are", $firstNames, true);

  // Echo the names, in the order they appear in the data, that are the first full name to use both the first and last name that makes it up.
  list_names("A list of 25 speciality unique names:", $specialityUniqueNames, false);

  // Echo some random names I made up from the unique first and last names that are otherwise not in the unique first names.
  echo '<p>A list of 25 speciality modified names: <ul>';
  $i = 0;
  while ($i < 25) {
    $seed = $i;
    $testName = $firstNamesIndexed[$seed+1].' '.$lastNamesIndexed[$seed+2];
    if (!isset($fullNames[$testName])) {
      echo '<li>'.$testName.'</li>';
      $i++;
    } else {
      $seed++;
    }
  }
  echo '</ul></p>';
}
