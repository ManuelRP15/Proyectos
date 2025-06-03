<?php
session_start();
require_once("funciones.php");
require_once("variables.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario']) && ($_SESSION['usuario']['perfil_id'] == 2 || $_SESSION['usuario']['perfil_id'] == 1)) {
    $conexion = conectarPDO($host, $user, $password, $bbdd);
    $oferta_id = $_POST['oferta_id'];
    $accion = $_POST['accion'];

    if ($accion == 'visar') {
        $query = "UPDATE ofertas SET visada = 1 WHERE id = :oferta_id";
    } elseif ($accion == 'desvisar') {
        $query = "UPDATE ofertas SET visada = 0 WHERE id = :oferta_id";
    }

    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: index.php');
    exit;
} else {
    header('Location: index.php');
    exit;
}
