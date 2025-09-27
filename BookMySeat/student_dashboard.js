const sessionStorageKey = "bms_session";
const eventsStorageKey = "bms_events";
const usersStorageKey = "bms_users";

// Elements
const studentNameDisplay = document.getElementById("studentNameDisplay");
const logoutBtn = document.getElementById("logoutBtn");
const eventsList = document.getElementById("eventsList");

const registrationModal = document.getElementById("registrationModal");
const closeModalBtn = document.getElementById("closeModalBtn");
const confirmRegisterBtn = document.getElementById("confirmRegisterBtn");
const cancelRegisterBtn = document.getElementById("cancelRegisterBtn");
const modalDesc = document.getElementById("modalDesc");
const modalMessage = document.getElementById("modalMessage");

let session = null;
let user = null;
let events = [];
let selectedEvent = null;

// Load session and check authentication
function loadSession() {
  const data = sessionStorage.getItem(sessionStorageKey);
  if (!data) {
    window.location.href = "login.html";
    return null;
  }
  return JSON.parse(data);
}

// Load users from localStorage
function loadUsers() {
  const data = localStorage.getItem(usersStorageKey);
  return data ? JSON.parse(data) : [];
}

// Load events or initialize sample events
function loadEvents() {
  const data = localStorage.getItem(eventsStorageKey);
  if (data) return JSON.parse(data);

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

// Save events to localStorage
function saveEvents() {
  localStorage.setItem(eventsStorageKey, JSON.stringify(events));
}

// Render the event cards list into DOM
function renderEvents() {
  eventsList.innerHTML = '';
  events.forEach(event => {
    const seatsLeft = event.capacity - event.participants.length;
    const isRegistered = event.participants.some(p => p.email === user.email);
    const isWaiting = event.waitingList.some(p => p.email === user.email);

    let statusText = '';
    let disableButton = false;

    if (isRegistered) {
      statusText = '✅ Registered';
      disableButton = true;
    } else if (isWaiting) {
      statusText = '⏳ On Waiting List';
      disableButton = true;
    } else if (seatsLeft <= 0) {
      statusText = '❌ Full - Waiting list open';
    } else {
      statusText = `Seats left: ${seatsLeft}`;
    }

    const eventCard = document.createElement('div');
    eventCard.className = 'event-card';
    eventCard.innerHTML = `
      <h3>${event.name}</h3>
      <p class="event-info"><strong>Date:</strong> ${event.date}</p>
      <p class="event-info">${statusText}</p>
      <button class="register-btn" ${disableButton ? 'disabled' : ''} aria-label="Register for ${event.name}">Register</button>
    `;
    eventsList.appendChild(eventCard);

    const btn = eventCard.querySelector('button.register-btn');
    btn.addEventListener('click', () => {
      selectedEvent = event;
      openModal();
    });
  });
}

// Modal open handler
function openModal() {
  modalDesc.textContent = `Do you want to register for "${selectedEvent.name}" on ${selectedEvent.date}?`;
  modalMessage.style.display = 'none';
  registrationModal.style.display = 'block';
  confirmRegisterBtn.disabled = false;
  confirmRegisterBtn.focus();
}

// Modal close handler
function closeModal() {
  registrationModal.style.display = 'none';
  selectedEvent = null;
  modalMessage.style.display = 'none';
}

// Modal button events to close modal
closeModalBtn.addEventListener('click', closeModal);
cancelRegisterBtn.addEventListener('click', closeModal);
window.addEventListener('click', (e) => { if (e.target === registrationModal) closeModal(); });

// Confirm registration button handler
confirmRegisterBtn.addEventListener('click', () => {
  if (!selectedEvent) {
    modalMessage.textContent = "No event selected!";
    modalMessage.className = "message error";
    modalMessage.style.display = "block";
    return;
  }

  if (selectedEvent.participants.some(p => p.email === user.email)) {
    modalMessage.textContent = "You are already registered for this event.";
    modalMessage.className = "message error";
    modalMessage.style.display = "block";
    return;
  }
  if (selectedEvent.waitingList.some(p => p.email === user.email)) {
    modalMessage.textContent = "You are already on the waiting list.";
    modalMessage.className = "message error";
    modalMessage.style.display = "block";
    return;
  }

  if (selectedEvent.participants.length < selectedEvent.capacity) {
    selectedEvent.participants.push({ name: user.name, email: user.email });
    modalMessage.textContent = "Registration successful! Confirmation email sent (simulated).";
    modalMessage.className = "message success";
  } else {
    selectedEvent.waitingList.push({ name: user.name, email: user.email });
    modalMessage.textContent = "Event is full. You have been added to the waiting list.";
    modalMessage.className = "message error";
  }

  saveEvents();
  renderEvents();

  confirmRegisterBtn.disabled = true;
});

// Logout button handler
logoutBtn.addEventListener('click', () => {
  sessionStorage.removeItem(sessionStorageKey);
  window.location.href = "login.html";
});

// Initialization
function init() {
  session = loadSession();
  if (!session) return;

  if (session.role !== 'student') {
    window.location.href = "login.html";
    return;
  }

  const users = loadUsers();
  user = users.find(u => u.email === session.email && u.role === 'student');
  if (!user) {
    window.location.href = "login.html";
    return;
  }

  studentNameDisplay.textContent = user.name;
  events = loadEvents();
  renderEvents();
}

init();