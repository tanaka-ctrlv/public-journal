<?php
// find all json files inside the entries folder
$files = glob("entries/*.json");

// reverse order so newest dates appear first
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
    <a href="index.php">Today</a>
    <a href="archive.php">Archive</a>
  </nav>

  <main>
    <section class="intro">
      <p class="eyebrow">archive</p>
      <h1>previous days</h1>
    </section>

    <section class="archive-list">
      <?php foreach ($files as $file): ?>
        <?php
          // remove folder and .json from filename
          $date = basename($file, ".json");

          // load entries from this file
          $entries = json_decode(file_get_contents($file), true);
        ?>

        <details class="archive-day">
          <summary>
            <?php echo htmlspecialchars($date); ?> 
            — <?php echo count($entries); ?> entries
          </summary>

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
              </article>
            <?php endforeach; ?>
          </div>
        </details>
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html>