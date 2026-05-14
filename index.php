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

</nav>

<section class="weekly-sticky-note">
  <p> This is a collective journaling community.
    Leave your own small trace from today, and see how others are moving through the week.</p>

  <p class="eyebrow">
    Come back every Monday for a new prompt :)
  </p>

 <!-- <p class="week-note">
    Open from 
    <?php echo htmlspecialchars($weekData["weekStart"]); ?> 
    to 
    <?php echo htmlspecialchars($weekData["weekEnd"]); ?>.
  </p> 
    -->
</section>

 <main>
  <section class="journal-board">
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

    <section class="submit-area">
      <form action="save.php" method="POST" class="note-form is-collapsed" id="noteForm">
  <input type="hidden" name="prompt" value="<?php echo htmlspecialchars($prompt); ?>" />

  <p class="form-eyebrow">this week’s prompt is...</p>

  <h2 class="form-prompt">
    <?php echo htmlspecialchars($prompt); ?>
  </h2>

  <textarea 
    id="messageInput"
    name="message" 
    placeholder="write a few words from today..." 
    required></textarea>

  <div class="form-extra-fields">
    <input type="text" name="name" placeholder="name / nickname (optional)" />

    <div class="small-inputs">
      <input type="text" name="age" placeholder="today i feel like the color..." />
      <input type="text" name="location" placeholder="town/city + country" />
    </div>

    <div class="form-buttons">
      <button type="submit">add to today</button>
      <button type="button" class="secondary-button" id="collapseForm">minimize</button>
    </div>
  </div>
</form>
    </section>
  </section>
</main>

  <script src="script.js"></script>
</body>
</html>