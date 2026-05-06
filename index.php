<?php
// index.php
// Modern single-file PHP + D3.js + dc.js + Crossfilter airport dashboard
// Run locally with: php -S localhost:8000
// Then open: http://localhost:8000/index.php

// Enables strict type checking in PHP for safer and more predictable code
declare(strict_types=1);

// Static dataset used by the dashboard.
// Each array item represents one airport flight operation record.
// The frontend charts and tables are created from this data.
$rawData = [
    ['date' => '2026-03-01', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 168, 'flights' => 1],
    ['date' => '2026-03-01', 'airport' => 'SKG', 'city' => 'Thessaloniki', 'airline' => 'Ryanair', 'flight_type' => 'International', 'status' => 'Delayed', 'passengers' => 142, 'flights' => 1],
    ['date' => '2026-03-02', 'airport' => 'HER', 'city' => 'Heraklion', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 151, 'flights' => 1],
    ['date' => '2026-03-02', 'airport' => 'RHO', 'city' => 'Rhodes', 'airline' => 'easyJet', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 176, 'flights' => 1],
    ['date' => '2026-03-03', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Lufthansa', 'flight_type' => 'International', 'status' => 'Cancelled', 'passengers' => 0, 'flights' => 1],
    ['date' => '2026-03-03', 'airport' => 'CHQ', 'city' => 'Chania', 'airline' => 'Ryanair', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 159, 'flights' => 1],
    ['date' => '2026-03-04', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Sky Express', 'flight_type' => 'Domestic', 'status' => 'Delayed', 'passengers' => 121, 'flights' => 1],
    ['date' => '2026-03-04', 'airport' => 'CFU', 'city' => 'Corfu', 'airline' => 'easyJet', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 166, 'flights' => 1],
    ['date' => '2026-03-05', 'airport' => 'SKG', 'city' => 'Thessaloniki', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 148, 'flights' => 1],
    ['date' => '2026-03-05', 'airport' => 'HER', 'city' => 'Heraklion', 'airline' => 'Jet2', 'flight_type' => 'International', 'status' => 'Delayed', 'passengers' => 171, 'flights' => 1],
    ['date' => '2026-03-06', 'airport' => 'RHO', 'city' => 'Rhodes', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 137, 'flights' => 1],
    ['date' => '2026-03-06', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Ryanair', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 182, 'flights' => 1],
    ['date' => '2026-03-07', 'airport' => 'CHQ', 'city' => 'Chania', 'airline' => 'Sky Express', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 113, 'flights' => 1],
    ['date' => '2026-03-07', 'airport' => 'CFU', 'city' => 'Corfu', 'airline' => 'Lufthansa', 'flight_type' => 'International', 'status' => 'Delayed', 'passengers' => 154, 'flights' => 1],
    ['date' => '2026-03-08', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 173, 'flights' => 1],
    ['date' => '2026-03-08', 'airport' => 'SKG', 'city' => 'Thessaloniki', 'airline' => 'easyJet', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 169, 'flights' => 1],
    ['date' => '2026-03-09', 'airport' => 'HER', 'city' => 'Heraklion', 'airline' => 'Ryanair', 'flight_type' => 'International', 'status' => 'Cancelled', 'passengers' => 0, 'flights' => 1],
    ['date' => '2026-03-09', 'airport' => 'RHO', 'city' => 'Rhodes', 'airline' => 'Sky Express', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 119, 'flights' => 1],
    ['date' => '2026-03-10', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Jet2', 'flight_type' => 'International', 'status' => 'Delayed', 'passengers' => 163, 'flights' => 1],
    ['date' => '2026-03-10', 'airport' => 'CFU', 'city' => 'Corfu', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 133, 'flights' => 1],
    ['date' => '2026-03-11', 'airport' => 'CHQ', 'city' => 'Chania', 'airline' => 'easyJet', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 178, 'flights' => 1],
    ['date' => '2026-03-11', 'airport' => 'SKG', 'city' => 'Thessaloniki', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'Delayed', 'passengers' => 145, 'flights' => 1],
    ['date' => '2026-03-12', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Lufthansa', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 181, 'flights' => 1],
    ['date' => '2026-03-12', 'airport' => 'HER', 'city' => 'Heraklion', 'airline' => 'Sky Express', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 126, 'flights' => 1],
    ['date' => '2026-03-13', 'airport' => 'RHO', 'city' => 'Rhodes', 'airline' => 'Jet2', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 174, 'flights' => 1],
    ['date' => '2026-03-13', 'airport' => 'CFU', 'city' => 'Corfu', 'airline' => 'Ryanair', 'flight_type' => 'International', 'status' => 'Delayed', 'passengers' => 158, 'flights' => 1],
    ['date' => '2026-03-14', 'airport' => 'ATH', 'city' => 'Athens', 'airline' => 'Aegean', 'flight_type' => 'Domestic', 'status' => 'On Time', 'passengers' => 177, 'flights' => 1],
    ['date' => '2026-03-14', 'airport' => 'CHQ', 'city' => 'Chania', 'airline' => 'Ryanair', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 161, 'flights' => 1],
    ['date' => '2026-03-15', 'airport' => 'SKG', 'city' => 'Thessaloniki', 'airline' => 'Sky Express', 'flight_type' => 'Domestic', 'status' => 'Cancelled', 'passengers' => 0, 'flights' => 1],
    ['date' => '2026-03-15', 'airport' => 'HER', 'city' => 'Heraklion', 'airline' => 'easyJet', 'flight_type' => 'International', 'status' => 'On Time', 'passengers' => 172, 'flights' => 1],
];
// Simple API mode.
// When the URL contains ?api=1, the page returns JSON instead of HTML.
// Example: /index.php?api=1
if (isset($_GET['api']) && $_GET['api'] === '1') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($rawData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
// Encode the PHP dataset so it can safely be embedded inside JavaScript.
// The JSON_HEX_* flags help prevent HTML/script injection problems.
$embeddedJson = json_encode(
    $rawData,
    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
);
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Airport Operations Dashboard</title>
    <!-- dc.js stylesheet for default chart styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dc/4.2.7/style/dc.min.css" />
    /* Global design tokens used throughout the dashboard */
    <style>
        :root {
            --bg: #edf2f9;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --surface-blue: #eff6ff;
            --text: #111827;
            --muted: #64748b;
            --border: #dbe4f0;
            --accent: #2563eb;
            --accent-dark: #1d4ed8;
            --success: #15803d;
            --success-bg: #dcfce7;
            --warning: #b45309;
            --warning-bg: #fef3c7;
            --danger: #b91c1c;
            --danger-bg: #fee2e2;
            --info: #0369a1;
            --info-bg: #e0f2fe;
            --shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
            --radius-lg: 22px;
            --radius-md: 16px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Inter, Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.18), transparent 34rem),
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.12), transparent 28rem),
                linear-gradient(180deg, #f8fbff 0%, var(--bg) 100%);
            color: var(--text);
        }

        .container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 28px;
        }

        .hero {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 22px;
            margin-bottom: 22px;
            padding: 26px;
            border: 1px solid rgba(255,255,255,0.7);
            border-radius: 28px;
            background: linear-gradient(135deg, rgba(255,255,255,0.96), rgba(239,246,255,0.92));
            box-shadow: var(--shadow);
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--accent);
            font-weight: 900;
            font-size: 12px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 10px;
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1;
            letter-spacing: -0.05em;
        }

        .subtitle {
            color: var(--muted);
            margin: 0;
            max-width: 820px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            min-width: 260px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 0;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
            background: var(--accent);
            padding: 11px 16px;
            border-radius: 999px;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.22);
            transition: transform 0.15s ease, background 0.15s ease;
        }

        .btn:hover { background: var(--accent-dark); transform: translateY(-1px); }
        .btn.secondary { color: var(--accent); background: #dbeafe; box-shadow: none; }

        .metrics,
        .grid {
            display: grid;
            gap: 18px;
        }

        .metrics {
            grid-template-columns: repeat(5, minmax(0, 1fr));
            margin-bottom: 18px;
        }

        .grid {
            grid-template-columns: repeat(12, minmax(0, 1fr));
            align-items: stretch;
        }

        .card {
            background: rgba(255,255,255,0.97);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 18px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .metric-card {
            position: relative;
            min-height: 130px;
            isolation: isolate;
        }

        .metric-card::after {
            content: "";
            position: absolute;
            right: -34px;
            top: -34px;
            width: 96px;
            height: 96px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.08);
            z-index: -1;
        }

        .metric-card h3,
        .chart-title {
            margin: 0 0 10px;
            font-size: 12px;
            color: var(--muted);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .metric-value {
            font-size: clamp(26px, 3vw, 36px);
            font-weight: 950;
            letter-spacing: -0.04em;
        }

        .metric-help {
            color: var(--muted);
            font-size: 13px;
            margin-top: 8px;
            line-height: 1.4;
        }

        .span-4 { grid-column: span 4; }
        .span-5 { grid-column: span 5; }
        .span-6 { grid-column: span 6; }
        .span-7 { grid-column: span 7; }
        .span-8 { grid-column: span 8; }
        .span-12 { grid-column: span 12; }

        .chart-wrap { width: 100%; min-height: 290px; }
        #passenger-trend { min-height: 330px; }
        #status-chart, #airport-chart, #airline-chart, #type-chart { min-height: 285px; }

        .dc-chart g.row text,
        .dc-chart text.pie-slice,
        .dc-chart g.axis text {
            font-size: 12px;
            fill: #1f2937;
        }

        .dc-chart .axis path,
        .dc-chart .axis line { stroke: #cbd5e1; }
        .dc-chart .grid-line line { stroke: #e2e8f0; }

        .filter-note {
            color: var(--muted);
            font-size: 13px;
            margin-top: 10px;
        }

        .table-card {
            padding: 0;
        }

        .table-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 18px 14px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .table-title-wrap .chart-title { margin-bottom: 4px; }

        .table-description {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.45;
        }

        .table-tools {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-box {
            width: min(360px, 100%);
            position: relative;
        }

        .search-box input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 11px 14px;
            outline: none;
            font-size: 14px;
            background: #fff;
            color: var(--text);
        }

        .search-box input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .small-btn {
            border: 1px solid var(--border);
            background: #fff;
            color: var(--text);
            border-radius: 999px;
            padding: 10px 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .small-btn:hover { background: var(--surface-blue); color: var(--accent); }

        .count-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 18px;
            color: var(--muted);
            font-size: 13px;
            border-bottom: 1px solid var(--border);
        }

        .dc-data-count strong { color: var(--text); }
        .dc-data-count a { color: var(--accent); font-weight: 800; text-decoration: none; }

        .table-shell {
            max-height: 560px;
            overflow: auto;
            background: #fff;
        }

        .airport-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
        }

        .airport-table thead th {
            position: sticky;
            top: 0;
            z-index: 2;
            padding: 13px 14px;
            background: #f8fafc;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            white-space: nowrap;
        }

        .airport-table tbody td {
            padding: 14px;
            border-bottom: 1px solid #edf2f7;
            vertical-align: middle;
            white-space: nowrap;
        }

        .airport-table tbody tr:nth-child(even) td { background: #fbfdff; }
        .airport-table tbody tr:hover td { background: #eff6ff; }

        .airport-table .primary-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .airport-code {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 46px;
            padding: 6px 8px;
            border-radius: 12px;
            background: #e0ecff;
            color: var(--accent-dark);
            font-weight: 950;
            letter-spacing: 0.04em;
        }

        .city-name {
            color: var(--muted);
            font-size: 12px;
            margin-top: 2px;
        }

        .airline-name { font-weight: 850; }

        .type-pill,
        .status-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
        }

        .type-domestic { color: #075985; background: #e0f2fe; }
        .type-international { color: #5b21b6; background: #ede9fe; }
        .status-on-time { color: var(--success); background: var(--success-bg); }
        .status-delayed { color: var(--warning); background: var(--warning-bg); }
        .status-cancelled { color: var(--danger); background: var(--danger-bg); }

        .passenger-value {
            display: inline-flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 72px;
            font-weight: 950;
            font-variant-numeric: tabular-nums;
        }

        .passenger-zero { color: var(--danger); }

        .empty-state {
            padding: 34px 18px;
            text-align: center;
            color: var(--muted);
            background: #fff;
        }

        .footer-note {
            color: var(--muted);
            font-size: 12px;
            margin-top: 18px;
            text-align: center;
        }

        @media (max-width: 1180px) {
            .metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .span-4, .span-5, .span-6, .span-7, .span-8 { grid-column: span 12; }
        }

        @media (max-width: 820px) {
            .container { padding: 16px; }
            .hero { flex-direction: column; align-items: flex-start; padding: 18px; }
            .actions { justify-content: flex-start; min-width: 0; }
            .metrics { grid-template-columns: 1fr; }
            .card { padding: 14px; }
            .table-card { padding: 0; }
            .table-header { flex-direction: column; }
            .table-tools, .search-box { width: 100%; }
            .small-btn { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <section class="hero">
            <div>
                <p class="eyebrow">Airport analytics</p>
                <h1>Airport Operations Dashboard</h1>
                <p class="subtitle">
                    Διαδραστική ανάλυση επιβατών, πτήσεων, αεροδρομίων, εταιρειών και κατάστασης πτήσεων με PHP, D3.js, dc.js και Crossfilter.
                </p>
            </div>
            <div class="actions">
                <button class="btn" id="resetFilters" type="button">Reset Filters</button>
                <a class="btn secondary" href="?api=1" target="_blank" rel="noopener">View JSON</a>
            </div>
        </section>

        <section class="metrics">
            <div class="card metric-card">
                <h3>Total Passengers</h3>
                <div id="total-passengers" class="metric-value"></div>
                <div class="metric-help">Σύνολο επιβατών στο τρέχον φίλτρο</div>
            </div>
            <div class="card metric-card">
                <h3>Total Flights</h3>
                <div id="total-flights" class="metric-value"></div>
                <div class="metric-help">Πλήθος εγγραφών πτήσεων</div>
            </div>
            <div class="card metric-card">
                <h3>Avg Passengers</h3>
                <div id="avg-passengers" class="metric-value"></div>
                <div class="metric-help">Μέσος όρος ανά πτήση</div>
            </div>
            <div class="card metric-card">
                <h3>Active Airports</h3>
                <div id="active-airports" class="metric-value"></div>
                <div class="metric-help">Μοναδικά αεροδρόμια</div>
            </div>
            <div class="card metric-card">
                <h3>Issue Rate</h3>
                <div id="issue-rate" class="metric-value"></div>
                <div class="metric-help">Delayed ή Cancelled</div>
            </div>
        </section>

        <section class="grid">
            <div class="card span-8">
                <div class="chart-title">Passengers Trend</div>
                <div id="passenger-trend" class="chart-wrap"></div>
                <div class="filter-note">Σύρε πάνω στο chart για φιλτράρισμα ανά ημερομηνία.</div>
            </div>

            <div class="card span-4">
                <div class="chart-title">Flights by Status</div>
                <div id="status-chart" class="chart-wrap"></div>
            </div>

            <div class="card span-4">
                <div class="chart-title">Passengers by Airport</div>
                <div id="airport-chart" class="chart-wrap"></div>
            </div>

            <div class="card span-4">
                <div class="chart-title">Flights by Airline</div>
                <div id="airline-chart" class="chart-wrap"></div>
            </div>

            <div class="card span-4">
                <div class="chart-title">Domestic vs International</div>
                <div id="type-chart" class="chart-wrap"></div>
            </div>

            <div class="card table-card span-12">
                <div class="table-header">
                    <div class="table-title-wrap">
                        <div class="chart-title">Flight Records</div>
                        <p class="table-description">Πίνακας με αναζήτηση, sticky κεφαλίδα και δυναμική ενημέρωση βάσει των φίλτρων.</p>
                    </div>
                    <div class="table-tools">
                        <div class="search-box">
                            <input id="tableSearch" type="search" placeholder="Αναζήτηση: ATH, Aegean, Delayed, Athens..." autocomplete="off" />
                        </div>
                        <button class="small-btn" id="clearSearch" type="button">Clear Search</button>
                    </div>
                </div>
                <div class="count-row">
                    <div id="data-count"></div>
                    <div id="visible-count">Showing 0 records</div>
                </div>
                <div class="table-shell">
                    <table class="airport-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Airport</th>
                                <th>Airline</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th style="text-align:right;">Passengers</th>
                            </tr>
                        </thead>
                        <tbody id="flight-table-body"></tbody>
                    </table>
                    <div id="empty-state" class="empty-state" hidden>No records match the current filters.</div>
                </div>
            </div>
        </section>

        <p class="footer-note">Tip: Κάνε click σε pie/row charts ή σύρε στο trend chart. Όλα τα KPIs και ο πίνακας ενημερώνονται αυτόματα.</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.9.0/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crossfilter2/1.5.4/crossfilter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dc/4.2.7/dc.min.js"></script>

    <script>
        const EMBEDDED_DATA = <?= $embeddedJson ?: '[]' ?>;

        function getContainerWidth(selector, fallback = 400) {
            const node = document.querySelector(selector);
            return Math.max(fallback, node ? node.clientWidth : fallback);
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function slug(value) {
            return String(value).toLowerCase().replace(/\s+/g, '-');
        }

        function statusBadge(status) {
            return `<span class="status-pill status-${slug(status)}">${escapeHtml(status)}</span>`;
        }

        function typeBadge(type) {
            return `<span class="type-pill type-${slug(type)}">${escapeHtml(type)}</span>`;
        }

        async function loadData() {
            try {
                const response = await fetch('index.php?api=1', { cache: 'no-store' });
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return await response.json();
            } catch (error) {
                console.warn('API fetch failed. Falling back to embedded data.', error);
                return EMBEDDED_DATA;
            }
        }

        async function initDashboard() {
            const data = await loadData();

            const parseDate = d3.timeParse('%Y-%m-%d');
            const formatDate = d3.timeFormat('%Y-%m-%d');
            const number = d3.format(',.0f');
            const percent = d3.format('.0%');

            data.forEach(d => {
                d.dateObj = parseDate(d.date);
                d.passengers = +d.passengers;
                d.flights = +d.flights;
                d.hasIssue = d.status === 'Delayed' || d.status === 'Cancelled' ? 1 : 0;
                d.searchText = [d.date, d.airport, d.city, d.airline, d.flight_type, d.status, d.passengers]
                    .join(' ')
                    .toLowerCase();
            });

            const ndx = crossfilter(data);
            const all = ndx.groupAll();

            const dateDim = ndx.dimension(d => d.dateObj);
            const statusDim = ndx.dimension(d => d.status);
            const airportDim = ndx.dimension(d => d.airport);
            const airlineDim = ndx.dimension(d => d.airline);
            const typeDim = ndx.dimension(d => d.flight_type);
            const tableDim = ndx.dimension(d => d.dateObj);
            const searchDim = ndx.dimension(d => d.searchText);

            const passengersByDate = dateDim.group().reduceSum(d => d.passengers);
            const flightsByStatus = statusDim.group().reduceCount();
            const passengersByAirport = airportDim.group().reduceSum(d => d.passengers);
            const flightsByAirline = airlineDim.group().reduceCount();
            const flightsByType = typeDim.group().reduceCount();

            const totalsGroup = all.reduce(
                (p, v) => {
                    p.passengers += v.passengers;
                    p.flights += v.flights;
                    p.issues += v.hasIssue;
                    p.airports[v.airport] = (p.airports[v.airport] || 0) + 1;
                    return p;
                },
                (p, v) => {
                    p.passengers -= v.passengers;
                    p.flights -= v.flights;
                    p.issues -= v.hasIssue;
                    p.airports[v.airport] = (p.airports[v.airport] || 0) - 1;
                    if (p.airports[v.airport] <= 0) delete p.airports[v.airport];
                    return p;
                },
                () => ({ passengers: 0, flights: 0, issues: 0, airports: {} })
            );

            const minDate = d3.min(data, d => d.dateObj);
            const maxDate = d3.max(data, d => d.dateObj);
            const paddedMaxDate = d3.timeDay.offset(maxDate, 1);

            const passengerTrendChart = new dc.LineChart('#passenger-trend');
            passengerTrendChart
                .width(getContainerWidth('#passenger-trend'))
                .height(330)
                .margins({ top: 20, right: 30, bottom: 45, left: 62 })
                .dimension(dateDim)
                .group(passengersByDate)
                .x(d3.scaleTime().domain([minDate, paddedMaxDate]))
                .renderArea(true)
                .brushOn(true)
                .elasticY(true)
                .xUnits(d3.timeDays)
                .renderHorizontalGridLines(true)
                .renderVerticalGridLines(false)
                .title(d => `${formatDate(d.key)}\nPassengers: ${number(d.value)}`)
                .yAxisLabel('Passengers')
                .xAxisLabel('Date');

            const statusChart = new dc.PieChart('#status-chart');
            statusChart
                .width(getContainerWidth('#status-chart'))
                .height(285)
                .radius(108)
                .innerRadius(54)
                .dimension(statusDim)
                .group(flightsByStatus)
                .legend(new dc.Legend().x(10).y(238).itemHeight(13).gap(5))
                .title(d => `${d.key}: ${number(d.value)} flights`);

            const airportChart = new dc.RowChart('#airport-chart');
            airportChart
                .width(getContainerWidth('#airport-chart'))
                .height(285)
                .margins({ top: 10, right: 34, bottom: 30, left: 18 })
                .dimension(airportDim)
                .group(passengersByAirport)
                .elasticX(true)
                .ordering(d => -d.value)
                .title(d => `${d.key}: ${number(d.value)} passengers`);
            airportChart.xAxis().ticks(5);

            const airlineChart = new dc.RowChart('#airline-chart');
            airlineChart
                .width(getContainerWidth('#airline-chart'))
                .height(285)
                .margins({ top: 10, right: 34, bottom: 30, left: 18 })
                .dimension(airlineDim)
                .group(flightsByAirline)
                .elasticX(true)
                .ordering(d => -d.value)
                .title(d => `${d.key}: ${number(d.value)} flights`);
            airlineChart.xAxis().ticks(5);

            const typeChart = new dc.PieChart('#type-chart');
            typeChart
                .width(getContainerWidth('#type-chart'))
                .height(285)
                .radius(110)
                .innerRadius(44)
                .dimension(typeDim)
                .group(flightsByType)
                .legend(new dc.Legend().x(10).y(238).itemHeight(13).gap(5))
                .title(d => `${d.key}: ${number(d.value)} flights`);

            new dc.NumberDisplay('#total-passengers')
                .group(totalsGroup)
                .valueAccessor(d => d.passengers)
                .formatNumber(number);

            new dc.NumberDisplay('#total-flights')
                .group(totalsGroup)
                .valueAccessor(d => d.flights)
                .formatNumber(number);

            new dc.NumberDisplay('#avg-passengers')
                .group(totalsGroup)
                .valueAccessor(d => d.flights ? d.passengers / d.flights : 0)
                .formatNumber(number);

            new dc.NumberDisplay('#active-airports')
                .group(totalsGroup)
                .valueAccessor(d => Object.keys(d.airports).length)
                .formatNumber(number);

            new dc.NumberDisplay('#issue-rate')
                .group(totalsGroup)
                .valueAccessor(d => d.flights ? d.issues / d.flights : 0)
                .formatNumber(percent);

            new dc.DataCount('#data-count')
                .dimension(ndx)
                .group(all)
                .html({
                    some: '<strong>%filter-count</strong> selected out of <strong>%total-count</strong> records | <a href="javascript:dc.filterAll();dc.renderAll();">Reset All</a>',
                    all: 'All records selected. Κάνε click στα charts για φιλτράρισμα.'
                });

            function renderTable() {
                const rows = tableDim.top(Infinity).sort((a, b) => d3.ascending(a.dateObj, b.dateObj));
                const tbody = document.getElementById('flight-table-body');
                const emptyState = document.getElementById('empty-state');
                const visibleCount = document.getElementById('visible-count');

                visibleCount.textContent = `Showing ${number(rows.length)} record${rows.length === 1 ? '' : 's'}`;
                emptyState.hidden = rows.length > 0;

                tbody.innerHTML = rows.map(d => {
                    const passengerClass = d.passengers === 0 ? 'passenger-value passenger-zero' : 'passenger-value';

                    return `
                        <tr>
                            <td>${escapeHtml(formatDate(d.dateObj))}</td>
                            <td>
                                <div class="primary-cell">
                                    <span class="airport-code">${escapeHtml(d.airport)}</span>
                                    <div>
                                        <div><strong>${escapeHtml(d.city)}</strong></div>
                                        <div class="city-name">Airport code ${escapeHtml(d.airport)}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="airline-name">${escapeHtml(d.airline)}</span></td>
                            <td>${typeBadge(d.flight_type)}</td>
                            <td>${statusBadge(d.status)}</td>
                            <td style="text-align:right;"><span class="${passengerClass}">${number(d.passengers)}</span></td>
                        </tr>
                    `;
                }).join('');
            }

            dc.chartRegistry.list().forEach(chart => {
                chart.on('filtered.table', renderTable);
                chart.on('postRender.table', renderTable);
                chart.on('postRedraw.table', renderTable);
            });

            const searchInput = document.getElementById('tableSearch');
            const clearSearch = document.getElementById('clearSearch');

            function applySearch() {
                const query = searchInput.value.trim().toLowerCase();
                searchDim.filterFunction(text => !query || text.includes(query));
                dc.redrawAll();
                renderTable();
            }

            searchInput.addEventListener('input', applySearch);
            clearSearch.addEventListener('click', () => {
                searchInput.value = '';
                searchDim.filterAll();
                dc.redrawAll();
                renderTable();
                searchInput.focus();
            });

            document.getElementById('resetFilters').addEventListener('click', () => {
                searchInput.value = '';
                searchDim.filterAll();
                dc.filterAll();
                dc.renderAll();
                renderTable();
            });

            dc.renderAll();
            renderTable();

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    passengerTrendChart.width(getContainerWidth('#passenger-trend'));
                    statusChart.width(getContainerWidth('#status-chart'));
                    airportChart.width(getContainerWidth('#airport-chart'));
                    airlineChart.width(getContainerWidth('#airline-chart'));
                    typeChart.width(getContainerWidth('#type-chart'));
                    dc.renderAll();
                    renderTable();
                }, 180);
            });
        }

        initDashboard().catch(error => {
            console.error('Dashboard init failed:', error);
            document.body.insertAdjacentHTML(
                'beforeend',
                '<div style="margin:16px;padding:16px;border-radius:12px;background:#fee2e2;color:#991b1b;font-weight:700;">Failed to load dashboard data.</div>'
            );
        });
    </script>
</body>
</html>
