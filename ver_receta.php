<?php 
require_once 'controladores/conexion.php';
$pdo = Conexion::getPDO();

$id_titular = isset($_GET['id_t']) ? intval($_GET['id_t']) : 0;
$id_beneficiario = isset($_GET['id_b']) ? intval($_GET['id_b']) : 0;

$recetas = [];

if ($id_titular > 0) {
  if ($id_beneficiario > 0) {
    // Paso 1: Buscar datos del beneficiario
    $stmt = $pdo->prepare("SELECT nombre, a_paterno, a_materno FROM beneficiarios WHERE pk_beneficiario = :id_b");
    $stmt->execute(['id_b' => $id_beneficiario]);
    $benef = $stmt->fetch();

    if ($benef) {
      // Paso 2: Buscar todos los pacientes que coincidan con el nombre/apellidos del beneficiario
      $sql_p = "SELECT pk_paciente FROM paciente 
                WHERE nombre = ? AND a_paterno = ? AND a_materno = ? AND fk_titular = ?";
      $stmt_p = $pdo->prepare($sql_p);
      $stmt_p->execute([
        $benef['nombre'],
        $benef['a_paterno'],
        $benef['a_materno'],
        $id_titular
      ]);
      $pacientes = $stmt_p->fetchAll(PDO::FETCH_COLUMN);

      if ($pacientes) {
        // Paso 3: Buscar todas las recetas para todos los pacientes encontrados
        $placeholders = implode(',', array_fill(0, count($pacientes), '?'));
        $sql_r = "SELECT r.texto_receta, c.fecha
                  FROM consulta c
                  INNER JOIN receta r ON c.fk_receta = r.pk_receta
                  WHERE c.fk_paciente IN ($placeholders) AND c.fk_titular = ?
                  ORDER BY c.fecha DESC";
        $stmt_r = $pdo->prepare($sql_r);
        $stmt_r->execute([...$pacientes, $id_titular]);
        $recetas = $stmt_r->fetchAll();
      }
    }
  } else {
    // Mostrar todas las recetas del titular (si no se indicó beneficiario)
    $stmt = $pdo->prepare("SELECT r.texto_receta, c.fecha
      FROM receta r
      INNER JOIN consulta c ON c.fk_receta = r.pk_receta
      WHERE c.fk_titular = :id
      ORDER BY c.fecha DESC");
    $stmt->execute(['id' => $id_titular]);
    $recetas = $stmt->fetchAll();
  }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Historial de Recetas</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilo_ver_receta.css">
</head>
<body>
    <?php include 'menu.php'?>

  <div style="margin: 15px 0 0 20px;">
  <a href="Historial_titular.php?id=<?=urlencode($id_titular)?>" class="back-button">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>
    

  <div class="titulo-container-subtle">
    <h2>Historial de Recetas Médicas</h2>
  </div>

  <div class="receta-lista">
  <?php if (!empty($recetas)): ?>
    <?php foreach ($recetas as $receta): ?>
      <div class="receta-card">
        <p class="fecha">Fecha: <?= htmlspecialchars($receta['fecha']) ?></p>
        <p><strong>RX:</strong><br><?= nl2br(htmlspecialchars($receta['texto_receta'])) ?></p>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="text-align:center;">No se encontraron recetas registradas.</p>
  <?php endif; ?>
</div>


</body>
</html>