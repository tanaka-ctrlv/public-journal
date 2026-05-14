<?php
// finding all saved weekly journal files
$files = glob("entries/*.json");

// newest weeks first
rsort($files);

// this will hold all the weekly journal data
$journals = [];

foreach ($files as $file) {
  $data = json_decode(file_get_contents($file), true);

  // only include files that use the weekly journal structure
  if (is_array($data) && isset($data["entries"])) {
    $journals[] = $data;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Archive — The Public Journal</title>

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
      <p class="eyebrow">archive</p>
      <h1>previous weeks</h1>

      <p class="description">
        Each archived page holds one week of responses to a shared prompt.
      </p>
    </section>

    <section class="calendar-grid">
      <?php foreach ($journals as $journal): ?>
        <a class="calendar-day" href="#week-<?php echo htmlspecialchars($journal["weekKey"]); ?>">
          <span class="calendar-date">
            <?php echo htmlspecialchars($journal["weekStart"]); ?> 
            – 
            <?php echo htmlspecialchars($journal["weekEnd"]); ?>
          </span>

          <span class="calendar-count">
            <?php echo count($journal["entries"]); ?> entries
          </span>

          <span class="calendar-prompt">
            <?php echo htmlspecialchars($journal["prompt"]); ?>
          </span>
        </a>
      <?php endforeach; ?>
    </section>

    <?php foreach ($journals as $journal): ?>
      <section class="archive-canvas" id="week-<?php echo htmlspecialchars($journal["weekKey"]); ?>">
        <p class="eyebrow">
          <?php echo htmlspecialchars($journal["weekStart"]); ?> 
          – 
          <?php echo htmlspecialchars($journal["weekEnd"]); ?>
        </p>

        <h2><?php echo htmlspecialchars($journal["prompt"]); ?></h2>

        <div class="wall archive-wall">
          <?php foreach ($journal["entries"] as $entry): ?>
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
        </div>
      </section>
    <?php endforeach; ?>
  </main>

  <script src="script.js"></script>
</body>
</html>