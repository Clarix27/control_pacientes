<?php
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();
    $pk_titular = $_POST['id'];
    $estatus = 1;
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
                'message' => "Se restauro el titular correctamente!"
            ]);
            exit;   
        } else {
            throw new Exception("Ocurrio un error al al restaurar.");
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