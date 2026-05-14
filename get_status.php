//This lets JavaScript check whether a new week has started
<?php
// pulling in shared weekly logic
require_once "config.php";

// this file returns json, not html
header("Content-Type: application/json");

// getting the current week
$weekData = getCurrentWeekData($promptChangeDay, $prompts);

// sending week info back to javascript
echo json_encode($weekData);
?>