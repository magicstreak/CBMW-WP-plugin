<?php
if (!defined('ABSPATH')) { exit; }
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CBMW Walk Scheduler</title>
  <!-- Google Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet" />
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
  <style>
    :root {
      --primary: #2563eb;
      --primary-hover: #1d4ed8;
      --bg-muted: #f8fafc;
      --border: #e2e8f0;
      --text: #1e293b;
      --text-muted: #64748b;
      --color-E: #16a34a;
      --color-M: #3773f5;
      --color-MS: #dc2626;
      --color-S: #2d1655;
      --color-VS: #111827;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family:
        "Google Sans",
        system-ui,
        -apple-system,
        sans-serif;
      background-color: #f1f5f9;
      color: var(--text);
      margin: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* ========================================================= PAGE HEADER ========================================================= */
    .page-header {
      text-align: center;
      margin-bottom: 32px;
      width: 100%;
      max-width: 1100px;
    }

    .page-header h1 {
      font-size: 2.2rem;
      font-weight: 700;
      margin: 0 0 8px 0;
      letter-spacing: -0.03em;
    }

    .page-header p {
      font-size: 1.05rem;
      color: var(--text-muted);
      margin: 0;
    }

    /* ========================================================= MAIN CONTAINERS ========================================================= */
    .calendar-container,
    .admin-container,
    .stats-container {
      width: 100%;
      max-width: 1100px;
      background: #fff;
      padding: 28px;
      border-radius: 16px;
      box-shadow:
        0 10px 25px -5px rgba(0, 0, 0, 0.05),
        0 8px 10px -6px rgba(0, 0, 0, 0.05);
      margin-bottom: 30px;
    }

    /* ========================================================= TOGGLE ========================================================= */
    .toggle-container {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 30px;
    }

    .switch-label {
      font-weight: 600;
      color: #333;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      inset: 0;
      background-color: #0284c7;
      transition: 0.4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    input:checked+.slider {
      background-color: #b91c1c;
    }

    input:checked+.slider:before {
      transform: translateX(26px);
    }

    /* ========================================================= CALENDAR ========================================================= */
    .calendar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 24px;
    }

    .calendar-header h2 {
      margin: 0;
      font-size: 1.75rem;
      font-weight: 700;
    }

    .nav-btn {
      background: #fff;
      border: 1px solid var(--border);
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      color: var(--text);
    }

    .nav-btn:hover {
      background: var(--bg-muted);
      border-color: #cbd5e1;
    }

    /* ========================================================= LEGEND ========================================================= */
    .legend-container {
      display: flex;
      gap: 12px;
      margin-bottom: 20px;
      flex-wrap: wrap;
      padding: 12px;
      background: var(--bg-muted);
      border-radius: 8px;
    }

    .legend-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.85rem;
      font-weight: 600;
    }

    .legend-dot {
      width: 12px;
      height: 12px;
      border-radius: 4px;
    }

    /* ========================================================= CALENDAR GRID ========================================================= */
    .weekdays {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      text-align: center;
      font-weight: 700;
      color: var(--text-muted);
      margin-bottom: 12px;
      text-transform: uppercase;
      font-size: 0.8rem;
    }

    .days-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 10px;
    }

    .day-cell {
      border: 1px solid var(--border);
      border-radius: 10px;
      min-height: 130px;
      padding: 10px;
      background: #fff;
      display: flex;
      flex-direction: column;
    }

    .day-cell.empty {
      background: var(--bg-muted);
      border: none;
    }

    .day-number {
      font-weight: 700;
      margin-bottom: 8px;
      font-size: 0.95rem;
    }

    .slots-container {
      display: flex;
      flex-direction: column;
      gap: 6px;
      flex-grow: 1;
    }

    /* ========================================================= SLOTS ========================================================= */
    .slot {
      padding: 6px 8px;
      font-size: 0.75rem;
      border-radius: 6px;
      cursor: pointer;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      transition: all 0.2s;
    }

    .slot.past {
      background-color: #f1f5f9 !important;
      color: #94a3b8 !important;
      border-color: #e2e8f0 !important;
      cursor: not-allowed;
      opacity: 0.6;
    }

    .slot.available {
      font-weight: 500;
      color: #64748b !important;
      border: 1px solid #cbd5e1;
    }

    .slot.unavailable {
      display: none;
    }

    .slot.available.grade-E {
      background-color: rgba(22, 163, 74, 0.12);
    }

    .slot.available.grade-M {
      background-color: rgba(37, 99, 235, 0.12);
    }

    .slot.available.grade-MS {
      background-color: rgba(220, 38, 38, 0.12);
    }

    .slot.available.grade-S {
      background-color: rgba(45, 22, 85, 0.12);
    }

    .slot.available.grade-VS {
      background-color: rgba(17, 24, 39, 0.06);
    }

    .slot.available:hover {
      background-color: #cbd5e1 !important;
      color: #1e293b !important;
    }

    .slot.booked {
      font-weight: 700;
      color: #fff;
      border: 1px solid transparent;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.15);
    }

    .slot.booked.grade-E {
      background: var(--color-E);
    }

    .slot.booked.grade-M {
      background: var(--color-M);
    }

    .slot.booked.grade-MS {
      background: var(--color-MS);
    }

    .slot.booked.grade-S {
      background: var(--color-S);
    }

    .slot.booked.grade-VS {
      background: var(--color-VS);
    }

    /* ========================================================= BUTTONS ========================================================= */
    .btn {
      padding: 10px 20px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.95rem;
    }

    .btn-primary {
      background: var(--primary);
      color: #fff;
    }

    .btn-secondary {
      background: var(--bg-muted);
      color: var(--text);
      border: 1px solid var(--border);
    }

    .btn-success {
      background: #10b981;
      color: white;
    }

    .btn-warning {
      background: #f59e0b;
      color: white;
    }

    .btn-danger {
      background: #ef4444;
      color: white;
      padding: 6px 12px;
      font-size: 0.85rem;
    }

    /* ========================================================= ADMIN ========================================================= */
    .admin-header,
    .stats-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      flex-wrap: wrap;
      gap: 12px;
    }

    .admin-header h3,
    .stats-header h3 {
      margin: 0;
      font-size: 1.35rem;
    }

    /* ========================================================= TABLES ========================================================= */
    .table-wrapper {
      overflow-x: auto;
      border: 1px solid var(--border);
      border-radius: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
      font-size: 0.9rem;
    }

    th {
      background: var(--bg-muted);
      color: var(--text-muted);
      padding: 14px 16px;
      font-weight: 700;
      border-bottom: 1px solid var(--border);
    }

    td {
      padding: 14px 16px;
      border-bottom: 1px solid var(--border);
    }

    tr:last-child td {
      border-bottom: none;
    }

    /* ========================================================= GRADE BADGES ========================================================= */
    .badge {
      padding: 4px 8px;
      border-radius: 6px;
      font-weight: 700;
      font-size: 0.75rem;
      color: white;
      display: inline-block;
    }

    .grade-E {
      background: var(--color-E);
    }

    .grade-M {
      background: var(--color-M);
    }

    .grade-MS {
      background: var(--color-MS);
    }

    .grade-S {
      background: var(--color-S);
    }

    .grade-VS {
      background: var(--color-VS);
    }

    /* ========================================================= STATISTICS ========================================================= */
    .stats-filter {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 15px;
      flex-wrap: wrap;
      margin-bottom: 25px;
      padding: 15px;
      background: var(--bg-muted);
      border-radius: 10px;
    }

    .stats-filter label {
      font-weight: 600;
    }

    .stats-filter select {
      min-width: 180px;
      padding: 10px 14px;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: white;
      font-family: inherit;
      font-size: 0.9rem;
    }

    /* SUMMARY CARDS */
    .stats-summary {
      display: grid;
      grid-template-columns: repeat(6, 1fr);
      gap: 12px;
      margin-bottom: 25px;
    }

    .stat-card {
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 16px;
      background: white;
    }

    .stat-label {
      font-size: 0.8rem;
      color: var(--text-muted);
      margin-bottom: 6px;
    }

    .stat-value {
      font-size: 1.7rem;
      font-weight: 700;
    }

    /* ========================================================= STATISTICS GRAPHICS ========================================================= */
    .stats-grid {
      display: grid;
      grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.8fr);
      gap: 20px;
      margin-bottom: 25px;
    }

    .stats-card {
      background: white;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 20px;
    }

    .stats-card h4 {
      margin: 0 0 5px 0;
      font-size: 1.05rem;
    }

    .stats-card p {
      margin: 0 0 18px 0;
      font-size: 0.85rem;
      color: var(--text-muted);
    }

    .chart-container {
      position: relative;
      height: 330px;
    }

    /* ========================================================= LEADER TABLE ========================================================= */
    .leader-table .grade-cell {
      text-align: center;
    }

    .leader-table .grade-count {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 32px;
      height: 27px;
      padding: 0 7px;
      border-radius: 6px;
      color: white;
      font-weight: 700;
      font-size: 0.75rem;
    }

    .total-row {
      background: var(--bg-muted);
      font-weight: 700;
    }

    /* ========================================================= MODAL ========================================================= */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.6);
      backdrop-filter: blur(4px);
      display: flex;
      justify-content: center;
      align-items: center;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.3s;
      z-index: 1000;
    }

    .modal-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }

    .modal-content {
      background: white;
      padding: 32px;
      border-radius: 16px;
      width: 100%;
      max-width: 480px;
      max-height: 90vh;
      overflow-y: auto;
    }

    .modal-content h3 {
      margin-top: 0;
      margin-bottom: 24px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      display: block;
      margin-bottom: 7px;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 0.95rem;
      font-family: inherit;
    }

    .form-group input[readonly] {
      background: var(--bg-muted);
      color: var(--text-muted);
    }

    .form-group textarea {
      resize: vertical;
      min-height: 70px;
    }

    .modal-actions {
      display: flex;
      justify-content: flex-end;
      gap: 12px;
      margin-top: 25px;
    }

    /* ========================================================= HIDDEN ========================================================= */
    .hidden {
      display: none !important;
    }

    /* ========================================================= RESPONSIVE ========================================================= */
    @media (max-width: 900px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }

      .stats-summary {
        grid-template-columns: repeat(3, 1fr);
      }
    }

    @media (max-width: 650px) {
      body {
        padding: 10px;
      }

      .calendar-container,
      .admin-container,
      .stats-container {
        padding: 16px;
      }

      .days-grid {
        gap: 4px;
      }

      .day-cell {
        min-height: 100px;
        padding: 5px;
      }

      .slot {
        font-size: 0.65rem;
        padding: 5px;
      }

      .stats-summary {
        grid-template-columns: repeat(2, 1fr);
      }

      .calendar-header h2 {
        font-size: 1.2rem;
      }
    }

    .sortable-header {
      cursor: pointer;
      user-select: none;
      white-space: nowrap;
    }

    .sortable-header:hover {
      background: #eef2f7;
    }

    .sort-indicator {
      display: inline-block;
      margin-left: 6px;
      font-size: 0.7rem;
      color: #94a3b8;
    }

    .sort-indicator.active {
      color: var(--primary);
    }

    /* =========================================================
   COLLAPSIBLE CONTAINERS
   ========================================================= */

    .collapsible-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 15px;
      cursor: pointer;
      user-select: none;
    }

    .collapse-button {
      width: 34px;
      height: 34px;
      border: 1px solid var(--border);
      border-radius: 8px;
      background: #fff;
      color: var(--text-muted);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s ease;
      flex-shrink: 0;
    }

    .collapse-button:hover {
      background: var(--bg-muted);
      color: var(--text);
    }

    .collapsible-content {
      overflow: hidden;
      max-height: 5000px;
      opacity: 1;
      transition:
        max-height 0.35s ease,
        opacity 0.25s ease;
    }

    .collapsible-container.collapsed .collapsible-content {
      max-height: 0;
      opacity: 0;
    }

    .collapsible-container.collapsed .collapse-button {
      transform: rotate(180deg);
    }

    .stats-section-header {
      background: var(--bg-muted);
      padding: 16px 18px;
      border-bottom: 1px solid var(--border);
    }

    .stats-section-title h4 {
      margin: 0;
      font-size: 1.25rem;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.02em;
    }

    .stats-section-title p {
      margin: 5px 0 0;
      font-size: 0.84rem;
      font-weight: 500;
      color: var(--text-muted);
    }
  </style>
