<?php
    try {
        header('Content-Type: application/json');
        require_once 'conexion.php';

        // Validar campos obligatorios de titular/tarjetón
        $requiredTitular = ['nombre_t', 'paterno_t', 'nombre_p', 'paterno_p', 'area', 'fecha', 'dependencia', 'parentesco'];
        foreach ($requiredTitular as $campo) {
            if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
                echo json_encode([
                    'success' => false,
                    'message' => "Falta el campo obligatorio: $campo"
                ]);
                exit;
            }
        }

        // Resiviendo datos.
        $nombre_t = isset($_POST['nombre_t']) ? trim($_POST['nombre_t']) : '';
        $paterno_t = isset($_POST['paterno_t']) ? trim($_POST['paterno_t']) : '';
        $materno_t = isset($_POST['materno_t']) ? trim($_POST['materno_t']) : '';
        $nombre_p = isset($_POST['nombre_p']) ? trim($_POST['nombre_p']) : '';
        $paterno_p = isset($_POST['paterno_p']) ? trim($_POST['paterno_p']) : '';
        $materno_p = isset($_POST['materno_p']) ? trim($_POST['materno_p']) : ''; 

        $parentesco = isset($_POST['parentesco']) ? trim($_POST['parentesco']) : ''; 
        $categoria = 'Normal';
        $area = isset($_POST['area']) ? mb_strtoupper(trim($_POST['area']), 'UTF-8') : '';
        $fecha = $_POST['fecha'];
        $dependencia = isset($_POST['dependencia']) ? trim($_POST['dependencia']) : '';
        $apoyo = isset($_POST['apoyo']) ? intval(trim($_POST['apoyo'])) : 0;
        $tarjeta = isset($_POST['tarjeton']) ? trim($_POST['tarjeton']) : ''; 
        $turno = 'Sin turno';
        $fk_empleado = 1;
        $fk_receta = null;

        // Se crea la funcion para insertar el titular
        function insertar_titular($nombre_t, $paterno_t, $materno_t, $dependencia, $categoria): int {
            $pdo = Conexion::getPDO();
            $sql = $pdo->prepare("INSERT INTO titular(nombre, a_paterno, a_materno, dependencia, categoria) VALUES(:nombre, :a_paterno, :a_materno, :dependencia, :categoria)");
            $sql->bindParam(':nombre', $nombre_t, PDO::PARAM_STR);
            $sql->bindParam(':a_paterno', $paterno_t, PDO::PARAM_STR);
            $sql->bindParam(':a_materno', $materno_t, PDO::PARAM_STR);
            $sql->bindParam(':dependencia', $dependencia, PDO::PARAM_STR);
            $sql->bindParam(':categoria', $categoria, PDO::PARAM_STR);
            $sql->execute();
            return $pdo->lastInsertId();
        }

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
        function registrar_consulta($fecha, $pago, $turno, $tipo_consulta, $fk_titular, $fk_paciente, $fk_receta, $fk_empleado) : int {
            $pdo = Conexion::getPDO();
            $stmt = $pdo->prepare("INSERT INTO consulta(fecha, pago, turno, tipo_consulta, fk_titular, fk_paciente, fk_receta, fk_empleado) VALUES(:fecha, :pago, :turno, :tipo_consulta, :fk_titular, :fk_paciente, :fk_receta, :fk_empleado)");
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':pago', $pago, PDO::PARAM_INT);
            $stmt->bindParam(':turno', $turno, PDO::PARAM_STR);
            $stmt->bindParam(':tipo_consulta', $tipo_consulta, PDO::PARAM_STR);
            $stmt->bindParam(':fk_titular', $fk_titular, PDO::PARAM_INT);
            $stmt->bindParam(':fk_paciente', $fk_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':fk_receta', $fk_receta, PDO::PARAM_NULL);
            $stmt->bindParam(':fk_empleado', $fk_empleado, PDO::PARAM_INT);
            $stmt->execute();
            return $pdo->lastInsertId();
        }

        // Se empieza a registrar y validar registros.
        $titular_id = insertar_titular($nombre_t, $paterno_t, $materno_t, $dependencia, $categoria);
        if (empty($titular_id)) {
            throw new Exception("Ocurrio un problema al registrar el titular.");
        }

        $paciente_id = insertar_paciente($nombre_p, $paterno_p, $materno_p, $parentesco, $titular_id);
        if (empty($paciente_id)) {
            throw new Exception("Ocurrio un problema al registrar el paciente.");
        }

        $consulta_id = registrar_consulta($fecha, $apoyo, $turno, $area, $titular_id, $paciente_id, $fk_receta, $fk_empleado);
        if (empty($consulta_id)) {
            throw new Exception("Ocurrio un problema al registrar la consulta.");
        }

        // Devolver JSON de éxito
        echo json_encode([
            'success' => true,
            'message' => "Se Registro con Éxito al Paciente: $nombre_p $paterno_p $materno_p"
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