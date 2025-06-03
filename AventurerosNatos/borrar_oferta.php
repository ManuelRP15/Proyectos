<?php
session_start();
require_once("funciones.php");
require_once("variables.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario']) && ($_SESSION['usuario']['perfil_id'] == 1 || $_SESSION['usuario']['perfil_id'] == 3)) {
    $conexion = conectarPDO($host, $user, $password, $bbdd);
    $oferta_id = $_POST['oferta_id'];

    if ($_SESSION['usuario']['perfil_id'] == 3) {
        $query_verificar = "SELECT usuario_id FROM ofertas WHERE id = :oferta_id";
        $stmt_verificar = $conexion->prepare($query_verificar);
        $stmt_verificar->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
        $stmt_verificar->execute();
        $oferta = $stmt_verificar->fetch(PDO::FETCH_ASSOC);

        if ($oferta['usuario_id'] != $_SESSION['usuario']['id']) {
            header('Location: index.php?error=No+puedes+borrar+esta+oferta');
            exit;
        }
    }

    $query = "DELETE FROM ofertas WHERE id = :oferta_id";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: index.php?mensaje=Oferta+borrada+con+éxito');
    exit;
} else {
    header('Location: index.php');
    exit;
}
