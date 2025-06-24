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
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f4;
      color: #333;
    }

    .titulo-container-subtle {
    background: #9CD8D9;
    border-left: 8px solid #CC1A1A;
    padding: 2px 5px;
    margin: 20px 0 10px 0;
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
  }

    .titulo-container-subtle h2 {
    margin: 0;
    font-size: 21px;
    font-weight: 600;
    text-align: center;
    color: #2c3e50;
  }

    .receta-lista {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 90%;
      max-width: 1000px;
      margin: auto;
      margin-bottom: 40px;
    }

    .receta-card {
      background: #fff;
      padding: 20px;
      border-left: 6px solid #2980b9;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .receta-card h3 {
      margin-bottom: 8px;
      font-size: 18px;
      color: #2980b9;
    }

    .receta-card p {
      margin: 5px 0;
      font-size: 14px;
      line-height: 1.6;
    }

    .receta-card .fecha {
      font-weight: bold;
      color: #555;
    }

    .volver-btn {
      display: block;
      text-align: center;
      margin: 20px auto;
      background-color: #CC1A1A;
      color: white;
      padding: 10px 25px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
      text-decoration: none;
      width: fit-content;
    }

    .volver-btn:hover {
      background-color: #a30000;
    }

       .back-button {
  color: #333;
  font-size: 18px;
  font-weight: bold;
  text-decoration: none;
  text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
  transition: color 0.3s ease;
}

.back-button:hover {
  color: #cc1a1a;
  text-shadow: 1px 1px 3px rgba(204, 26, 26, 0.6);
}

.back-text {
  font-size: 18px;  
  font-weight: normal;
}
  </style>
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
