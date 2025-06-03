<?php
session_start();
require_once("funciones.php");
require_once("variables.php");

if (isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil_id'] == 1) {
    $conexion = conectarPDO($host, $user, $password, $bbdd);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario_id = $_POST['usuario_id'];
        $gestor_id = $_POST['gestor_id'];

        try {
            // Verificar si el usuario es un gestor
            $queryGestor = "SELECT * FROM gestores WHERE id = :gestor_id";
            $stmtGestor = $conexion->prepare($queryGestor);
            $stmtGestor->bindParam(':gestor_id', $gestor_id, PDO::PARAM_INT);
            $stmtGestor->execute();
            $gestor = $stmtGestor->fetch(PDO::FETCH_ASSOC);

            if ($gestor) {
                // Eliminar el gestor
                $queryDeleteGestor = "DELETE FROM gestores WHERE id = :gestor_id";
                $stmtDeleteGestor = $conexion->prepare($queryDeleteGestor);
                $stmtDeleteGestor->bindParam(':gestor_id', $gestor_id, PDO::PARAM_INT);
                $stmtDeleteGestor->execute();
            } else {
                // Eliminar ofertas asociadas al usuario
                $queryOfertas = "DELETE FROM ofertas WHERE usuario_id = :usuario_id";
                $stmtOfertas = $conexion->prepare($queryOfertas);
                $stmtOfertas->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmtOfertas->execute();

                // Eliminar el usuario
                $queryUsuario = "DELETE FROM usuarios WHERE id = :usuario_id";
                $stmtUsuario = $conexion->prepare($queryUsuario);
                $stmtUsuario->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
                $stmtUsuario->execute();
            }

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
