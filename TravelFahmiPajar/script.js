const profiles = [
  {
    name: "Ahmad Fahmi Abdillah",
    role: "Developer Front-End, UI Designer",
    bg: "FAHMI",
    img: "fahmi.jpg",
  },
  {
    name: "Rekan Tim Kedua",
    role: "Back-End Developer, DevOps",
    bg: "PAJAR  ",
    img: "raka.jpg",
  },
];

let current = 0;

function renderProfile(index) {
  const profile = profiles[index];
  document.getElementById("name").textContent = profile.name;
  document.getElementById("role").textContent = profile.role;
  document.getElementById("background-name").textContent = profile.bg;
  document.querySelector(".profile-img img").src = profile.img;

  // Re-apply animation
  document.querySelector(".bg-name").style.animation = "none";
  void document.querySelector(".bg-name").offsetWidth; // trigger reflow
  document.querySelector(".bg-name").style.animation =
    "zoomIn 0.8s ease forwards";
}

function nextProfile() {
  current = (current + 1) % profiles.length;
  renderProfile(current);
}

function prevProfile() {
  current = (current - 1 + profiles.length) % profiles.length;
  renderProfile(current);
}
