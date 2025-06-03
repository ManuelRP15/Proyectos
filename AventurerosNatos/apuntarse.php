<?php
session_start();
require_once("funciones.php");
require_once("variables.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario']) && ($_SESSION['usuario']['perfil_id'] == 4 || $_SESSION['usuario']['perfil_id'] == 1)) {
    $usuario_id = $_SESSION['usuario']['id'];
    $oferta_id = $_POST['oferta_id'];

    $conexion = conectarPDO($host, $user, $password, $bbdd);

    $query = "INSERT INTO solicitudes (oferta_id, usuario_id, fecha_solicitud, created_at, updated_at) VALUES (:oferta_id, :usuario_id, NOW(), NOW(), NOW())";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error al apuntarse a la oferta.";
    }
} else {
    header('Location: index.php');
    exit();
}
