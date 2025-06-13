<?php
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();

    $id_beneficiario = isset($_POST['pk_beneficiario']) ? trim($_POST['amaterno']) : 1;
    $id_titular = isset($_POST['pk_titular']) ? trim($_POST['amaterno']) : 2;
    $p_nombre     = trim($_POST['p_nombre']     ?? 'Paco');
    $p_paterno  = trim($_POST['p_paterno']   ?? 'El chato');
    //$p_materno  = isset($_POST['p_materno']) ? trim($_POST['amaterno']) : null;
    $p_materno  = isset($_POST['p_materno']) ?? 'huvos';
    $fecha = isset($_POST['t_materno']) ? trim($_POST['amaterno']) : '2025-06-05';
    $num_tarjeton = $_POST['num_tarjeton'] ?? 'F-003';
    $area_trabajo = $_POST['area_trabajo'] ?? 'ejemplo';
    $rx = $_POST['rx'] ?? 'ndldkdak';
    $folio = 'Ejemplo';
    $fk_empleado = 1;
    $turno = 'Sin turno';
    $pago = 0;
    $tipo_consulta = 'Consulta General';

    // Obtener el folio del tarjeton del titular.
    function tarjeton_folio($num_tarjeton, $id) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT pk_tarjeton, folio FROM tarjeton WHERE folio = :folio AND fk_titular = :id");
        $stmt->bindParam(':folio', $num_tarjeton, PDO::PARAM_INT);
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
        $tarjeton = tarjeton_folio($num_tarjeton, $folio);
        $id_tarjeton = $tarjeton['pk_tarjeton'];
        $folio = $tarjeton['folio'];

        //     
        $beneficiario = traerParentesco($id_beneficiario, $id_tarjeton);
        $parentesco = $beneficiario['parentesco'];

        //
        $paciente_id = insertar_paciente($p_nombre, $p_paterno, $p_materno, $parentesco, $id_titular);
        //
        $receta_id = insertar_receta($rx, $folio, $fk_empleado);
        //
        $consulta_id = registrar_consulta($fecha, $pago, $turno, $tipo_consulta, $id_titular, $paciente_id, $receta_id, $fk_empleado);
        
        // Devolver JSON de éxito
        echo json_encode([
            'success' => true,
            'message' => "Se Registro con Exito la Receta al Paciente: $p_nombre $a_paterno"
        ]);
        exit;
    } catch (PDOException $e) {
        //throw $th;
        echo "Ocurrió un error de base de datos: " . $e->getMessage();
        echo "......".$e->getLine();
    }

?>