</head>

<body>
  <!-- ======================================================= HEADER ======================================================= -->
  <header class="page-header">
    <h1>CBMW Walk Scheduler</h1>
    <p>Click on a slot to schedule or edit a walk.</p>
  </header>
  <!-- ======================================================= VIEW TOGGLE ======================================================= -->
  <div class="toggle-container">
    <span class="switch-label"> Leaders View </span>
    <label class="switch">
      <input type="checkbox" id="viewToggle" /> <span class="slider"></span>
    </label>
    <span class="switch-label"> Admin View </span>
  </div>
  <!-- ======================================================= CALENDAR ======================================================= -->
  <div class="calendar-container">
    <div class="calendar-header">
      <button class="nav-btn" id="prev-month">&larr; Previous</button>
      <h2 id="calendar-title">Month Year</h2>
      <button class="nav-btn" id="next-month">Next &rarr;</button>
    </div>
    <div class="legend-container">
      <div class="legend-item">
        <div class="legend-dot" style="background: var(--color-E)"></div>
        E (Easy)
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: var(--color-M)"></div>
        M (Moderate)
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: var(--color-MS)"></div>
        MS (Moderate S)
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: var(--color-S)"></div>
        S (Strenuous)
      </div>
      <div class="legend-item">
        <div class="legend-dot" style="background: var(--color-VS)"></div>
        VS (Very Strenuous)
      </div>
    </div>
    <div class="weekdays">
      <div>Sun</div>
      <div>Mon</div>
      <div>Tue</div>
      <div>Wed</div>
      <div>Thu</div>
      <div>Fri</div>
      <div>Sat</div>
    </div>
    <div class="days-grid" id="days-grid"></div>
  </div>
  <!-- ======================================================= ADMIN ======================================================= -->
  <div class="admin-container hidden">
    <div class="admin-header">
      <h3>Administration Dashboard</h3>
      <div style="display: flex; gap: 8px; flex-wrap: wrap">

        <!-- ======================================================= VIEW TOGGLE ======================================================= -->
        <div class="toggle-container">
          <span class="switch-label">Open</span>
          <label class="switch">
            <!-- This checkbox uses the correct ID and calls modeToggle() -->
            <input type="checkbox" id="modeCheckBox">
            <span class="slider"></span>
          </label>
          <span class="switch-label">Pause</span>
        </div>
        <button class="btn btn-success" id="add-walk-to-schedule">Add Walk</button>
        <button class="btn btn-success" id="export-csv">Export to CSV</button>
        <button class="btn btn-danger" id="clear-all">
          Clear All Bookings
        </button>
        <button class="btn btn-success" id="publish">Build Programme</button>
      </div>
    </div>
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Start Time</th>
            <th>Grade</th>
            <th>Walk Number</th>
            <th>Leader</th>
            <th>Owner</th>
            <th>Pueblo</th>
            <th>Comments</th>
            <th>Edit</th>
            <th>Cancel</th>
          </tr>
        </thead>
        <tbody id="admin-table-body"></tbody>
      </table>
    </div>
  </div>
  <!-- =======================================================
     STATISTICS DASHBOARD
     ======================================================= -->

  <div class="stats-container collapsible-container collapsed" id="statistics-dashboard">
    <!-- MAIN STATISTICS HEADER -->

    <div class="stats-header collapsible-header">
      <div>
        <h3>Programme Stats Dashboard</h3>

        <p style="margin: 5px 0 0; color: var(--text-muted)">
          Statistics for the scheduled walk programme
        </p>
      </div>

      <button type="button" class="collapse-button" aria-label="Collapse statistics dashboard">
        <span class="collapse-icon"> ⌃ </span>
      </button>
    </div>

    <!-- MAIN STATISTICS CONTENT -->

    <div class="collapsible-content">
      <!-- =================================================
             PUEBLO FILTER
             ================================================= -->

      <div class="stats-filter">
        <label for="pueblo-filter"> Filter statistics by Pueblo </label>

        <select id="pueblo-filter">
          <option value="ALL">All Pueblos</option>
        </select>
      </div>

      <!-- =================================================
             STACKED STATISTIC CARDS
             ================================================= -->

      <div class="stats-summary">
        <div class="stat-card total-card">
          <div class="stat-label">Total Walks</div>

          <div class="stat-value" id="stat-total">0</div>
        </div>

        <div class="stat-card">
          <div class="stat-label">E — Easy</div>

          <div class="stat-value" style="color: var(--color-E)" id="stat-E">
            0
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-label">M — Moderate</div>

          <div class="stat-value" style="color: var(--color-M)" id="stat-M">
            0
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-label">MS — Moderate Strenuous</div>

          <div class="stat-value" style="color: var(--color-MS)" id="stat-MS">
            0
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-label">S — Strenuous</div>

          <div class="stat-value" style="color: var(--color-S)" id="stat-S">
            0
          </div>
        </div>

        <div class="stat-card">
          <div class="stat-label">VS — Very Strenuous</div>

          <div class="stat-value" style="color: var(--color-VS)" id="stat-VS">
            0
          </div>
        </div>
      </div>
      <!-- =================================================
             RAW WALK DATA
             ================================================= -->

      <div class="stats-section collapsible-container" id="walk-data-section">
        <div class="stats-section-header collapsible-header">
          <div class="stats-section-title">
            <h4>Overview of Scheduled Walks</h4>

            <p>
              <span id="stats-count"> 0 </span>

              walks shown — click a heading to sort
            </p>
          </div>

          <button type="button" class="collapse-button" aria-label="Collapse walk data">
            <span class="collapse-icon"> ⌃ </span>
          </button>
        </div>

        <div class="stats-section-content collapsible-content">
          <div class="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th class="sortable-header" data-sort="walk_number">
                    Walk #
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-sort="date">
                    Date
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-sort="time">
                    Time
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-sort="walk_grade">
                    Grade
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-sort="owner">
                    Owner
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-sort="leader_name">
                    Leader
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-sort="pueblo">
                    Pueblo
                    <span class="sort-indicator"> ↕ </span>
                  </th>
                </tr>
              </thead>

              <tbody id="stats-data-body"></tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- =================================================
             MONTHLY CHART
             ================================================= -->

      <div class="stats-section collapsible-container" id="monthly-stats-section">
        <div class="stats-section-header collapsible-header">
          <div class="stats-section-title">
            <h4>Walks Scheduled by Month & Grade</h4>

            <p>Monthly distribution of walking grades</p>
          </div>

          <button type="button" class="collapse-button" aria-label="Collapse monthly chart">
            <span class="collapse-icon"> ⌃ </span>
          </button>
        </div>

        <div class="stats-section-content collapsible-content">
          <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
          </div>
        </div>
      </div>

      <!-- =================================================
             LEADER TABLE
             ================================================= -->

      <div class="stats-section collapsible-container" id="leader-stats-section">
        <div class="stats-section-header collapsible-header">
          <div class="stats-section-title">
            <h4>Walks Scheduled by Leader & Grade</h4>
          </div>

          <button type="button" class="collapse-button" aria-label="Collapse leader statistics">
            <span class="collapse-icon"> ⌃ </span>
          </button>
        </div>

        <div class="stats-section-content collapsible-content">
          <div class="table-wrapper">
            <table class="leader-table">
              <thead>
                <tr>
                  <th class="sortable-header" data-leader-sort="leader">
                    Leader
                    <span class="sort-indicator"> ↑ </span>
                  </th>

                  <th class="sortable-header" data-leader-sort="E" style="text-align: center">
                    E
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-leader-sort="M" style="text-align: center">
                    M
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-leader-sort="MS" style="text-align: center">
                    MS
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-leader-sort="S" style="text-align: center">
                    S
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-leader-sort="VS" style="text-align: center">
                    VS
                    <span class="sort-indicator"> ↕ </span>
                  </th>

                  <th class="sortable-header" data-leader-sort="total" style="text-align: center">
                    Total
                    <span class="sort-indicator"> ↕ </span>
                  </th>
                </tr>
              </thead>

              <tbody id="leader-stats-body"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ======================================================= BOOKING MODAL ======================================================= -->
  <div class="modal-overlay" id="booking-modal">
    <div class="modal-content">
      <h3 id="modal-heading">Book Walk Slot</h3>
      <form id="kv-booking-form">
  <!-- 1. The Hidden Value Input -->
    <input type="hidden" id="modalHiddenValue" name="uniqueId" value="">
        <div class="form-group">
          <label> Selected Date </label>
          <input type="text" id="input-date" readonly />
        </div>
        <div class="form-group">
          <label> Start Time </label>
          <input type="time" id="input-start-time" value="10:00" />
        </div>
        <div class="form-group">
          <label> Walk Grade </label>
          <select id="input-grade">
            <option value="E">E</option>
            <option value="M">M</option>
            <option value="MS">MS</option>
            <option value="S">S</option>
            <option value="VS">VS</option>
          </select>

        </div>
        <div class="form-group">
          <label> Walk Number </label>
          <input type="text" id="input-walk-no" required placeholder="e.g. WK-104" />
        </div>
        <div class="form-group">
          <label> Name of Leader </label>
          <input type="text" id="input-leader" required placeholder="e.g. John Doe" />
        </div>
        <div class="form-group">
          <label> Owner </label>
          <input type="text" id="input-owner" placeholder="put the owner of the walk if different from Leader" />
        </div>
        <div class="form-group">
          <label> Pueblo </label>
          <input type="text" id="input-pueblo" placeholder="e.g. Pego" />
        </div>
        <div class="form-group">
          <label>Programme Comments </label>
          <textarea id="input-comments"
            placeholder="Add comments to be included in the programme e.g. option lunch, walking pace that are not included in the walk description">
            </textarea>
        </div>
        <div class="form-group">
          <label>Notes for the Programme Team</label>
          <textarea id="input-notes" placeholder="Add comments that may be helpful to the team creating the programme">
            </textarea>
        </div>
        <div class="modal-actions">
          <button type="button" class="btn btn-secondary" id="close-modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary" id="submit-booking">
            Submit Booking
          </button>
        </div>
      </form>
    </div>
  </div>
  <!-- ======================================================= FIREBASE ======================================================= -->
  <script type="module">
    import {initializeApp} from "https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js";
    import {
      getDatabase,
      ref,
      set,
      onValue,
      remove,
    } from "https://www.gstatic.com/firebasejs/10.8.0/firebase-database.js";
      /* ========================================================= FIREBASE CONFIG ========================================================= */ const firebaseConfig =
    {
      apiKey: "AIzaSyC0hEmdWHSlBkdnxrQiNt_RITYsbj3wvi0",
      authDomain: "cbmw-walk-scheduler.firebaseapp.com",
      databaseURL:
        "https://cbmw-walk-scheduler-default-rtdb.europe-west1.firebasedatabase.app",
      projectId: "cbmw-walk-scheduler",
      storageBucket: "cbmw-walk-scheduler.firebasestorage.app",
      messagingSenderId: "108766389213",
      appId: "1:108766389213:web:cded7ada3d32874b380c34",
      measurementId: "G-QFS6HHL007",
    };
    let db = null;
    let isFirebaseActive = false;
    try {
      const app = initializeApp(firebaseConfig);
      db = getDatabase(app);
      isFirebaseActive = true;
      console.log("Firebase connected successfully.");
    } catch (err) {
      console.error("Firebase startup failed.", err);
    }
      /* ========================================================= GLOBAL VARIABLES ========================================================= */ const grades =
      ["E", "M", "MS", "S", "VS"];
    let currentDate = new Date();
    let globalBookings = {};
    let monthlyChart = null;
    const monthNames = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    const daysGrid = document.getElementById("days-grid");
    const calendarTitle = document.getElementById("calendar-title");
    const modal = document.getElementById("booking-modal");
    const bookingForm = document.getElementById("kv-booking-form");
    const adminTableBody = document.getElementById("admin-table-body");
    const modalHeading = document.getElementById("modal-heading");
    const puebloFilter = document.getElementById("pueblo-filter");
      /* ========================================================= GRADE COLOURS FOR CHART ========================================================= */ const gradeColours =
    {
      E: "#16a34a",
      M: "#3773f5",
      MS: "#dc2626",
      S: "#2d1655",
      VS: "#111827",
    };
      /* ========================================================= DATA SYNC ========================================================= */ function initDataSync() {
      if (isFirebaseActive) {
        const dbRef = ref(db, "walk_bookings");
        onValue(dbRef, (snapshot) => {
          const data = snapshot.val();
          globalBookings = data || {};
          renderCalendar();
          renderAdminTable();
          updateStatistics();
        });
      } else {
        const localData = localStorage.getItem("global_walk_bookings");
        globalBookings = localData ? JSON.parse(localData) : {};
        renderCalendar();
        renderAdminTable();
        updateStatistics();
      }
    }
      /* ========================================================= SAVE BOOKING ========================================================= */ function saveBookingRecord(
      key,
      data,
    ) {
      if (data === null) {
        delete globalBookings[key];
      } else {
        globalBookings[key] = data;
      }
      if (isFirebaseActive) {

        set(ref(db, "walk_bookings/" + key), data);
      } else {
        localStorage.setItem(
          "global_walk_bookings",
          JSON.stringify(globalBookings),
        );
        renderCalendar();
        renderAdminTable();
        updateStatistics();
      }
    }
      /* ========================================================= CLEAR ALL ========================================================= */ function clearAllRecords() {
      if (!confirm("Are you sure you want to delete EVERY record?")) {
        return;
      }
      if (isFirebaseActive) {
        remove(ref(db, "walk_bookings"));
      } else {
        globalBookings = {};
        localStorage.removeItem("global_walk_bookings");
        renderCalendar();
        renderAdminTable();
        updateStatistics();
      }
    }
    /* ========================================================= CALENDAR ========================================================= */
      function renderCalendar() {
        daysGrid.innerHTML = "";

        const isPaused = document.getElementById("modeCheckBox")
          ? document.getElementById("modeCheckBox").checked
          : false;

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        calendarTitle.innerText = `${monthNames[month]} ${year}`;

        const firstDayIndex = new Date(year, month, 1).getDay();
        const totalDays = new Date(year, month + 1, 0).getDate();

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        // Empty cells before the first day of the month
        for (let i = 0; i < firstDayIndex; i++) {
          const emptyCell = document.createElement("div");
          emptyCell.classList.add("day-cell", "empty");
          daysGrid.appendChild(emptyCell);
        }

        // Render each day
        for (let day = 1; day <= totalDays; day++) {

          const dayCell = document.createElement("div");
          dayCell.classList.add("day-cell");

          // Day number
          const dayNoDiv = document.createElement("div");
          dayNoDiv.classList.add("day-number");
          dayNoDiv.innerText = day;
          dayCell.appendChild(dayNoDiv);

          const specificDate = new Date(year, month, day);
          specificDate.setHours(0, 0, 0, 0);

          const dayOfWeek = specificDate.getDay();

          // Firebase date format: DD-MM-YYYY
          const dateISO =
            `${String(day).padStart(2, "0")}-` +
            `${String(month + 1).padStart(2, "0")}-` +
            `${year}`;

          const isPast = specificDate < today;

          const slotsContainer = document.createElement("div");
          slotsContainer.classList.add("slots-container");

          // ============================================================
          // STANDARD WEDNESDAY / SATURDAY
          // ============================================================

          if (dayOfWeek === 3 || dayOfWeek === 6) {

            grades.forEach((grade) => {

              /*
              * Find ALL booking keys matching:
              *
              * DD-MM-YYYY_GRADE_unique
              *
              * Example:
              * 29-09-2026_E_34444
              * 29-09-2026_E_565656
              */

              const keyPrefix = `${dateISO}_${grade}_`;

              const matchingBookings = Object.entries(globalBookings || {})
                .filter(([key]) => key.startsWith(keyPrefix));


              // --------------------------------------------------------
              // There are bookings for this date/grade
              // --------------------------------------------------------

              if (matchingBookings.length > 0) {

                matchingBookings.forEach(([key, bookedData]) => {

                  const slotEl = document.createElement("div");

                  slotEl.classList.add(
                    "slot",
                    `grade-${grade}`,
                    "booked"
                  );

                  /*
                  * Get the Walk ID from:
                  *
                  * DD-MM-YYYY_GRADE_WALKID
                  */
                  const walkID = bookedData.walk_number;

                  slotEl.innerText =
                    `${grade} Booked: ${bookedData.walk_number || walkID}`;

                  slotEl.title =
                    `Leader: ${bookedData.leader_name || ""} | ` +
                    `Pueblo: ${bookedData.pueblo || ""}`;

                  if (isPast) {
                    slotEl.classList.add("past");
                  } else {
                    slotEl.addEventListener("click", () =>
                      openBookingModal(
                        dateISO,
                        grade,
                        bookedData,
                        walkID
                      )
                    );
                  }

                  slotsContainer.appendChild(slotEl);
                });

              }

              // --------------------------------------------------------
              // No bookings - show available slot
              // --------------------------------------------------------

              else {

                const slotEl = document.createElement("div");

                slotEl.classList.add(
                  "slot",
                  `grade-${grade}`
                );

                if (isPast) {

                  slotEl.classList.add("past");
                  slotEl.innerText = grade;

                } else if (isPaused) {

                  slotEl.classList.add("unavailable");
                  slotEl.innerText = `${grade} Unavailable`;

                } else {

                  slotEl.classList.add("available");
                  slotEl.innerText = `${grade} Available`;

                  slotEl.addEventListener("click", () =>
                    openBookingModal(dateISO, grade)
                  );
                }

                slotsContainer.appendChild(slotEl);
              }

            });
          }


          // ============================================================
          // AD HOC WALKS
          // ============================================================

          else {

            grades.forEach((grade) => {

              const keyPrefix = `${dateISO}_${grade}_`;

              const matchingBookings = Object.entries(globalBookings || {})
                .filter(([key]) => key.startsWith(keyPrefix));


              /*
              * Ad hoc days only display slots that actually exist
              * in Firebase.
              */

              matchingBookings.forEach(([key, bookedData]) => {

                const walkID = key.substring(keyPrefix.length);

                const slotEl = document.createElement("div");

                slotEl.classList.add(
                  "slot",
                  `grade-${grade}`,
                  "booked"
                );

                slotEl.innerText =
                  `${grade} Booked: ${bookedData.walk_number || walkID}`;

                slotEl.title =
                  `Leader: ${bookedData.leader_name || ""} | ` +
                  `Pueblo: ${bookedData.pueblo || ""}`;

                if (isPast) {
                  slotEl.classList.add("past");
                } else {
                  slotEl.addEventListener("click", () =>
                    openBookingModal(
                      dateISO,
                      grade,
                      bookedData,
                      walkID
                    )
                  );
                }

                slotsContainer.appendChild(slotEl);
              });

            });
          }


          // Add slots to day
          dayCell.appendChild(slotsContainer);

          // Add day to calendar
          daysGrid.appendChild(dayCell);
        }
      }
      /* ========================================================= ADMIN TABLE ========================================================= */ 
    function renderAdminTable() {
      adminTableBody.innerHTML = "";
      const sortedKeys = Object.keys(globalBookings).sort();
      if (!sortedKeys.length) {
        adminTableBody.innerHTML = ` <tr> <td colspan="10" style=" text-align:center; color:var(--text-muted) "> No walks recorded. </td> </tr> `;
        return;
      }
      sortedKeys.forEach((key) => {
        const record = globalBookings[key];
        const tr = document.createElement("tr");
        tr.innerHTML = ` <td> <strong> ${record.date} </strong> </td> <td> ${record.start_time || "-"} </td> <td> <span class="badge grade-${record.walk_grade}"> ${record.walk_grade} </span> </td> <td> ${record.walk_number || "-"} </td> <td> ${record.leader_name || "-"} </td> <td> ${record.owner || "-"} </td> <td> ${record.pueblo || "-"} </td> <td> ${record.comments || "-"} </td> <td> <button class="btn btn-success" data-key="${key}"> Edit </button> </td> <td> <button class="btn btn-danger" data-key="${key}"> Cancel </button> </td> `;
        tr.querySelector(".btn-success").addEventListener("click", () =>
          openBookingModal(record.date, record.walk_grade, record, record.walk_number),
        );
        tr.querySelector(".btn-danger").addEventListener("click", () => {
          if (confirm(`Cancel walk ${record.walk_number}?`)) {
            saveBookingRecord(key, null);
          }
        });
        adminTableBody.appendChild(tr);
      });
    }
    // Wait for the window to load, then attach the listener
