<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirmPassword = trim($_POST["confirm_password"] ?? "");

    if ($password !== $confirmPassword) {
        $errore = "Le password non coincidono";
    } else {
        $passwordHash = password_hash($_POST["password"] ?? "", PASSWORD_DEFAULT);

        try {
            // Controllo se username o email esistono già
            $check = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $check->execute([
                'username' => $username,
                'email' => $email
            ]);
            $exists = (int)$check->fetchColumn();

            if ($exists > 0) {
                $errore = "Username o Email già registrati!";
            } else {

                $stmt = $conn->prepare(
                    "INSERT INTO users (username, email, password)
                 VALUES (:username, :email, :password)"
                );

                $stmt->execute([
                    'username' => $username,
                    'email' => $email,
                    'password' => $passwordHash
                ]);

                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            $errore = "Errore durante la registrazione.";
            // In debug: $errore = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Registrati</title>

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
    <h2>Registrati</h2>

    <?php if(isset($errore)) echo "<div class='error'>$errore</div>"; ?>

    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Conferma password</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Registrati</button>
    </form>
</div>

</body>
</html>
