<?php
    try {
        header('Content-Type: application/json');
        require_once 'conexion.php';

        // Función para insertar paciente.
        function insertar_paciente($nombre_p, $paterno_p, $materno_p, $parentesco , $fk): int {
            $pdo = Conexion::getPDO();
            $stmt = $pdo->prepare("INSERT INTO paciente(nombre, a_paterno, a_materno, parentesco, fk_titular) VALUES(:nombre, :apaterno, :amaterno, :parentesco, :fk)");
            $stmt->bindParam(':nombre', $nombre_p, PDO::PARAM_STR);
            $stmt->bindParam(':apaterno', $paterno_p, PDO::PARAM_STR);
            $stmt->bindParam(':amaterno', $materno_p, PDO::PARAM_STR);
            $stmt->bindParam(':parentesco', $parentesco, PDO::PARAM_STR);
            $stmt->bindParam(':fk', $fk, PDO::PARAM_INT);
            $stmt->execute();
            return $pdo->lastInsertId();
        }

        // Registrar consulta
        function registrar_consulta($fecha, $pago, $turno, $tipo_consulta, $fk_titular, $fk_paciente, $fk_receta, $fk_empleado, $fk_beneficiario) : int {
            $pdo = Conexion::getPDO();
            $stmt = $pdo->prepare("INSERT INTO consulta(fecha, pago, turno, tipo_consulta, fk_titular, fk_paciente, fk_receta, fk_empleado, fk_beneficiario) VALUES(:fecha, :pago, :turno, :tipo_consulta, :fk_titular, :fk_paciente, :fk_receta, :fk_empleado, :fk_beneficiario)");
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':pago', $pago, PDO::PARAM_INT);
            $stmt->bindParam(':turno', $turno, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_consulta', $tipo_consulta, PDO::PARAM_STR);
            $stmt->bindParam(':fk_titular', $fk_titular, PDO::PARAM_INT);
            $stmt->bindParam(':fk_paciente', $fk_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':fk_receta', $fk_receta, PDO::PARAM_NULL);
            $stmt->bindParam(':fk_empleado', $fk_empleado, PDO::PARAM_INT);
            $stmt->bindParam(':fk_beneficiario', $fk_beneficiario, PDO::PARAM_INT);
            $stmt->execute();
            return $pdo->lastInsertId();
        }

        $pk_titular = intval($_POST['pk_titular']);
        $fk_beneficiario = isset($_POST['pk_b']) ? intval($_POST['pk_b']) : null;
        $nombre_p = $_POST['nombre'];
        $paterno_p = $_POST['apellido_paterno'];
        $materno_p = $_POST['apellido_materno'];

        $parentesco = isset($_POST['parentesco']) ? trim($_POST['parentesco']) : 'Misma Persona'; 
        $apoyo = isset($_POST['apoyo']) ? intval(trim($_POST['apoyo'])) : 0;
        $turno = 'Sin turno';
        $fk_empleado = 1;
        $fk_receta = null;
        $paciente_id = 0;
        $consulta_id = 0;
        $fecha = date('Y-m-d');
        $area = $_POST['area'];

        // Se llama a la función
        $paciente_id = insertar_paciente($nombre_p, $paterno_p, $materno_p, $parentesco, $pk_titular);
        if (empty($paciente_id)) {
            throw new Exception("Ocurrio un problema al registrar el paciente.");
        }

        // Se llama a la función
        $consulta_id = registrar_consulta($fecha, $apoyo, $turno, $area, $pk_titular, $paciente_id, $fk_receta, $fk_empleado, $fk_beneficiario);
        if (empty($consulta_id)) {
            throw new Exception("Ocurrio un problema al registrar la consulta.");
        }

        // Devolver JSON de éxito
        echo json_encode([
            'success' => true,
            'message' => "Se registro con exito la consulta!"
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