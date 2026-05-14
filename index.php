<?php
// pulling in the shared weekly prompt/archive logic
require_once "config.php";

// getting this week’s information
$weekData = getCurrentWeekData($promptChangeDay, $prompts);

// loading this week’s journal file
$journal = loadWeeklyJournal($weekData);

// pulling out the pieces we need for the page
$prompt = $journal["prompt"];
$entries = $journal["entries"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>The Public Journal</title>

  <link rel="stylesheet" href="style.css" />
</head>

<body data-week-key="<?php echo htmlspecialchars($weekData["weekKey"]); ?>">
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
  <p class="eyebrow">this week’s journal prompt is…</p>

  <h1><?php echo htmlspecialchars($prompt); ?></h1>

  <p class="description">
    Write a few words or sentences. No pressure to make it polished.
    This shared page stays open for the week, then becomes part of the archive.
  </p>

  <p class="week-note">
    This prompt is open from 
    <?php echo htmlspecialchars($weekData["weekStart"]); ?> 
    to 
    <?php echo htmlspecialchars($weekData["weekEnd"]); ?>. 
    Come back every Monday for a new prompt.
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