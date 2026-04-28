<?php 
// 1. SESSION START - Absolute first priority for security
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

// 2. DATABASE CONNECTION
include 'db.php';

// 3. DASHBOARD DATA LOGIC
$chart_data = mysqli_query($conn, "SELECT blood_group, COUNT(*) as count FROM donors GROUP BY blood_group");
$groups = [];
$counts = [];
while($row = mysqli_fetch_assoc($chart_data)) {
    $groups[] = $row['blood_group'];
    $counts[] = $row['count'];
}

$total_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM donors");
$total_row = mysqli_fetch_assoc($total_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Command | Blood Donor Intelligence</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono:wght@300;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --deep-obsidian: #050b14;
            --slate-blue: #16213e;
            --neon-emerald: #00ff9d;
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

        .logout-btn {
            background: transparent;
            color: #ff4d4d;
            border: 1px solid #ff4d4d;
            padding: 8px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            transition: 0.3s;
        }

        .logout-btn:hover { background: #ff4d4d; color: white; box-shadow: 0 0 15px rgba(255, 77, 77, 0.4); }

        /* --- ANALYTICS FRAME --- */
        .analytics-grid {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        .chart-frame {
            background: var(--glass-panel);
            border: 1px solid var(--slate-blue);
            border-radius: 12px;
            padding: 40px;
            position: relative;
            box-shadow: 0 15px 40px rgba(0,0,0,0.6);
            min-height: 450px;
        }

        .chart-frame::before {
            content: "AI_LIVE_VISUALIZATION // 360° ENGINE";
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 9px;
            color: var(--neon-emerald);
            letter-spacing: 1px;
            opacity: 0.8;
        }

        /* --- STAT TILES & MINI TABLES --- */
        .data-panel {
            background: var(--glass-panel);
            border: 1px solid var(--slate-blue);
            border-radius: 12px;
            padding: 30px;
        }

        .stat-tile {
            text-align: center;
            border: 1px solid var(--neon-emerald);
            padding: 30px;
            border-radius: 12px;
            background: rgba(0, 255, 157, 0.03);
            margin-bottom: 30px;
        }

        .stat-val { font-size: 64px; color: var(--neon-emerald); font-family: 'Orbitron'; text-shadow: 0 0 20px rgba(0, 255, 157, 0.4); }

        /* --- INDUSTRIAL MASTER TABLE --- */
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
            color: #fff;
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

    </style>
</head>
<body>

    <div class="sidebar">
        <h3>SYSTEM_CONTROL</h3>
        <a href="view_donors.php" style="color:var(--neon-emerald); border-left: 4px solid var(--neon-emerald);">● DATA_LOG: DONORS</a>
        <a href="blood_inventory.php">○ STOCK: BLOOD_BANK</a>
        <a href="view_request.php">○ REQ: PATIENT_ORDERS</a>
        <a href="staff_management.php">○ AUTH: STAFF_LIST</a>
    </div>

    <div class="main-content">
        <div class="header-box">
            <h2>Command Dashboard</h2>
            <a href="logout.php" class="logout-btn">TERMINATE_SESSION</a>
        </div>

        <div class="analytics-grid">
            <div class="chart-frame">
                <canvas id="bloodChart"></canvas>
            </div>
            
            <div class="data-panel">
                <div class="stat-tile">
                    <div style="font-size: 11px; opacity: 0.7; letter-spacing: 2px;">TOTAL_RECORDED_ENTRIES</div>
                    <div class="stat-val"><?php echo $total_row['total']; ?></div>
                </div>

                <div style="margin-top: 20px;">
                    <h4 style="color: var(--ai-blue); font-size: 11px; letter-spacing: 1px;">INVENTORY_SNAPSHOT</h4>
                    <table style="border-spacing: 0 5px;">
                        <?php
                        $inv_query = mysqli_query($conn, "SELECT blood_group, COUNT(*) as count FROM donors GROUP BY blood_group");
                        while($inv = mysqli_fetch_assoc($inv_query)) {
                            echo "<tr>
                                    <td><span class='blood-tag'>".$inv['blood_group']."</span></td>
                                    <td style='text-align:right; font-weight:bold;'>".$inv['count']." UNITS</td>
                                  </tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="data-panel">
            <h4 style="color: var(--ai-blue); letter-spacing: 2px;">MASTER_DONOR_DATABASE</h4>
            <table>
                <thead>
                    <tr>
                        <th>Personnel_Name</th>
                        <th>Classification</th>
                        <th>Comms_Link</th>
                        <th style="text-align:right;">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM donors ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td style='color:#fff; font-weight:500;'>".htmlspecialchars($row['name'])."</td>
                                <td><span class='blood-tag'>".$row['blood_group']."</span></td>
                                <td style='opacity:0.8;'>".htmlspecialchars($row['phone'])."</td>
                                <td style='text-align:right;'>
                                    <a href='edit_donor.php?id=".$row['id']."' style='color:var(--ai-blue); text-decoration:none; font-size:11px; font-weight:bold;'>[EDIT]</a>
                                    <a href='delete_donor.php?id=".$row['id']."' style='color:#ff4d4d; text-decoration:none; font-size:11px; font-weight:bold; margin-left:15px;' onclick='return confirm(\"WIPE DATA?\")'>[WIPE]</a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 30px; text-align: right;">
             <a href="index.php" style="color:var(--neon-emerald); text-decoration:none; font-weight:bold; font-size:12px; border: 1px solid var(--neon-emerald); padding: 10px 20px; border-radius: 5px;">+ INITIALIZE_NEW_ENTRY</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bloodChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($groups); ?>,
                datasets: [{
                    data: <?php echo json_encode($counts); ?>,
                    backgroundColor: [
                        '#4cc9f0', '#00ff9d', '#ff4d4d', '#7209b7', 
                        '#f72585', '#3a0ca3', '#4361ee', '#4895ef'
                    ],
                    hoverOffset: 40,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '82%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { 
                            color: '#8892b0', 
                            font: { family: 'Roboto Mono', size: 10 },
                            padding: 20
                        }
                    }
                },
                // --- THE LUXURY 360° SPIN ANIMATION ---
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 3500,        // Luxe slow spin
                    easing: 'easeOutQuart'  // Smooth deceleration
                }
            }
        });
    </script>
</body>
</html>