<?php
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();
    $pk_titular = $_POST['id'];
    $estatus = 0;
    try {
        $stmt = $pdo->prepare("UPDATE titular SET estatus = :estatus WHERE pk_titular = :id");
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_INT);
        $stmt->bindParam(':id', $pk_titular, PDO::PARAM_INT);
        $stmt->execute();

        // Opcional: verificas cuántas filas afectó
        if ($stmt->rowCount() > 0) {
            // Devolver JSON de éxito
            echo json_encode([
                'success' => true,
                'message' => "Se dio de baja a este titular!"
            ]);
            exit;   
        } else {
            throw new Exception("Ocurrio un error al dar de baja.");
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