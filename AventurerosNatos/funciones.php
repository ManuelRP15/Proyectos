<?php
function conectarPDO($host, $user, $password, $bbdd)
{
    try {
        $dsn = "mysql:host=$host;dbname=$bbdd;charset=utf8mb4";
        $conexion = new PDO($dsn, $user, $password);

        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        exit;
    }
}

function apuntarseOferta($usuario_id, $oferta_id)
{
    global $conexion;
    $query = "INSERT INTO solicitudes (usuario_id, oferta_id, fecha_solicitud) VALUES (:usuario_id, :oferta_id, NOW())";
    $stmt = $conexion->prepare($query);
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->bindParam(':oferta_id', $oferta_id, PDO::PARAM_INT);
    return $stmt->execute();
}

function obtenerCategorias()
{
    global $conexion;
    $query = "SELECT * FROM categorias";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
