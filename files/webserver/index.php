<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION["username"]);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Area Riservata</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }

        /* Barra superiore */
        .header {
            background-color: #9ca1ff;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        /* Testo scorrevole */
        .marquee {
            margin-top: 40px;
            font-size: 22px;
            font-weight: bold;
            color: #4b51c5;
            white-space: nowrap;
            overflow: hidden;
            box-sizing: border-box;
        }

        .marquee span {
            display: inline-block;
            padding-left: 100%;
            animation: scroll 10s linear infinite;
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        /* Logout */
        .logout-container {
            text-align: center;
            margin-top: 40px;
        }

        .logout-btn {
            padding: 12px 30px;
            background-color: #9ca1ff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background-color: #4b51c5;
        }
    </style>
</head>
<body>

<div class="header">
    Area Riservata
</div>

<div class="marquee">
    <span>The Mighty Zaras ti danno il benvenuto <?php echo $username; ?>!</span>
</div>

<div class="logout-container">
    <form action="logout.php" method="post">
        <button class="logout-btn" type="submit">Logout</button>
    </form>
</div>

</body>
</html>