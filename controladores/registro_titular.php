<?php
    header('Content-Type: application/json');
    require_once('conexion.php');
    $pdo = Conexion::getPDO();

    // Se crea la funcion para insertar el titular
    function insertar_titular($nombre, $a_paterno, $a_materno, $categoria): int {
        $pdo = Conexion::getPDO();
        $sql = $pdo->prepare("INSERT INTO titular(nombre, a_paterno, a_materno, categoria) VALUES(:nombre, :a_paterno, :a_materno, :categoria)");
        $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $sql->bindParam(':a_paterno', $a_paterno, PDO::PARAM_STR);
        $sql->bindParam(':a_materno', $a_materno, PDO::PARAM_STR);
        $sql->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        $sql->execute();
        return $pdo->lastInsertId();
    }

    // Se crea la funcion para insertar el tarjeton
    function insertar_tarjeton($folio, $puesto, $direccion, $titular_id): int {
        $pdo = Conexion::getPDO();
        $sql2 = $pdo->prepare("INSERT INTO tarjeton(folio, puesto, direccion, fk_titular) VALUES(:folio, :puesto, :direccion, :fk_titular)");
        $sql2->bindParam(':folio', $folio, PDO::PARAM_STR);
        $sql2->bindParam(':puesto', $puesto, PDO::PARAM_STR);
        $sql2->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $sql2->bindParam(':fk_titular', $titular_id, PDO::PARAM_INT);
        $sql2->execute();
        return $pdo->lastInsertId();
    }

    // Se define la funcion para insertar domicilio
    function insertar_domicilio($calle, $num_casa, $colonia, $municipio, $titular_id): int {
        $pdo = Conexion::getPDO();
        $stmt = $pdo->prepare("INSERT INTO direccion(calle, num_casa, colonia, municipio, fk_titular) VALUES(:calle, :casa, :colonia, :municipio, :fk_titular)");
        $stmt->bindParam(':calle', $calle, PDO::PARAM_STR);
        $stmt->bindParam(':casa', $num_casa, PDO::PARAM_INT);
        $stmt->bindParam(':colonia', $colonia, PDO::PARAM_STR);
        $stmt->bindParam(':municipio', $municipio, PDO::PARAM_STR);
        $stmt->bindParam(':fk_titular', $titular_id, PDO::PARAM_INT);
        $stmt->execute();
        return $pdo->lastInsertId();
    }
    
    //----------------------------------------------------------------------------------------------------------------------------------------
    try {
    // 1) Recolectar y sanear datos del titular y tarjetón
    $nombre     = trim($_POST['nombre']     ?? '');
    $a_paterno  = trim($_POST['apaterno']   ?? '');
    $a_materno  = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : null;
    $puesto     = trim($_POST['puesto']     ?? '');
    $direccion  = trim($_POST['direccion']  ?? 'ejemplo');
    $categoria  = trim($_POST['categoria']  ?? '');
    $folio      = trim('Folio');

    // 2) Recolectar y sanear datos del domicilio (pueden estar vacíos)
    $calle      = trim($_POST['calle']      ?? '');
    $num_casa   = trim($_POST['num_casa']   ?? '');
    $colonia    = trim($_POST['colonia']    ?? '');
    $municipio  = trim($_POST['municipio']  ?? '');

    // 3) Validar campos obligatorios de titular/tarjetón
    $requiredTitular = ['nombre','apaterno','puesto','categoria'];
    foreach ($requiredTitular as $campo) {
        if (!isset($_POST[$campo]) || trim((string)$_POST[$campo]) === '') {
            echo json_encode([
                'success' => false,
                'message' => "Falta el campo obligatorio: $campo"
            ]);
            exit;
        }
    }

    // 4) Determinar si debemos procesar domicilio: si al menos uno de esos inputs no está vacío
    $hasDomicilio = ($calle !== '' || $num_casa !== '' || $colonia !== '' || $municipio !== '');

    // 5) Si el usuario empez ó a llenar cualquier campo de domicilio, validar que ninguno quede vacío
    if ($hasDomicilio) {
        $requiredDomicilio = ['calle','num_casa','colonia','municipio'];
        foreach ($requiredDomicilio as $campoD) {
            if (!isset($_POST[$campoD]) || trim((string)$_POST[$campoD]) === '') {
                echo json_encode([
                    'success' => false,
                    'message' => "Falta el campo obligatorio de domicilio: $campoD"
                ]);
                exit;
            }
        }
    }

    // 7) Insertar el titular
    $titular_id = insertar_titular($nombre, $a_paterno, $a_materno, $categoria);
    
    if ($titular_id === 0) {
        throw new Exception("No se pudo obtener el ID del titular.");
    }

    // 8) Insertar en tarjetón
    $tarjeton_id = insertar_tarjeton($folio, $puesto, $direccion, $titular_id);

    if ($tarjeton_id === 0) {
        throw new Exception("No se pudo obtener el ID del tarjetón.");
    }

    // 9) Si el usuario llenó datos de domicilio, insertar domiclio también
    if ($hasDomicilio) {
        // Insertar datos en la funcion
        $direccion_id = insertar_domicilio($calle, $num_casa, $colonia, $municipio, $titular_id);
        
        if ($direccion_id === 0) {
            throw new Exception("No se pudo obtener el ID del domicilio.");
        }
    }

    // 10) Devolver JSON de éxito
    echo json_encode([
        'success' => true,
        'message' => "Se Registro con Exito el Titular: $nombre $a_paterno $a_materno"
    ]);
    exit;

    } catch (Exception $e) {
        // Si hay error, revertir transacción y devolver JSON de error
        echo json_encode([
            'success' => false,
            'message' => 'Ocurrio un error con el registro!!!'
        ]);
        exit;
    }
?>