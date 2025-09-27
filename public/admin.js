async function loadEvents() {
  const res = await fetch('/api/events');
  const events = await res.json();
  const sel = document.getElementById('eventSelect');
  sel.innerHTML = events.map(e => `<option value="${e._id}">${e.title} (capacity ${e.capacity})</option>`).join('');
  if (events[0]) loadRegs(events[0]._id);
  sel.onchange = () => loadRegs(sel.value);
}

async function loadRegs(eventId) {
  const res = await fetch(`/admin-api/events/${eventId}/registrations`, {
    headers: {
    }
  });
  if (res.status === 401) {
    const user = prompt('Admin username:');
    const pass = prompt('Admin password:');
    const basic = btoa(`${user}:${pass}`);
    return fetch(`/admin-api/events/${eventId}/registrations`, { headers: { 'Authorization': 'Basic ' + basic } })
      .then(r => r.json())
      .then(data => renderRegs(data, eventId))
      .catch(err => alert('Auth failed'));
  }
  const data = await res.json();
  renderRegs(data, eventId);
}

function renderRegs(data, eventId) {
  const conf = document.getElementById('confirmedList');
  const wait = document.getElementById('waitlist');
  conf.innerHTML = data.confirmed.map(c => `<li class="list-group-item">${c.name} — ${c.email}</li>`).join('') || '<li class="list-group-item">No confirmed</li>';
  wait.innerHTML = data.waitlist.map(w => `<li class="list-group-item">${w.name} — ${w.email}</li>`).join('') || '<li class="list-group-item">No waitlist</li>';
  document.getElementById('promoteBtn').onclick = async () => {
    const user = prompt('Admin username:');
    const pass = prompt('Admin password:');
    const basic = btoa(`${user}:${pass}`);
    const r = await fetch(`/admin-api/events/${eventId}/promote`, {
      method: 'POST',
      headers: { 'Authorization': 'Basic ' + basic }
    });
    const result = await r.json();
    if (r.ok) {
      alert('Promoted: ' + result.promoted.name);
      loadRegs(eventId);
    } else {
      alert('Error: ' + (result.message || 'unknown'));
    }
  };
}

window.onload = loadEvents;
