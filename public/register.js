async function loadEvents() {
  const res = await fetch('/api/events');
  const events = await res.json();
  const container = document.getElementById('events');
  container.innerHTML = '';
  events.forEach(ev => {
    const col = document.createElement('div');
    col.className = 'col-12 col-md-6';
    const fullness = ev.seats_taken >= ev.capacity ? 'Full' : `${ev.capacity - ev.seats_taken} seats left`;
    col.innerHTML = `
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">${ev.title}</h5>
          <p class="card-text">${ev.description || ''}</p>
          <p class="mb-1"><strong>Capacity:</strong> ${ev.capacity}</p>
          <p class="mb-3"><strong>Status:</strong> ${fullness}</p>
          <button class="btn btn-primary register-btn" data-id="${ev._id}" ${ev.seats_taken >= ev.capacity ? '' : ''}>Register</button>
        </div>
      </div>
    `;
    container.appendChild(col);
  });

  document.querySelectorAll('.register-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      const id = e.target.dataset.id;
      document.getElementById('eventId').value = id;
      document.getElementById('regMsg').innerText = '';
      const modal = new bootstrap.Modal(document.getElementById('regModal'));
      modal.show();
    });
  });
}

document.getElementById('regForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const id = document.getElementById('eventId').value;
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const res = await fetch(`/api/events/${id}/register`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ name, email })
  });
  const data = await res.json();
  const msg = data.message || 'Done';
  document.getElementById('regMsg').innerText = `${msg} (${data.status})`;
  await loadEvents();
});
window.onload = loadEvents;
