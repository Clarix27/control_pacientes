<?php
try {
    header('Content-Type: application/json');
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();

    $requeridos = ['nombre', 'apaterno', 'edad', 'sexo', 'parentesco', 'pk_titular', 'id'];
    foreach ($requeridos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            header("Location: ../Editar_afiliado.php?id=" . urlencode($_POST['id']) . "&error=Falta el campo: $campo");
            exit;
        }
    }

    $id = intval($_POST['id']);
    // Lista de caracteres a eliminar
    $toRemove = ['-','@','#','$','%','&','*','+','/','=','.',',',';',':','!','?','\''];

    // 1) Recolectar y sanear datos del titular y tarjetón
    $nombre_t     = trim($_POST['nombre']     ?? '');
    $nombre_t2 = str_replace($toRemove, '', $nombre_t);
    $nombre = mb_strtoupper($nombre_t2, 'UTF-8');

    // Quito caracteres y vuelvo en mayusculas
    $a_paterno_t  = trim($_POST['apaterno']   ?? '');
    $paterno_t2 = str_replace($toRemove, '', $a_paterno_t);
    $apaterno = mb_strtoupper($paterno_t2, 'UTF-8');  

    // Quito caracteres y vuelvo en mayusculas
    $a_materno_t  = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : '';
    $materno_t2 = str_replace($toRemove, '', $a_materno_t);
    $amaterno = mb_strtoupper($materno_t2, 'UTF-8');  

    $edad = intval($_POST['edad']);
    $sexo = trim($_POST['sexo']);
    $parentesco = trim($_POST['parentesco']);
    $pk_titular = intval($_POST['pk_titular']);

    $stmt = $pdo->prepare("UPDATE beneficiarios 
        SET nombre = :nombre, a_paterno = :apaterno, a_materno = :amaterno, 
            edad = :edad, sexo = :sexo, parentesco = :parentesco 
        WHERE pk_beneficiario = :id");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apaterno', $apaterno);
    $stmt->bindParam(':amaterno', $amaterno);
    $stmt->bindParam(':edad', $edad);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':parentesco', $parentesco);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo json_encode([
        'success' => true,
        'message' => "Se actualizaron con exito los datos de: $nombre $apaterno $amaterno"
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
