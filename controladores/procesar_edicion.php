<?php
header('Content-Type: application/json');
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
    $categoria_t  = trim($_POST['categoria']  ?? '');
    $categoria_t2 = str_replace($toRemove, '', $categoria_t);
    $categoria = mb_strtoupper($categoria_t2, 'UTF-8');

    // Quito lo inecesario y pongo en mayusculas.
    $puesto_t     = trim($_POST['puesto']     ?? '');
    $puesto_t2 = str_replace($toRemove, '', $puesto_t);
    $puesto = mb_strtoupper($puesto_t2, 'UTF-8');

    // Quito lo inecesario y pongo en mayusculas.
    $direccion_t  = trim($_POST['direccion']  ?? 'ejemplo');
    $direccion_t2 = str_replace($toRemove, '', $direccion_t);
    $direccion = mb_strtoupper($direccion_t2, 'UTF-8');

    // 2) Recolectar y sanear datos del domicilio (pueden estar vacíos)
    $calle_t      = trim($_POST['calle']    ?? '');
    $calle_t2 = str_replace($toRemove, '', $calle_t);
    $calle = mb_strtoupper($calle_t2, 'UTF-8');

    $num_casa   = !empty($_POST['num_casa']) ? trim($_POST['num_casa']) : 'S/N';

    // Quito lo inecesario y pongo en mayusculas.
    $colonia_t    = trim($_POST['colonia']    ?? '');
    $colonia_t2 = str_replace($toRemove, '', $colonia_t);
    $colonia = mb_strtoupper($colonia_t2, 'UTF-8');

    // Quito lo inecesario y pongo en mayusculas.
    $municipio_t  = trim($_POST['municipio']  ?? '');
    $municipio_t2 = str_replace($toRemove, '', $municipio_t);
    $municipio = mb_strtoupper($municipio_t2, 'UTF-8');

    if (!$id || $nombre === '' || $a_paterno === '' || $puesto === '' || $categoria === '') {
        throw new Exception("Faltan campos obligatorios.");
    }
    

    

    $v1 = actualizar_titular($id, $nombre, $a_paterno, $a_materno, $categoria);
    $v2 = actualizar_tarjeton($id, $puesto, $direccion);
    $v3 = 0;

    // Si alguno de los campos de domicilio está lleno, se actualiza dirección
    if ($calle !== '' || $num_casa !== '' || $colonia !== '' || $municipio !== '') {
        $v3 = actualizar_direccion($id, $calle, $num_casa, $colonia, $municipio);
    }

    if ($v1 === false) {
        throw new Exception("Error al actualizar titular");
    }
    
    if ($v2 === false) {
        throw new Exception("Error al actualizar tarjetón");
    }
    
    if ($v3 === false) {
        throw new Exception("Error al actualizar dirección");
    }

    // 10) Devolver JSON de éxito
    echo json_encode([
        'success' => true,
        'message' => "Se actualizaron con exito los datos de: $nombre $a_paterno $a_materno"
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
    exit;
}
