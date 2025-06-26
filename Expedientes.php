<?php
  session_start();
  // Verificar si el usuario ha iniciado sesión
  if (!isset($_SESSION['pk_usuario'])) {
    // Redirigir a la página de login si no está autenticado
    echo("<script>window.location.assign('Login.html');</script>");
    exit();
  }
  // Continua si esta bien
  require_once 'controladores/conexion.php';
  $pdo = Conexion::getPDO();
  $consulta = $pdo->query("SELECT YEAR(fecha) AS anio, MONTH(fecha) AS mes FROM consulta GROUP BY anio, mes ORDER BY anio DESC, mes DESC");
  $expedientes = $consulta->fetchAll(PDO::FETCH_ASSOC);
  $i = 1;
  // 2) Arreglo de nombres de mes
  $meses = [
    1 => 'Enero',   2 => 'Febrero', 3 => 'Marzo',
    4 => 'Abril',   5 => 'Mayo',    6 => 'Junio',
    7 => 'Julio',   8 => 'Agosto',  9 => 'Septiembre',
    10=> 'Octubre',11 => 'Noviembre',12 => 'Diciembre'
  ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Expedientes</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/estilo_expediente.css">
  <link rel="stylesheet" href="css/expedientes.css">
</head>
<body>
  <?php include 'menu.php'?>

    <div style="margin: 15px 0 0 20px;">
  <a href="Inicio.html" class="back-button" title="Regresar">
    <i class="fas fa-arrow-left"></i>
    <span class="back-text">Regresar</span>
  </a>
</div>

  <div  class="titulo-container-subtle">
    <h2 style= "text-align: center; margin-top: 20px;" class="titulo-pagina">EXPEDIENTES</h2>
  </div>

  <div class="expedientes-container">
    <?php if (empty($expedientes)): ?>
      <div class="no-expedientes">
        <i class="fas fa-folder-open icon-left"></i>
        <span>Sin expedientes</span>
      </div>
    <?php else: ?>

      <?php foreach ($expedientes as $p): ?>
        <?php 
          $nombreMes = $meses[intval($p['mes'])]; 
          $anio      = $p['anio'];
        ?>
        <a href="Expediente_seleccionado.php?anio=<?= urlencode($p['anio']) ?>&mes=<?= urlencode($p['mes']) ?>">
          <div class="expediente-item">
            <div class="expediente-info">
              <i class="fas fa-archive icon-left"></i>
              <span>Expediente <?= $i ?> – <?= $nombreMes ?> <?= $anio ?></span>
            </div>
            <i class="fas fa-eye icon-right"></i>

          </div>
        </a>
        <?php $i++; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <footer>
  Este sistema es propiedad del Sistema DIF Municipal Escuinapa y está destinado exclusivamente para uso administrativo. 
  <a href="aviso_privacidad.php">Aviso de privacidad</a>
</footer>


</body>
</html>


