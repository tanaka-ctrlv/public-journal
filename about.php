<!DOCTYPE html>
<html lang="en">
<head>
  <!-- telling the browser how to read characters/text -->
  <meta charset="UTF-8" />

  <!-- making sure the site scales properly on phones/tablets/etc. -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- title that appears in the browser tab -->
  <title>About — The Public Journal</title>

  <!-- connecting this page to the shared css file -->
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <!-- main navigation for moving between pages -->
  <nav>
  <a href="index.php" class="logo">The Public Journal</a>

  <div class="nav-links">
    <a href="index.php">Today</a>
    <a href="archive.php">Archive</a>
    <a href="about.php">About</a>
  </div>
</nav>

  <main>
    <!-- intro section for the about page -->
    <section class="intro about-page">
      <p class="eyebrow">about the project</p>

      <h1>The Public Journal</h1>

      <p class="description">
        The Public Journal is a shared daily journaling space for short, low-pressure reflections.
        Each day, the site offers one prompt. Visitors can respond with a few words or sentences,
        optionally adding a name, age, and location.
      </p>

      <p class="description">
        The project is motivated by the idea that journaling does not always need to be long,
        private, or perfectly written. Instead, it can be brief, collective, and encouraging.
        Each entry becomes a small trace of how someone moved through the day.
      </p>

      <p class="description">
        At the end of each day (Eastern Time, GMT-5), the current page becomes part of the archive.
        A new day begins with a fresh prompt and a new shared canvas.
      </p>

      <!-- dropdown section for technical info -->
      <!-- details/summary gives us a built-in open-close interaction without extra js -->
      <details class="tech-details">
        <summary>technical information</summary>

        <div class="tech-copy">
          <p>
            This site is built with HTML, CSS, JavaScript, PHP, and JSON.
          </p>

          <p>
            PHP controls the daily prompt, saves entries, and loads archived journal files.
            JSON acts as a lightweight database by storing each day’s entries in a separate file
            inside the <code>entries/</code> folder.
          </p>

          <p>
            JavaScript prevents the form from refreshing the page when someone submits a note.
            It sends the form data to <code>save.php</code>, reloads the latest entries from
            <code>get_entries.php</code>, and redraws the sticky-note wall.
          </p>

          <p>
            The site uses Providence / Eastern Time through:
          </p>

          <pre><code>date_default_timezone_set("America/New_York");</code></pre>

          <p>
            This means the daily reset and archive system follow Providence time.
          </p>
        </div>
      </details>
    </section>
  </main>
</body>
</html>