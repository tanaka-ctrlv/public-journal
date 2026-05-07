<?php
// using providence / eastern time for the site day
date_default_timezone_set("America/New_York");

// telling the browser this file returns json, not html
header("Content-Type: application/json");

// today's date
$today = date("Y-m-d");

// today's file path
$filename = "entries/" . $today . ".json";

// if the file exists, send its contents
if (file_exists($filename)) {
  echo file_get_contents($filename);
} else {
  // otherwise, send an empty json array
  echo json_encode([]);
}
?>