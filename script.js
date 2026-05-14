// grabbing the form and the wall where notes appear
const form = document.querySelector("#noteForm");
const wall = document.querySelector("#todayWall");

// storing the current week key from the body tag
// php puts this into the html when the page loads
let currentWeekKey = document.body.dataset.weekKey || null;


// this function escapes user text before putting it into html
// important because users can type anything
function escapeHTML(text) {
  return text
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}


// creates one sticky note from one entry object
function createNote(entry) {
  const note = document.createElement("article");
  note.classList.add("note");

  // random rotation so the notes feel more human / less rigid
  const rotation = Math.random() * 8 - 4;

  // random x/y offset for scattered placement
  const x = Math.random() * 60 - 30;
  const y = Math.random() * 50 - 25;

  note.style.setProperty("--rotation", `${rotation}deg`);
  note.style.setProperty("--x", `${x}px`);
  note.style.setProperty("--y", `${y}px`);

  const name = entry.name && entry.name.trim() !== "" ? entry.name : "Anonymous";

  let meta = escapeHTML(name);

  if (entry.age && entry.age.trim() !== "") {
    meta += `, ${escapeHTML(entry.age)}`;
  }

  if (entry.location && entry.location.trim() !== "") {
    meta += `<br />in ${escapeHTML(entry.location)}`;
  }

  note.innerHTML = `
    <p class="note-message">${escapeHTML(entry.message)}</p>
    <p class="note-meta">${meta}</p>
    <p class="note-time">${escapeHTML(entry.time)}</p>
  `;

  return note;
}


// redraws the full wall from an array of entries
function renderWall(entries) {
  if (!wall) return;

  wall.innerHTML = "";

  entries.forEach(entry => {
    wall.appendChild(createNote(entry));
  });
}


// asks php for the latest entries
async function loadEntries() {
  if (!wall) return;

  const response = await fetch("get_entries.php");
  const entries = await response.json();

  renderWall(entries);
}


// intercepting the form submit so the page does not refresh
if (form) {
  form.addEventListener("submit", async function(event) {
    event.preventDefault();

    const formData = new FormData(form);

    const response = await fetch("save.php", {
      method: "POST",
      body: formData
    });

    const result = await response.json();

    if (result.success) {
      form.reset();
      loadEntries();
    }
  });
}


// checks whether providence has moved into a new journal week
async function checkForNewWeek() {
  // if this page does not have a week key, stop here
  if (!currentWeekKey) return;

  // asking php what the current week is
  const response = await fetch("get_status.php");
  const status = await response.json();

  // if the week has changed, fade out and reload
  if (status.weekKey !== currentWeekKey) {
    document.body.classList.add("midnight-reset");

    setTimeout(() => {
      window.location.reload();
    }, 1800);
  }
}


// load entries immediately
loadEntries();

// then check for new notes every 5 seconds
// setInterval(loadEntries, 5000);

// then check for midnight every 30 seconds
setInterval(checkForNewWeek, 30000);