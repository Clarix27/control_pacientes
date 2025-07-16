<?php
require_once 'conexion.php';
header('Content-Type: application/json');

try {
  $id_consulta = intval($_POST['id_consulta']);
  $area = trim($_POST['area']);
  $pago = intval($_POST['pago']);

  // Campos de paciente
  $nombre_p = mb_strtoupper(trim($_POST['nombre_p']), 'UTF-8');
  $paterno_p = mb_strtoupper(trim($_POST['paterno_p']), 'UTF-8');
  $materno_p = mb_strtoupper(trim($_POST['materno_p']), 'UTF-8');

  // Campos de titular
  $nombre_t = mb_strtoupper(trim($_POST['nombre_t']), 'UTF-8');
  $paterno_t = mb_strtoupper(trim($_POST['paterno_t']), 'UTF-8');
  $materno_t = mb_strtoupper(trim($_POST['materno_t']), 'UTF-8');

  $pdo = Conexion::getPDO();
  $pdo->beginTransaction();

  // 1. Actualizar consulta
  $updateConsulta = $pdo->prepare("
    UPDATE consulta 
    SET tipo_consulta = :area, pago = :pago 
    WHERE pk_consulta = :id
  ");
  $updateConsulta->execute([
    ':area' => $area,
    ':pago' => $pago,
    ':id' => $id_consulta
  ]);

  // 2. Obtener fk_paciente y fk_titular
  $query = $pdo->prepare("
    SELECT fk_paciente, fk_titular 
    FROM consulta 
    WHERE pk_consulta = :id
  ");
  $query->execute([':id' => $id_consulta]);
  $row = $query->fetch(PDO::FETCH_ASSOC);

  if (!$row) {
    throw new Exception("Consulta no encontrada.");
  }

  $fk_paciente = $row['fk_paciente'];
  $fk_titular = $row['fk_titular'];

  // 3. Obtener datos actuales de ambos para comparar
  $getPaciente = $pdo->prepare("SELECT nombre, a_paterno, a_materno FROM paciente WHERE pk_paciente = ?");
  $getPaciente->execute([$fk_paciente]);
  $pac = $getPaciente->fetch(PDO::FETCH_ASSOC);

  $getTitular = $pdo->prepare("SELECT nombre, a_paterno, a_materno FROM titular WHERE pk_titular = ?");
  $getTitular->execute([$fk_titular]);
  $tit = $getTitular->fetch(PDO::FETCH_ASSOC);

  $esMismaPersona = (
    $pac['nombre'] === $tit['nombre'] &&
    $pac['a_paterno'] === $tit['a_paterno'] &&
    $pac['a_materno'] === $tit['a_materno']
  );

  // 4. Actualizar paciente
  $updatePaciente = $pdo->prepare("
    UPDATE paciente 
    SET nombre = :nombre, a_paterno = :paterno, a_materno = :materno 
    WHERE pk_paciente = :id
  ");
  $updatePaciente->execute([
    ':nombre' => $nombre_p,
    ':paterno' => $paterno_p,
    ':materno' => $materno_p,
    ':id' => $fk_paciente
  ]);

  // 5. Si son la misma persona, actualizar también titular con los mismos datos
  //    Si no lo son, usar los datos del formulario del titular
  if ($esMismaPersona) {
    $nombre_t = $nombre_p;
    $paterno_t = $paterno_p;
    $materno_t = $materno_p;
  }

  $updateTitular = $pdo->prepare("
    UPDATE titular 
    SET nombre = :nombre, a_paterno = :paterno, a_materno = :materno 
    WHERE pk_titular = :id
  ");
  $updateTitular->execute([
    ':nombre' => $nombre_t,
    ':paterno' => $paterno_t,
    ':materno' => $materno_t,
    ':id' => $fk_titular
  ]);

  $pdo->commit();
  echo json_encode(['success' => true, 'message' => 'Consulta, paciente y titular actualizados.']);
} catch (Exception $e) {
  if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
