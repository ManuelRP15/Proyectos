<?php
session_start();
require_once("funciones.php");
require_once("variables.php");

if (isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil_id'] == 1) {
    $conexion = conectarPDO($host, $user, $password, $bbdd);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $perfil_id = $_POST['perfil_id'];
        $activo = 1;
        $token = bin2hex(random_bytes(30));
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        if ($perfil_id == 2) { // Gestor
            $query = "INSERT INTO gestores (nombre, email, password, perfil_id, created_at, updated_at) VALUES (:nombre, :email, :password, :perfil_id, :created_at, :updated_at)";
        } else { // Otros perfiles
            $query = "INSERT INTO usuarios (nombre, email, password, perfil_id, activo, token, created_at, updated_at) VALUES (:nombre, :email, :password, :perfil_id, :activo, :token, :created_at, :updated_at)";
        }

        $stmt = $conexion->prepare($query);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
        $stmt->bindParam(':created_at', $created_at, PDO::PARAM_STR);
        $stmt->bindParam(':updated_at', $updated_at, PDO::PARAM_STR);

        if ($perfil_id != 2) {
            $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        }

        try {
            $stmt->execute();
            header('Location: lista_usuarios.php');
            exit;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    header('Location: index.php');
    exit;
}
