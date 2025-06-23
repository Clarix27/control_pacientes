<?php
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();
    $pk_beneficiario = $_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM beneficiarios WHERE pk_beneficiario = :id");
        $stmt->bindParam(':id', $pk_beneficiario, PDO::PARAM_INT);
        $stmt->execute();

        // Opcional: verificas cuántas filas afectó
        if ($stmt->rowCount() > 0) {
            // Devolver JSON de éxito
            echo json_encode([
                'success' => true,
                'message' => "Registro eliminado correctamente."
            ]);
            exit;   
        } else {
            throw new Exception("Ocurrio un error al eliminar.");
        }
    } catch (Exception $e) {
        //Si hay un error throw $th;
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>