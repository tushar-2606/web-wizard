document.getElementById('registrationForm').addEventListener('submit', function(e) {
    let name = this.name.value.trim();
    let email = this.email.value.trim();
    let phone = this.phone.value.trim();
    let event_id = this.event_id.value;

    if (!name || !email || !phone || !event_id) {
        e.preventDefault();
        displayMessage('Please fill all fields!', 'error');
        return false;
    }

    let phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(phone)) {
        e.preventDefault();
        displayMessage('Enter a valid 10-digit phone number', 'error');
        return false;
    }

    displayMessage('Submitting your registration...', 'success');
});

function displayMessage(msg, type) {
    let messageDiv = document.getElementById('message');
    messageDiv.innerText = msg;
    messageDiv.className = type;
    setTimeout(() => { messageDiv.innerText = ''; messageDiv.className = ''; }, 5000);
}
