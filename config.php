<?php
// using providence / eastern time as the official time for the project
date_default_timezone_set("America/New_York");

// this is the day the prompt changes
// change this to "Friday" if you decide friday feels better
$promptChangeDay = "Monday";

// list of prompts
// the site will rotate through these weekly
$prompts = [
  "What small thing brought you joy today?",
  "What did you notice that you usually miss?",
  "What made today feel human?",
  "What are you carrying gently today?",
  "Where did your mind wander today?",
  "What gave you a little bit of hope?",
  "What is one small thing you want to remember from today?"
];

// this function figures out the current weekly journal period
function getCurrentWeekData($promptChangeDay, $prompts) {
  // if today is the prompt-change day, the week starts today
  if (date("l") === $promptChangeDay) {
    $weekStartTimestamp = strtotime("today");
  } else {
    // otherwise, find the most recent prompt-change day
    $weekStartTimestamp = strtotime("last " . $promptChangeDay);
  }

  // the weekly journal lasts 7 days
  $weekEndTimestamp = strtotime("+6 days", $weekStartTimestamp);

  // readable start/end dates
  $weekStart = date("Y-m-d", $weekStartTimestamp);
  $weekEnd = date("Y-m-d", $weekEndTimestamp);

  // creating a stable file-friendly week label, like 2026-W19
  $weekKey = date("o", $weekStartTimestamp) . "-W" . date("W", $weekStartTimestamp);

  // using the week timestamp to choose a prompt
  // this keeps the prompt stable for the whole week
  $weeksSince = floor($weekStartTimestamp / 604800);
  $prompt = $prompts[$weeksSince % count($prompts)];

  return [
    "weekKey" => $weekKey,
    "weekStart" => $weekStart,
    "weekEnd" => $weekEnd,
    "prompt" => $prompt
  ];
}

// this turns a week key into a json file path
function getJournalFilename($weekKey) {
  return "entries/" . $weekKey . ".json";
}

// this loads the current week’s journal file if it exists
// otherwise, it creates the structure in memory
function loadWeeklyJournal($weekData) {
  $filename = getJournalFilename($weekData["weekKey"]);

  if (file_exists($filename)) {
    $decoded = json_decode(file_get_contents($filename), true);

    if (is_array($decoded) && isset($decoded["entries"])) {
      return $decoded;
    }
  }

  return [
    "weekKey" => $weekData["weekKey"],
    "weekStart" => $weekData["weekStart"],
    "weekEnd" => $weekData["weekEnd"],
    "prompt" => $weekData["prompt"],
    "entries" => []
  ];
}
?>