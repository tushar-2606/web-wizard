// =======================
// admin.js
// =======================

const sessionStorageKey = "bms_session";
const eventsStorageKey = "bms_events";
const usersStorageKey = "bms_users";

const logoutBtn = document.getElementById("logoutBtn");
const eventsContainer = document.getElementById("eventsContainer");

let session;
let user;
let events = [];

// Load session and validate admin access
function loadSession(){
  const data = sessionStorage.getItem(sessionStorageKey);
  if(!data) {
    window.location.href = "login.html";
    return null;
  }
  return JSON.parse(data);
}

// Load users from localStorage
function loadUsers(){
  const data = localStorage.getItem(usersStorageKey);
  return data ? JSON.parse(data) : [];
}

// Load events or initialize sample events if none exist
function loadEvents(){
  const data = localStorage.getItem(eventsStorageKey);
  if(data) return JSON.parse(data);

  const sampleEvents = [
    {
      id: 1,
      name: "Tech Talk: Future of AI",
      date: "2024-07-15",
      capacity: 3,
      participants: [],
      waitingList: []
    },
    {
      id: 2,
      name: "Workshop: Web Development Basics",
      date: "2024-07-20",
      capacity: 2,
      participants: [],
      waitingList: []
    },
    {
      id: 3,
      name: "Seminar: Cloud Computing",
      date: "2024-07-25",
      capacity: 1,
      participants: [],
      waitingList: []
    }
  ];
  localStorage.setItem(eventsStorageKey, JSON.stringify(sampleEvents));
  return sampleEvents;
}

// Save updated events list
function saveEvents(){
  localStorage.setItem(eventsStorageKey, JSON.stringify(events));
}

// Render event sections with participants and waiting list
function renderEvents(){
  eventsContainer.innerHTML = "";
  if(events.length === 0){
    eventsContainer.innerHTML = '<p>No events found.</p>';
    return;
  }

  events.forEach(event => {
    const section = document.createElement("section");

    const participantsList = event.participants.length > 0
      ? event.participants.map(p => `<li>${p.name} (${p.email})</li>`).join("")
      : "<li><em>No participants registered yet.</em></li>";

    const waitingList = event.waitingList.length > 0
      ? event.waitingList.map(p => `<li>${p.name} (${p.email})</li>`).join("")
      : "<li><em>No one on the waiting list.</em></li>";

    section.innerHTML = `
      <h2 class="subheading">${event.name} — ${event.date}</h2>
      <p><strong>Capacity:</strong> ${event.capacity}</p>

      <div>
        <p class="section-title">Registered Participants (${event.participants.length}):</p>
        <ul>${participantsList}</ul>
      </div>

      <div>
        <p class="section-title">Waiting List (${event.waitingList.length}):</p>
        <ul>${waitingList}</ul>
      </div>
    `;
    eventsContainer.appendChild(section);
  });
}

// Logout handler clears session and redirects
logoutBtn.addEventListener("click", () => {
  sessionStorage.removeItem(sessionStorageKey);
  window.location.href = "login.html";
});

// Initialization function that validates session & loads data
function init(){
  session = loadSession();
  if(!session) return;

  if(session.role !== "admin"){
    window.location.href = "login.html";
    return;
  }

  const users = loadUsers();
  user = users.find(u => u.email === session.email && u.role === "admin");
  if(!user){
    window.location.href = "login.html";
    return;
  }

  events = loadEvents();
  renderEvents();
}

// Call init on page load
init();
