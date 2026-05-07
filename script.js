// grabbing every note on the page
const notes = document.querySelectorAll(".note");

// adding a random rotation to each note
// this makes the wall feel less rigid / more human
notes.forEach(note => {
  const rotation = Math.random() * 6 - 3;
  note.style.setProperty("--rotation", `${rotation}deg`);
});