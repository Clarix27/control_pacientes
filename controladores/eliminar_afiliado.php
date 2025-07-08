<?php
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();
    $pk_beneficiario = $_POST['id'];
    $estatus = 0;
    try {
        $stmt = $pdo->prepare("UPDATE beneficiarios SET estatus = :estatus WHERE pk_beneficiario = :id");
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
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