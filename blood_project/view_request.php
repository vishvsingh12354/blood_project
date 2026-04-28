<?php 
// 1. SESSION START - Critical security layer for administrative access
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// 2. DATABASE CONNECTION
include 'db.php';

// 3. FETCH LIVE REQUEST DATA
$res = mysqli_query($conn, "SELECT * FROM requests ORDER BY request_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Logistics | Patient Blood Requests</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono:wght@300;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --deep-obsidian: #050b14;
            --slate-blue: #16213e;
            --neon-emerald: #00ff9d;
            --warning-amber: #ffb703;
            --ai-blue: #4cc9f0;
            --glass-panel: rgba(22, 33, 62, 0.7);
        }

        body {
            font-family: 'Roboto Mono', monospace;
            background: radial-gradient(circle at center, #101827 0%, #050b14 100%);
            color: #e0e6ed;
            margin: 0;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- HIGH-TECH SIDEBAR --- */
        .sidebar {
            width: 280px;
            background: rgba(5, 11, 20, 0.95);
            border-right: 2px solid var(--slate-blue);
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
            z-index: 1000;
        }

        .sidebar h3 {
            font-family: 'Orbitron', sans-serif;
            color: var(--neon-emerald);
            text-align: center;
            letter-spacing: 4px;
            padding: 40px 0;
            margin: 0;
            text-shadow: 0 0 15px rgba(0, 255, 157, 0.3);
            border-bottom: 1px solid var(--slate-blue);
        }

        .sidebar a {
            color: #8892b0;
            padding: 20px 30px;
            text-decoration: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            transition: 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background: rgba(76, 201, 240, 0.05);
            color: var(--ai-blue);
            border-left: 4px solid var(--ai-blue);
            padding-left: 40px;
        }

        /* --- MAIN COMMAND AREA --- */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 50px;
            box-sizing: border-box;
            /* Fade-in transition for the entire panel */
            animation: panelFade 1s ease-out;
        }

        @keyframes panelFade {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .header-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            border-bottom: 2px solid var(--slate-blue);
            padding-bottom: 20px;
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            font-size: 24px;
            margin: 0;
            color: var(--ai-blue);
            text-transform: uppercase;
        }

        /* --- INDUSTRIAL LOG TABLES --- */
        .data-panel {
            background: var(--glass-panel);
            border: 1px solid var(--slate-blue);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            position: relative;
        }

        .data-panel::before {
            content: "SECURE_LOGISTICS_FEED";
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 9px;
            color: var(--neon-emerald);
            opacity: 0.6;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        th {
            text-align: left;
            color: var(--ai-blue);
            font-size: 12px;
            padding: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            background: rgba(255,255,255,0.03);
            padding: 18px;
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: transform 0.2s;
        }

        tr:hover td {
            background: rgba(255,255,255,0.07);
            transform: scale(1.005);
        }

        tr td:first-child { border-left: 1px solid rgba(255,255,255,0.05); border-radius: 8px 0 0 8px; }
        tr td:last-child { border-right: 1px solid rgba(255,255,255,0.05); border-radius: 0 8px 8px 0; }

        /* --- STATUS & ACTION UI --- */
        .blood-tag {
            color: var(--neon-emerald);
            font-weight: bold;
            background: rgba(0, 255, 157, 0.1);
            padding: 4px 10px;
            border-radius: 4px;
            border: 1px solid rgba(0, 255, 157, 0.3);
        }

        .status-pending { color: var(--warning-amber); text-transform: uppercase; font-size: 11px; font-weight: 700; }
        .status-approved { color: var(--neon-emerald); text-transform: uppercase; font-size: 11px; font-weight: 700; }

        .approve-btn {
            background: transparent;
            color: var(--neon-emerald);
            border: 1px solid var(--neon-emerald);
            padding: 6px 12px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
            border-radius: 4px;
            transition: all 0.3s;
            display: inline-block;
        }

        .approve-btn:hover {
            background: var(--neon-emerald);
            color: var(--deep-obsidian);
            box-shadow: 0 0 15px var(--neon-emerald);
        }

        .completed-badge {
            color: #8892b0;
            font-size: 11px;
            opacity: 0.6;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>SYSTEM_CONTROL</h3>
        <a href="view_donors.php">○ DATA_LOG: DONORS</a>
        <a href="blood_inventory.php">○ STOCK: BLOOD_BANK</a>
        <a href="view_request.php" style="color:var(--neon-emerald);">● REQ: PATIENT_ORDERS</a>
        <a href="staff_management.php">○ AUTH: STAFF_LIST</a>
    </div>

    <div class="main-content">
        <div class="header-box">
            <h2>Requests Queue</h2>
            <div style="font-size: 10px; color: var(--neon-emerald); border: 1px solid var(--neon-emerald); padding: 5px 15px; border-radius: 20px;">
                LOGISTICS_ACTIVE
            </div>
        </div>

        <div class="data-panel">
            <table>
                <thead>
                    <tr>
                        <th>Patient_ID</th>
                        <th>Classification</th>
                        <th>Volume</th>
                        <th>Status</th>
                        <th style="text-align:right;">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = mysqli_fetch_assoc($res)) {
                        $statusClass = ($row['status'] == 'Pending') ? 'status-pending' : 'status-approved';
                        echo "<tr>
                                <td style='font-weight:500; color:#fff;'>".htmlspecialchars($row['patient_name'])."</td>
                                <td><span class='blood-tag'>".$row['blood_group_needed']."</span></td>
                                <td>".$row['units_requested']." UNITS</td>
                                <td class='$statusClass'>[ ".$row['status']." ]</td>
                                <td style='text-align:right;'>";
                        
                        if($row['status'] == 'Pending') {
                            echo "<a href='approve_request.php?id=".$row['request_id']."' class='approve-btn'>EXECUTE_APPROVAL</a>";
                        } else {
                            echo "<span class='completed-badge'>DEPOSITED</span>";
                        }
                        
                        echo "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 30px; opacity: 0.4; font-size: 10px; text-align: center;">
            SECURE ACCESS: TERMINAL_B-49 // END_OF_LOG
        </div>
    </div>

</body>
</html>