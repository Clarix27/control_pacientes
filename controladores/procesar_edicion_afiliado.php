<?php
try {
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
    $nombre = trim($_POST['nombre']);
    $apaterno = trim($_POST['apaterno']);
    $amaterno = isset($_POST['amaterno']) ? trim($_POST['amaterno']) : null;
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

    header("Location: ../Historial_titular.php?id=" . urlencode($pk_titular) . "&mensaje=actualizado");
    exit;

} catch (Exception $e) {
    header("Location: ../Editar_afiliado.php?id=" . urlencode($_POST['id']) . "&error=" . urlencode($e->getMessage()));
    exit;
}
