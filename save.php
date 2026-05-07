<?php
// providence timezone again
date_default_timezone_set("America/New_York");

// only run this if the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // today’s date decides which file to save into
  $today = date("Y-m-d");

  // file path for today’s entries
  $filename = "entries/" . $today . ".json";

  // collect submitted form data
  // trim() removes accidental spaces before/after text
  $message = trim($_POST["message"] ?? "");
  $name = trim($_POST["name"] ?? "");
  $age = trim($_POST["age"] ?? "");
  $location = trim($_POST["location"] ?? "");
  $prompt = trim($_POST["prompt"] ?? "");

  // if the message is empty, stop and go back
  if ($message === "") {
    header("Location: index.php");
    exit;
  }

  // create one new entry as an associative array
  // this will become one object inside the json file
  $newEntry = [
    "prompt" => $prompt,
    "message" => $message,
    "name" => $name,
    "age" => $age,
    "location" => $location,
    "time" => date("g:i A")
  ];

  // load existing entries if the file already exists
  if (file_exists($filename)) {
    $entries = json_decode(file_get_contents($filename), true);
  } else {
    $entries = [];
  }

  // add the new entry to the array
  $entries[] = $newEntry;

  // save the full array back into the json file
  // JSON_PRETTY_PRINT makes it easier for you to read
  file_put_contents($filename, json_encode($entries, JSON_PRETTY_PRINT));

  // send user back to today’s page after saving
  header("Location: index.php");
  exit;
}
?>