<?php
if (!defined('ABSPATH')) { exit; }
?>

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iterative Programme Builder</title>
<style>
:root{--primary:#2e7d32;--primary-hover:#1b5e20;--bg:#f8f9fa;--text:#212529;--card-bg:#fff;--border:#dee2e6;--warning:#f57c00;--muted:#6c757d}
*{box-sizing:border-box}body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:var(--bg);color:var(--text);margin:0;padding:20px}.container{max-width:950px;margin:0 auto}header{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;border-bottom:2px solid var(--border);padding-bottom:15px}h1{color:var(--primary);margin:0}.header-actions{display:flex;gap:8px}.btn{background:var(--primary);color:#fff;border:0;padding:10px 16px;border-radius:4px;cursor:pointer;font-weight:600;font-size:.95em;display:inline-flex;align-items:center;gap:6px}.btn:hover{background:var(--primary-hover)}.btn-secondary{background:#6c757d}.btn-secondary:hover{background:#5a6268}.btn-danger{background:#dc3545}.btn-danger:hover{background:#bd2130}.btn-link{background:transparent;color:var(--muted);border:1px solid var(--border);padding:6px 10px}.btn-link:hover{background:#f3f4f5}.cbmw-programme-builder .filter-section{background:var(--card-bg);border:1px solid var(--border);border-radius:6px;padding:20px;margin-bottom:18px;box-shadow:0 2px 4px rgba(0,0,0,.05)}
.cbmw-programme-builder .filter-title{font-weight:600;color:var(--primary);margin:0 0 15px}
.cbmw-programme-builder .filter-controls{display:grid!important;grid-template-columns:minmax(0,1fr) minmax(0,1fr) minmax(0,1.35fr) minmax(0,1.15fr) auto auto!important;gap:12px!important;align-items:end!important;width:100%!important}
.cbmw-programme-builder .filter-group{display:flex!important;flex-direction:column!important;gap:5px!important;min-width:0!important;width:auto!important;margin:0!important;padding:0!important}
.cbmw-programme-builder .filter-group label{display:block!important;font-size:.85em!important;font-weight:600!important;color:#6c757d!important;line-height:1.2!important;margin:0!important;padding:0!important}
.cbmw-programme-builder .field-with-clear{display:grid!important;grid-template-columns:minmax(0,1fr) auto!important;gap:8px!important;align-items:center!important;width:100%!important}
.cbmw-programme-builder .field-with-clear input{display:block!important;width:100%!important;min-width:0!important;max-width:none!important;margin:0!important}
.cbmw-programme-builder .field-with-clear button{width:auto!important;min-width:0!important;max-width:none!important;margin:0!important}
.cbmw-programme-builder .filter-group select{display:block!important;width:100%!important;min-width:0!important;max-width:none!important;margin:0!important}
.cbmw-programme-builder .filter-controls>.btn{width:auto!important;min-width:145px!important;justify-content:center!important;white-space:nowrap!important;margin:0!important}
.cbmw-programme-builder .filter-controls input,
.cbmw-programme-builder .filter-controls select{box-sizing:border-box!important;padding:8px 12px!important;border:1px solid var(--border)!important;border-radius:4px!important;font-family:inherit!important;font-size:.95em!important;height:38px!important}
.cbmw-programme-builder .filter-controls .btn-link{height:38px!important;padding:8px 10px!important;line-height:20px!important}
.summary-card{background:#edf7ee;border:1px solid #cfe8d5;border-radius:6px;padding:16px;margin-bottom:18px}.summary-title{font-weight:700;color:var(--primary);margin:0 0 8px}.summary-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px}.summary-item{background:#fff;border:1px solid #d7eadb;border-radius:4px;padding:10px}.summary-label{font-size:.75em;color:var(--muted);text-transform:uppercase;letter-spacing:.04em}.summary-value{font-size:1rem;font-weight:700;margin-top:4px;color:#1f2d1f}.schedule-list{display:flex;flex-direction:column;gap:20px}.schedule-item{background:var(--card-bg);border-left:6px solid var(--primary);border-radius:6px;padding:24px;box-shadow:0 4px 6px rgba(0,0,0,.05);display:grid;grid-template-columns:160px 1fr;gap:20px;position:relative}.schedule-item.is-modified{border-left-color:var(--warning)}.schedule-item.is-editing{box-shadow:0 0 0 3px rgba(46,125,50,.4)}.walk-date{font-weight:bold;color:#495057;font-size:1.1em}.walk-time{font-size:.9em;color:#6c757d;margin-top:5px}.walk-title{font-size:1.35em;font-weight:700;margin:0 0 10px;color:var(--primary)}.schedule-item.is-modified .walk-title{color:#c60}.walk-meta{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:10px;font-size:.9em;color:#495057;margin-bottom:12px}.meta-tag{background:#e8f5e9;padding:2px 6px;border-radius:4px;font-weight:500;display:inline-block}.schedule-item.is-modified .meta-tag{background:#fff3e0}.walk-desc{font-size:.95em;line-height:1.6;color:#555;margin:0 0 12px 0}.walk-directions{background:#f1f3f5;border-radius:4px;padding:12px;font-size:.85em;color:#495057;border-left:3px solid #6c757d;margin-top:10px}.badge{font-size:.7em;padding:3px 8px;border-radius:12px;font-weight:600;margin-left:10px;display:inline-block}.badge-modified{background:#fff3cd;color:#856404;border:1px solid #ffeeba}.card-actions{position:absolute;top:20px;right:20px}.edit-form{display:flex;flex-direction:column;gap:12px}.form-group{display:flex;flex-direction:column;gap:5px}.form-group label{font-size:.85em;font-weight:600;color:#6c757d}.form-row{display:grid;grid-template-columns:1fr 1fr;gap:15px}.edit-buttons{display:flex;gap:10px;margin-top:5px}.empty-state{text-align:center;padding:40px 20px;color:#6c757d}.print-only{display:none}@media(max-width:760px){header{display:block}.header-actions{margin-top:15px;flex-wrap:wrap}.filter-controls{grid-template-columns:1fr}.schedule-item{grid-template-columns:1fr;gap:15px;padding-top:50px}.card-actions{top:15px;right:15px}.form-row{grid-template-columns:1fr}.field-with-clear{display:flex}.btn-link{padding:8px 10px}}@media print{body{background:#fff;padding:0}.header-actions,.filter-section,.card-actions,.btn-link{display:none!important}.container{max-width:none}.summary-card{border:none;background:#fff;padding:0;margin-bottom:12px}.schedule-item{break-inside:avoid;box-shadow:none;border-left:4px solid var(--primary);margin-bottom:12px}.print-only{display:none}.print-summary{font-size:16px;font-weight:700;color:#1f2d1f;margin-bottom:10px}} 
</style>
</head>
<body>
<div class="container cbmw-programme-builder">
<header>
<div>
<h1>🗺️ CBMW Programme Builder</h1>
<p style="color:#6c757d;margin:5px 0">Create, filter, and export a programme for the dates you need.</p>
<div id="print-summary" class="print-only"></div>
</div>
<div class="header-actions">
<button class="btn" onclick="exportCSV()">📊 Export CSV</button>
<button class="btn" onclick="exportData()">💾 Export JSON</button>
<button class="btn" onclick="exportPDF()">🖨️ Export PDF</button>
</div>
</header>

<section class="filter-section">
<div class="filter-title">📅 Programme filters</div>
<div class="filter-controls">
<div class="filter-group">
<label for="filter-from">From date</label>
<div class="field-with-clear">
<input type="date" id="filter-from">
<button class="btn btn-link" type="button" onclick="clearDateField('filter-from')">Clear</button>
</div>
</div>

<div class="filter-group">
<label for="filter-to">To date</label>
<div class="field-with-clear">
<input type="date" id="filter-to">
<button class="btn btn-link" type="button" onclick="clearDateField('filter-to')">Clear</button>
</div>
</div>

<div class="filter-group">
<label for="walk-search">Walk search</label>
<div class="field-with-clear">
<input type="text" id="walk-search" placeholder="Search walk name" oninput="refreshWalkOptions()">
<button class="btn btn-link" type="button" onclick="clearWalkSearch()">Clear</button>
</div>
</div>

<div class="filter-group">
<label for="walk-filter">Walk</label>
<select id="walk-filter" onchange="setActiveWalk(this.value)">
<option value="all">All walks</option>
</select>
</div>

<button class="btn" onclick="createProgramme()">Create Programme</button>
<button class="btn btn-secondary" onclick="clearAllFilters()">Reset All</button>
</div>
<div class="filter-info" id="filter-info">Loading programme database from Firebase...</div>
</section>

<section id="programme-summary" class="summary-card" aria-live="polite"></section>

<div id="schedule" class="schedule-list"></div>
</div>

<!-- Firebase Modular App Scripts Setup -->
<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-app.js";
import { getDatabase, ref, get } from "https://www.gstatic.com/firebasejs/9.23.0/firebase-database.js";

// Database 1: Calendar/Bookings App Connection Configuration
const firebaseConfigCalendar = {
  apiKey: "AIzaSyC0hEmdWHSlBkdnxrQiNt_RITYsbj3wvi0",
  authDomain: "cbmw-walk-scheduler.firebaseapp.com",
  databaseURL: "https://cbmw-walk-scheduler-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "cbmw-walk-scheduler",
  storageBucket: "cbmw-walk-scheduler.firebasestorage.app",
  messagingSenderId: "108766389213",
  appId: "1:108766389213:web:cded7ada3d32874b380c34",
  measurementId: "G-QFS6HHL007"
};

// Database 2: Master Walks Database Configuration
const firebaseConfigWalks = {
   apiKey: "AIzaSyB9WLJSl4QmubgBW5rknmnMeHcNbkwqOHQ",
  authDomain: "programme-planning.firebaseapp.com",
  databaseURL: "https://programme-planning-default-rtdb.europe-west1.firebasedatabase.app",
  projectId: "programme-planning",
  storageBucket: "programme-planning.firebasestorage.app",
  messagingSenderId: "1028011310189",
  appId: "1:1028011310189:web:8ac4f37a8d248899735364",
  measurementId: "G-BBQ4Q6TQHD"
};

// Initialize distinct standalone instances
const calendarApp = initializeApp(firebaseConfigCalendar, "calendarInstance");
const walksApp = initializeApp(firebaseConfigWalks, "walksInstance");

// Map target database connectivity layers
const dbCalendar = getDatabase(calendarApp);
const dbWalks = getDatabase(walksApp);

// Global application working matrices
let calendarSchedule = [];
let walkDatabase = {};

let currentEditingId = null;
let activeFrom = '';
let activeTo = '';
let activeWalk = 'all';

async function initApp() {
  setInfo("🔄 Synchronizing parallel records from Firebase...");
  
  // 1. Safe fetch for Calendar Bookings (DB 1)
  let bookingsSnapshot = null;
  try {
    bookingsSnapshot = await get(ref(dbCalendar, 'walk_bookings'));
  } catch (error) {
    console.error("❌ Failed to fetch from DB 1 (Calendar):", error);
    setInfo("❌ Error loading calendar database check connection/rules.", true);
  }

  // 2. Safe fetch for Master Walks (DB 2)
  let walksSnapshot = null;
  try {
    walksSnapshot = await get(ref(dbWalks, 'walks'));
  } catch (error) {
    console.error("❌ Failed to fetch from DB 2 (Walks Master):", error);
  }

  // 3. Clear existing states
  calendarSchedule = [];
  walkDatabase = {};

  if (walksSnapshot && walksSnapshot.exists()) {
    const rawWalksData = walksSnapshot.val();
    walkDatabase = {};

    console.group("🚀 Firebase DB 2 Fetch & Structuring Logic");
    Object.keys(rawWalksData).forEach(walkId => {
      const walk = rawWalksData[walkId] || {};
      
      walkDatabase[walkId] = {
        title: walk.Route_Name || `Walk ${walkId}`,
        ascent: walk.Ascent || 'N/A',
        directions: walk.Directions || 'No directions listed.',
        distance: walk.Distance || 'N/A',
        dogs: walk.Dogs || 'No restrictions specified.',
        difficulty: walk.Grade || 'N/A',
        description: walk.Route_Description || 'No description available.',
        scr: walk.Scr || 'N/A',
        terrain: walk.Terrain || 'N/A',
        total_time: walk.Total_Time || 'N/A'
      };
    });
    console.groupEnd();
  }

  // 5. Process Bookings from DB 1 if they exist
  if (bookingsSnapshot && bookingsSnapshot.exists()) {
    const firebaseData = bookingsSnapshot.val();
    
    Object.keys(firebaseData).forEach((key, index) => {
      const booking = firebaseData[key];
      const walkId = booking.walk_number;
      
      const [day, month, year] = booking.date.split('-');
      const standardDate = `${year}-${month}-${day}`;

      if (!walkDatabase[walkId]) {
        walkDatabase[walkId] = {
          title: booking.pueblo ? `Walk to ${booking.pueblo}` : `Walk ${walkId}`,
          ascent: 'N/A',
          directions: 'No directions available.',
          distance: 'Dynamic Route',
          dogs: 'N/A',
          difficulty: booking.walk_grade || 'N/A',
          description: booking.notes || 'No description available.',
          scr: 'N/A',
          terrain: 'N/A',
          total_time: 'N/A'
        };
      }

      calendarSchedule.push({
        id: index,
        date: standardDate,
        time: booking.start_time || '10:00',
        walkid: walkId,
        leader_name: booking.leader_name || 'TBD',
        overrides: (booking.comments) ? {
          description: booking.comments || undefined
        } : undefined
      });
    });

    calendarSchedule.sort((a, b) => a.date.localeCompare(b.date));
    setInfo("✅ Data synchronized successfully.");
  } else {
    setInfo("⚠️ No calendar records found in primary database.");
  }

  populateWalkOptions();
  renderSchedule();
}

function formatTime(value){
  if(!value) return 'N/A';
  const m = /^([01]\d|2[0-3]):([0-5]\d)$/.exec(value);
  if(!m) return value;
  const h = Number(m[1]);
  return `${((h+11)%12)+1}:${m[2]} ${h>=12?'PM':'AM'}`;
}

function formatDate(value){
  if(!value) return 'No Date';
  return new Date(value+'T00:00:00').toLocaleDateString('en-US', { weekday:'short', month:'short', day:'numeric', year:'numeric' });
}

function setInfo(message, isError = false){
  const el = document.getElementById('filter-info');
  el.textContent = message;
  el.style.color = isError ? '#dc3545' : '#6c757d';
}

function populateWalkOptions(){
  const select = document.getElementById('walk-filter');
  const filterText = document.getElementById('walk-search').value.trim().toLowerCase();
  const currentValue = select.value;
  const matches = Object.entries(walkDatabase).filter(([id, walk]) => walk.title.toLowerCase().includes(filterText));

  select.innerHTML = '<option value="all">All walks</option>';
  matches.forEach(([id, walk]) => {
    const option = document.createElement('option');
    option.value = id;
    option.textContent = walk.title;
    select.appendChild(option);
  });

  if (matches.some(([id]) => id === currentValue)) {
    select.value = currentValue;
  } else {
    select.value = 'all';
    activeWalk = 'all';
  }
}

function refreshWalkOptions(){
  const currentValue = document.getElementById('walk-filter').value;
  populateWalkOptions();
  if (currentValue !== 'all') {
    document.getElementById('walk-filter').value = currentValue;
  }
}

function clearDateField(fieldId){
  document.getElementById(fieldId).value = '';
  if (fieldId === 'filter-from') activeFrom = '';
  if (fieldId === 'filter-to') activeTo = '';
  setInfo('Filter cleared for that date field.');
  renderSchedule();
  updateSummary();
}

function clearWalkSearch(){
  document.getElementById('walk-search').value = '';
  populateWalkOptions();
  activeWalk = 'all';
  document.getElementById('walk-filter').value = 'all';
  setInfo('Walk search cleared.');
  renderSchedule();
  updateSummary();
}

function setActiveWalk(value){
  activeWalk = value || 'all';
  renderSchedule();
  updateSummary();
}

function clearAllFilters(){
  activeFrom = '';
  activeTo = '';
  activeWalk = 'all';
  document.getElementById('filter-from').value = '';
  document.getElementById('filter-to').value = '';
  document.getElementById('walk-search').value = '';
  populateWalkOptions();
  document.getElementById('walk-filter').value = 'all';
  setInfo('Showing all scheduled walks.');
  renderSchedule();
  updateSummary();
}

function createProgramme(){
  const from = document.getElementById('filter-from').value;
  const to = document.getElementById('filter-to').value;
  const walk = document.getElementById('walk-filter').value || 'all';

  if (!from || !to) {
    setInfo('Please select both a From date and a To date.', true);
    return;
  }

  if (from > to) {
    setInfo('The From date must be on or before the To date.', true);
    return;
  }

  activeFrom = from;
  activeTo = to;
  activeWalk = walk;
  const walkName = walk === 'all' ? 'All walks' : walkDatabase[walk].title;
  setInfo(`Programme created: ${formatDate(from)} to ${formatDate(to)} — ${walkName}.`);
  renderSchedule();
  updateSummary();
}

function getSchedule(){
  return calendarSchedule.filter(slot => {
    if (activeFrom && slot.date < activeFrom) return false;
    if (activeTo && slot.date > activeTo) return false;
    if (activeWalk !== 'all' && slot.walkid !== activeWalk) return false;
    return true;
  }).sort((a,b) => a.date.localeCompare(b.date));
}

function updateSummary(){
  const schedule = getSchedule();
  const total = calendarSchedule.length;
  const fromLabel = activeFrom ? formatDate(activeFrom) : 'Any';
  const toLabel = activeTo ? formatDate(activeTo) : 'Any';
  const walkLabel = activeWalk === 'all' ? 'All walk types' : walkDatabase[activeWalk].title;

  const summary = document.getElementById('programme-summary');
  summary.innerHTML = `
    <div class="summary-title">Programme summary</div>
    <div class="summary-grid">
      <div class="summary-item"><div class="summary-label">Showing</div><div class="summary-value">${schedule.length} / ${total} walks</div></div>
      <div class="summary-item"><div class="summary-label">From</div><div class="summary-value">${fromLabel}</div></div>
      <div class="summary-item"><div class="summary-label">To</div><div class="summary-value">${toLabel}</div></div>
      <div class="summary-item"><div class="summary-label">Walk filter</div><div class="summary-value">${walkLabel}</div></div>
    </div>
  `;

  document.getElementById('print-summary').textContent = `${fromLabel} to ${toLabel} • ${walkLabel} • ${schedule.length} walks`;
}

function renderSchedule(){
  const container = document.getElementById('schedule');
  container.innerHTML = '';
  const schedule = getSchedule();

  if (!schedule.length) {
    container.innerHTML = '<div class="empty-state"><p>📭 No walks match the current filters.</p></div>';
    updateSummary();
    return;
  }

  schedule.forEach(slot => {
    const base = walkDatabase[slot.walkid] || {};
    const overrides = slot.overrides || {};
    const modified = Object.keys(overrides).length > 0;
    
    const title = overrides.title || base.title || 'Unknown Walk';
    const distance = overrides.distance || base.distance || 'N/A';
    const difficulty = overrides.difficulty || base.difficulty || 'N/A';
    const description = overrides.description || base.description || '';
    const time = overrides.time || slot.time || 'N/A';
    const ascent = base.ascent || 'N/A';
    const directions = base.directions || '';
    const dogs = base.dogs || 'N/A';
    const scr = base.scr || 'N/A';
    const terrain = base.terrain || 'N/A';
    const total_time = base.total_time || 'N/A';
    const leader = slot.leader_name || 'TBD';

    const item = document.createElement('div');
    item.className = `schedule-item ${modified ? 'is-modified' : ''} ${currentEditingId === slot.id ? 'is-editing' : ''}`;

    if (currentEditingId === slot.id) {
      item.innerHTML = `
        <div>
          <div class="walk-date">${formatDate(slot.date)}</div>
          <div class="walk-time">⏰ ${formatTime(slot.time)}</div>
        </div>
        <div class="edit-form">
          <div class="form-row">
            <div class="form-group"><label>Date</label><input type="date" value="${slot.date}" readonly></div>
            <div class="form-group"><label>Time Override</label><input type="time" id="edit-time-${slot.id}" value="${overrides.time || slot.time || ''}"></div>
          </div>
          <div class="form-group"><label>Title Override</label><input type="text" id="edit-title-${slot.id}" value="${overrides.title || ''}" placeholder="Master: ${base.title || ''}"></div>
          <div class="form-row">
            <div class="form-group"><label>Distance Override</label><input type="text" id="edit-distance-${slot.id}" value="${overrides.distance || ''}" placeholder="Master: ${base.distance || ''}"></div>
            <div class="form-group"><label>Difficulty Override</label><input type="text" id="edit-difficulty-${slot.id}" value="${overrides.difficulty || ''}" placeholder="Master: ${base.difficulty || ''}"></div>
          </div>
          <div class="form-group"><label>Description Override</label><textarea id="edit-desc-${slot.id}" placeholder="Master: ${base.description || ''}">${overrides.description || ''}</textarea></div>
          <div class="edit-buttons">
            <button class="btn" onclick="saveOverride(${slot.id})">Save Changes</button>
            <button class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
            ${modified ? `<button class="btn btn-danger" onclick="resetToMaster(${slot.id})">Reset to Master</button>` : ''}
          </div>
        </div>
      `;
    } else {
      item.innerHTML = `
        <div>
          <div class="walk-date">${formatDate(slot.date)}</div>
          <div class="walk-time">⏰ ${formatTime(time)}</div>
        </div>
        <div>
          <div class="card-actions"><button class="btn btn-secondary" style="padding:5px 10px;font-size:.85em" onclick="enterEditMode(${slot.id})">✏️ Edit Card</button></div>
          <h2 class="walk-title">${title}${modified ? '<span class="badge badge-modified">Modified</span>' : ''}</h2>
          <div class="walk-meta">
            <span>🔢 <strong>Walk No:</strong> <span class="meta-tag">${slot.walkid}</span></span>
            <span>🥾 <strong>Leader:</strong> ${leader}</span>
            <span>📏 <strong>Distance:</strong> ${distance}</span>
            <span>🏔️ <strong>Ascent:</strong> ${ascent}</span>
            <span>⏱️ <strong>Total Time:</strong> ${total_time}</span>
            <span>📊 <strong>Grade:</strong> <span class="meta-tag">${difficulty}</span></span>
            <span>🪨 <strong>Terrain:</strong> ${terrain}</span>
            <span>📋 <strong>Scr:</strong> ${scr}</span>
            <span>🐕 <strong>Dogs:</strong> ${dogs}</span>
          </div>
          <p class="walk-desc">${description || '<em>No description available.</em>'}</p>
          ${directions ? `<div class="walk-directions">📍 <strong>Directions:</strong> ${directions}</div>` : ''}
        </div>
      `;
    }

    container.appendChild(item);
  });

  updateSummary();
}

function enterEditMode(id){
  currentEditingId = id;
  renderSchedule();
}

function cancelEdit(){
  currentEditingId = null;
  renderSchedule();
}

function saveOverride(id){
  const slot = calendarSchedule.find(s => s.id === id);
  if (!slot) return;

  const fields = {
    time: 'edit-time-',
    title: 'edit-title-',
    distance: 'edit-distance-',
    difficulty: 'edit-difficulty-',
    description: 'edit-desc-'
  };

  const overrides = {};
  Object.entries(fields).forEach(([key, prefix]) => {
    const el = document.getElementById(prefix + id);
    const value = el ? el.value.trim() : '';
    if (value) overrides[key] = value;
  });

  if (Object.keys(overrides).length > 0) {
    slot.overrides = { ...(slot.overrides || {}), ...overrides };
  } else {
    delete slot.overrides;
  }

  if (overrides.time) slot.time = overrides.time;
  currentEditingId = null;
  renderSchedule();
}

function resetToMaster(id){
  const slot = calendarSchedule.find(s => s.id === id);
  if (slot) delete slot.overrides;
  currentEditingId = null;
  renderSchedule();
}

function exportCSV(){
  const schedule = getSchedule();
  if (!schedule.length) {
    setInfo('There are no walks to export for the current filters.', true);
    return;
  }
  
  const headers = ["Date", "Start Time", "Walk Number", "Leader Name", "Route Name", "Distance", "Ascent", "Grade", "Terrain", "Scr", "Total Time", "Dogs", "Route Description", "Directions"];
  
  const rows = schedule.map(slot => {
    const base = walkDatabase[slot.walkid] || {};
    const overrides = slot.overrides || {};
    
    const date = slot.date;
    const time = overrides.time || slot.time || 'N/A';
    const walkNo = slot.walkid;
    const leader = slot.leader_name || 'TBD';
    const title = overrides.title || base.title || 'Unknown Walk';
    const distance = overrides.distance || base.distance || 'N/A';
    const ascent = base.ascent || 'N/A';
    const grade = overrides.difficulty || base.difficulty || 'N/A';
    const terrain = base.terrain || 'N/A';
    const scr = base.scr || 'N/A';
    const totalTime = base.total_time || 'N/A';
    const dogs = base.dogs || 'N/A';
    const desc = (overrides.description || base.description || '').replace(/"/g, '""');
    const directions = (base.directions || '').replace(/"/g, '""');
    
    return [date, time, walkNo, leader, title, distance, ascent, grade, terrain, scr, totalTime, dogs, desc, directions].map(val => `"${val}"`).join(",");
  });
  
  const csvContent = "data:text/csv;charset=utf-8,\uFEFF" + [headers.join(","), ...rows].join("\n");
  const encodedUri = encodeURI(csvContent);
  const link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "programme_schedule_export.csv");
  document.body.appendChild(link);
  link.click();
  link.remove();
}

function exportData(){
  const data = getSchedule();
  const url = 'data:application/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(data, null, 2));
  const link = document.createElement('a');
  link.href = url;
  link.download = 'programme_schedule_output.json';
  document.body.appendChild(link);
  link.click();
  link.remove();
}

function exportPDF(){
  if (!getSchedule().length) {
    setInfo('There are no walks to export for the current filters.', true);
    return;
  }
  const fromValue = activeFrom ? formatDate(activeFrom) : 'Any date';
  const toValue = activeTo ? formatDate(activeTo) : 'Any date';
  const walkValue = activeWalk === 'all' ? 'All walks' : walkDatabase[activeWalk].title;
  document.getElementById('print-summary').textContent = `Programme: ${fromValue} to ${toValue} • ${walkValue} • ${getSchedule().length} walks`;
  window.print();
}

window.clearDateField = clearDateField;
window.clearWalkSearch = clearWalkSearch;
window.refreshWalkOptions = refreshWalkOptions;
window.setActiveWalk = setActiveWalk;
window.createProgramme = createProgramme;
window.clearAllFilters = clearAllFilters;
window.exportCSV = exportCSV;
window.exportData = exportData;
window.exportPDF = exportPDF;
window.enterEditMode = enterEditMode;
window.cancelEdit = cancelEdit;
window.saveOverride = saveOverride;
window.resetToMaster = resetToMaster;

window.addEventListener('DOMContentLoaded', initApp);
</script>
</body>

