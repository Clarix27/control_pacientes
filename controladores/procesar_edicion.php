<?php
require_once 'conexion.php';
$pdo = Conexion::getPDO();

function actualizar_titular($id, $nombre, $a_paterno, $a_materno, $categoria) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE titular SET nombre = :nombre, a_paterno = :a_paterno, a_materno = :a_materno, categoria = :categoria WHERE pk_titular = :id");
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':a_paterno', $a_paterno);
    $stmt->bindParam(':a_materno', $a_materno);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function actualizar_tarjeton($id, $puesto, $direccion) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE tarjeton SET puesto = :puesto, direccion = :direccion WHERE fk_titular = :id");
    $stmt->bindParam(':puesto', $puesto);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function actualizar_direccion($id, $calle, $num_casa, $colonia, $municipio) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE direccion SET calle = :calle, num_casa = :num_casa, colonia = :colonia, municipio = :municipio WHERE fk_titular = :id");
    $stmt->bindParam(':calle', $calle);
    $stmt->bindParam(':num_casa', $num_casa);
    $stmt->bindParam(':colonia', $colonia);
    $stmt->bindParam(':municipio', $municipio);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

try {
    $id = intval($_POST['id'] ?? 0);
    $nombre = trim($_POST['nombre'] ?? '');
    $a_paterno = trim($_POST['apaterno'] ?? '');
    $a_materno = trim($_POST['amaterno'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $puesto = trim($_POST['puesto'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');

    $calle = trim($_POST['calle'] ?? '');
    $num_casa = trim($_POST['num_casa'] ?? '');
    $colonia = trim($_POST['colonia'] ?? '');
    $municipio = trim($_POST['municipio'] ?? '');

    if (!$id || $nombre === '' || $a_paterno === '' || $puesto === '' || $categoria === '') {
        throw new Exception("Faltan campos obligatorios.");
    }
    

    $pdo->beginTransaction();

    actualizar_titular($id, $nombre, $a_paterno, $a_materno, $categoria);
    actualizar_tarjeton($id, $puesto, $direccion);

    // Si alguno de los campos de domicilio está lleno, se actualiza dirección
    if ($calle !== '' || $num_casa !== '' || $colonia !== '' || $municipio !== '') {
        actualizar_direccion($id, $calle, $num_casa, $colonia, $municipio);
    }

    $pdo->commit();

    header("Location: ../lista_titulares.php?mensaje=actualizado");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
    exit;
}
