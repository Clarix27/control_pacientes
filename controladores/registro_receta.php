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

        // 1. Obtener tarjetón
$tarjeton = tarjeton_folio($num_tarjeton, $id_titular);
if (!is_array($tarjeton)) {
    throw new Exception("El número del tarjetón no concuerda para ese titular.");
}
$id_tarjeton = $tarjeton['pk_tarjeton'];
$folio = $tarjeton['folio'];

// 2. Si es receta de beneficiario
if ($id_beneficiario) {
    // Verifica parentesco
    $beneficiario = traerParentesco($id_beneficiario, $id_tarjeton);
    if (!is_array($beneficiario) || !isset($beneficiario['parentesco'])) {
        throw new Exception("No se pudo obtener el parentesco.");
    }

    $parentesco = $beneficiario['parentesco'];

    // Insertar paciente
    $paciente_id = insertar_paciente($p_nombre, $p_paterno, $p_materno, $parentesco, $id_titular);
    if (!$paciente_id) {
        throw new Exception("Error al registrar al paciente.");
    }

} else {
    // 3. Si es receta del titular
    // Buscar si ya existe paciente “Misma persona”
    $stmt = $pdo->prepare("SELECT pk_paciente FROM paciente WHERE fk_titular = ? AND parentesco = 'Misma persona'");
    $stmt->execute([$id_titular]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($paciente) {
        $paciente_id = $paciente['pk_paciente'];
    } else {
        // Obtener datos del titular
        $stmt = $pdo->prepare("SELECT nombre, a_paterno, a_materno FROM titular WHERE pk_titular = ?");
        $stmt->execute([$id_titular]);
        $titular = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$titular) {
            throw new Exception("No se pudo obtener los datos del titular.");
        }

        $paciente_id = insertar_paciente($titular['nombre'], $titular['a_paterno'], $titular['a_materno'], 'Misma persona', $id_titular);
    }
}

// 4. Insertar receta
$receta_id = insertar_receta($rx, $folio, $fk_empleado);
if (!$receta_id) {
    throw new Exception("Error al registrar la receta.");
}

// 5. Insertar consulta
$consulta_id = registrar_consulta($fecha, $pago, $turno, $tipo_consulta, $id_titular, $paciente_id, $receta_id, $fk_empleado);
if (!$consulta_id) {
    throw new Exception("Error al registrar la consulta.");
}

// ✅ Éxito
echo json_encode([
    'success' => true,
    'message' => "Receta registrada correctamente"
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