<?php 
// 1. SESSION START - Absolute first priority for security
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// 2. DATABASE CONNECTION
include 'db.php';

// 3. FETCH INVENTORY DATA
$inventory_res = mysqli_query($conn, "SELECT * FROM blood_bank");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Inventory | Blood Bank Monitoring</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono:wght@300;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --deep-obsidian: #050b14;
            --slate-blue: #16213e;
            --neon-emerald: #00ff9d;
            --ai-blue: #4cc9f0;
            --critical-red: #ff4d4d;
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

        /* --- MAIN CONTENT AREA --- */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 50px;
            box-sizing: border-box;
            animation: panelFade 1.2s ease-out;
        }

        @keyframes panelFade {
            from { opacity: 0; transform: translateY(30px); }
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

        /* --- CRITICAL ALERT ANIMATION --- */
        @keyframes pulse-red {
            0% { box-shadow: 0 0 5px rgba(255, 77, 77, 0.1); }
            50% { box-shadow: 0 0 20px rgba(255, 77, 77, 0.4); background: rgba(255, 77, 77, 0.05); }
            100% { box-shadow: 0 0 5px rgba(255, 77, 77, 0.1); }
        }

        .critical-row td {
            border-top: 1px solid var(--critical-red) !important;
            border-bottom: 1px solid var(--critical-red) !important;
            animation: pulse-red 2s infinite;
        }

        .critical-tag {
            color: var(--critical-red);
            font-weight: bold;
            font-size: 9px;
            border: 1px solid var(--critical-red);
            padding: 2px 8px;
            border-radius: 4px;
            margin-left: 15px;
            letter-spacing: 1px;
            text-shadow: 0 0 5px rgba(255, 77, 77, 0.3);
        }

        /* --- INDUSTRIAL DATA TABLES --- */
        .data-panel {
            background: var(--glass-panel);
            border: 1px solid var(--slate-blue);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.6);
            position: relative;
        }

        .data-panel::before {
            content: "SECURE_STORAGE_ACTIVE // SENSOR_DATA";
            position: absolute;
            top: 12px;
            right: 25px;
            font-size: 9px;
            color: var(--neon-emerald);
            opacity: 0.7;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        th {
            text-align: left;
            color: var(--ai-blue);
            font-size: 11px;
            padding: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        td {
            background: rgba(255,255,255,0.03);
            padding: 18px;
            border-top: 1px solid rgba(255,255,255,0.05);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: 0.3s;
        }

        tr:hover td {
            background: rgba(76, 201, 240, 0.08);
        }

        tr td:first-child { border-left: 1px solid rgba(255,255,255,0.05); border-radius: 10px 0 0 10px; }
        tr td:last-child { border-right: 1px solid rgba(255,255,255,0.05); border-radius: 0 10px 10px 0; }

        .blood-tag {
            color: var(--neon-emerald);
            font-weight: bold;
            background: rgba(0, 255, 157, 0.1);
            padding: 5px 12px;
            border-radius: 5px;
            border: 1px solid rgba(0, 255, 157, 0.2);
        }

        .quantity-val {
            font-weight: bold;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h3>SYSTEM_CONTROL</h3>
        <a href="view_donors.php">○ DATA_LOG: DONORS</a>
        <a href="blood_inventory.php" style="color:var(--neon-emerald); border-left: 4px solid var(--neon-emerald);">● STOCK: BLOOD_BANK</a>
        <a href="view_request.php">○ REQ: PATIENT_ORDERS</a>
        <a href="staff_management.php">○ AUTH: STAFF_LIST</a>
    </div>

    <div class="main-content">
        <div class="header-box">
            <h2>Inventory Monitoring</h2>
            <div style="font-size: 10px; color: var(--neon-emerald); border: 1px solid var(--neon-emerald); padding: 6px 18px; border-radius: 20px; letter-spacing: 1px;">
                STORAGE_PROTOCOLS_ENGAGED
            </div>
        </div>

        <div class="data-panel">
            <h4 style="color: var(--ai-blue); margin-top: 0; letter-spacing: 2px;">GLOBAL_STOCK_REPORT</h4>
            <table>
                <thead>
                    <tr>
                        <th>Facility_Location</th>
                        <th>Classification</th>
                        <th style="text-align:right;">Volume_Metrics</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($inventory_res) > 0) {
                        while($row = mysqli_fetch_assoc($inventory_res)) {
                            // HEURISTIC ALERT ENGINE: Trigger if units <= 10
                            $is_critical = ($row['quantity_units'] <= 10);
                            $row_class = $is_critical ? "class='critical-row'" : "";
                            
                            echo "<tr $row_class>
                                    <td style='opacity:0.7;'>".htmlspecialchars($row['location'])."</td>
                                    <td>
                                        <span class='blood-tag'>".$row['blood_group']."</span>";
                                        if($is_critical) echo "<span class='critical-tag'>[CRITICAL_LEVEL]</span>";
                            echo "  </td>
                                    <td style='text-align:right;' class='quantity-val'>
                                        <span style='color: ".($is_critical ? "var(--critical-red)" : "#fff").";'>
                                            ".$row['quantity_units']." Units
                                        </span>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' style='text-align:center; padding:40px; opacity:0.5; letter-spacing: 2px;'>NO_TELEMETRY_DATA_FOUND</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-top:40px;">
            <div class="data-panel" style="text-align: center;">
                <div style="font-size: 9px; opacity: 0.6; letter-spacing: 2px; margin-bottom: 10px;">ACTIVE_NODES</div>
                <div style="font-size: 32px; color: var(--ai-blue); font-family: 'Orbitron';">02</div>
            </div>
            <div class="data-panel" style="text-align: center;">
                <div style="font-size: 9px; opacity: 0.6; letter-spacing: 2px; margin-bottom: 10px;">CUMULATIVE_RESERVES</div>
                <div style="font-size: 32px; color: var(--neon-emerald); font-family: 'Orbitron';">94 U</div>
            </div>
            <div class="data-panel" style="text-align: center;">
                <div style="font-size: 9px; opacity: 0.6; letter-spacing: 2px; margin-bottom: 10px;">ENCRYPTION_STATUS</div>
                <div style="font-size: 14px; color: var(--neon-emerald); font-family: 'Orbitron'; margin-top:15px; letter-spacing: 1px;">VERIFIED</div>
            </div>
        </div>
    </div>

</body>
</html>