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
        // Lista de caracteres a eliminar
        $toRemove = ['-','@','#','$','%','&','*','+','/','=','.',',',';',':','!','?','\''];

        // 1) Recolectar y sanear datos del titular y tarjetón
        $nombre_t     = trim($_POST['nombre']     ?? '');
        $nombre_t2 = str_replace($toRemove, '', $nombre_t);
        $nombre = mb_strtoupper($nombre_t2, 'UTF-8');

        // Quito caracteres y vuelvo en mayusculas
        $a_paterno_t  = trim($_POST['apaterno']   ?? '');
        $paterno_t2 = str_replace($toRemove, '', $a_paterno_t);
        $a_paterno = mb_strtoupper($paterno_t2, 'UTF-8');  

        // Quito caracteres y vuelvo en mayusculas
        $a_materno_t  = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : '';
        $materno_t2 = str_replace($toRemove, '', $a_materno_t);
        $a_materno = mb_strtoupper($materno_t2, 'UTF-8');  

        // Quito lo inecesario y pongo en mayusculas.
        $puesto_t     = trim($_POST['puesto']     ?? '');
        $puesto_t2 = str_replace($toRemove, '', $puesto_t);
        $puesto = mb_strtoupper($puesto_t2, 'UTF-8');

        // Quito lo inecesario y pongo en mayusculas.
        $direccion_t  = trim($_POST['direccion']  ?? 'ejemplo');
        $direccion_t2 = str_replace($toRemove, '', $direccion_t);
        $direccion = mb_strtoupper($direccion_t2, 'UTF-8');

        // Quito lo inecesario y pongo en mayusculas.
        $categoria_t  = trim($_POST['categoria']  ?? '');
        $categoria_t2 = str_replace($toRemove, '', $categoria_t);
        $categoria = mb_strtoupper($categoria_t2, 'UTF-8');

        $folio      =  isset($_POST['folio']) ? trim($_POST['folio']) : '';

        // 2) Recolectar y sanear datos del domicilio (pueden estar vacíos)
        $calle_t      = trim($_POST['calle']    ?? '');
        $calle_t2 = str_replace($toRemove, '', $calle_t);
        $calle = mb_strtoupper($calle_t2, 'UTF-8');

        $num_casa   = trim($_POST['num_casa']   ?? '');

        // Quito lo inecesario y pongo en mayusculas.
        $colonia_t    = trim($_POST['colonia']    ?? '');
        $colonia_t2 = str_replace($toRemove, '', $colonia_t);
        $colonia = mb_strtoupper($colonia_t2, 'UTF-8');

        // Quito lo inecesario y pongo en mayusculas.
        $municipio_t  = trim($_POST['municipio']  ?? '');
        $municipio_t2 = str_replace($toRemove, '', $municipio_t);
        $municipio = mb_strtoupper($municipio_t2, 'UTF-8');

        // 3) Validar campos obligatorios de titular/tarjetón
        $requiredTitular = ['nombre','apaterno','puesto','categoria', 'calle', 'num_casa', 'colonia', 'municipio', 'folio',];
        foreach ($requiredTitular as $campo) {
            if (!isset($_POST[$campo]) || trim((string)$_POST[$campo]) === '') {
                if($campo === 'folio'){
                    throw new Exception("Falta el campo obligatorio: Número del Tarjetón");
                }
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
            'message' => $e->getMessage()
        ]);
        exit;
    }
?>