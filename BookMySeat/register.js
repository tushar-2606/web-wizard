const usersStorageKey = "bms_users";

// DOM elements
const registerForm = document.getElementById("registerForm");
const registerMessage = document.getElementById("registerMessage");
const goToLoginLink = document.getElementById("goToLogin");

// Load & Save users
function loadUsers() {
  const data = localStorage.getItem(usersStorageKey);
  return data ? JSON.parse(data) : [];
}

function saveUsers(users) {
  localStorage.setItem(usersStorageKey, JSON.stringify(users));
}

// Show message helper
function showMessage(message, type) {
  registerMessage.textContent = message;
  registerMessage.className = "message " + (type === "error" ? "error" : "success");
  registerMessage.style.display = "block";
  registerMessage.style.opacity = "1";
}

function hideMessage() {
  registerMessage.style.opacity = "0";
  setTimeout(() => {
    registerMessage.style.display = "none";
  }, 300);
}

// Handle registration
registerForm.addEventListener("submit", function (e) {
  e.preventDefault();
  hideMessage();

  const name = document.getElementById("name").value.trim();
  const email = document.getElementById("email").value.trim().toLowerCase();
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  if (!name || !email || !password || !confirmPassword) {
    showMessage("Please fill in all fields.", "error");
    return;
  }

  if (password !== confirmPassword) {
    showMessage("Passwords do not match.", "error");
    return;
  }

  const users = loadUsers();
  const exists = users.some(u => u.email === email && u.role === "student");

  if (exists) {
    showMessage("This email is already registered as a student.", "error");
    return;
  }

  // Add new student user
  users.push({ name, email, password, role: "student" });
  saveUsers(users);

  showMessage("Registration successful! Redirecting to login...", "success");
  setTimeout(() => {
    window.location.href = "login.html";
  }, 1400);
});

// Go to login
goToLoginLink.addEventListener("click", function () {
  window.location.href = "login.html";
});
