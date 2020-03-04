<?php
class NameType {
  public $associativeNames;
  public $indexedNames;
  public $uniqueNames;
  
  public function getAssociativeNames() {
    return $this->associativeNames;
  }
  public function getIndexedNames() {
    return $this->indexedNames;
  }
  // Sort the associative arrays by value, so that we can get the most common names later.
  public function getMostCommonNames() {
    $array = $this->associativeNames;
    arsort($array);
    return $array;
  }
  public function setNames($name) {
    if (!isset($this->associativeNames[$name])) {
      $this->uniqueNames++;
      $this->indexedNames[] = $name;
      $this->associativeNames[$name] = 1;
    } else {
      $this->associativeNames[$name] += 1;
    }
  }
}
