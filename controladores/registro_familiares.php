<?php
    try {
        header('Content-Type: application/json');
        require_once 'conexion.php';
        $pdo = Conexion::getPDO();
        
        // Validar campos obligatorios de titular/tarjetón
        $requiredTitular = ['nombre', 'apaterno', 'edad', 'sexo', 'parentesco'];
        foreach ($requiredTitular as $campo) {
            if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
                echo json_encode([
                    'success' => false,
                    'message' => "Falta el campo obligatorio: $campo"
                ]);
                exit;
            }
        }

        $pk_titular = !empty($_POST['pk_titular']) ? intval($_POST['pk_titular']) : null;
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $apaterno = isset($_POST['apaterno']) ? trim($_POST['apaterno']) : '';
        $amaterno = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : null;
        $edad = isset($_POST['edad']) ? trim($_POST['edad']) : '';;
        $sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : '';;
        $parentesco = isset($_POST['parentesco']) ? trim($_POST['parentesco']) : '';


        // Consulta
        $sql = $pdo->prepare("SELECT pk_tarjeton FROM tarjeton WHERE fk_titular = :id");
        $sql->bindParam(':id', $pk_titular, PDO::PARAM_INT);
        $sql->execute();
        $tarjeton = $sql->fetch(PDO::FETCH_ASSOC);

        if (!is_array($tarjeton) || empty($tarjeton)) {
            throw new Exception("Ocurrio un error al trear una información del titular.");
        }
        $pk_tarjeton = intval($tarjeton['pk_tarjeton']);
        
        // Consulta
        $stmt = $pdo->prepare("INSERT INTO beneficiarios (nombre, a_paterno, a_materno, edad, sexo, parentesco, fk_tarjeton) VALUES(:nombre, :paterno, :materno, :edad, :sexo, :parentesco, :fk)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':paterno', $apaterno, PDO::PARAM_STR);
        $stmt->bindParam(':materno', $amaterno, PDO::PARAM_STR);
        $stmt->bindParam(':edad', $edad, PDO::PARAM_INT);
        $stmt->bindParam(':sexo', $sexo, PDO::PARAM_STR);
        $stmt->bindParam(':parentesco', $parentesco, PDO::PARAM_STR);
        $stmt->bindParam(':fk', $pk_tarjeton, PDO::PARAM_INT);
        $stmt->execute();
        $beneficiario_id = $pdo->lastInsertId();

        if (empty($beneficiario_id)) {
            throw new Exception("Ocurrio un error al registrar al afiliado.{$pk_tarjeton}");
        }

        // Devolver JSON de éxito
        echo json_encode([
            'success' => true,
            'message' => "Se Registro al Afiliado: $nombre $apaterno $amaterno"
        ]);
        exit;
    } catch (Exception $e) {
        //Si hay un error throw $th;
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
        exit;
    }

?>