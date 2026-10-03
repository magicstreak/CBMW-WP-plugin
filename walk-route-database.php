<?php
if (!defined('ABSPATH')) { exit; }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walking Routes Manager</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            margin: 2rem;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }
        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            font-weight: bold;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }
        .status-local {
            background-color: #ffeaa7;
            color: #d63031;
        }
        .status-firebase {
            background-color: #e3faf2;
            color: #2ecc71;
        }
        .btn {
            background-color: #3498db;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            white-space: nowrap;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .btn-danger {
            background-color: #e74c3c;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .btn-secondary {
            background-color: #95a5a6;
        }
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        
        .table-container {
            width: 100%;
            overflow-x: auto;
            margin-top: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border-radius: 4px;
            background: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1300px;
        }
        th, td {
            padding: 0.75rem 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 0.9rem;
        }
        th {
            background-color: #f4f6f7;
            color: #34495e;
            font-weight: 600;
        }
        .actions-cell {
            display: flex;
            gap: 0.5rem;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            width: 100%;
            max-width: 650px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .modal h2 {
            margin-top: 0;
            margin-bottom: 1.5rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-group {
            margin-bottom: 0.5rem;
        }
        .form-group.full-width {
            grid-column: span 2;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.25rem;
            font-weight: 500;
            font-size: 0.85rem;
        }
        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-family: inherit;
            font-size: 0.9rem;
        }
        .form-group textarea {
            resize: vertical;
            height: 60px;
        }
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>

    <h1>Walking Routes Dashboard</h1>
    <div id="storageStatus" class="status-badge">Detecting environment...</div>
    
    <div>
        <button class="btn" id="addRouteBtn">Add New Route</button>
    </div>

    <div class="table-container">
        <table id="routesTable">
            <thead>
                <tr>
                    <th>Walk Number</th>
                    <th>Route Name</th>
                    <th>Grade</th>
                    <th>Distance</th>
                    <th>Ascent</th>
                    <th>Terrain</th>
                    <th>Scr</th>
                    <th>Time</th>
                    <th>Owner</th>
                    <th>Description</th>
                    <th>Directions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="routesTableBody">
                <tr><td colspan="12" style="text-align:center;">Loading application...</td></tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Form for Add/Edit -->
    <div class="modal-overlay" id="routeModal">
        <div class="modal">
            <h2 id="modalTitle">Add Route</h2>
            <form id="routeForm">
                <input type="hidden" id="routeId">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="walkID">Route Number</label>
                        <input type="text" id="walkID" required placeholder="e.g. R-01">
                    </div>
                    <div class="form-group">
                        <label for="Route_Name">Route Name</label>
                        <input type="text" id="Route_Name" required>
                    </div>
                    <div class="form-group">
                        <label for="Grade">Grade</label>
                        <select id="Grade">
                            <option value="E">E</option>
                            <option value="M">M</option>
                            <option value="MS">MS</option>
                            <option value="S">S</option>
                            <option value="VS">VS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Distance">Distance</label>
                        <input type="text" id="Distance" required placeholder="e.g. 5.4 km">
                    </div>
                    <div class="form-group">
                        <label for="Ascent">Ascent</label>
                        <input type="text" id="Ascent" placeholder="e.g. 230m">
                    </div>
                    <div class="form-group">
                        <label for="Terrain">Terrain</label>
                        <select id="Terrain">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="X">X</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Scr">Scr (Score)</label>
                        <select id="Scr">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="3+">3+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Total_Time">Time (Duration)</label>
                        <input type="text" id="Total_Time" required placeholder="e.g. 2h 30m">
                    </div>
                    <div class="form-group full-width">
                        <label for="Leader">Leader</label>
                        <input type="text" id="Leader" required placeholder="Author or organization name">
                    </div>
                    <div class="form-group full-width">
                        <label for="Route_Description">Route Description</label>
                        <textarea id="Route_Description" placeholder="Brief summary of path features..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="Directions">Directions</label>
                        <textarea id="Directions" placeholder="Step-by-step path logs..."></textarea>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn" id="saveBtn">Save Route</button>
                </div>
            </form>
        </div>
    </div>

    <script type="module">
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        const firebaseConfig = {
        apiKey: "AIzaSyB9WLJSl4QmubgBW5rknmnMeHcNbkwqOHQ",
        authDomain: "programme-planning.firebaseapp.com",
        databaseURL: "https://programme-planning-default-rtdb.europe-west1.firebasedatabase.app",
        projectId: "programme-planning",
        storageBucket: "programme-planning.firebasestorage.app",
        messagingSenderId: "1028011310189",
        appId: "1:1028011310189:web:8ac4f37a8d248899735364",
        measurementId: "G-BBQ4Q6TQHD"
        };

        const storageStatus = document.getElementById('storageStatus');
        const routeModal = document.getElementById('routeModal');
        const routeForm = document.getElementById('routeForm');
        const modalTitle = document.getElementById('modalTitle');
        const routeIdInput = document.getElementById('routeId');
        
        const fields = ['walkID', 'Route_Name', 'Route_Description', 'Grade', 'Distance', 'Ascent', 'Terrain', 'Scr', 'Total_Time', 'Directions', 'Leader'];
        const elements = {};
        fields.forEach(f => elements[f] = document.getElementById(f));

        const routesTableBody = document.getElementById('routesTableBody');
        const addRouteBtn = document.getElementById('addRouteBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        let isTestingMode = firebaseConfig.apiKey === "YOUR_API_KEY";
        let localRoutesData = {};
        let dbService = {};

        async function initApp() {
            if (isTestingMode) {
                storageStatus.textContent = "Testing Mode: Using LocalStorage";
                storageStatus.className = "status-badge status-local";

                dbService = {
                    init: (callback) => {
                        const loadData = () => {
                            const data = JSON.parse(localStorage.getItem('walks')) || {};
                            localRoutesData = data;
                            callback(data);
                        };
                        loadData();
                        window.addEventListener('storage', loadData);
                    },
                    create: (data) => {
                       // const id = 'route_' + Date.now();
                        const id = data.walkID.trim();
                        if (!id) return Promise.reject("Route Number is required.");

                        const currentData = JSON.parse(localStorage.getItem('walks')) || {};
                        if (currentData[id]) return Promise.reject(`Route ${id} already exists.`);

                        currentData[id] = data;
                        localStorage.setItem('walks', JSON.stringify(currentData));
                        dbService.refresh();
                        return Promise.resolve();                        
                    },
                    update: (id, data) => {
                        const currentData = JSON.parse(localStorage.getItem('walks')) || {};
                        
                        // If user changes walkID during an edit, remove the old key entity
                        if (id !== data.walkID.trim()) {
                            delete currentData[id];
                        }
                        
                        const newId = data.walkID.trim();
                        currentData[newId] = data;
                        localStorage.setItem('walks', JSON.stringify(currentData));
                        dbService.refresh();
                        return Promise.resolve();
                    },
                    delete: (id) => {
                        const currentData = JSON.parse(localStorage.getItem('walks')) || {};
                        delete currentData[id];
                        localStorage.setItem('walks', JSON.stringify(currentData));
                        dbService.refresh();
                        return Promise.resolve();
                    },
                    refresh: () => {
                        const data = JSON.parse(localStorage.getItem('walks')) || {};
                        localRoutesData = data;
                        renderTable(data);
                    }
                };
                dbService.init(renderTable);

            } else {
                storageStatus.textContent = "Production Mode: Firebase Connected";
                storageStatus.className = "status-badge status-firebase";

                try {
                    const { initializeApp } = await import("https://www.gstatic.com/firebasejs/10.8.0/firebase-app.js");
                    const { getDatabase, ref, set, onValue, update, remove, get } = await import("https://www.gstatic.com/firebasejs/10.8.0/firebase-database.js");

                    const app = initializeApp(firebaseConfig);
                    const db = getDatabase(app);
                    const routesRef = ref(db, 'walks');

                    dbService = {
                        init: (callback) => {
                            onValue(routesRef, (snapshot) => {
                                const data = snapshot.val() || {};
                                localRoutesData = data;
                                callback(data);
                            });
                        },
                        create: async (data) => {
                            const id = 'walk_'+data.walkID.trim();
                            if (!id) throw new Error("Route Number is required.");
                            
                            // Check if walkID already exists before writing
                            const snapshot = await get(ref(db, `walks/${id}`));
                            if (snapshot.exists()) {
                                throw new Error(`Route ${id} already exists.`);
                            }
                            
                            return set(ref(db, `walks/${id}`), data);
                        },
                        update: async (id, data) => {
                            const newId = 'walks_'+data.walkID.trim();
                            if (id !== newId) {
                                // If primary key walkID changed, delete the old node and set the new one
                                await remove(ref(db, `walks/${id}`));
                                return set(ref(db, `walks/${newId}`), data);
                            }
                            return update(ref(db, `walks/${id}`), data);
                        },
                        delete: (id) => remove(ref(db, `walks/${id}`))
                    };
                    dbService.init(renderTable);
                } catch (error) {
                    console.error("Firebase module fallback initialization failure:", error);
                    routesTableBody.innerHTML = `<tr><td colspan="12" style="color:red; text-align:center;">Failed to initialize database connection.</td></tr>`;
                }
            }
        }

        function renderTable(data) {
            routesTableBody.innerHTML = '';
            
            if (Object.keys(data).length === 0) {
                routesTableBody.innerHTML = `<tr><td colspan="12" style="text-align:center;">No routes found. Click 'Add New Route' to start testing.</td></tr>`;
                return;
            }

            Object.keys(data).forEach((key) => {
                
                const route = data[key];
                const tr = document.createElement('tr');
                
                tr.innerHTML = `
                    <td><strong>${escapeHtml(route.walkID || '')}</strong></td>
                    <td>${escapeHtml(route.Route_Name || '')}</td>
                    <td><span style="font-size:0.8rem; padding:2px 6px; border-radius:3px; background:#eee;">${escapeHtml(route.Grade || 'E')}</span></td>
                    <td>${escapeHtml(route.Distance || '')}</td>
                    <td>${escapeHtml(route.Ascent || '-')}</td>
                    <td><span style="font-size:0.8rem; padding:2px 6px; border-radius:3px; background:#e0f7fa;">${escapeHtml(route.Terrain || 'A')}</span></td>
                    <td>${escapeHtml(route.Scr || '0')}</td>
                    <td>${escapeHtml(route.Total_Time || '')}</td>
                    <td>${escapeHtml(route.Leader || '')}</td>
                    <td title="${escapeHtml(route.Route_Description || '')}">${truncateText(route.Route_Description || '-', 20)}</td>
                    <td title="${escapeHtml(route.Directions || '')}">${truncateText(route.Directions || '-', 20)}</td>
                    <td class="actions-cell">
                        <button class="btn edit-btn" data-id="${key}">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="${key}">Delete</button>
                    </td>
                `;
                routesTableBody.appendChild(tr);
            });

            attachRowEventListeners();
        }

        addRouteBtn.addEventListener('click', () => {
            routeForm.reset();
            routeIdInput.value = '';
            modalTitle.textContent = 'Create New Walking Profile';
            routeModal.style.display = 'flex';
        });

        cancelBtn.addEventListener('click', () => {
            routeModal.style.display = 'none';
        });

        routeForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const id = routeIdInput.value;
            const routeData = {};
            fields.forEach(f => {
                routeData[f] = elements[f].value;
            });

            const action = id ? dbService.update(id, routeData) : dbService.create(routeData);
            
            action
                .then(() => routeModal.style.display = 'none')
                .catch((err) => console.error("Database operation failed:", err));
        });

        function attachRowEventListeners() {
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    
                    const id = e.target.getAttribute('data-id');
                    const route = localRoutesData[id];
                     
                    if (route) {
                        routeIdInput.value = id;
                            fields.forEach(f => {
                            elements[f].value = route[f] || '';
                        });
                        modalTitle.textContent = `Edit Profile: ${route.routeName}`;
                        routeModal.style.display = 'flex';
                    }
                });
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const id = e.target.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this route profile?')) {
                        dbService.delete(id).catch((err) => console.error("Deletion failed:", err));
                    }
                });
            });
        }

        function escapeHtml(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function truncateText(str, maxLen) {
            if (str.length <= maxLen) return str;
            return str.substr(0, maxLen) + '...';
        }

        initApp();
    </script>
</body>
