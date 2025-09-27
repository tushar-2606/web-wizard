// =======================
// login.js
// =======================

// Storage keys
const usersStorageKey = "bms_users";
const sessionStorageKey = "bms_session";

// DOM elements
const loginForm = document.getElementById("loginForm");
const roleSelect = document.getElementById("role");
const emailInput = document.getElementById("email");
const passwordInput = document.getElementById("password");
const loginMessage = document.getElementById("loginMessage");
const goToRegisterLink = document.getElementById("goToRegister");

// Load & Save users
function loadUsers() {
  const data = localStorage.getItem(usersStorageKey);
  return data ? JSON.parse(data) : [];
}

function saveUsers(users) {
  localStorage.setItem(usersStorageKey, JSON.stringify(users));
}

// Show / Hide messages
function showMessage(message, type) {
  loginMessage.textContent = message;
  loginMessage.className = "message " + (type === "error" ? "error" : "success");
  loginMessage.style.display = "block";
  loginMessage.style.opacity = "1";
}

function hideMessage() {
  loginMessage.style.opacity = "0";
  setTimeout(() => {
    loginMessage.style.display = "none";
  }, 300);
}

// =======================
// Init function
// =======================
function init() {
  // Seed admin for testing
  const users = loadUsers();
  if (!users.some(u => u.role === "admin")) {
    users.push({
      name: "Admin",
      email: "admin@example.com",
      password: "admin123",
      role: "admin"
    });
    saveUsers(users);
    console.log("Seed admin created: admin@example.com / admin123");
  }
}

// Call init on page load
init();

// =======================
// Login form submit handler
// =======================
loginForm.addEventListener("submit", function (e) {
  e.preventDefault();
  hideMessage();

  const role = roleSelect.value;
  const email = emailInput.value.trim().toLowerCase();
  const password = passwordInput.value;

  if (!role) {
    showMessage("Please select a role.", "error");
    return;
  }
  if (!email || !password) {
    showMessage("Please fill in all fields.", "error");
    return;
  }

  const users = loadUsers();

  const user = users.find(u => u.email === email && u.role === role);
  if (!user) {
    showMessage("User not found. Please register first.", "error");
    return;
  }

  if (user.password !== password) {
    showMessage("Incorrect password.", "error");
    return;
  }

  // Success → create session
  sessionStorage.setItem(sessionStorageKey, JSON.stringify({ email, role }));
  showMessage("Login successful! Redirecting...", "success");

  setTimeout(() => {
    if (role === "admin") {
      window.location.href = "admin.html";
    } else {
      window.location.href = "student_dashboard.html";
    }
  }, 1200);
});

// Link to registration
goToRegisterLink.addEventListener("click", function () {
  window.location.href = "register.html";
});
