<?php 
require_once 'controladores/conexion.php';
$pdo = Conexion::getPDO();

$id_titular = isset($_GET['id_t']) ? intval($_GET['id_t']) : 0;
$recetas = [];

if ($id_titular > 0) {
  // Consulta directa: recetas de pacientes con parentesco 'Misma persona' y este titular
  $stmt = $pdo->prepare("
    SELECT r.texto_receta, c.fecha
    FROM consulta c
    INNER JOIN receta r ON c.fk_receta = r.pk_receta
    INNER JOIN paciente p ON c.fk_paciente = p.pk_paciente
    WHERE c.fk_titular = :titular AND p.parentesco = 'Misma persona'
    ORDER BY c.fecha DESC
  ");
  $stmt->execute(['titular' => $id_titular]);
  $recetas = $stmt->fetchAll();
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
    <link rel="stylesheet" href="css/estilo_ver_receta_titular.css">

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

<footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo.
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>


</body>
</html>
