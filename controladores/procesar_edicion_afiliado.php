<?php
try {
    require_once 'conexion.php';
    $pdo = Conexion::getPDO();

    // Validar campos obligatorios
    $requeridos = ['nombre', 'apaterno', 'edad', 'sexo', 'parentesco'];
    foreach ($requeridos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            throw new Exception("Falta el campo obligatorio: $campo");
        }
    }

    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $apaterno = trim($_POST['apaterno']);
    $amaterno = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : null;
    $edad = intval($_POST['edad']);
    $sexo = trim($_POST['sexo']);
    $parentesco = trim($_POST['parentesco']);

    // Ejecutar actualización
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

    // Redirigir con mensaje
    header("Location: ../Historial_titular.php?mensaje=actualizado");
    exit;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
