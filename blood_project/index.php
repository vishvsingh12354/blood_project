<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation Portal | Industrial Interface</title>
    <style>
        /* INDUSTRIALIST SYSTEM UPGRADE */
        :root {
            --industry-red: #d90429;
            --steel-dark: #2b2d42;
            --concrete-light: #edf2f4;
            --hazard-yellow: #ffb703;
            --border-heavy: 2px solid #2b2d42;
        }

        body {
            font-family: 'Roboto Mono', 'Courier New', monospace;
            background-color: #1a1a1a;
            /* Industrial Blueprint/Grid Effect */
            background-image: 
                linear-gradient(rgba(43, 45, 66, 0.1) 1px, transparent 1px),
                linear-gradient(90deg, rgba(43, 45, 66, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--steel-dark);
        }

        .container {
            background: var(--concrete-light);
            padding: 40px;
            width: 400px;
            text-align: center;
            border: 4px solid var(--steel-dark);
            box-shadow: 10px 10px 0px var(--industry-red);
            position: relative;
            clip-path: polygon(0% 0%, 100% 0%, 100% 95%, 95% 100%, 0% 100%);
        }

        /* Industrial Branding */
        .container::before {
            content: "SYSTEM ID: BLOOD-UNIT-01";
            position: absolute;
            top: 5px;
            left: 10px;
            font-size: 10px;
            font-weight: bold;
            opacity: 0.5;
        }

        h2 {
            text-transform: uppercase;
            font-size: 32px;
            font-weight: 900;
            margin: 10px 0;
            letter-spacing: 2px;
            background: var(--steel-dark);
            color: white;
            padding: 10px;
            display: inline-block;
            width: 100%;
            box-sizing: border-box;
        }

        .blood-drop {
            font-size: 50px;
            color: var(--industry-red);
            margin-bottom: 5px;
            filter: drop-shadow(3px 3px 0px rgba(0,0,0,0.2));
        }

        p {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            border-bottom: var(--border-heavy);
            display: inline-block;
            margin-bottom: 20px;
        }

        .view-link {
            display: block;
            margin: 10px 0;
            color: var(--industry-red);
            text-decoration: none;
            font-weight: 900;
            font-size: 14px;
            text-transform: uppercase;
            transition: 0.2s;
        }

        .view-link:hover {
            background: var(--industry-red);
            color: white;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid var(--steel-dark);
            background: white;
            font-size: 14px;
            font-weight: bold;
            border-radius: 0; /* Square edges for industrial look */
            transition: background 0.3s;
        }

        input:focus, select:focus {
            outline: none;
            background: #fff3f3;
            border-color: var(--industry-red);
        }

        label {
            display: block;
            text-align: left;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            margin-top: 10px;
            color: var(--steel-dark);
        }

        input[type="submit"] {
            background: var(--industry-red);
            color: white;
            border: var(--border-heavy);
            padding: 15px;
            margin-top: 25px;
            cursor: pointer;
            font-weight: 900;
            font-size: 18px;
            text-transform: uppercase;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 4px 4px 0px var(--steel-dark);
        }

        input[type="submit"]:hover {
            transform: translate(-2px, -2px);
            box-shadow: 6px 6px 0px var(--steel-dark);
            background: #a4161a;
        }

        input[type="submit"]:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px var(--steel-dark);
        }

        .success-msg {
            border: 2px solid #2d6a4f;
            background: #d8f3dc;
            color: #1b4332;
            padding: 10px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
            font-size: 12px;
        }

        .error-msg {
            border: 2px solid var(--industry-red);
            background: #ffcccb;
            color: #a4161a;
            padding: 10px;
            font-weight: bold;
            margin: 15px 0;
            text-transform: uppercase;
            font-size: 12px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="blood-drop">🩸</div>
    <h2>Core Registry</h2>
    <a href="view_donors.php" class="view-link">[ ACCESS DATA LOGS ]</a>
    <p>Initiate Donor Enrollment Protocol</p>
    
    <form method="POST">
        <input type="text" name="name" placeholder="OPERATOR NAME" required>
        
        <select name="blood_group" required>
            <option value="" disabled selected>CLASSIFY BLOOD GROUP</option>
            <option value="A+">TYPE A POSITIVE</option>
            <option value="A-">TYPE A NEGATIVE</option>
            <option value="B+">TYPE B POSITIVE</option>
            <option value="B-">TYPE B NEGATIVE</option>
            <option value="O+">TYPE O POSITIVE</option>
            <option value="O-">TYPE O NEGATIVE</option>
            <option value="AB+">TYPE AB POSITIVE</option>
            <option value="AB-">TYPE AB NEGATIVE</option>
        </select>
        
        <input type="text" name="phone" placeholder="COMMS NUMBER" required>

        <label>Timestamp: Last Donation</label>
        <input type="date" name="last_donation_date">

        <?php
        if(isset($_POST['submit'])){
            // PHP Logic remains untouched
            include 'db.php';
            
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $bg = mysqli_real_escape_string($conn, $_POST['blood_group']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $last_date = $_POST['last_donation_date']; 

            $sql = "INSERT INTO donors (name, blood_group, phone, last_donation_date) 
                    VALUES ('$name', '$bg', '$phone', '$last_date')";
            
            if(mysqli_query($conn, $sql)){
                echo "<div class='success-msg'>PRTCL_SUCC: ENTRY RECORDED</div>";
            } else {
                echo "<div class='error-msg'>PRTCL_ERR: " . mysqli_error($conn) . "</div>";
            }
        }
        ?>

        <input type="submit" name="submit" value="EXECUTE REGISTRATION">
    </form>
</div>

</body>
</html>