window.addEventListener('DOMContentLoaded', () => {
    const checkbox = document.getElementById('modeCheckBox');
    
    checkbox.addEventListener('change', function() {
        console.log("Checkbox state is: ", this.checked);
        // Put your toggle logic here
        renderCalendar();
    });
});
    /* ========================================================= MODAL ========================================================= */
    function openBookingModal(
      dateString,
      grade,
      existingData = null,
      walkNum
    ) {
      let uniqueValue = null;
      let admin = false;

      if (dateString === "" && grade === "" && !existingData) {
        admin = true;
      }
 
      // 1. Reset the form FIRST so custom default injections aren't immediately wiped out
      if (!existingData) {
        bookingForm.reset();
        uniqueValue = crypto.randomUUID();
        document.getElementById('modalHiddenValue').value = uniqueValue || ""; // Inject the value safely
      } else {
        document.getElementById('modalHiddenValue').value = existingData.unique_id || ""; // Inject the value safely
      }
      const isPaused = document.getElementById("modeCheckBox") ? document.getElementById("modeCheckBox").checked : false;
      const adminView = document.getElementById("viewToggle") ? document.getElementById("viewToggle").checked : false;

      document.getElementById("input-date").value = dateString;
      // 2. Cache DOM Elements for performance and cleaner code
      const dateInput = document.getElementById("input-date");
      const gradeAtt = document.getElementById("input-grade");
      const commentsInput = document.getElementById("input-comments");
      const notesInput = document.getElementById("input-notes");

      // 3. Handle Admin Permissions & Locks
      if (admin) {
        dateInput.removeAttribute('readonly');
        gradeAtt.value = "M";
        gradeAtt.disabled = false;
      } else {
        dateInput.setAttribute('readonly', 'true');
        gradeAtt.value = grade;
        gradeAtt.disabled = true;
      }

      // 4. Populate Form Data
      if (existingData) {
        modalHeading.innerText = "Edit Walk Parameters";
        document.getElementById("input-walk-no").value = existingData.walk_number || "";
        document.getElementById("input-leader").value = existingData.leader_name || "";
        document.getElementById("input-owner").value = existingData.owner || "";
        document.getElementById("input-pueblo").value = existingData.pueblo || "";
        document.getElementById("input-start-time").value = existingData.start_time || "";

        // Clean textareas of stringified whitespaces or fallback cleanly to expose placeholders
        commentsInput.value = (existingData.comments && existingData.comments.trim()) || "";
        notesInput.value = (existingData.notes && existingData.notes.trim()) || "";
      } else {
        modalHeading.innerText = "Book Walk Slot";
        dateInput.value = dateString;
        gradeAtt.value = grade;

        // Explicitly guarantee textareas are empty string to force placeholder visibility
        commentsInput.value = "";
        notesInput.value = "";
      }
       const button = document.getElementById("submit-booking");
       button.disabled = false;
      if(isPaused && !adminView){       
          button.disabled = true;
      }
      // 5. Open Modal
      modal.classList.add("active");
    }
    function closeModal() {
      modal.classList.remove("active");
    
    }
      /* ========================================================= BOOKING FORM ========================================================= */ bookingForm.addEventListener(
      "submit",
      (e) => {
        e.preventDefault();
        const dateStr = document.getElementById("input-date").value;
        const gradeStr = document.getElementById("input-grade").value;
        const walkNum = document.getElementById("input-walk-no").value;
        const uniqueID = document.getElementById("modalHiddenValue").value;
        console.log("key: ", uniqueID);
        const compositeKey = `${dateStr}_${gradeStr}_${uniqueID}`;

        const payload = {
          date: dateStr,
          walk_grade: gradeStr,
          walk_number: walkNum,
          leader_name: document.getElementById("input-leader").value.trim(),
          owner: document.getElementById("input-owner").value.trim(),
          pueblo: document.getElementById("input-pueblo").value.trim(),
          comments: document.getElementById("input-comments").value.trim(),
          notes: document.getElementById("input-notes").value.trim(),
          unique_id: uniqueID,
          start_time: document
            .getElementById("input-start-time")
            .value.trim(),
        };
        saveBookingRecord(compositeKey, payload);
        closeModal();
      },
    );
      /* ========================================================= DATE CONVERSION ========================================================= */ function convertDate(
      dateString,
    ) {
      if (!dateString) {
        return null;
      }
        /* * Converts: * * DD-MM-YYYY * * into a JavaScript Date. */ const parts =
        dateString.split("-");
      if (parts.length !== 3) {
        return null;
      }
      return new Date(
        Number(parts[2]),
        Number(parts[1]) - 1,
        Number(parts[0]),
      );
    }
      /* ========================================================= GET FILTERED STATISTICS DATA ========================================================= */ function getStatisticsData() {
      const selectedPueblo = puebloFilter.value;
      let data = Object.values(globalBookings);
      if (selectedPueblo !== "ALL") {
        data = data.filter((item) => item.pueblo === selectedPueblo);
      }
      return data;
    }
      /* ========================================================= POPULATE PUEBLO FILTER ========================================================= */ function populatePuebloFilter() {
      const currentValue = puebloFilter.value;
      const pueblos = [
        ...new Set(
          Object.values(globalBookings)
            .map((item) => item.pueblo)
            .filter(Boolean),
        ),
      ].sort();
      puebloFilter.innerHTML = ` <option value="ALL"> All Pueblos </option> `;
      pueblos.forEach((pueblo) => {
        const option = document.createElement("option");
        option.value = pueblo;
        option.textContent = pueblo;
        puebloFilter.appendChild(option);
      });
      if (pueblos.includes(currentValue)) {
        puebloFilter.value = currentValue;
      } else {
        puebloFilter.value = "ALL";
      }
    }
      /* ========================================================= STATISTICS TOTALS ========================================================= */ function updateStatisticsTotals(
      data,
    ) {
      document.getElementById("stat-total").textContent = data.length;
      grades.forEach((grade) => {
        document.getElementById(`stat-${grade}`).textContent = data.filter(
          (item) => item.walk_grade === grade,
        ).length;
      });
    }
      /* ========================================================= MONTHLY CHART ========================================================= */ function updateMonthlyChart(
      data,
    ) {
      const monthKeys = [
        ...new Set(
          data
            .map((item) => {
              const d = convertDate(item.date);
              if (!d) {
                return null;
              }
              return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`;
            })
            .filter(Boolean),
        ),
      ].sort();
      const labels = monthKeys.map((key) => {
        const parts = key.split("-");
        const d = new Date(Number(parts[0]), Number(parts[1]) - 1, 1);
        return d.toLocaleDateString("en-GB", {
          month: "short",
          year: "numeric",
        });
      });
      const datasets = grades.map((grade) => ({
        label: grade,
        data: monthKeys.map(
          (monthKey) =>
            data.filter((item) => {
              const d = convertDate(item.date);
              if (!d) {
                return false;
              }
              const key = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}`;
              return key === monthKey && item.walk_grade === grade;
            }).length,
        ),
        backgroundColor: gradeColours[grade],
        borderWidth: 0,
      }));
      if (monthlyChart) {
        monthlyChart.destroy();
      }
      monthlyChart = new Chart(document.getElementById("monthlyChart"), {
        type: "bar",
        data: {labels: labels, datasets: datasets},
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            x: {stacked: true, grid: {display: false}},
            y: {stacked: true, beginAtZero: true, ticks: {precision: 0}},
          },
          plugins: {
            legend: {
              position: "bottom",
              labels: {usePointStyle: true, padding: 18},
            },
          },
        },
      });
    }
      /* ========================================================= LEADER TABLE ========================================================= */ function updateLeaderTable(
      data,
    ) {
      const body = document.getElementById("leader-stats-body");
      body.innerHTML = "";
      const leaders = [
        ...new Set(data.map((item) => item.leader_name).filter(Boolean)),
      ].sort();
      const grandTotals = {E: 0, M: 0, MS: 0, S: 0, VS: 0};
      leaders.forEach((leader) => {
        const leaderData = data.filter((item) => item.leader_name === leader);
        const counts = {};
        grades.forEach((grade) => {
          counts[grade] = leaderData.filter(
            (item) => item.walk_grade === grade,
          ).length;
          grandTotals[grade] += counts[grade];
        });
        const tr = document.createElement("tr");
        tr.innerHTML = ` <td> <strong> ${leader} </strong> </td> ${grades.map((grade) => ` <td class="grade-cell"> <span class="grade-count" style=" background: ${gradeColours[grade]} "> ${counts[grade]} </span> </td> `).join("")} <td style=" text-align:center; font-weight:700 "> ${leaderData.length} </td> `;
        body.appendChild(tr);
      });
      const total = Object.values(grandTotals).reduce((a, b) => a + b, 0);
      const totalRow = document.createElement("tr");
      totalRow.classList.add("total-row");
      totalRow.innerHTML = ` <td> TOTAL </td> ${grades.map((grade) => ` <td class="grade-cell"> <span class="grade-count" style=" background: ${gradeColours[grade]} "> ${grandTotals[grade]} </span> </td> `).join("")} <td style=" text-align:center "> ${total} </td> `;
      body.appendChild(totalRow);
    }
    /* ========================================================= RAW STATISTICS TABLE ========================================================= */

    function updateStatisticsTable(data) {
      const body = document.getElementById("stats-data-body");

      body.innerHTML = "";

      const sorted = sortWalkData(data);

      sorted.forEach((item) => {
        const tr = document.createElement("tr");

        tr.innerHTML = `

            <td>
                ${item.walk_number || "-"}
            </td>

            <td>
                ${item.date || "-"}
            </td>

            <td>
                ${item.start_time || "-"}
            </td>

            <td>

                <span
                    class="badge"
                    style="
                        background:
                        ${gradeColours[item.walk_grade] || "#64748b"}
                    ">

                    ${item.walk_grade || "-"}

                </span>

            </td>

            <td>
                ${item.owner || "-"}
            </td>

            <td>
                ${item.leader_name || "-"}
            </td>

            <td>
                ${item.pueblo || "-"}
            </td>

        `;

        body.appendChild(tr);
      });

      document.getElementById("stats-count").textContent = data.length;

      updateSortIndicators();
    }
      /* ========================================================= MASTER STATISTICS UPDATE ========================================================= */ function updateStatistics() {
      populatePuebloFilter();
      const data = getStatisticsData();
      updateStatisticsTotals(data);
      updateMonthlyChart(data);
      updateLeaderTable(data);
      updateStatisticsTable(data);
    }
      /* ========================================================= PUEBLO FILTER ========================================================= */ puebloFilter.addEventListener(
      "change",
      updateStatistics,
    );
      /* ========================================================= EXPORT CSV ========================================================= */ document
      .getElementById("export-csv")
      .addEventListener("click", () => {
        const records = Object.values(globalBookings);
        if (!records.length) {
          alert("No active data entries to export.");
          return;
        }
        let csv =
          "Date,Start Time,Grade,Walk Number,Leader,Owner,Pueblo,Comments\n";
        records.forEach((r) => {
          const row = [
            r.date,
            r.start_time || "",
            r.walk_grade,
            r.walk_number || "",
            r.leader_name || "",
            r.owner || "",
            r.pueblo || "",
            r.comments || "",
          ]
            .map((value) => `"${String(value).replace(/"/g, '""')}"`)
            .join(",");
          csv += row + "\n";
        });
        const blob = new Blob([csv], {type: "text/csv;charset=utf-8;"});
        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");
        link.href = url;
        link.download = "walk_bookings_export.csv";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
      });
        /* ========================================================= ADD A WALK TO THE SCHEDULER ========================================================= */ document
      .getElementById("add-walk-to-schedule")
      .addEventListener("click", () => {
        openBookingModal("", "", "", "", "", true);
      });
      /* ========================================================= CALENDAR NAVIGATION ========================================================= */ document
      .getElementById("prev-month")
      .addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
      });
    document.getElementById("next-month").addEventListener("click", () => {
      currentDate.setMonth(currentDate.getMonth() + 1);
      renderCalendar();
    });
      /* ========================================================= MODAL BUTTON ========================================================= */ document
      .getElementById("close-modal")
      .addEventListener("click", closeModal);
    document
      .getElementById("clear-all")
      .addEventListener("click", clearAllRecords);
      /* ========================================================= ADMIN TOGGLE ========================================================= */ document
      .getElementById("viewToggle")
      .addEventListener("change", function () {
        document
          .querySelector(".admin-container")
          .classList.toggle("hidden", !this.checked);
      });
   

      /* ========================================================= START ========================================================= */ initDataSync();
    /* =========================================================
WALK DATA TABLE SORTING
========================================================= */

    let walkSortColumn = "date";
    let walkSortDirection = "asc";
    const gradeSortOrder = {
      E: 1,
      M: 2,
      MS: 3,
      S: 4,
      VS: 5,
    };

    /* ---------------------------------------------------------
      Get value for sorting
      --------------------------------------------------------- */

    function getWalkSortValue(item, column) {
      switch (column) {
        case "walk_number":
          return Number(item.walk_number) || 0;

        case "date": {
          const d = convertDate(item.date);
          return d ? d.getTime() : 0;
        }
        case "time":
          return item.start_time || "";

        case "walk_grade":
          return gradeSortOrder[item.walk_grade] || 99;

        case "owner":
          return (item.owner || "").toLowerCase();

        case "leader_name":
          return (item.leader_name || "").toLowerCase();

        case "pueblo":
          return (item.pueblo || "").toLowerCase();
        default:
          return "";
      }
    }

    /* ---------------------------------------------------------
      Sort data
      --------------------------------------------------------- */

    function sortWalkData(data) {
      return [...data].sort((a, b) => {
        const valueA = getWalkSortValue(a, walkSortColumn);

        const valueB = getWalkSortValue(b, walkSortColumn);

        let result = 0;

        if (typeof valueA === "number" && typeof valueB === "number") {
          result = valueA - valueB;
        } else {
          result = String(valueA).localeCompare(String(valueB), undefined, {
            numeric: true,
            sensitivity: "base",
          });
        }

        return walkSortDirection === "asc" ? result : -result;
      });
    }

    /* ---------------------------------------------------------
      Update arrows in the header
      --------------------------------------------------------- */

    function updateSortIndicators() {
      document.querySelectorAll(".sortable-header").forEach((header) => {
        const column = header.dataset.sort;

        const indicator = header.querySelector(".sort-indicator");

        if (column === walkSortColumn) {
          indicator.textContent = walkSortDirection === "asc" ? "↑" : "↓";

          indicator.classList.add("active");
        } else {
          indicator.textContent = "↕";

          indicator.classList.remove("active");
        }
      });
    }

    /* ---------------------------------------------------------
      Header click handlers
      --------------------------------------------------------- */

    document.querySelectorAll(".sortable-header").forEach((header) => {
      header.addEventListener("click", () => {
        const column = header.dataset.sort;

        if (walkSortColumn === column) {
          walkSortDirection = walkSortDirection === "asc" ? "desc" : "asc";
        } else {
          walkSortColumn = column;

          walkSortDirection = "asc";
        }

        updateStatistics();
      });
    });

    updateSortIndicators();
    /* =========================================================
 COLLAPSIBLE STATISTICS SECTIONS
 ========================================================= */

    function setupCollapsibleSection(container, header, button) {
      function toggleSection(event) {
        /*
         * Prevent an inner section click from
         * bubbling to an outer section.
         */

        if (event) {
          event.stopPropagation();
        }

        const collapsed = container.classList.toggle("collapsed");

        button.setAttribute(
          "aria-label",
          collapsed ? "Expand section" : "Collapse section",
        );
      }

      header.addEventListener("click", toggleSection);

      /*
       * Stop the button from causing
       * a second header click.
       */

      button.addEventListener("click", (event) => {
        event.stopPropagation();

        toggleSection();
      });
    }

    /* =========================================================
 MAIN STATISTICS DASHBOARD
 ========================================================= */

    const statisticsDashboard = document.getElementById(
      "statistics-dashboard",
    );

    setupCollapsibleSection(
      statisticsDashboard,

      statisticsDashboard.querySelector(".stats-header"),

      statisticsDashboard.querySelector(".stats-header .collapse-button"),
    );

    /* =========================================================
 INNER STATISTICS SECTIONS
 ========================================================= */

    document
      .querySelectorAll("#statistics-dashboard .stats-section")
      .forEach((section) => {
        setupCollapsibleSection(
          section,

          section.querySelector(".stats-section-header"),

          section.querySelector(".stats-section-header .collapse-button"),
        );
      });
    

  </script>
  <script src="https://github.io"></script>

</body>
