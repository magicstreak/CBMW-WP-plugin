<?php
if (!defined('ABSPATH')) { exit; }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 p-4 md:p-8 font-sans">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- HEADER BLOCK -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white border border-slate-200 p-6 rounded-xl shadow-sm gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Walk Popularity Analytics Dashboard</h1>
                <p class="text-xs text-slate-500 mt-0.5">Interactive performance tracking registry system.</p>
            </div>
            <div class="bg-amber-500 text-white p-3 rounded-lg flex items-center gap-2 text-xs font-bold">
                <span>🏆 Activity Rank:</span> Grace Morris (28 Walkers - Lliber Llomas de L’Agre)
            </div>
        </div>

        <!-- MATRIX STATISTICS LAYER -->
        <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm overflow-x-auto">
            <h2 class="font-bold text-slate-700 text-sm mb-3">📊 Grade Scale & Attendance Summary Breakdown</h2>
            <table class="w-full text-xs text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200">
                        <th class="p-2.5">Grade Scale</th>
                        <th class="p-2.5">Associated Color Theme</th>
                        <th class="p-2.5 text-center">Scheduled Walks</th>
                        <th class="p-2.5 text-center">Completed Walks</th>
                        <th class="p-2.5 text-center">Cancelled Walks</th>
                        <th class="p-2.5 text-right">Total Walk Attendance Count</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    <tr><td class="p-2.5 font-bold">E</td><td class="p-2.5 text-green-600">Green</td><td class="p-2.5 text-center">7 Walks</td><td class="p-2.5 text-center">7</td><td class="p-2.5 text-center">0</td><td class="p-2.5 text-right font-bold">137 Walkers</td></tr>
                    <tr><td class="p-2.5 font-bold">M</td><td class="p-2.5 text-blue-600">Blue</td><td class="p-2.5 text-center">29 Walks</td><td class="p-2.5 text-center">25</td><td class="p-2.5 text-center text-red-500">4</td><td class="p-2.5 text-right font-bold">426 Walkers</td></tr>
                    <tr><td class="p-2.5 font-bold">MS</td><td class="p-2.5 text-red-600">Red</td><td class="p-2.5 text-center">41 Walks</td><td class="p-2.5 text-center">34</td><td class="p-2.5 text-center text-red-500">7</td><td class="p-2.5 text-right font-bold">412 Walkers</td></tr>
                    <tr><td class="p-2.5 font-bold">S</td><td class="p-2.5 text-purple-600">Deep Purple</td><td class="p-2.5 text-center">21 Walks</td><td class="p-2.5 text-center">14</td><td class="p-2.5 text-center text-red-500">7</td><td class="p-2.5 text-right font-bold">114 Walkers</td></tr>
                    <tr><td class="p-2.5 font-bold">VS</td><td class="p-2.5 text-slate-800">Black</td><td class="p-2.5 text-center">6 Walks</td><td class="p-2.5 text-center">2</td><td class="p-2.5 text-center text-red-500">4</td><td class="p-2.5 text-right font-bold">8 Walkers</td></tr>
                    <tr class="bg-slate-50 font-bold text-slate-900 border-t border-slate-200">
                        <td class="p-2.5">Totals</td><td class="p-2.5 text-slate-400">—</td><td class="p-2.5 text-center">104 Walks</td><td class="p-2.5 text-center">82</td><td class="p-2.5 text-center text-red-600">22</td><td class="p-2.5 text-right text-indigo-600">1,097 Walkers</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- VISUALS GRID LAYOUT BLOCK -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- TIMELINE GRAPH CONTAINER -->
            <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm flex flex-col">
                <div class="mb-2">
                    <h3 class="text-sm font-bold text-slate-700">📉 Monthly Historical Walk Attendance Trend Line</h3>
                    <p class="text-[11px] text-slate-400">Turnout trends with monthly averages shown on tooltip hover.</p>
                </div>
                <div class="bg-slate-50 px-3 py-1.5 rounded border border-slate-100 flex items-center gap-2 mb-3 text-xs font-semibold text-slate-700">
                    <input type="checkbox" id="chkTotalOnly" onchange="filterLineTrend()">
                    <label for="chkTotalOnly" class="cursor-pointer">Hide All Lines Except Total</label>
                </div>
                <div class="relative h-64"><canvas id="canvasLine"></canvas></div>
            </div>

            <!-- LEADERS BREAKDOWN CONTAINER -->
            <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm flex flex-col">
                <div class="mb-2">
                    <h3 class="text-sm font-bold text-slate-700">👥 Walk Attendance Breakdown Matrix by Leader</h3>
                    <p class="text-[11px] text-slate-400">Toggle categories below to filter leader distribution segments.</p>
                </div>
                <div class="bg-slate-50 p-2 rounded border border-slate-100 flex gap-3 mb-3 text-xs font-bold text-slate-600">
                    <label class="text-green-600"><input type="checkbox" class="chk-g" value="E" checked onchange="updateBars()"> E</label>
                    <label class="text-blue-600"><input type="checkbox" class="chk-g" value="M" checked onchange="updateBars()"> M</label>
                    <label class="text-red-600"><input type="checkbox" class="chk-g" value="MS" checked onchange="updateBars()"> MS</label>
                    <label class="text-purple-600"><input type="checkbox" class="chk-g" value="S" checked onchange="updateBars()"> S</label>
                    <label class="text-slate-800"><input type="checkbox" class="chk-g" value="VS" checked onchange="updateBars()"> VS</label>
                </div>
                <div class="overflow-y-auto max-h-64 border border-slate-100 rounded bg-slate-50 p-1">
                    <div style="height: 1000px; position: relative;"><canvas id="canvasBars"></canvas></div>
                </div>
            </div>
        </div>

        <!-- SEARCHABLE AND SORTABLE LEDGER DATABASE GRID TABLE -->
        <div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
            <div class="mb-3">
                <h3 class="text-sm font-bold text-slate-700">📋 Complete Historical Session Ledger Registry</h3>
                <p class="text-[11px] text-slate-400">Click column labels to sort rows. Extract active tables instantly to CSV spreadsheets.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-between gap-3 bg-slate-50 p-3 rounded-lg border border-slate-100 mb-4 text-xs font-semibold text-slate-700">
                <div class="flex flex-wrap gap-2 items-center">
                    <input type="text" id="queryInput" placeholder="Search leader, walk, pueblo..." class="p-1.5 border border-slate-200 bg-white rounded w-52 font-medium" oninput="drawTable()">
                    <select id="statusSelect" class="p-1.5 border border-slate-200 bg-white rounded" onchange="drawTable()">
                        <option value="all">Show All Walks</option>
                        <option value="cancelled">Show Cancelled Walks Only</option>
                    </select>
                </div>
                <button onclick="exportCSV()" class="bg-green-600 text-white font-bold px-3 py-1.5 rounded shadow cursor-pointer hover:bg-green-700">
                    💾 Export Filtered Table to CSV
                </button>
            </div>

            <div class="overflow-x-auto border border-slate-200 rounded-lg">
                <table class="w-full text-xs text-left border-collapse" id="mainTable">
                    <thead>
                        <tr class="bg-slate-100 text-slate-600 font-bold border-b border-slate-200 cursor-pointer select-none">
                            <th class="p-2.5" onclick="triggerSort('date')">Date <span id="s-date">↕</span></th>
                            <th class="p-2.5" onclick="triggerSort('leader')">Leader Name(s) <span id="s-leader">↕</span></th>
                            <th class="p-2.5 text-center" onclick="triggerSort('walk_no')">Walk No <span id="s-walk_no">↕</span></th>
                            <th class="p-2.5" onclick="triggerSort('walk_name')">Walk Name <span id="s-walk_name">↕</span></th>
                            <th class="p-2.5" onclick="triggerSort('pueblo')">Pueblo <span id="s-pueblo">↕</span></th>
                            <th class="p-2.5 text-center" onclick="triggerSort('grade')">Grade <span id="s-grade">↕</span></th>
                            <th class="p-2.5 text-center" onclick="triggerSort('walkers')">Walkers <span id="s-walkers">↕</span></th>
                            <th class="p-2.5">Operational Status Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium" id="tableBody"></tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        const rawJsonStream = [{"date": "2026-02-04", "leader": "Angela Colgate", "walk_no": "471", "walk_name": "Lliber Wander", "pueblo": "Lliber", "grade": "E", "walkers": 11, "cancelled": false, "notes": ""}, {"date": "2026-02-04", "leader": "Grace Morris", "walk_no": "236", "walk_name": "Lliber Llomas de L’Agre Circuit", "pueblo": "Lliber", "grade": "M", "walkers": 28, "cancelled": false, "notes": ""}, {"date": "2026-02-04", "leader": "Tracy Hui-Szostek", "walk_no": "105", "walk_name": "Lliber, Tossal Pla and Muntanyet circuit", "pueblo": "Lliber", "grade": "S", "walkers": 14, "cancelled": false, "notes": ""}, {"date": "2026-02-07", "leader": "Katy Phipps", "walk_no": "480", "walk_name": "NEW WALK Forna countryside", "pueblo": "Forna", "grade": "M", "walkers": 43, "cancelled": false, "notes": ""}, {"date": "2026-02-07", "leader": "Fer Schenk", "walk_no": "336", "walk_name": "Ѧ Penyo Mulero – Counterclockwise Ѧ", "pueblo": "Guadalest", "grade": "MS", "walkers": 18, "cancelled": false, "notes": ""}, {"date": "2026-02-07", "leader": "Hazel & Richard Marsden", "walk_no": "146", "walk_name": "Ѧ Aitana, & Penya Mulero Ѧ", "pueblo": "Benifato", "grade": "S", "walkers": 14, "cancelled": false, "notes": ""}, {"date": "2026-02-11", "leader": "Jane & Mark Smith", "walk_no": "55", "walk_name": "Tossal del Moro from Gata de Gorgos", "pueblo": "Gata de Gorgos", "grade": "M", "walkers": 30, "cancelled": false, "notes": ""}, {"date": "2026-02-11", "leader": "Ange Elliott", "walk_no": "13", "walk_name": "Les Planises from Jalon (Spring Leg Stretcher)", "pueblo": "Xaló / Jalón", "grade": "MS", "walkers": 19, "cancelled": false, "notes": ""}, {"date": "2026-02-11", "leader": "Fer Schenk", "walk_no": "363", "walk_name": "Sierra Helada circuit from Albir", "pueblo": "Albir", "grade": "S", "walkers": 9, "cancelled": false, "notes": ""}, {"date": "2026-02-18", "leader": "Joan & Fergus Fitzpatrick", "walk_no": "230", "walk_name": "Alcalali - Almond Blossom circuit", "pueblo": "Alcalalí", "grade": "E", "walkers": 31, "cancelled": false, "notes": ""}, {"date": "2026-02-18", "leader": "Pauline & Rob Chalmers", "walk_no": "", "walk_name": "Spring Festival Moderate Walk", "pueblo": "Xaló / Jalón", "grade": "M", "walkers": 24, "cancelled": false, "notes": ""}, {"date": "2026-02-18", "leader": "Sarah Kennedy", "walk_no": "104", "walk_name": "Mirador Coll de Rates from Alcalalí, via Mosqueres, Camí de la Pansa, Camí de Tárbena & Mestre", "pueblo": "Alcalalí", "grade": "MS", "walkers": 16, "cancelled": false, "notes": ""}, {"date": "2026-02-21", "leader": "Theresa & David Brain", "walk_no": "163", "walk_name": "La Nucia, Elian’s School to Carp Pond", "pueblo": "La Nucia", "grade": "M", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-02-21", "leader": "Veronica & Martin Dunkley", "walk_no": "268", "walk_name": "Rotova Castle Circuit", "pueblo": "Rotova", "grade": "MS", "walkers": 16, "cancelled": false, "notes": ""}, {"date": "2026-02-21", "leader": "Fer Schenk", "walk_no": "377", "walk_name": "Vall del Estre short circuit", "pueblo": "Calp / Calpe", "grade": "S", "walkers": 4, "cancelled": false, "notes": ""}, {"date": "2026-02-21", "leader": "Paul Elliott", "walk_no": "479", "walk_name": "Cabello verde ridge (west to east) - extended (the more difficult option)", "pueblo": "Benimaurell", "grade": "S", "walkers": 4, "cancelled": false, "notes": ""}, {"date": "2026-02-21", "leader": "Brian Sear", "walk_no": "", "walk_name": "Granadella Extended", "pueblo": "javea", "grade": "M", "walkers": 7, "cancelled": false, "notes": ""}, {"date": "2026-02-25", "leader": "Les Morris", "walk_no": "202", "walk_name": "Orbeta Seguili circuit", "pueblo": "Orbeta", "grade": "M", "walkers": 16, "cancelled": false, "notes": ""}, {"date": "2026-02-25", "leader": "John & Clodagh Mail", "walk_no": "152", "walk_name": "Partagat-Confrides Castle circuit", "pueblo": "Benifato", "grade": "MS", "walkers": 16, "cancelled": false, "notes": ""}, {"date": "2026-02-25", "leader": "Klaus Frommel", "walk_no": "251", "walk_name": "Ѧ El Cau (Lloma Larga) Ѧ", "pueblo": "Benissa", "grade": "MS", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-02-28", "leader": "Theresa & David Brain", "walk_no": "90", "walk_name": "Parcent to Murla circular stroll.", "pueblo": "Parcent", "grade": "M", "walkers": 18, "cancelled": false, "notes": ""}, {"date": "2026-02-28", "leader": "Pauline & Rob Chalmers", "walk_no": "199", "walk_name": "Vall d'Ebo, Cova Blanca, Refugi de la Figuereta", "pueblo": "Vall d'Ebo", "grade": "MS", "walkers": 10, "cancelled": false, "notes": ""}, {"date": "2026-02-28", "leader": "Fer Schenk", "walk_no": "171", "walk_name": "Ѧ Alfaro & Barranco Malafi Ѧ", "pueblo": "Benigembla", "grade": "S", "walkers": 11, "cancelled": false, "notes": ""}, {"date": "2026-03-04", "leader": "Thijs Broer", "walk_no": "365a", "walk_name": "Serra de Besa circuit (from Tourist Info Vall de Pop)", "pueblo": "Xaló / Jalón", "grade": "M", "walkers": 13, "cancelled": false, "notes": ""}, {"date": "2026-03-04", "leader": "Tracy Hui-Szostek", "walk_no": "402", "walk_name": "Circuit of Barranc del Cau and Alt de Ample from Jalon", "pueblo": "Xaló / Jalón", "grade": "MS", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-03-04", "leader": "Klaus Frommel", "walk_no": "437", "walk_name": "Monte Castellet Long Circuit", "pueblo": "Finestrat", "grade": "VS", "walkers": 0, "cancelled": false, "notes": ""}, {"date": "2026-03-07", "leader": "Sarah & Steve Kennedy", "walk_no": "191", "walk_name": "Moli de Quisi circuit from Benissa", "pueblo": "Benissa", "grade": "M", "walkers": 0, "cancelled": false, "notes": ""}, {"date": "2026-03-07", "leader": "Ralph Phipps", "walk_no": "54", "walk_name": "Penon de Mediodia", "pueblo": "Vall d'Ebo", "grade": "MS", "walkers": 12, "cancelled": false, "notes": ""}, {"date": "2026-03-07", "leader": "Pauline & Rob Chalmers", "walk_no": "200", "walk_name": "Solana de la Canal to Cova Blanca", "pueblo": "Pego", "grade": "S", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-03-11", "leader": "Joan & Fergus Fitzpatrick", "walk_no": "581", "walk_name": "Segaria western exploration", "pueblo": "Benimeli", "grade": "M", "walkers": 12, "cancelled": false, "notes": ""}, {"date": "2026-03-13", "leader": "Jane & Mark Smith", "walk_no": "168", "walk_name": "Serrellas Circuit", "pueblo": "Gata de Gorgos", "grade": "MS", "walkers": 9, "cancelled": false, "notes": ""}, {"date": "2026-03-11", "leader": "John & Clodagh Mail", "walk_no": "264", "walk_name": "Foyes Valley Extended (Clockwise)", "pueblo": "Castell de Castells", "grade": "MS", "walkers": 0, "cancelled": false, "notes": ""}, {"date": "2026-03-11", "leader": "Fer Schenk", "walk_no": "342", "walk_name": "Ѧ Pla de la Casa circuit from the south Ѧ", "pueblo": "Confrides", "grade": "S", "walkers": 0, "cancelled": true, "notes": "cancelled"}, {"date": "2026-03-14", "leader": "Angela Colgate", "walk_no": "19", "walk_name": "Hills around Aldea de las Cuevas", "pueblo": "Benidoleig", "grade": "M", "walkers": 7, "cancelled": false, "notes": ""}, {"date": "2026-03-14", "leader": "Bernard Szostek", "walk_no": "290", "walk_name": "Ѧ Caballo Verde Ridge (west to east) Extended (the easier option) Ѧ", "pueblo": "Benimaurell", "grade": "MS", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-03-14", "leader": "Ralph Phipps", "walk_no": "281", "walk_name": "Serra del Mirant", "pueblo": "Benialí", "grade": "S", "walkers": 8, "cancelled": false, "notes": ""}, {"date": "2026-03-18", "leader": "Grace Morris", "walk_no": "98", "walk_name": "Font Mata and Beyond", "pueblo": "Benissa", "grade": "S", "walkers": 22, "cancelled": false, "notes": ""}, {"date": "2026-03-18", "leader": "Bernard Szostek", "walk_no": "141", "walk_name": "Tossal Trails Extra", "pueblo": "Benissa", "grade": "MS", "walkers": 18, "cancelled": false, "notes": ""}, {"date": "2026-03-18", "leader": "John & Clodagh Mail", "walk_no": "56", "walk_name": "Maigmó Circuit via the Via Verde", "pueblo": "Tibi", "grade": "S", "walkers": 6, "cancelled": false, "notes": ""}, {"date": "2026-03-21", "leader": "Sylvia & Thijs Broer", "walk_no": "462", "walk_name": "Javea La Plana from the Port, clockwise", "pueblo": "Xàbia / Jávea", "grade": "M", "walkers": 21, "cancelled": false, "notes": ""}, {"date": "2026-03-21", "leader": "Aidan & Gillian Humphries", "walk_no": "364", "walk_name": "Soldetes Ridge", "pueblo": "Gata de Gorgos", "grade": "MS", "walkers": 14, "cancelled": true, "notes": "Walk abandoned due to heavy rain"}, {"date": "2026-03-21", "leader": "Ange Elliott", "walk_no": "288", "walk_name": "Vall d'Ebo and Back (Figure of Eight)", "pueblo": "Pego", "grade": "VS", "walkers": 7, "cancelled": false, "notes": ""}, {"date": "2026-03-25", "leader": "Bernard Szostek", "walk_no": "20", "walk_name": "Smugglers' Cove of Cala Llebeig", "pueblo": "Moraira", "grade": "M", "walkers": 0, "cancelled": false, "notes": ""}, {"date": "2026-03-25", "leader": "Les Morris", "walk_no": "374", "walk_name": "Orba Orbital", "pueblo": "Orba", "grade": "MS", "walkers": 23, "cancelled": false, "notes": ""}, {"date": "2026-03-25", "leader": "Olaf Hasse", "walk_no": "273", "walk_name": "Castell d’Aixa Circuit from Lliber", "pueblo": "Lliber", "grade": "VS", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-03-28", "leader": "Peter Greene", "walk_no": "109", "walk_name": "Iberian settlement from Los Lagos", "pueblo": "Jesus Pobre", "grade": "M", "walkers": 17, "cancelled": false, "notes": ""}, {"date": "2026-03-28", "leader": "Helen & Mike Granville", "walk_no": "116", "walk_name": "Los Cinco Pueblos de Beniali", "pueblo": "Benialí", "grade": "MS", "walkers": 28, "cancelled": false, "notes": ""}, {"date": "2026-03-28", "leader": "Sarah & Steve Kennedy", "walk_no": "35", "walk_name": "Los Tres Pueblos", "pueblo": "Tollos", "grade": "VS", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-04-01", "leader": "Peter Greene", "walk_no": "254", "walk_name": "La Montana Caseta del Moros", "pueblo": "Tarbena", "grade": "M", "walkers": 6, "cancelled": false, "notes": ""}, {"date": "2026-04-01", "leader": "Ralph Phipps", "walk_no": "291", "walk_name": "Barrancos de la Canal and Cova extended clockwise", "pueblo": "Pego", "grade": "MS", "walkers": 21, "cancelled": false, "notes": ""}, {"date": "2026-04-01", "leader": "Jo Fletcher", "walk_no": "73", "walk_name": "Sierra de Sireret", "pueblo": "Vall d'Ebo", "grade": "S", "walkers": 8, "cancelled": false, "notes": ""}, {"date": "2026-04-04", "leader": "Sylvia & Thijs Broer", "walk_no": "463", "walk_name": "El Miquelet Circular & Penya Budhista", "pueblo": "Pedreguer", "grade": "S", "walkers": 20, "cancelled": false, "notes": ""}, {"date": "2026-04-04", "leader": "Colin Read", "walk_no": "382", "walk_name": "Cim de l'Aldaia Circuit", "pueblo": "Barx", "grade": "MS", "walkers": 12, "cancelled": false, "notes": ""}, {"date": "2026-04-04", "leader": "David Harbach", "walk_no": "535", "walk_name": "Sierra del Sireret from Alcala de la Jovada", "pueblo": "Alcalà de la Jovada", "grade": "S", "walkers": 0, "cancelled": true, "notes": "cancelled"}, {"date": "2026-04-08", "leader": "Grace Morris", "walk_no": "586", "walk_name": "Mediodia low level traverse from Tormos", "pueblo": "Tormos", "grade": "M", "walkers": 20, "cancelled": false, "notes": ""}, {"date": "2026-04-08", "leader": "David Harbach", "walk_no": "2", "walk_name": "Cabo San Antonio & Watchtower", "pueblo": "Xàbia / Jávea", "grade": "MS", "walkers": 10, "cancelled": false, "notes": ""}, {"date": "2026-04-08", "leader": "Gerda Bruinsma", "walk_no": "398", "walk_name": "Bollula to castell de Garx", "pueblo": "Bolulla", "grade": "MS", "walkers": 15, "cancelled": false, "notes": ""}, {"date": "2026-04-11", "leader": "Pat Moss & Peter Greene", "walk_no": "391", "walk_name": "Parcent Alcalali Circuit", "pueblo": "Parcent", "grade": "E", "walkers": 20, "cancelled": false, "notes": ""}, {"date": "2026-04-11", "leader": "Gerda Bruinsma", "walk_no": "74", "walk_name": "Bolulla circuit to Tarbena", "pueblo": "Bolulla", "grade": "MS", "walkers": 14, "cancelled": false, "notes": ""}, {"date": "2026-04-11", "leader": "Ralph Phipps", "walk_no": "481", "walk_name": "NEW WALK Puig del Frare from Forna", "pueblo": "Forna", "grade": "MS", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-04-11", "leader": "Jo Fletcher", "walk_no": "33", "walk_name": "Els Despoblats Moriscos", "pueblo": "Alcalà de la Jovada", "grade": "MS", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-04-11", "leader": "Kelly Watson", "walk_no": "119", "walk_name": "Ѧ Montgo Javea Summit from Denia Ѧ", "pueblo": "Dénia", "grade": "VS", "walkers": 1, "cancelled": false, "notes": ""}, {"date": "2026-04-15", "leader": "Jo Fletcher", "walk_no": "22", "walk_name": "Vall de Ebo to the Pla Dels Corralets", "pueblo": "Vall d'Ebo", "grade": "M", "walkers": 17, "cancelled": false, "notes": ""}, {"date": "2026-04-15", "leader": "Colin Read", "walk_no": "399", "walk_name": "Castell de Marinyen & Barranc de Cremades Circuit", "pueblo": "Tavernes de la Valldigna", "grade": "MS", "walkers": 9, "cancelled": false, "notes": ""}, {"date": "2026-04-15", "leader": "Vicki & David Francis", "walk_no": "159", "walk_name": "Ѧ Sanchet Circuit Ѧ", "pueblo": "Guadalest", "grade": "S", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-04-17", "leader": "John & Clodagh Mail", "walk_no": "264", "walk_name": "Foyes Valley Extended (Clockwise)", "pueblo": "Castell de Castells", "grade": "MS", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-04-18", "leader": "Angela Colgate", "walk_no": "588", "walk_name": "Tormos Stroll", "pueblo": "Tormos", "grade": "E", "walkers": 24, "cancelled": false, "notes": ""}, {"date": "2026-04-18", "leader": "Carol Harbach", "walk_no": "331", "walk_name": "North and South of Alcala de la Jovada", "pueblo": "Alcalà de la Jovada", "grade": "MS", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-04-18", "leader": "Gerda Bruinsma", "walk_no": "211", "walk_name": "Extended route around Tossal de Grau from Polop", "pueblo": "Polop", "grade": "MS", "walkers": 11, "cancelled": false, "notes": "Replacement for Aiden's walk"}, {"date": "2026-04-22", "leader": "John & Clodagh Mail", "walk_no": "158", "walk_name": "Rio Serpis Circuit with optional easy route back", "pueblo": "Vilallonga", "grade": "M", "walkers": 15, "cancelled": false, "notes": ""}, {"date": "2026-04-22", "leader": "Sarah & Steve Kennedy", "walk_no": "345", "walk_name": "Les Fonts de Pedreguer, Font d'Aixa, & Camí dels Pouets", "pueblo": "Pedreguer", "grade": "MS", "walkers": 4, "cancelled": false, "notes": ""}, {"date": "2026-04-22", "leader": "Gerda Bruinsma", "walk_no": "396", "walk_name": "Lower Bernia Circuit from Altea la Vella", "pueblo": "Altea la Vella / Altea la Vieja", "grade": "S", "walkers": 8, "cancelled": false, "notes": ""}, {"date": "2026-04-25", "leader": "Grace Morris", "walk_no": "236", "walk_name": "Lliber Llomas de L’Agre Circuit", "pueblo": "Altea", "grade": "M", "walkers": 10, "cancelled": false, "notes": ""}, {"date": "2026-04-25", "leader": "Jean Russell", "walk_no": "218", "walk_name": "Alternative Olta circuit from Calpe", "pueblo": "Calp / Calpe", "grade": "MS", "walkers": 0, "cancelled": true, "notes": "cancelled obstructions"}, {"date": "2026-04-25", "leader": "Aidan & Gillian Humphries", "walk_no": "290", "walk_name": "Ѧ Caballo Verde Ridge (west to east) Extended (the easier option) Ѧ", "pueblo": "Benimaurell", "grade": "MS", "walkers": 0, "cancelled": true, "notes": "Cancelled, David & Theresa to offer alternative"}, {"date": "2026-04-25", "leader": "Sarah & Steve Kennedy", "walk_no": "368", "walk_name": "Tollos circuit extended and in reverse", "pueblo": "Tollos", "grade": "S", "walkers": 9, "cancelled": false, "notes": ""}, {"date": "2026-04-29", "leader": "John & Clodagh Mail", "walk_no": "220", "walk_name": "Torre d’ Aguiló & Raco de Conil Circuit", "pueblo": "Cala Finestrat", "grade": "M", "walkers": 19, "cancelled": false, "notes": ""}, {"date": "2026-04-29", "leader": "Grace Morris", "walk_no": "57", "walk_name": "Tossal Verd via Orbeta from Benidoleig", "pueblo": "Benidoleig", "grade": "MS", "walkers": 17, "cancelled": false, "notes": ""}, {"date": "2026-04-29", "leader": "Vicki & David Francis", "walk_no": "534", "walk_name": "Ѧ Clockwise Miserat summit Ѧ from Benirrama", "pueblo": "Benirrama", "grade": "S", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-05-02", "leader": "Joan & Fergus Fitzpatrick", "walk_no": "383", "walk_name": "Adsubia Pego circuit", "pueblo": "L’Atzúbia / Adsubia", "grade": "M", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-05-02", "leader": "Peter Greene", "walk_no": "557", "walk_name": "Villages of the Vall de Laguar from Murla Polideportivo", "pueblo": "Murla", "grade": "MS", "walkers": 15, "cancelled": false, "notes": ""}, {"date": "2026-05-02", "leader": "Colin Read", "walk_no": "48", "walk_name": "Ѧ Segaria Ridge Scramble from the West Ѧ", "pueblo": "Benimeli", "grade": "S", "walkers": 8, "cancelled": false, "notes": ""}, {"date": "2026-05-06", "leader": "Veronica & Martin Dunkley", "walk_no": "215", "walk_name": "Parcent Les Fonts", "pueblo": "Parcent", "grade": "M", "walkers": 12, "cancelled": false, "notes": ""}, {"date": "2026-05-06", "leader": "Ingrid Van Steenbergen", "walk_no": "416", "walk_name": "Lliber Circuit, including the Hidden Valley and Font D'Aixa", "pueblo": "Lliber", "grade": "MS", "walkers": 16, "cancelled": false, "notes": ""}, {"date": "2026-05-06", "leader": "Klaus Frommel", "walk_no": "496", "walk_name": "Costera de Baladres", "pueblo": "Benialí", "grade": "S", "walkers": 5, "cancelled": false, "notes": ""}, {"date": "2026-05-09", "leader": "Theresa & David Brain", "walk_no": "91", "walk_name": "Xirles Loop", "pueblo": "Polop", "grade": "MS", "walkers": 0, "cancelled": true, "notes": "cancelled weather"}, {"date": "2026-05-09", "leader": "Theresa & David Brain", "walk_no": "178", "walk_name": "Xirles Stretch", "pueblo": "Polop", "grade": "MS", "walkers": 0, "cancelled": false, "notes": ""}, {"date": "2026-05-09", "leader": "Paul Elliott", "walk_no": "537", "walk_name": "Carrasca ridge from Benimaurell", "pueblo": "Benimaurell", "grade": "VS", "walkers": 0, "cancelled": true, "notes": "Cancelled weather"}, {"date": "2026-05-13", "leader": "John & Clodagh Mail", "walk_no": "132", "walk_name": "Albir Lighthouse", "pueblo": "Albir", "grade": "E", "walkers": 8, "cancelled": false, "notes": "Led by John Mail in place of Theresa & David Brain"}, {"date": "2026-05-13", "leader": "David Harbach", "walk_no": "34", "walk_name": "Ѧ La Muntanya Sud d’Alcala and part Forada Ridge Ѧ", "pueblo": "Alcalà de la Jovada", "grade": "MS", "walkers": 9, "cancelled": false, "notes": ""}, {"date": "2026-05-13", "leader": "Colin Read", "walk_no": "16", "walk_name": "Javea circuit to the Eye of Montgo", "pueblo": "Xàbia / Jávea", "grade": "MS", "walkers": 9, "cancelled": false, "notes": ""}, {"date": "2026-05-16", "leader": "Veronica & Martin Dunkley", "walk_no": "240", "walk_name": "Jalon via Verde Vent circuit", "pueblo": "Xaló / Jalón", "grade": "M", "walkers": 23, "cancelled": false, "notes": ""}, {"date": "2026-05-16", "leader": "Theresa & David Brain", "walk_no": "28", "walk_name": "Finestrat. Figures of eight", "pueblo": "Finestrat", "grade": "MS", "walkers": 6, "cancelled": false, "notes": ""}, {"date": "2026-05-16", "leader": "Sarah & Steve Kennedy", "walk_no": "47", "walk_name": "Beniaia, Margarida, Catamarruch Loop", "pueblo": "Beniaia", "grade": "S", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-05-20", "leader": "Vicki & David Francis", "walk_no": "7", "walk_name": "Alt del Ample Circular Walk from Jalon", "pueblo": "Xaló / Jalón", "grade": "M", "walkers": 0, "cancelled": true, "notes": "Cancelled"}, {"date": "2026-05-20", "leader": "Colin Read", "walk_no": "245", "walk_name": "Sierra de Bernia Font, Forat & Fort (PR-CV 7) (from Casas de Bernia)", "pueblo": "Xaló / Jalón", "grade": "MS", "walkers": 4, "cancelled": false, "notes": "Led by Colin Read in place of Sarah & Steve Kennedy"}, {"date": "2026-05-20", "leader": "Veronica & Martin Dunkley", "walk_no": "558", "walk_name": "Jalon Parcent circuit via Coll de Rates extended", "pueblo": "Xaló / Jalón", "grade": "S", "walkers": 0, "cancelled": true, "notes": "cancelled"}, {"date": "2026-05-20", "leader": "Theresa & David Brain", "walk_no": "na", "walk_name": "Alea", "pueblo": "Unknown", "grade": "E", "walkers": 17, "cancelled": false, "notes": ""}, {"date": "2026-05-20", "leader": "Bernard Szostek", "walk_no": "20", "walk_name": "Smugglers' Cove of Cala Llebeig", "pueblo": "Unknown", "grade": "M", "walkers": 6, "cancelled": false, "notes": ""}, {"date": "2026-05-20", "leader": "Rob & Pauline Chelmers", "walk_no": "200", "walk_name": "Cova Blanca", "pueblo": "Unknown", "grade": "S", "walkers": 6, "cancelled": false, "notes": ""}, {"date": "2026-05-23", "leader": "Jean Russell", "walk_no": "29", "walk_name": "Pedro Paseo from Ermita de San Juan", "pueblo": "Calp / Calpe", "grade": "M", "walkers": 10, "cancelled": false, "notes": ""}, {"date": "2026-05-23", "leader": "Sarah & Steve Kennedy", "walk_no": "259", "walk_name": "Ruta de los Ribereros de Benissa", "pueblo": "Benissa", "grade": "MS", "walkers": 11, "cancelled": false, "notes": ""}, {"date": "2026-05-27", "leader": "Joan & Fergus Fitzpatrick", "walk_no": "134", "walk_name": "Benimaurell Fleix circuit (anticlockwise)", "pueblo": "Benimaurell", "grade": "E", "walkers": 26, "cancelled": false, "notes": "Led by Joan & Fergus in place of Martin & Veronica"}, {"date": "2026-05-27", "leader": "Pauline & Rob Chalmers", "walk_no": "293", "walk_name": "Ѧ Caballo Verde ridge circuit - shortened version Ѧ", "pueblo": "Benimaurell", "grade": "M", "walkers": 12, "cancelled": false, "notes": ""}, {"date": "2026-05-27", "leader": "Bernard Szostek", "walk_no": "10", "walk_name": "Ѧ Caballo Verde Ridge West to East Ѧ", "pueblo": "Benimaurell", "grade": "MS", "walkers": 0, "cancelled": false, "notes": ""}];
        
        const palette = {'E': '#22c55e', 'M': '#3b82f6', 'MS': '#ef4444', 'S': '#a855f7', 'VS': '#1e293b'};
        let activeSortKey = 'date';
        let isAsc = true;
        let lineChart = null;
        let barChart = null;

        document.addEventListener("DOMContentLoaded", () => {
            initLineChart();
            initBarChart();
            drawTable();
        });

        function initLineChart() {
            const ctx = document.getElementById('canvasLine').getContext('2d');
            lineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['February', 'March', 'April', 'May'],
                    datasets: [
                        { label: 'E', data: [31, 0, 44, 62], borderColor: palette['E'], backgroundColor: palette['E'], tension: 0.1, walkAverages: [31.0, 0.0, 22.0, 15.5] },
                        { label: 'M', data: [144, 68, 118, 96], borderColor: palette['M'], backgroundColor: palette['M'], tension: 0.1, walkAverages: [24.0, 6.8, 11.8, 13.7] },
                        { label: 'MS', data: [117, 122, 118, 55], borderColor: palette['MS'], backgroundColor: palette['MS'], tension: 0.1, walkAverages: [14.6, 13.6, 9.8, 4.6] },
                        { label: 'S', data: [72, 30, 24, 0], borderColor: palette['S'], backgroundColor: palette['S'], tension: 0.1, walkAverages: [10.3, 7.5, 4.0, 0.0] },
                        { label: 'VS', data: [0, 7, 1, 0], borderColor: palette['VS'], backgroundColor: palette['VS'], tension: 0.1, walkAverages: [0.0, 3.5, 1.0, 0.0] },
                        { label: 'All Walks Combined', data: [364, 227, 305, 208], borderColor: '#64748b', borderDash: [5, 5], borderWidth: 2.5, pointStyle: 'rectRot', tension: 0.1, walkAverages: [15.8, 9.1, 9.8, 8.0] }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } },
                        tooltip: {
                            callbacks: {
                                footer: (items) => {
                                    const idx = items[0].dataIndex;
                                    const ds = items[0].dataset;
                                    return 'Avg Size Per Walk: ' + (ds.walkAverages ? ds.walkAverages[idx].toFixed(1) : 0) + ' hikers';
                                }
                            }
                        }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        function filterLineTrend() {
            const onlyTotal = document.getElementById('chkTotalOnly').checked;
            lineChart.data.datasets.forEach(ds => {
                ds.hidden = (ds.label !== 'All Walks Combined') && onlyTotal;
            });
            lineChart.update();
        }

        function initBarChart() {
            const counts = {};
            rawJsonStream.forEach(row => {
                const name = row.leader;
                if (!counts[name]) counts[name] = {'E':0, 'M':0, 'MS':0, 'S':0, 'VS':0, 'tot':0};
                counts[name][row.grade] += row.walkers;
                counts[name]['tot'] += row.walkers;
            });
            const sorted = Object.entries(counts).sort((a,b) => b[1].tot - a[1].tot);
            const labels = sorted.map(x => x[0]);
            
            const ctx = document.getElementById('canvasBars').getContext('2d');
            barChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        { label: 'E', data: sorted.map(x => x[1]['E']), backgroundColor: palette['E'] },
                        { label: 'M', data: sorted.map(x => x[1]['M']), backgroundColor: palette['M'] },
                        { label: 'MS', data: sorted.map(x => x[1]['MS']), backgroundColor: palette['MS'] },
                        { label: 'S', data: sorted.map(x => x[1]['S']), backgroundColor: palette['S'] },
                        { label: 'VS', data: sorted.map(x => x[1]['VS']), backgroundColor: palette['VS'] }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { x: { stacked: true }, y: { stacked: true, ticks: { autoSkip: false, font: { size: 9 } } } },
                    plugins: { legend: { display: false } }
                }
            });
        }

        function updateBars() {
            const checked = Array.from(document.querySelectorAll('.chk-g:checked')).map(el => el.value);
            barChart.data.datasets.forEach(ds => {
                ds.hidden = !checked.includes(ds.label);
            });
            barChart.update();
        }

        function drawTable() {
            const tbody = document.getElementById('tableBody');
            tbody.innerHTML = '';
            
            const query = document.getElementById('queryInput').value.toLowerCase().trim();
            const status = document.getElementById('statusSelect').value;

            let filtered = rawJsonStream.filter(r => {
                if (status === 'cancelled' && !r.cancelled) return false;
                if (query) {
                    return r.leader.toLowerCase().includes(query) || 
                           r.walk_name.toLowerCase().includes(query) || 
                           r.pueblo.toLowerCase().includes(query) || 
                           r.notes.toLowerCase().includes(query) || 
                           r.grade.toLowerCase() === query;
                }
                return true;
            });

            filtered.sort((a,b) => {
                let vA = a[activeSortKey];
                let vB = b[activeSortKey];
                if (activeSortKey === 'walkers' || activeSortKey === 'walk_no') {
                    vA = parseInt(vA) || 0;
                    vB = parseInt(vB) || 0;
                } else {
                    vA = String(vA).toLowerCase();
                    vB = String(vB).toLowerCase();
                }
                if (vA < vB) return isAsc ? -1 : 1;
                if (vA > vB) return isAsc ? 1 : -1;
                return 0;
            });

            filtered.forEach(r => {
                const tr = document.createElement('tr');
                if (r.cancelled) tr.className = "bg-red-50 text-slate-400 line-through decoration-slate-300";
                
                tr.innerHTML = `
                    <td class="p-2.5 font-mono text-[11px]">${escape(r.date)}</td>
                    <td class="p-2.5 font-semibold text-slate-800">${escape(r.leader)}</td>
                    <td class="p-2.5 text-center font-mono">${escape(r.walk_no || '—')}</td>
                    <td class="p-2.5 text-slate-700">${escape(r.walk_name)}</td>
                    <td class="p-2.5 text-slate-600">${escape(r.pueblo)}</td>
                    <td class="p-2.5 text-center"><span class="px-1.5 py-0.5 rounded text-[10px] font-bold text-white" style="background-color:${palette[r.grade]}">${r.grade}</span></td>
                    <td class="p-2.5 text-center font-bold">${r.walkers}</td>
                    <td class="p-2.5 text-[11px] italic text-slate-500">${r.cancelled ? '[CANCELLED] ' : ''}${escape(r.notes || '')}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function triggerSort(key) {
            if (activeSortKey === key) { isAsc = !isAsc; } else { activeSortKey = key; isAsc = true; }
            ['date', 'leader', 'walk_no', 'walk_name', 'pueblo', 'grade', 'walkers'].forEach(k => {
                document.getElementById('s-' + k).innerText = '↕';
            });
            document.getElementById('s-' + key).innerText = isAsc ? '▲' : '▼';
            drawTable();
        }

        function exportCSV() {
            const query = document.getElementById('queryInput').value.toLowerCase().trim();
            const status = document.getElementById('statusSelect').value;
            let filtered = rawJsonStream.filter(r => {
                if (status === 'cancelled' && !r.cancelled) return false;
                if (query) {
                    return r.leader.toLowerCase().includes(query) || r.walk_name.toLowerCase().includes(query) || r.pueblo.toLowerCase().includes(query);
                }
                return true;
            });
            
            let out = "Date,Leader,Walk No,Walk Name,Pueblo,Grade,Walkers,Notes\n";
            filtered.forEach(r => {
                out += `"${r.date}","${r.leader.replace(/"/g,'""')}","${r.walk_no}","${r.walk_name.replace(/"/g,'""')}","${r.pueblo.replace(/"/g,'""')}","${r.grade}",${r.walkers},"${(r.notes||'').replace(/"/g,'""')}"\n`;
            });
            const blob = new Blob([out], {type: 'text/csv;charset=utf-8;'});
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = "walk_attendance_report.csv";
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function escape(s) {
            if(!s) return '';
            return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }
    </script>
</body>