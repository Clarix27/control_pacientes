<?php
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
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, sans-serif;
    background: #fff;
  }

  .expedientes-container {
    width: 90%;
    margin: 40px auto;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  .expediente-item {
    background-color: #D9D9D9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 25px;
    border-radius: 6px;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    font-family: 'Poppins', sans-serif;
    font-size: 18px;
    font-weight: 500;
  }

  .expediente-info {
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .icon-left {
    font-size: 28px;
  }

  .icon-right {
    font-size: 24px;
    cursor: pointer;
    transition: transform 0.2s ease;
  }

  .icon-right:hover {
    transform: scale(1.1);
  }

  .titulo-pagina {
  
  font-size: 28px;
}

.icon-right {
  font-size: 24px;
  cursor: pointer;
  transition: transform 0.2s ease;
}

.icon-right:hover {
  transform: scale(1.1);
}

.titulo-pagina {
 
 font-size: 28px;
 font-weight: bold;
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

.titulo-registro {
  font-size: 20px;
  font-weight: 600;
  color: #2c3e50;
  text-align: left;
  margin: 0;
  padding: 0 0 10px 0;
}

</style>
<body>
  <?php include 'menu.php'?>

    <?php include 'regresar.php'?>

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

</body>
</html>


