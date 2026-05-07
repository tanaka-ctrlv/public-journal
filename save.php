<?php
date_default_timezone_set("America/New_York");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $today = date("Y-m-d");
  $filename = "entries/" . $today . ".json";

  $message = trim($_POST["message"] ?? "");
  $name = trim($_POST["name"] ?? "");
  $age = trim($_POST["age"] ?? "");
  $location = trim($_POST["location"] ?? "");
  $prompt = trim($_POST["prompt"] ?? "");

  if ($message === "") {
    echo json_encode(["success" => false, "error" => "message is empty"]);
    exit;
  }

  $newEntry = [
    "prompt" => $prompt,
    "message" => $message,
    "name" => $name,
    "age" => $age,
    "location" => $location,
    "time" => date("g:i A")
  ];

  if (file_exists($filename)) {
    $entries = json_decode(file_get_contents($filename), true);
  } else {
    $entries = [];
  }

  $entries[] = $newEntry;

  file_put_contents($filename, json_encode($entries, JSON_PRETTY_PRINT));

  echo json_encode(["success" => true, "entry" => $newEntry]);
  exit;
}
?>