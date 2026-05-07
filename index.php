<?php
// setting the timezone to providence / eastern time
// this means the site day resets according to pvd time
date_default_timezone_set("America/New_York");

// today's date in YYYY-MM-DD format
// this becomes the name of today's json file
$today = date("Y-m-d");

// day number of the year, from 0–365
// we'll use this to rotate through the prompt array
$dayNumber = date("z");

// list of journal prompts
// you can add/edit/remove prompts here
$prompts = [
  "What small thing brought you joy today?",
  "What did you notice that you usually miss?",
  "What made today feel human?",
  "What are you carrying gently today?",
  "Where did your mind wander today?",
  "What gave you a little bit of hope?",
  "What is one small thing you want to remember from today?"
];

// choosing one prompt based on the day of the year
// the % symbol loops through the prompt list without going out of range
$prompt = $prompts[$dayNumber % count($prompts)];

// path to today's entries file
$filename = "entries/" . $today . ".json";

// if today's json file exists, load it
if (file_exists($filename)) {
  $entries = json_decode(file_get_contents($filename), true);
} else {
  // if there is no file yet, start with an empty array
  $entries = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>The Public Journal</title>

  <link rel="stylesheet" href="style.css" />
</head>

<body>
 <nav>
  <a href="index.php" class="logo">The Public Journal</a>

  <div class="nav-links">
    <a href="index.php">Today</a>
    <a href="archive.php">Archive</a>
    <a href="about.php">About</a>
  </div>
</nav>

  <main>
    <section class="intro">
      <p class="eyebrow">today’s journal prompt is…</p>

      <h1><?php echo $prompt; ?></h1>

      <p class="description">
        Write a few words or sentences. No pressure to make it polished.
        At the end of the day, today’s page becomes part of the archive.
      </p>
    </section>

    <section class="submit-area">
      <form action="save.php" method="POST" class="note-form" id="noteForm">
        <!-- sending today’s prompt with the form so it gets saved with each entry -->
        <input type="hidden" name="prompt" value="<?php echo htmlspecialchars($prompt); ?>" />

        <textarea 
          name="message" 
          placeholder="write a few words from today..." 
          required></textarea>

        <input type="text" name="name" placeholder="name / nickname (optional)" />

        <div class="small-inputs">
          <input type="text" name="age" placeholder="age (optional)" />
          <input type="text" name="location" placeholder="location (optional)" />
        </div>

        <button type="submit">add to today</button>
      </form>
    </section>

   <section class="wall" id="todayWall">
  <?php foreach ($entries as $entry): ?>
    <article class="note">
      <p class="note-message">
        <?php echo htmlspecialchars($entry["message"]); ?>
      </p>

      <p class="note-meta">
        <?php echo htmlspecialchars($entry["name"] ?: "Anonymous"); ?>

        <?php if (!empty($entry["age"])): ?>
          , <?php echo htmlspecialchars($entry["age"]); ?>
        <?php endif; ?>

        <?php if (!empty($entry["location"])): ?>
          <br />
          in <?php echo htmlspecialchars($entry["location"]); ?>
        <?php endif; ?>
      </p>

      <p class="note-time">
        <?php echo htmlspecialchars($entry["time"]); ?>
      </p>
    </article>
  <?php endforeach; ?>
</section>
  </main>

  <script src="script.js"></script>
</body>
</html>