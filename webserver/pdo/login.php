<?php
require "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user = $_POST["user"];
    $password = $_POST["password"];

    try {
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :user OR email = :email");
        $stmt->execute(['user' => $user, "email" => $user]);
        $result = $stmt->fetch(); // false se non trovato

        if ($result) {
            // Con password hashate (register.php usa password_hash)
            if ($password == $result["password"]) {
                $_SESSION["user_id"] = $result["id"];
                $_SESSION["username"] = $result["username"];

                header("Location: welcome.php");
                exit();
            } else {
                $errore = "Password non corretta.";
            }
        } else {
            $errore = "Utente non trovato.";
        }
    } catch (PDOException $e) {
        $errore = $e->getMessage();
        // In debug: $errore = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accedi</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #9ca1ff; /* indaco */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        h2 {
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4b51c5; /* indaco più scuro */
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #251e87;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">
    <h2>Accedi</h2>

    <?php if(isset($errore)) echo "<div class='error'>$errore</div>"; ?>

    <form method="post">
        <label>Username o Email</label>
        <input type="text" name="user" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Accedi</button>
    </form>
</div>

</body>
</html>
