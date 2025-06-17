<?php
    header('Content-Type: application/json');
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();

    // Obtener el folio del tarjeton del titular.
    function tarjeton_folio($num_tarjeton, $id) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT pk_tarjeton, folio FROM tarjeton WHERE folio = :folio AND fk_titular = :id");
        $stmt->bindParam(':folio', $num_tarjeton, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtner el parentesco del paciente que quieren registrar.
    function traerParentesco($id_b, $id_t) {
        $pdo = Conexion::getPDO();
        $sql1 = $pdo->prepare("SELECT parentesco FROM beneficiarios WHERE pk_beneficiario = :id_b AND fk_tarjeton = :id_t");
        $sql1->bindParam(':id_b', $id_b, PDO::PARAM_INT);
        $sql1->bindParam(':id_t', $id_t, PDO::PARAM_INT);
        $sql1->execute();
        return $sql1->fetch(PDO::FETCH_ASSOC); 
    }

    function insertar_paciente($nombre, $apaterno, $amaterno, $parentesco , $fk): int {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("INSERT INTO paciente(nombre, a_paterno, a_materno, parentesco, fk_titular) VALUES(:nombre, :apaterno, :amaterno, :parentesco, :fk)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apaterno', $apaterno, PDO::PARAM_STR);
        $stmt->bindParam(':amaterno', $amaterno, PDO::PARAM_STR);
        $stmt->bindParam(':parentesco', $parentesco, PDO::PARAM_STR);
        $stmt->bindParam(':fk', $fk, PDO::PARAM_INT);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    // Registrar receta
    function insertar_receta($texto, $folio, $fk) : int {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("INSERT INTO receta(texto_receta, folio, fk_empleado) VALUES(:texto, :folio, :fk)");
        $stmt->bindParam(':texto', $texto, PDO::PARAM_STR);
        $stmt->bindParam(':folio', $folio, PDO::PARAM_STR);
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
        $stmt->bindParam(':fk_receta', $fk_receta, PDO::PARAM_INT);
        $stmt->bindParam(':fk_empleado', $fk_empleado, PDO::PARAM_INT);
        $stmt->execute();
        return $pdo->lastInsertId();
    }

    /// Probando las funciones.
    try {
        // Recolección de id.
        $id_beneficiario = !empty($_POST['pk_beneficiario']) ? (int) $_POST['pk_beneficiario'] : false;
        $id_titular = !empty($_POST['pk_titular']) ? (int) $_POST['pk_titular'] : false;

        // Datos del beneficiario.
        $p_nombre     = trim($_POST['p_nombre']     ?? '');
        $p_paterno  = trim($_POST['p_paterno']   ?? '');
        $p_materno  = isset($_POST['p_materno']) ? trim($_POST['p_materno']) : null;

        // Datos de la receta.
        $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : date('Y-m-d');
        $num_tarjeton = isset($_POST['num_tarjeton']) ? trim($_POST['num_tarjeton']) : null;
        $rx = isset($_POST['rx']) ? trim($_POST['rx']) : false;

        // Por recebizar.
        $area_trabajo = $_POST['area_trabajo'] ?? 'ejemplo';
        $fk_empleado = 1;
        $turno = 'Sin turno';
        $pago = 0;
        $tipo_consulta = 'Consulta General';

        // Validar campos obligatorios de titular/tarjetón
        $requiredTitular = ['fecha','num_tarjeton','rx'];
        foreach ($requiredTitular as $campo) {
            if (!isset($_POST[$campo]) || trim((string)$_POST[$campo]) === '') {
                echo json_encode([
                    'success' => false,
                    'message' => "Falta el campo obligatorio: $campo"
                ]);
                exit;
            }
        }

        // Se obtiene el numero de tarjeton del titular
        $tarjeton = tarjeton_folio($num_tarjeton, $id_titular);
        // Verificar que devolvió algo (array y no false)
        if (!is_array($tarjeton)) {
            throw new Exception("El número del tarjetón no concuerda para ese titular.");
        }

        // Sacamos el id y folio de la variable.
        $id_tarjeton = isset($tarjeton['pk_tarjeton']) ? $tarjeton['pk_tarjeton'] : null;
        $folio = isset($tarjeton['folio']) ? $tarjeton['folio'] : '';

        // Si no hay fila, $paciente === false
        if (!isset($id_tarjeton)) {
            throw new Exception("Ocurrio un error al traer el ID del tarjetón.");
        }
        // Validamos si los folios son los mismos.
        if ($num_tarjeton !== $folio){
            throw new Exception("El folio no concuerda con el titular.");
        }

        // Se trae el parentesco del beneficiario.
        $beneficiario = traerParentesco($id_beneficiario, $id_tarjeton);
        $parentesco = $beneficiario['parentesco'];
        if (!is_array($beneficiario) || !isset($beneficiario['parentesco'])) {
            throw new Exception("Ocurrio un error al registrar el parentesco.");
        }

        // Se inserta al beneficiario como paciente.
        $paciente_id = insertar_paciente($p_nombre, $p_paterno, $p_materno, $parentesco, $id_titular);
        if (empty($paciente_id)) {
            throw new Exception("Ocurrio un error al registrar al paciente.");
        }

        // Se inserta la receta de ese paciente.
        $receta_id = insertar_receta($rx, $folio, $fk_empleado);
        if ($receta_id=== 0) {
            throw new Exception("Ocurrio un error al registrar la receta.");
        }

        // Se registra la consulta
        $consulta_id = registrar_consulta($fecha, $pago, $turno, $tipo_consulta, $id_titular, $paciente_id, $receta_id, $fk_empleado);
        if ($consulta_id === 0) {
            throw new Exception("Ocurrio un error al registrar la consulta.");
        }
        
        // Devolver JSON de éxito
        echo json_encode([
            'success' => true,
            'message' => "Se Registro con Exito la Receta al Paciente: $p_nombre $p_paterno"
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