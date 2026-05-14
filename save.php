<?php
// pulling in shared timezone, prompt, and weekly archive logic
require_once "config.php";

// telling the browser this file responds with json
header("Content-Type: application/json");

// only continue if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // making sure the entries folder exists
  if (!is_dir("entries")) {
    mkdir("entries", 0777, true);
  }

  // getting the current week
  $weekData = getCurrentWeekData($promptChangeDay, $prompts);

  // loading the journal for this week
  $journal = loadWeeklyJournal($weekData);

  // file path for this week’s archive
  $filename = getJournalFilename($weekData["weekKey"]);

  // collecting form data
  $message = trim($_POST["message"] ?? "");
  $name = trim($_POST["name"] ?? "");
  $age = trim($_POST["age"] ?? "");
  $location = trim($_POST["location"] ?? "");

  // stopping if there is no message
  if ($message === "") {
    echo json_encode(["success" => false, "error" => "message is empty"]);
    exit;
  }

  // creating one new journal entry
  $newEntry = [
    "prompt" => $journal["prompt"],
    "message" => $message,
    "name" => $name,
    "age" => $age,
    "location" => $location,
    "date" => date("Y-m-d"),
    "time" => date("D, M j, g:i A")
  ];

  // adding the new entry to this week’s entries
  $journal["entries"][] = $newEntry;

  // saving the whole weekly journal back into the json file
  file_put_contents($filename, json_encode($journal, JSON_PRETTY_PRINT));

  // sending success back to javascript
  echo json_encode(["success" => true, "entry" => $newEntry]);
  exit;
}
?>