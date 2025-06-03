<?php
session_start();
require_once("../funciones.php");
require_once("../variables.php");

if (isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = conectarPDO($host, $user, $password, $bbdd);
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM gestores WHERE email = :email";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario'] = $user;
        header('Location: ../index.php');
        exit;
    } else {
        $error = 'Correo o contraseña incorrectos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="icon" type="image/x-icon" href="../img/favicon.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg,rgb(54, 39, 15),rgb(224, 126, 91));
            animation: fadeIn 1s ease-in-out;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.15);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            width: 400px;
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: white;
            font-size: 28px;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            text-align: left;
            margin-bottom: 8px;
            color: white;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transition: background 0.3s, border 0.3s;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .input-group input:focus {
            border: 2px solid #FFB84D;
            box-shadow: 0 0 8px rgba(255, 184, 77, 0.8);
        }

        .error-message {
            color: #FF4C4C;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: #FFB84D;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #FF7F4F;
        }

        .links {
            margin-top: 15px;
        }

        .links a {
            display: block;
            font-size: 15px;
            color: #ffffff;
            text-decoration: none;
            margin-top: 10px;
            transition: opacity 0.3s;
        }

        .links a:hover {
            opacity: 0.7;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" placeholder="Introduce tu email" value="<?php if (isset($_POST['email'])) echo htmlspecialchars($_POST['email']); ?>" required>
            </div>

            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" placeholder="Introduce tu contraseña" required>
            </div>

            <button type="submit" class="login-btn">Iniciar sesión</button>
        </form>
        <br>
        <div class="links">
            <a href="../index.php">Volver a la página web</a>
        </div>
    </div>

</body>

</html>