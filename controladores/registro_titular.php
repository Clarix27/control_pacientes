<?php
    header('Content-Type: application/json');
    require_once('conexion.php');
    $pdo = Conexion::getPDO();

    $required = ['nombre','apaterno','domicilio','puesto','direccion','categoria'];
    foreach ($required as $field) {
        // Si no existe la clave O está vacía (excepto '0')
        if (!isset($_POST[$field]) || trim((string)$_POST[$field]) === '') {
            echo json_encode([
                'success' => false,
                'message' => "Falta el campo obligatorio: $field"
            ]);
            exit;
        }
    }

    $nombre     = trim($_POST['nombre']);
    $a_paterno  = trim($_POST['apaterno']);
    $a_materno  = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : null;
    $domicilio  = trim($_POST['domicilio']);
    $puesto     = trim($_POST['puesto']);
    $direccion  = trim($_POST['direccion']);
    $categoria  = trim($_POST['categoria']);
    $folio      = trim('Folio');

    //Insertar el titular
    $sql = $pdo->prepare("INSERT INTO titular(nombre, a_paterno, a_materno, categoria) VALUES(:nombre, :a_paterno, :a_materno, :categoria)");
    $sql->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $sql->bindParam(':a_paterno', $a_paterno, PDO::PARAM_STR);
    $sql->bindParam(':a_materno', $a_materno, PDO::PARAM_STR);
    $sql->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    $sql->execute();
    $titular_id = $pdo->lastInsertId();

    if (!isset($titular_id)) {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo registrar el titular!'
        ]);
        exit;
    }

    //Insertar los demas datos al tarjeton
    $sql2 = $pdo->prepare("INSERT INTO tarjeton(folio, puesto, direccion, fk_titular) VALUES(:folio, :puesto, :direccion, :fk_titular)");
    $sql2->bindParam(':folio', $folio, PDO::PARAM_STR);
    $sql2->bindParam(':puesto', $puesto, PDO::PARAM_STR);
    $sql2->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $sql2->bindParam(':fk_titular', $titular_id, PDO::PARAM_INT);
    $sql2->execute();
    $tarjeton_id = $pdo->lastInsertId();

    if ($tarjeton_id) {
        echo json_encode([
            'success' => true,
            'message' => ' Registrado con Exito el Titular: ' . $nombre
        ]);
        exit;
    }else{
        echo json_encode([
            'success' => false,
            'message' => 'Ocurrio un error con el registro!!!'
        ]);
        exit;
    }
?>