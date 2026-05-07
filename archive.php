<?php
$files = glob("entries/*.json");
rsort($files);
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
      <h1>previous days</h1>
    </section>

    <section class="calendar-grid">
      <?php foreach ($files as $file): ?>
        <?php
          $date = basename($file, ".json");
          $entries = json_decode(file_get_contents($file), true);
          $firstPrompt = $entries[0]["prompt"] ?? "Archived prompt";
        ?>

        <a class="calendar-day" href="#day-<?php echo htmlspecialchars($date); ?>">
          <span class="calendar-date"><?php echo htmlspecialchars($date); ?></span>
          <span class="calendar-count"><?php echo count($entries); ?> entries</span>
          <span class="calendar-prompt"><?php echo htmlspecialchars($firstPrompt); ?></span>
        </a>
      <?php endforeach; ?>
    </section>

    <?php foreach ($files as $file): ?>
      <?php
        $date = basename($file, ".json");
        $entries = json_decode(file_get_contents($file), true);
        $firstPrompt = $entries[0]["prompt"] ?? "Archived prompt";
      ?>

      <section class="archive-canvas" id="day-<?php echo htmlspecialchars($date); ?>">
        <p class="eyebrow"><?php echo htmlspecialchars($date); ?></p>
        <h2><?php echo htmlspecialchars($firstPrompt); ?></h2>

        <div class="wall archive-wall">
          <?php foreach ($entries as $entry): ?>
            <article class="note">
              <p class="note-message">
                <?php echo htmlspecialchars($entry["message"]); ?>
              </p>

              <p class="note-meta">
                <?php echo htmlspecialchars($entry["name"] ?: "Anonymous"); ?>

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