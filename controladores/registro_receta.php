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

    // Traer paciente
    function traer_paciente($nombre, $apaterno, $amaterno) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT pk_paciente FROM paciente WHERE nombre = :nombre AND a_paterno = :paterno AND a_materno = :materno ORDER BY pk_paciente DESC LIMIT 1");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':paterno', $apaterno, PDO::PARAM_STR);
        $stmt->bindParam(':materno', $amaterno, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Traer consulta.
    function traer_consulta($titular, $paciente) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("SELECT pk_consulta FROM consulta c WHERE c.fecha=CURDATE() AND c.fk_titular = :titular AND c.fk_paciente = :paciente");
        $stmt->bindParam(':titular', $titular, PDO::PARAM_INT);
        $stmt->bindParam(':paciente', $paciente, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
    function editar_consulta($receip, $consult) {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("UPDATE consulta SET fk_receta = :receta WHERE pk_consulta = :consulta");
        $stmt->bindParam(':receta', $receip, PDO::PARAM_INT);
        $stmt->bindParam(':consulta', $consult, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            // error en la ejecución
            return false;
        }
        // devuelve cuántas filas modificó
        return $stmt->rowCount();
    }

    /// Probando las funciones.
    try {
        // Recolección de id.
        $id_titular = !empty($_POST['pk_titular']) ? intval($_POST['pk_titular']) : false;

        // Datos del beneficiario.
        $p_nombre     = trim($_POST['p_nombre']  ?? '');
        $p_paterno  = trim($_POST['p_paterno']   ?? '');
        $p_materno  = isset($_POST['p_materno']) ? trim($_POST['p_materno']) : '';

        // Datos de la receta.
        $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : date('Y-m-d');
        $num_tarjeton = isset($_POST['num_tarjeton']) ? trim($_POST['num_tarjeton']) : '';
        $rx = isset($_POST['rx']) ? trim($_POST['rx']) : false;
        $fk_empleado = 1;

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

        // Traer el pk del paciente.
        $paciente = traer_paciente($p_nombre, $p_paterno, $p_materno);
        if (empty($paciente)) {
            throw new Exception("Ocurrio un error al registrar al paciente.");
        }
        $pk_paciente = intval($paciente['pk_paciente']);

        // Se obtiene la clave de la consulta
        $consulta = traer_consulta($id_titular, $pk_paciente);
        if (empty($consulta)) {
            throw new Exception("Ocurrio al traer los datos de la consulta.");
        }
        $pk_consulta = intval($consulta['pk_consulta']);

        // Se inserta la receta de ese paciente.
        $receta_id = insertar_receta($rx, $folio, $fk_empleado);
        if ($receta_id=== 0) {
            throw new Exception("Ocurrio un error al registrar la receta.");
        }

        // Se registra la consulta
        $consulta_id = editar_consulta($receta_id, $pk_consulta);
        
        // error de ejecución
        if ($consulta_id === false) {
            throw new Exception("Ocurrio un error al editar la consulta.");
        }
        // no encontró coincidencias o el valor era igual al anterior
        elseif ($consulta_id === 0) {
            throw new Exception("No se modificó ningún registro.");
        }else {
            // Devolver JSON de éxito
            echo json_encode([
                'success' => true,
                'message' => "Se Registro con Exito la Receta al Paciente: $p_nombre $p_paterno $p_materno"
            ]);
            exit;
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